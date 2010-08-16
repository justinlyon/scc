<?php
/**
 * @version		$Id: stream.php 17854 2010-06-23 17:43:55Z eddieajau $
 * @package		Joomla.Framework
 * @subpackage	FileSystem
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('JPATH_BASE') or die();

jimport('joomla.filesystem.helper');
jimport('joomla.utilities.utility');

/**
 * Joomla! Stream Interface
 *
 * The Joomla! stream interface is designed to handle files as streams
 * where as the legacy JFile static class treated files in a rather
 * atomic manner.
 *
 * This class adheres to the stream wrapper operations:
 * http://www.php.net/manual/en/function.stream-get-wrappers.php
 *
 * @see http://au.php.net/manual/en/intro.stream.php PHP Stream Manual
 * @see http://au.php.net/manual/en/wrappers.php Stream Wrappers
 * @see http://au.php.net/manual/en/filters.php Stream Filters
 * @see http://au.php.net/manual/en/transports.php Socket Transports (used by some options, particularly HTTP proxy)
 */
class JStream extends JObject
{
	// Publicly settable vars (protected to let our parent read them)
	/** @var File Mode */
	protected $filemode = 0644;
	/** @var Directory Mode */
	protected $dirmode = 0755;
	/** @var Default Chunk Size */
	protected $chunksize = 8192;
	/** @var Filename */
	protected $filename;
	/** @var Prefix of the connection for writing */
	protected $writeprefix;
	/** @var Prefix of the connection for reading */
	protected $readprefix;
	/** @var Read Processing method: gz, bz, f
	 *			If a scheme is detected, fopen will be defaulted
	 *			To use compression with a network stream use a filter
	 */
	protected $processingmethod = 'f';
	/** @var array Filters applied to the current stream */
	protected $filters = Array();

	// Private vars
	/** @var File Handle */
	private $_fh;
	/** @var File size */
	private $_filesize;
	/** @var Context to use when opening the connection */
	private $_context = null;
	/** @var Context options; used to rebuild the context */
	private $_contextOptions;
	/** @var The mode under which the file was opened */
	private $_openmode;

	/**
	 * Constructor
	 * @param string Prefix of the stream; Note: unlike the JPATH_*, this has a final path seperator!
	 */
	function __construct($writeprefix='', $readprefix='', $context=Array())
	{
		$this->writeprefix = $writeprefix;
		$this->readprefix = $readprefix;
		$this->_contextOptions = $context;
		$this->_buildContext();
	}

	/**
	 * Destructor
	 */
	function __destruct()
	{
		// attempt to close on destruction if there is a file handle
		if($this->_fh) @$this->close();
	}

	// ----------------------------
	// Generic File Operations
	// ----------------------------

	/**
	 * Open a stream with some lazy loading smarts
	 * @param string Filename
	 * @param string Mode string to use
	 * @param bool Use the PHP include path
	 * @param resource Context to use when opening
	 * @param bool Use a prefix to open the file
	 * @param bool Filename is a relative path (if false, strips JPATH_ROOT to make it relative)
	 * @param bool Detect the processing method for the file and use the appropriate function to handle output automatically
	 */
	function open($filename, $mode='r', $use_include_path=false, $context=null, $use_prefix=true, $relative=false, $detectprocessingmode=false)
	{
		$filename = $this->_getFilename($filename, $mode, $use_prefix, $relative);
		if(!$filename)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILENAME'));
			return false;
		}

		$this->filename = $filename;
		$this->_openmode = $mode;

		$url = parse_url($filename);
		$retval = false;
		if(isset($url['scheme']))
		{
			// if we're dealing with a Joomla! stream, load it
			if(JFilesystemHelper::isJoomlaStream($url['scheme'])) {
				require_once dirname(__FILE__).DS.'streams'.DS.$url['scheme'].'.php';
			}

			// we have a scheme! force the method to be f
			$this->processingmethod = 'f';
		}
		else if($detectprocessingmode)
		{
			$ext = strtolower(JFile::getExt($this->filename));
			switch ($ext)
			{
				case 'tgz':
				case 'gz':
				case 'gzip':
					$this->processingmethod = 'gz';
					break;
				case 'tbz2':
				case 'bz2':
				case 'bzip2':
					$this->processingmethod = 'bz';
					break;
				default:
					$this->processingmethod = 'f';
					break;
			}
		}
		// Capture PHP errors
		$php_errormsg = 'Error Unknown whilst opening a file';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		// Decide which context to use:
		switch($this->processingmethod)
		{
			case 'gz': // gzip doesn't support contexts or streams
				$this->_fh = gzopen($filename, $mode, $use_include_path);
				break;
			case 'bz': // bzip2 is much like gzip except it doesn't use the include path
				$this->_fh = bzopen($filename, $mode);
				break;
			case 'f': // fopen can handle streams
			default:
				if($context) {					//  one supplied at open; overrides everything
					$this->_fh = fopen($filename, $mode, $use_include_path, $context);
				} else if ($this->_context) {	// one provided at initialisation
					$this->_fh = fopen($filename, $mode, $use_include_path, $this->_context);
				} else {						// no context; all defaults
					$this->_fh = fopen($filename, $mode, $use_include_path);
				}
				break;
		}

		if(!$this->_fh) {
			$this->setError($php_errormsg);
		} else {
			$retval = true;
		}
		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $retval;
	}

	/**
	 * Attempt to close a file handle
	 * Will return false if it failed and true on success
	 * Note: if the file is not open the system will return true
	 * Note: this function destroys the file handle as well
	 */
	function close()
	{
		if(!$this->_fh)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return true;
		}
		$retval = false;
		// Capture PHP errors
		$php_errormsg = 'Error Unknown';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		switch($this->processingmethod)
		{
			case 'gz':
				$res = gzclose($this->_fh);
				break;
			case 'bz':
				$res = bzclose($this->_fh);
				break;
			case 'f':
			default:
				$res = fclose($this->_fh);
				break;
		}


		if(!$res) {
			$this->setError($php_errormsg);
		}
		else
		{
			$this->_fh = null; // reset this
			$retval = true;
		}
		// chmod the file after its closed if we wrote
		if($this->_openmode[0] == 'w') {
			$this->chmod();
		}
		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $retval;
	}

	/**
	 * Work out if we're at the end of the file for a stream
	 */
	function eof()
	{
		if(!$this->_fh)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return false;
		}

		$retval = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		switch($this->processingmethod)
		{
			case 'gz':
				$res = gzeof($this->_fh);
				break;
			case 'bz':
			case 'f':
			default:
				$res = feof($this->_fh);
				break;
		}

		if($php_errormsg) {
			$this->setError($php_errormsg);
		}

		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $res;
	}

	/**
	 * Retrieve the file size of the path
	 */
	function filesize()
	{
		if(!$this->filename)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return false;
		}

		$retval = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		$res = @filesize($this->filename);
		if(!$res)
		{
			$tmp_error = '';

			if($php_errormsg) { // some bad went wrong
				$tmp_error = $php_errormsg; // store the error in case we need it
			}

			$res = JFilesystemHelper::remotefsize($this->filename);

			if(!$res)
			{
				if($tmp_error) { // use the php_errormsg from before
					$this->setError($tmp_error);
				} else { // error but nothing from php? how strange! create our own
					$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_SIZE'));
				}
			}
			else
			{
				$this->_filesize = $res;
				$retval = $res;
			}
		}
		else
		{
			$this->_filesize = $res;
			$retval = $res;
		}
		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $retval;
	}

	function gets($length=0)
	{
		if(!$this->_fh)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return false;
		}

		$retval = false;
		// Capture PHP errors
		$php_errormsg = 'Error Unknown';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		switch($this->processingmethod)
		{
			case 'gz':
				$res = $length ? gzgets($this->_fh, $length) : gzgets($this->_fh);
				break;
			case 'bz':
			case 'f':
			default:
				$res = $length ? fgets($this->_fh, $length) : fgets($this->_fh);
				break;
		}

		if(!$res) {
			$this->setError($php_errormsg);
		} else {
			$retval = $res;
		}
		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $retval;
	}

	/**
	 * Read a file
	 * Handles user space streams appropriately otherwise any read will return 8192
	 * @param int length of data to read
	 * @see http://www.php.net/manual/en/function.fread.php
	 */
	function read($length=0)
	{
		if(!$this->_filesize && !$length)
		{
			$this->filesize(); // get the filesize
			if(!$this->_filesize) {
				$length = -1; // set it to the biggest and then wait until eof
			} else {
				$length = $this->_filesize;
			}
		}
		if(!$this->_fh)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return false;
		}
		$retval = false;
		// Capture PHP errors
		$php_errormsg = 'Error Unknown';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		$remaining = $length;
		do {
			// do chunked reads where relevant
			switch($this->processingmethod)
			{
				case 'bz':
					$res = ($remaining > 0) ? bzread($this->_fh, $remaining) : bzread($this->_fh, $this->chunksize);
					break;
				case 'gz':
					$res = ($remaining > 0) ? gzread($this->_fh, $remaining) : gzread($this->_fh, $this->chunksize);
					break;
				case 'f':
				default:
					$res = ($remaining > 0) ? fread($this->_fh, $remaining) : fread($this->_fh, $this->chunksize);
					break;
			}

			if(!$res)
			{
				$this->setError($php_errormsg);
				$remaining = 0; // jump from the loop
			} else
			{
				if(!$retval) $retval = '';
				$retval .= $res;
				if(!$this->eof())
				{
					$len = strlen($res);
					$remaining -= $len;
				}
				else
				{
					// if its the end of the file then we've nothing left to read; reset remaining and len
					$remaining = 0;
					$length = strlen($retval);
				}
			}
		} while($remaining || !$length);
		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $retval;
	}

	/**
	 * Seek the file
	 * Note: the return value is different to that of fseek
	 * @param int Offset to use when seeking
	 * @param int Seek mode to use
	 * @return boolean True on success, false on failure
	 * @see http://www.php.net/manual/en/function.fseek.php
	 */
	function seek($offset, $whence=SEEK_SET)
	{
		if(!$this->_fh)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return false;
		}
		$retval = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		switch($this->processingmethod)
		{
			case 'gz':
				$res = gzseek($this->_fh, $offset, $whence);
				break;
			case 'bz':
			case 'f':
			default:
				$res = fseek($this->_fh, $offset, $whence);
				break;
		}
		// seek, interestingly returns 0 on success or -1 on failure
		if($res == -1) {
			$this->setError($php_errormsg);
		} else {
			$retval = true;
		}

		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $retval;
	}

	function tell()
	{
		if(!$this->_fh)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return false;
		}
		$res = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		switch($this->processingmethod)
		{
			case 'gz':
				$res = gztell($this->_fh);
				break;
			case 'bz':
			case 'f':
			default:
				$res = ftell($this->_fh);
				break;
		}
		// may return 0 so check its really false
		if($res === FALSE) {
			$this->setError($php_errormsg);
		}

		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $res;
	}

	/**
	 * File write
	 * Note: Whilst this function accepts a reference, the underlying fwrite
	 * will do a copy! This will roughly double the memory allocation for
	 * any write you do. Specifying chunked will get around this by only
	 * writing in specific chunk sizes. This defaults to 8192 which is a
	 * sane number to use most of the time (change the default with
	 * JStream::set('chunksize', newsize);)
	 * Note: This doesn't support gzip/bzip2 writing like reading does
	 * @param string Reference to the string to write
	 * @param int Length of the string to write
	 * @param int Size of chunks to write in
	 * @see http://www.php.net/manual/en/function.fwrite.php
	 */
	function write(&$string, $length=0, $chunk=0)
	{
		if(!$this->_fh)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return false;
		}
		// if the length isn't set, set it to the length of the string
		if(!$length) $length = strlen($string);
		// if the chunk isn't set, set it to the default
		if(!$chunk) $chunk = $this->chunksize;
		$retval = true;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		$remaining = $length;
		do {
			// if the amount remaining is greater than the chunk size, then use the chunk
			$amount = ($remaining > $chunk) ? $chunk : $remaining;
			$res = fwrite($this->_fh, $string, $amount);
			// returns false on error or the number of bytes written
			if($res === false)
			{ // returned error
				$this->setError($php_errormsg);
				$retval = false;
				$remaining = 0;
			}
			else if($res === 0)
			{ // wrote nothing?
				$remaining = 0;
				$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_NO_DATA_WRITTEN'));
			} else
			{ // wrote something
				$remaining -= $res;
			}
		} while($remaining);

		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $retval;
	}

	/**
	 * chmod wrapper
	 * @param mixed Mode to use
	 */
	function chmod($filename='', $mode=0)
	{
		if(!$filename)
		{
			if(!isset($this->filename) || !$this->filename) {
				$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILENAME'));
				return false;
			}
			$filename = $this->filename;
		}

		// if no mode is set use the default
		if(!$mode) $mode = $this->filemode;

		$retval = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		$sch = parse_url($filename, PHP_URL_SCHEME);
		// scheme specific options; ftp's chmod support is fun
		switch($sch)
		{
			case 'ftp':
			case 'ftps':
				$res = JFilesystemHelper::ftpChmod($filename, $mode);
				break;
			default:
				//echo '<p>Chmodding '. $filename . ' with ' . decoct($mode) .'</p>';
				$res = chmod($filename, $mode);
				break;
		}
		// seek, interestingly returns 0 on success or -1 on failure
		if(!$res) {
			$this->setError($php_errormsg);
		} else {
			$retval = true;
		}
		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		// return the result
		return $retval;
	}

	/**
	 * Get the stream metadata
	 * @see http://au.php.net/manual/en/function.stream-get-meta-data.php
	 * @return array header/metadata
	 */
	function get_meta_data()
	{
		if(!$this->_fh)
		{
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_FILE_NOT_OPEN'));
			return false;
		}
		return stream_get_meta_data($this->_fh);
	}



	// ----------------------------
	// Stream contexts
	// ----------------------------

	/**
	 * Builds the context from the array
	 */
	function _buildContext()
	{
		// according to the manual this always works!
		if(count($this->_contextOptions)) {
			$this->_context = @stream_context_create($this->_contextOptions);
		} else {
			$this->_context = null;
		}
	}

	/**
	 * Updates the context to the array
	 * Format is the same as the options for stream_context_create
	 * @param Array Options to create the context with
	 * @see http://www.php.net/stream_context_create
	 */
	function setContextOptions($context)
	{
		$this->_contextOptions = $context;
		$this->_buildContext();
	}

	/**
	 * Adds a particular options to the context
	 * @param string The wrapper to use
	 * @param string The option to set
	 * @param string The value of the option
	 * @see http://www.php.net/stream_context_create Stream Context Creation
	 * @see http://au.php.net/manual/en/context.php Context Options for various streams
	 */
	function addContextEntry($wrapper, $name, $value)
	{
		$this->_contextOptions[$wrapper][$name] = $value;
		$this->_buildContext();
	}

	/**
	 * Deletes a particular setting from a context
	 * @param string The wrapper to use
	 * @param string The option to unset
	 * @see http://www.php.net/stream_context_create
	 */
	function deleteContextEntry($wrapper, $name)
	{
		// check the wrapper is set
		if(isset($this->_contextOptions[$wrapper]))
		{
			// check that entry is set for that wrapper
			if(isset($this->_contextOptions[$wrapper][$name]))
			{
				// unset the item
				unset($this->_contextOptions[$wrapper][$name]);

				// check that there are still items there
				if(!count($this->_contextOptions[$wrapper])) {
					// clean up an empty wrapper context option
					unset($this->_contextOptions[$wrapper]);
				}
			}
		}
		// rebuild the context and apply it to the stream
		$this->_buildContext();
	}

	/**
	 * Applies the current context to the stream
	 * Use this to change the values of the context after you've opened a stream
	 */
	function applyContextToStream()
	{
		$retval = false;
		if($this->_fh)
		{
			// Capture PHP errors
			$php_errormsg = 'Unknown error setting context option';
			$track_errors = ini_get('track_errors');
			ini_set('track_errors', true);
			$retval = @stream_context_set_option($this->_fh, $this->_contextOptions);
			if(!$retval) {
				$this->setError($php_errormsg);
			}
			// restore error tracking to what it was before
			ini_set('track_errors',$track_errors);
		}
		return $retval;
	}

	// ----------------------------
	// Stream filters
	// ----------------------------

	/**
	 * Append a filter to the chain
	 * @param
	 * @see http://www.php.net/manual/en/function.stream-filter-append.php
	 */
	function appendFilter($filtername, $read_write=STREAM_FILTER_READ, $params=Array() )
	{
		$res = false;
		if($this->_fh)
		{
			// Capture PHP errors
			$php_errormsg = '';
			$track_errors = ini_get('track_errors');
			ini_set('track_errors', true);

			$res = @stream_filter_append($this->_fh, $filtername, $read_write, $params);
			if(!$res && $php_errormsg) {
				$this->setError($php_errormsg);
			} else {
				$this->filters[] = &$res;
			}

			// restore error tracking to what it was before
			ini_set('track_errors',$track_errors);
		}
		return $res;
	}

	function prependFilter($filtername, $read_write=STREAM_FILTER_READ, $params=Array() )
	{
		$res = false;
		if($this->_fh)
		{
			// Capture PHP errors
			$php_errormsg = '';
			$track_errors = ini_get('track_errors');
			ini_set('track_errors', true);
			$res = @stream_filter_prepend($this->_fh, $filtername, $read_write, $params);
			if(!$res && $php_errormsg)
			{
				$this->setError($php_errormsg); // set the error msg
			}
			else
			{
				array_unshift($res,'');
				$res[0] =&$this->filters;
			}
			// restore error tracking to what it was before
			ini_set('track_errors',$track_errors);
		}
		return $res;
	}

	/**
	 * Remove a filter, either by resource (handed out from the
	 * append or prepend function alternatively via getting the
	 * filter list)
	 * @return bool Result of operation
	 */
	function removeFilter(&$resource, $byindex=false)
	{
		$res = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);
		if($byindex) {
			$res = stream_filter_remove($this->filters[$resource]);
		} else {
			$res = stream_filter_remove($resource);
		}
		if($res && $php_errormsg) {
			$this->setError($php_errormsg);
		}
		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		return $res;
	}

	// ----------------------------
	// Support operations (copy, move)
	// ----------------------------

	/**
	 * Copy a file from src to dest
	 */
	function copy($src, $dest, $context=null, $use_prefix=true, $relative=false)
	{
		$res = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);

		$chmodDest = $this->_getFilename($dest, 'w', $use_prefix, $relative);
		$exists = file_exists($dest);
		$context_support = version_compare(PHP_VERSION, '5.3', '>='); // 5.3 provides context support
		if($exists && !$context_support)
		{
			// the file exists and there is no context support
			// this could cause a failure as we may need to overwrite the file
			// so we write our own copy function that will work with a stream
			// context; php 5.3 will fix this for us (yay!)
			// Note: since open processes the filename for us we won't worry about
			// calling _getFilename
			$res = $this->open($src);
			if($res) {
				$reader = $this->_fh;
				$res = $this->open($dest, 'w');
				if($res)
				{
					$res = stream_copy_to_stream($reader, $this->_fh);
					$tmperror = $php_errormsg; // save this in case fclose throws an error
					@fclose($reader);
					$php_errormsg = $tmperror; // restore after fclose
				}
				else
				{
					@fclose($reader); // close the reader off
					$php_errormsg = JText::sprintf('JLIB_FILESYSTEM_ERROR_STREAMS_FAILED_TO_OPEN_WRITER', $this->getError());
				}
			}
			else
			{
				if(!$php_errormsg) {
					$php_errormsg = JText::sprintf('JLIB_FILESYSTEM_ERROR_STREAMS_FAILED_TO_OPEN_READER', $this->getError());
				}
			}
		}
		else
		{
			// since we're going to open the file directly we need to get the filename
			// we need to use the same prefix so force everything to write
			$src = $this->_getFilename($src, 'w', $use_prefix, $relative);
			$dest = $this->_getFilename($dest, 'w', $use_prefix, $relative);
			if($context_support && $context) { // use the provided context
				$res = @copy($src, $dest, $context);
			} else if($context_support && $this->_context) { // use the objects context
				$res = @copy($src, $dest, $this->_context);
			} else { // don't use any context
				$res = @copy($src, $dest);
			}
		}
		if(!$res && $php_errormsg) {
			$this->setError($php_errormsg);
		} else {
			$this->chmod($chmodDest);
		}

		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		return $res;
	}

	/**
	 * Moves a file
	 */
	function move($src, $dest, $context=null, $use_prefix=true, $relative=false)
	{
		$res = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);

		$src = $this->_getFilename($src, 'w', $use_prefix, $relative);
		$dest = $this->_getFilename($dest, 'w', $use_prefix, $relative);
		if($context) { // use the provided context
			$res = @rename($src, $dest, $context);
		} else if($this->_context) { // use the objects context
			$res = @rename($src, $dest, $this->_context);
		} else { // don't use any context
			$res = @rename($src, $dest);
		}
		if(!$res && $php_errormsg) {
			$this->setError($php_errormsg());
		}
		$this->chmod($dest);

		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		return $res;
	}

	/**
	 * Delete a file
	 */
	function delete($filename, $context=null, $use_prefix=true, $relative=false)
	{
		$res = false;
		// Capture PHP errors
		$php_errormsg = '';
		$track_errors = ini_get('track_errors');
		ini_set('track_errors', true);

		$filename = $this->_getFilename($filename, 'w', $use_prefix, $relative);
		if($context) { // use the provided context
			$res = @unlink($filename, $context);
		} else if($this->_context) { // use the objects context
			$res = @unlink($filename, $this->_context);
		} else { // don't use any context
			$res = @unlink($filename);
		}
		if(!$res && $php_errormsg) {
			$this->setError($php_errormsg());
		}

		// restore error tracking to what it was before
		ini_set('track_errors',$track_errors);
		return $res;
	}

	/**
	 * Upload a file
	 */
	function upload($src, $dest, $context=null, $use_prefix=true, $relative=false)
	{
		if(is_uploaded_file($src)) { // make sure its an uploaded file
			return $this->copy($src, $dest, $context, $use_prefix, $relative);
		} else {
			$this->setError(JText::_('JLIB_FILESYSTEM_ERROR_STREAMS_NOT_UPLOADED_FILE'));
			return false;
		}
	}

	// ----------------------------
	// All in one
	// ----------------------------


	/**
	 * Writes a chunk of data to a file
	 */
	function writeFile($filename, &$buffer)
	{
		if($this->open($filename, 'w'))
		{
			$result = $this->write($buffer);
			$this->chmod();
			$this->close();
			return $result;
		}
		return false;
	}

	/**
	 * Determine the appropriate 'filename' of a file
	 * @param string Original filename of the file
	 * @param string Mode string to retrieve the filename
	 * @param boolean Controls the use of a prefix
	 * @param boolean Determines if the filename given is relative. Relative paths do not have JPATH_ROOT stripped.
	 */
	function _getFilename($filename, $mode, $use_prefix, $relative)
	{
		if($use_prefix)
		{
			// get rid of binary or t, should be at the end of the string
			$tmode = trim($mode,'btf123456789');
			// check if its a write mode then add the appropriate prefix
			// get rid of JPATH_ROOT (legacy compat) along the way
			if(in_array($tmode, JFilesystemHelper::getWriteModes()))
			{
				if(!$relative && $this->writeprefix) $filename = str_replace(JPATH_ROOT, '', $filename);
				$filename = $this->writeprefix . $filename;
			}
			else
			{
				if(!$relative && $this->readprefix) $filename = str_replace(JPATH_ROOT, '', $filename);
				$filename = $this->readprefix . $filename;
			}
		}
		return $filename;
	}

	/**
	 * Return the internal file handle
	 */
	function getFileHandle() {
		return $this->_fh;
	}
}
