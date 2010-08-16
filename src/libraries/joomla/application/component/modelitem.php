<?php
/**
 * @version		$Id: modelitem.php 16239 2010-04-20 05:57:53Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.application.component.model');

/**
 * Prototype item model.
 *
 * @package		Joomla.Framework
 * @subpackage	Application
 * @version		1.6
 */
abstract class JModelItem extends JModel
{
	/**
	 * An item.
	 *
	 * @var		array
	 */
	protected $_item = null;

	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	protected $_context = 'group.type';

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$context	A prefix for the store id.
	 * @return	string		A store id.
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.

		return md5($id);
	}
}