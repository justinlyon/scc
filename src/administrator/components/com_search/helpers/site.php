<?php
/**
 * @version		$Id: site.php 14276 2010-01-18 14:20:28Z louis $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Mock JSite class used to fool the frontend search plugins because they route the results.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_search
 */
class JSite extends JObject
{
	/**
	 * False method to fool the frontend search plugins
	 */
	function getMenu()
	{
		$result = new JSite;
		return $result;
	}

	/**
	 * False method to fool the frontend search plugins
	 */
	function getItems()
	{
		return array();
	}
}