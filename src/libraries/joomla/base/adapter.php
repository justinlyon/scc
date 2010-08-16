<?php
/**
 * @version		$Id: adapter.php 17854 2010-06-23 17:43:55Z eddieajau $
 * @package		Joomla.Framework
 * @subpackage	Base
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Adapter Class
 * Retains common adapter pattern functions
 * Class harvested from joomla.installer.installer
 *
 * @package		Joomla.Framework
 * @subpackage	Base
 * @since		1.6
 */
class JAdapter extends JObject {
	/**
	 * Associative array of adapters
	 * @var array
	 */
	protected $_adapters = array();

	/**
	 * Adapter Folder
	 * @var string
	 */
	protected $_adapterfolder = 'adapters';

	/**
	 * Adapter Class Prefix
	 * @var string
	 */
	protected $_classprefix = 'J';

	/**
	 * Base Path for the adapter instance
	 * @var string
	 */
	protected $_basepath = null;

	/**
	 * Database Connector Object
	 * @var object
	 */
	protected $_db;

	/**
	 * Constructor
	 * @param string Base Path of the adapters
	 * @param string Class prefix of adapters
	 * @param string Name of folder to append to base path
	 */
	public function __construct($basepath, $classprefix=null, $adapterfolder=null) {
		$this->_basepath = $basepath;
		$this->_classprefix = $classprefix ? $classprefix : 'J';
		$this->_adapterfolder = $adapterfolder ? $adapterfolder : 'adapters';
		$this->_db = JFactory::getDBO();
	}

	/**
	 * Get the database connector object
	 *
	 * @access	public
	 * @return	object	Database connector object
	 * @since	1.5
	 */
	public function getDBO()
	{
		return $this->_db;
	}

	/**
	 * Set an adapter by name
	 *
	 * @access	public
	 * @param	string	$name		Adapter name
	 * @param	object	$adapter	Adapter object
	 * @param	array	$options	Adapter options
	 * @return	boolean True if successful
	 * @since	1.5
	 */
	public function setAdapter($name, &$adapter = null, $options = Array())
	{
		if (!is_object($adapter))
		{
			$fullpath = $this->_basepath.DS.$this->_adapterfolder.DS.strtolower($name).'.php';
			if(!file_exists($fullpath)) {
				return false;
			}
			// Try to load the adapter object
			require_once $fullpath;
			$class = $this->_classprefix.ucfirst($name);
			if (!class_exists($class)) {
				return false;
			}
			$adapter = new $class($this, $this->_db, $options);
		}
		$this->_adapters[$name] = &$adapter;
		return true;
	}

	/**
	 * Return an adapter
	 * @param 	string 	name of adapter to return
	 * @param 	Array 	$options Adapter options
	 * @return 	object 	Adapter of type 'name' or false
	 */
	public function getAdapter($name, $options = Array()) {
		if(!array_key_exists($name, $this->_adapters)) {
			if(!$this->setAdapter($name, $options)) {
				$false = false;
				return $false;
			}
		}
		return $this->_adapters[$name];
	}

	/**
	 * Loads all adapters
	 * @params array	$options	Adapter options
	 */
	public function loadAllAdapters($options = Array()) {
		$list = JFolder::files($this->_basepath.DS.$this->_adapterfolder);
		foreach($list as $filename) {
			if(JFile::getExt($filename) == 'php') {
				// Try to load the adapter object
				require_once $this->_basepath.DS.$this->_adapterfolder.DS.$filename;
				$name = JFile::stripExt($filename);
				$class = $this->_classprefix.ucfirst($name);
				if (!class_exists($class)) {
					continue; // skip to next one
				}
				$adapter = new $class($this, $this->_db, $options);
				$this->_adapters[$name] = clone $adapter;
			}
		}
	}
}