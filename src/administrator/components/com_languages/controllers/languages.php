<?php
/**
 * @version		$Id: languages.php 17130 2010-05-17 05:52:36Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * @package		Joomla.Administrator
 * @subpackage	com_languages
 * @since	1.6
 */
class LanguagesControllerLanguages extends JControllerAdmin
{
	/**
	 * Proxy for getModel
	 * @since	1.6
	 */
	function &getModel($name = 'Language', $prefix = 'LanguagesModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	/**
	 * Override the execute method to clear the language cache for non-display tasks.
	 *
	 * @param	string		The task to perform.
	 * @return	mixed|false	The value returned by the called method, false in error case.
	 * @since	1.6
	 */
	public function execute($task)
	{
		parent::execute($task);

		// Clear the component's cache
		if ($task != 'display' && $task != 'edit') {
			$cache = JFactory::getCache('com_languages');
			$cache->clean();
		}
	}
}
