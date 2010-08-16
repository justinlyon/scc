<?php
/**
 * @version		$Id: system.php 15299 2010-03-09 10:57:51Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Utility class working with system
 *
 * @package		Joomla.Administrator
 * @subpackage	Admin
 * @since		1.6
 */
abstract class JHtmlSystem
{
	/**
	 * method to generate a string message for a value
	 *
	 * @param string $val a php ini value
	 *
	 * @return string html code
	 */
	public static function server($val)
	{
		if (empty($val)) {
			return JText::_('COM_ADMIN_NA');
		}
		else {
			return $val;
		}
	}
}

