<?php
/**
 * @version		$Id: format.php 16378 2010-04-23 08:50:50Z infograf768 $
 * @package		Joomla.Framework
 * @subpackage	Registry
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Abstract Format for JRegistry
 *
 * @abstract
 * @package		Joomla.Framework
 * @subpackage	Registry
 * @since		1.5
 */
abstract class JRegistryFormat
{
	/**
	 * Returns a reference to a Format object, only creating it
	 * if it doesn't already exist.
	 *
	 * @param	string	The format to load
	 * @return	object	Registry format handler
	 * @throws	JException
	 * @since	1.5
	 */
	public static function getInstance($type)
	{
		// Initialize static variable.
		static $instances;
		if (!isset ($instances)) {
			$instances = array ();
		}

		// Sanitize format type.
		$type = strtolower(preg_replace('/[^A-Z0-9_]/i', '', $type));

		// Only instantiate the object if it doesn't already exist.
		if (!isset($instances[$type])) {
			// Only load the file the class does not exist.
			$class = 'JRegistryFormat'.$type;
			if (!class_exists($class)) {
				$path = dirname(__FILE__).'/format/'.$type.'.php';
				if (is_file($path)) {
					require_once $path;
				} else {
					throw new JException(JText::_('JLIB_REGISTRY_EXCEPTION_LOAD_FORMAT_CLASS'), 500, E_ERROR);
				}
			}

			$instances[$type] = new $class();
		}
		return $instances[$type];
	}

	/**
	 * Converts an object into a formatted string.
	 *
	 * @param	object	Data Source Object.
	 * @param	array	An array of options for the formatter.
	 * @return	string	Formatted string.
	 * @since	1.5
	 */
	abstract public function objectToString($object, $options = null);

	/**
	 * Converts a formatted string into an object.
	 *
	 * @param	string	Formatted string
	 * @param	array	An array of options for the formatter.
	 * @return	object	Data Object
	 * @since	1.5
	 */
	abstract public function stringToObject($data, $options = null);
}