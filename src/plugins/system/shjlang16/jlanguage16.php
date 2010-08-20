<?php
/**
 * @version		$Id: jlanguage16.php 1466 2010-06-12 18:54:47Z silianacom-svn $
 * @package		Joomla.Framework
 * @subpackage	Language
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * Modified as a backport to Joomla! 1.5.x
 * (c) 2010 Yannick Gaultier
 *
 */

// No direct access.
defined('JPATH_BASE') or die;

/**
 * Allows for quoting in language .ini files.
 */
define('_QQ_', '"');


// import some libariries
jimport('joomla.filesystem.stream');

/**
 * Languages/translation handler class
 *
 * @package		Joomla.Framework
 * @subpackage	Language
 * @since		1.5
 */
class JLanguage16 extends JObject
{
  /**
   * Debug language, If true, highlights if string isn't found
   *
   * @var		boolean
   * @since	1.5
   */
  protected $_debug = false;

  /**
   * The default language
   *
   * The default language is used when a language file in the requested language does not exist.
   *
   * @var		string
   * @since	1.5
   */
  protected $_default	= 'en-GB';

  /**
   * An array of orphaned text
   *
   * @var		array
   * @since	1.5
   */
  protected $_orphans = array();

  /**
   * Array holding the language metadata
   *
   * @var		array
   * @since	1.5
   */
  protected $_metadata = null;

  /**
   * The language to load
   *
   * @var		string
   * @since	1.5
   */
  protected $_lang = null;

  /**
   * List of language files that have been loaded
   *
   * @var		array of arrays
   * @since	1.5
   */
  protected $_paths = array();

  /**
   * List of language files that are in error state
   *
   * @var		array of string
   * @since	1.6
   */
  protected $_errorfiles = array();

  /**
   * Translations
   *
   * @var		array
   * @since	1.5
   */
  protected $_strings = null;

  /**
   * An array of used text, used during debugging
   *
   * @var		array
   * @since	1.5
   */
  protected $_used = array();

  /**
   * Counter for number of loads
   *
   * @var		integer
   * @since	1.6
   */
  protected $_counter = 0;

  /**
   * An array used to store overrides
   *
   * @var		array
   * @since	1.6
   */
  protected $_override = array();

  /**
   * Name of the transliterator function for this language
   *
   * @var		string
   * @since	1.6
   */
  protected $_transliterator = null;

  /**
   * Constructor activating the default information of the language
   */
  public function __construct($lang = null, $debug = false)
  {
    $this->_strings = array ();

    if ($lang == null) {
      $lang = $this->_default;
    }

    $this->setLanguage($lang);
    $this->setDebug($debug);

    $filename = JPATH_BASE.DS.'language'.DS.'overrides'.DS.$lang.'.override.ini';
    if (file_exists($filename) && $contents = $this->_parse($filename)) {
      if (is_array($contents)) {
        $this->_override = $contents;
      }
      unset($contents);
    }

    // Look for a special transliterate function for this language
    $function = str_replace('-', '', $lang.'Transliterate');
    if (function_exists($function)) {
      $this->_transliterator = $function;
    } else {
      // Function does not exist. Try to find it in the Site language folder
      $transFile = JPATH_SITE.DS.'language'.DS.$lang.DS.$lang.'.transliterate.php';
      if (file_exists($transFile)) {
        require_once $transFile;
        if (function_exists($function)) {
          $this->_transliterator = $function;
        }
      } else {
        // Function does not exist. Try to find it in the Administrator language folder
        $transFile = JPATH_ADMINISTRATOR.DS.'language'.DS.$lang.DS.$lang.'.transliterate.php';
        if (file_exists($transFile)) {
          require_once $transFile;
          if (function_exists($function)) {
            $this->_transliterator = $function;
          }
        }
      }
    }

    // shumisha : don't autoload Joomla strings as the 1.5 strings
    // we cannot use. Joomla strings are to be fetched using JText::_()
    // instead of JText16::_()
    // they would not load anyway, but we'll just waste time trying
    //$this->load();
  }

  /**
   * Returns a language object
   *
   * @param	string $lang  The language to use.
   * @param	boolean	$debug	The debug mode
   * @return	Jlanguage16  The Language object.
   * @since	1.5
   */
  public static function getInstance($lang, $debug=false)
  {
    return new Jlanguage16($lang, $debug);
  }

  public static function &createLanguage()  {
    jimport('joomla.language.language');

    $conf =& JFactory::getConfig();
    $locale = $conf->getValue('config.language');
    $lang =& self::getInstance($locale);
    $lang->setDebug($conf->getValue('config.debug_lang'));

    return $lang;
  }

  /**
   * Translate function, mimics the php gettext (alias _) function
   *
   * @param	string		$string	The string to translate
   * @param	boolean	$jsSafe		Make the result javascript safe
   * @return	string	The translation of the string
   * @since	1.5
   */
  public function _($string, $jsSafe = false)
  {
    $key = strtoupper($string);
    if (isset ($this->_strings[$key])) {
      $string = $this->_debug ? '**'.$this->_strings[$key].'**' : $this->_strings[$key];

      // Store debug information
      if ($this->_debug) {
        $caller = $this->_getCallerInfo();

        if (! array_key_exists($key, $this->_used)) {
          $this->_used[$key] = array();
        }

        $this->_used[$key][] = $caller;
      }
    } else {
      if ($this->_debug) {
        $caller = $this->_getCallerInfo();
        $caller['string'] = $string;

        if (! array_key_exists($key, $this->_orphans)) {
          $this->_orphans[$key] = array();
        }

        $this->_orphans[$key][] = $caller;

        $string = '??'.$string.'??';
      }
    }

    if ($jsSafe) {
      $string = addslashes($string);
    }

    return $string;
  }

  /**
   * Transliterate function
   *
   * This method processes a string and replaces all accented UTF-8 characters by unaccented
   * ASCII-7 "equivalents"
   *
   * @param	string	$string	The string to transliterate
   * @return	string	The transliteration of the string
   * @since	1.5
   */
  public function transliterate($string)
  {
    include_once(dirname(__FILE__).DS.'latin_transliterate.php');

    if ($this->_transliterator !== null) {
      return call_user_func($this->_transliterator, $string);
    }

    $string = Jlanguage16Transliterate::utf8_latin_to_ascii($string);
    $string = JString::strtolower($string);

    return $string;
  }

  /**
   * Getter for transliteration function
   *
   * @return	string|function Function name or the actual function for PHP 5.3
   * @since	1.6
   */
  public function getTransliterator()
  {
    return $this->_transliterator;
  }

  /**
   * Set the transliteration function
   *
   * @return	string|function Function name or the actual function for PHP 5.3
   * @since	1.6
   */
  public function setTransliterator($function)
  {
    $previous = $this->_transliterator;
    $this->_transliterator = $function;
    return $previous;
  }

  /**
   * Check if a language exists
   *
   * This is a simple, quick check for the directory that should contain language files for the given user.
   *
   * @param	string $lang Language to check
   * @param	string $basePath Optional path to check
   * @return	boolean True if the language exists
   * @since	1.5
   */
  public static function exists($lang, $basePath = JPATH_BASE)
  {
    static	$paths	= array();

    // Return false if no language was specified
    if (! $lang) {
      return false;
    }

    $path	= $basePath.DS.'language'.DS.$lang;

    // Return previous check results if it exists
    if (isset($paths[$path]))
    {
      return $paths[$path];
    }

    // Check if the language exists
    jimport('joomla.filesystem.folder');

    $paths[$path]	= JFolder::exists($path);

    return $paths[$path];
  }

  /**
   * Loads a single language file and appends the results to the existing strings
   *
   * @param	string	$extension	The extension for which a language file should be loaded
   * @param	string	$basePath	The basepath to use
   * @param	string	$lang		The language to load, default null for the current language
   * @param	boolean $reload		Flag that will force a language to be reloaded if set to true
   * @param	boolean	$default	Flag that force the default language to be loaded if the current does not exist
   * @return	boolean	True, if the file has successfully loaded.
   * @since	1.5
   */
  //public function load($extension = 'joomla', $basePath = JPATH_BASE, $lang = null, $reload = false, $default = true)
  public function load($extension, $basePath = JPATH_BASE, $lang = null, $reload = false, $default = true)
  {

    static $allLangFolders = array();

    // shumisha : only use jLanguage16 to load extensions strings, not Joomla, which is
    // not going to be compatible anyway as we are on J! 1.5
    if (empty( $extension)) {
      return false;
    }

    if (! $lang) {
      $lang = $this->_lang;
    }

    $path = self::getLanguagePath($basePath, $lang);

    $internal = $extension == 'joomla' || $extension == '';
    $filename = $internal ? $lang : $lang . '.' . $extension;
    $filename = $path.DS.$filename.'.ini';

    $result = false;
    if (isset($this->_paths[$extension][$filename]) && ! $reload) {
      // Strings for this file have already been loaded
      $result = true;
    } else {

      // shumisha : Check if file exists. If not
      // try to load another file from the same language family
      // for instance, if fr-FR requested but not found
      // fr-CA will do just as well
      if (!shFileExists($filename)) {
        $newBasePath = substr( $path, 0, -5);
        // get all possible languages folders, and store them, so as not
        // to have to fetch them again
        if (!isset( $allLangFolders[$basePath])) {
          // read all language folders for this base path
          $allLangFolders[$basePath] = JFolder::folders( $newBasePath, '[A-Za-z]{2}-[A-Za-z]{2}');
        }
        // if we have other languages installed
        if (!empty( $allLangFolders[$basePath])) {
          // what is the root language code we are looking for ?
          $langRoot = substr( $lang, 0, 3);
          // look until we find
          foreach( $allLangFolders[$basePath] as $langFolder) {
            // if same root language code (and not the language we already tried),
            //search for the lang file we want
            if ($langFolder != $lang && substr( $langFolder, 0, 3) == $langRoot) {
              $newFilename = $langFolder . '.' . $extension;
              $newFilename = $newBasePath . $langFolder . DS . $newFilename . '.ini';
              // if the language file we want exists
              // just break the loop to use it
              if (shFileExists( $newFilename)) {
                $filename = $newFilename;
                break;
              }
            }
          }
        }
      }

      // Load the language file
      $result = $this->_load($filename, $extension);

      // Check if there was a problem with loading the file
      if ($result === false && $default) {
        // No strings, so either file doesn't exist or the file is invalid
        $oldFilename = $filename;

        // Check the standard file name
        $path		= self::getLanguagePath($basePath, $this->_default);
        $filename = $internal ? $this->_default : $this->_default . '.' . $extension;
        $filename	= $path.DS.$filename.'.ini';

        // If the one we tried is different than the new name, try again
        if ($oldFilename != $filename) {
          $result = $this->_load($filename, $extension, false);
        }
      }
    }
    return $result;
  }

  /**
   * Loads a language file
   *
   * This method will not note the successful loading of a file - use load() instead
   *
   * @param	string The name of the file
   * @param	string The name of the extension
   * @return	boolean True if new strings have been added to the language
   * @see		Jlanguage16::load()
   * @since	1.5
   */
  protected function _load($filename, $extension = 'unknown', $overwrite = true)
  {

    $this->_counter++;

    $result	= false;

    $strings = false;
    if (shFileExists($filename)) {
      $strings = $this->_parse($filename);
    }

    if ($strings) {
      if (is_array($strings)) {
        $this->_strings = array_merge($this->_strings, $strings);
      }
      if (is_array($strings) && count($strings)) {
        $this->_strings = array_merge($this->_strings, $this->_override);
        $result = true;
      }
    }

    // Record the result of loading the extension's file.
    if (! isset($this->_paths[$extension])) {
      $this->_paths[$extension] = array();
    }

    $this->_paths[$extension][$filename] = $result;

    return $result;
  }

  /**
   * Parses a language file
   *
   * @param	string The name of the file
   * @since	1.6
   */
  protected function _parse($filename)
  {
    $version = phpversion();
    if($version >= "5.3.1") {
      $contents = file_get_contents($filename);
      $contents = str_replace('_QQ_','"\""',$contents);
      $strings = (array) @parse_ini_string($contents);
    } else {
      $strings = (array) @parse_ini_file($filename);
      if ($version == "5.3.0") {
        foreach($strings as $key => $string) {
          $strings[$key]=str_replace('_QQ_','"',$string);
        }
      }
    }
    if ($this->_debug) {
/*      
 * Disabled, JStream does not exists in J 1.5
 * $this->_debug = false;
      $errors = array();
      $lineNumber = 0;
      $stream = new JStream();
      $stream->open($filename);
      while(!$stream->eof())
      {
        $line = $stream->gets();
        $lineNumber++;
        if (!preg_match('/^(|(\[[^\]]*\])|([A-Z][A-Z0-9_\-]*\s*=(\s*(("[^"]*")|(_QQ_)))+))\s*(;.*)?$/',$line))
        {
          $errors[] = $lineNumber;
        }
      }
      $stream->close();
      if (count($errors)) {
        if (basename($filename)!=$this->_lang.'.ini') {
          $this->_errorfiles[$filename] = $filename.JText::sprintf('JERROR_PARSING_LANGUAGE_FILE',implode(', ',$errors));
        }
        else {
          $this->_errorfiles[$filename] = $filename . '&nbsp;: error(s) in line(s) ' . implode(', ',$errors);
        }
      }
      $this->_debug = true;*/
    }
    return $strings;
  }

  /**
   * Get a matadata language property
   *
   * @param	string $property	The name of the property
   * @param	mixed  $default	The default value
   * @return	mixed The value of the property
   * @since	1.5
   */
  public function get($property, $default = null)
  {
    if (isset ($this->_metadata[$property])) {
      return $this->_metadata[$property];
    }
    return $default;
  }

  /**
   * Determine who called Jlanguage16 or JText
   *
   * @return	array Caller information
   * @since	1.5
   */
  protected function _getCallerInfo()
  {
    // Try to determine the source if none was provided
    if (!function_exists('debug_backtrace')) {
      return null;
    }

    $backtrace	= debug_backtrace();
    $info		= array();

    // Search through the backtrace to our caller
    $continue = true;
    while ($continue && next($backtrace)) {
      $step	= current($backtrace);
      $class	= @ $step['class'];

      // We're looking for something outside of language.php
      if ($class != 'Jlanguage16' && $class != 'JText') {
        $info['function']	= @ $step['function'];
        $info['class']		= $class;
        $info['step']		= prev($backtrace);

        // Determine the file and name of the file
        $info['file']		= @ $step['file'];
        $info['line']		= @ $step['line'];

        $continue = false;
      }
    }

    return $info;
  }

  /**
   * Getter for Name
   *
   * @return	string Official name element of the language
   * @since	1.5
   */
  public function getName() {
    return $this->_metadata['name'];
  }

  /**
   * Get a list of language files that have been loaded
   *
   * @param	string	$extension	An option extension name
   * @return	array
   * @since	1.5
   */
  public function getPaths($extension = null)
  {
    if (isset($extension)) {
      if (isset($this->_paths[$extension])) {
        return $this->_paths[$extension];
      }

      return null;
    } else {
      return $this->_paths;
    }
  }

  /**
   * Get a list of language files that are in error state
   *
   * @return	array
   * @since	1.6
   */
  public function getErrorFiles()
  {
    return $this->_errorfiles;
  }

  /**
   * Get for the language tag (as defined in RFC 3066)
   *
   * @return	string The language tag
   * @since	1.5
   */
  public function getTag() {
    return $this->_metadata['tag'];
  }

  /**
   * Get the RTL property
   *
   * @return	boolean True is it an RTL language
   * @since	1.5
   */
  public function isRTL()
  {
    return $this->_metadata['rtl'];
  }

  /**
   * Set the Debug property
   *
   * @return	boolean Previous value
   * @since	1.5
   */
  public function setDebug($debug)
  {
    $previous	= $this->_debug;
    $this->_debug = $debug;
    return $previous;
  }

  /**
   * Get the Debug property
   *
   * @return	boolean True is in debug mode
   * @since	1.5
   */
  public function getDebug()
  {
    return $this->_debug;
  }

  /**
   * Get the default language code
   *
   * @return	string Language code
   * @since	1.5
   */
  public function getDefault()
  {
    return $this->_default;
  }

  /**
   * Set the default language code
   *
   * @return	string Previous value
   * @since	1.5
   */
  public function setDefault($lang)
  {
    $previous	= $this->_default;
    $this->_default	= $lang;
    return $previous;
  }

  /**
   * Get the list of orphaned strings if being tracked
   *
   * @return	array Orphaned text
   * @since	1.5
   */
  public function getOrphans()
  {
    return $this->_orphans;
  }

  /**
   * Get the list of used strings
   *
   * Used strings are those strings requested and found either as a string or a constant
   *
   * @return	array	Used strings
   * @since	1.5
   */
  public function getUsed()
  {
    return $this->_used;
  }

  /**
   * Determines is a key exists
   *
   * @param	key $key	The key to check
   * @return	boolean True, if the key exists
   * @since	1.5
   */
  function hasKey($string)
  {
    $key = strtoupper($string);
    return isset ($this->_strings[$key]);
  }

  /**
   * Returns a associative array holding the metadata
   *
   * @param	string	The name of the language
   * @return	mixed	If $lang exists return key/value pair with the language metadata,
   *				otherwise return NULL
   * @since	1.5
   */
  public static function getMetadata($lang)
  {
    $path = self::getLanguagePath(JPATH_BASE, $lang);
    $file = $lang.'.xml';

    $result = null;
    if (is_file($path.DS.$file)) {
      $result = self::_parseXMLLanguageFile($path.DS.$file);
    }

    return $result;
  }

  /**
   * Returns a list of known languages for an area
   *
   * @param	string	$basePath	The basepath to use
   * @return	array	key/value pair with the language file and real name
   * @since	1.5
   */
  public static function getKnownLanguages($basePath = JPATH_BASE)
  {
    $dir = self::getLanguagePath($basePath);
    $knownLanguages = self::_parseLanguageFiles($dir);

    return $knownLanguages;
  }

  /**
   * Get the path to a language
   *
   * @param	string $basePath  The basepath to use
   * @param	string $language	The language tag
   * @return	string	language related path or null
   * @since	1.5
   */
  public static function getLanguagePath($basePath = JPATH_BASE, $language = null)
  {
    $dir = $basePath.DS.'language';
    if (!empty($language)) {
      $dir .= DS.$language;
    }
    return $dir;
  }

  /**
   * Set the language attributes to the given language
   *
   * Once called, the language still needs to be loaded using Jlanguage16::load()
   *
   * @param	string	$lang	Language code
   * @return	string	Previous value
   * @since	1.5
   */
  public function setLanguage($lang)
  {
    $previous			= $this->_lang;
    $this->_lang		= $lang;
    $this->_metadata	= $this->getMetadata($this->_lang);

    return $previous;
  }

  /**
   * Searches for language directories within a certain base dir
   *
   * @param	string	$dir	directory of files
   * @return	array	Array holding the found languages as filename => real name pairs
   * @since	1.5
   */
  public static function _parseLanguageFiles($dir = null)
  {
    jimport('joomla.filesystem.folder');

    $languages = array ();

    $subdirs = JFolder::folders($dir);
    foreach ($subdirs as $path) {
      $langs = self::_parseXMLLanguageFiles($dir.DS.$path);
      $languages = array_merge($languages, $langs);
    }

    return $languages;
  }

  /**
   * Parses XML files for language information
   *
   * @param	string	$dir	Directory of files
   * @return	array	Array holding the found languages as filename => metadata array
   * @since	1.5
   */
  public static function _parseXMLLanguageFiles($dir = null)
  {
    if ($dir == null) {
      return null;
    }

    $languages = array ();
    jimport('joomla.filesystem.folder');
    $files = JFolder::files($dir, '^([-_A-Za-z]*)\.xml$');
    foreach ($files as $file) {
      if ($content = file_get_contents($dir.DS.$file)) {
        if ($metadata = self::_parseXMLLanguageFile($dir.DS.$file)) {
          $lang = str_replace('.xml', '', $file);
          $languages[$lang] = $metadata;
        }
      }
    }
    return $languages;
  }

  /**
   * Parse XML file for language information.
   *
   * @param	string	$path	Path to the xml files
   * @return	array	Array holding the found metadata as a key => value pair
   * @since	1.5
   */
  public static function _parseXMLLanguageFile($path)
  {
    // Try to load the file
    /*if (!$xml = JFactory::getXML($path)) {
    return null;
    }*/
    // shumisha : JFactory::getXML() does not exist in J! 1.5
    if (!$xml = shjlang16Helper::_getXML($path)) {
      return null;
    }

    // Check that it's a metadata file
    if ((string)$xml->getName() != 'metafile') {
      return null;
    }

    $metadata = array();

    foreach ($xml->metadata->children() as $child) {
      $metadata[$child->getName()] = (string) $child;
    }

    return $metadata;
  }


}

