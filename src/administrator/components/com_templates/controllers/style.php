<?php
/**
 * @version		$Id: style.php 16830 2010-05-05 18:57:07Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Template style controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_templates
 * @since		1.6
 */
class TemplatesControllerStyle extends JControllerForm
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_TEMPLATES_STYLE';

	/**
	 * Proxy for execute.
	 *
	 * If the task is an action which modifies data, the component cache is cleared.
	 *
	 * @since	1.6
 	 */
	public function execute($task)
	{
		parent::execute($task);

		// Clear the component's cache
		if (!in_array($task, array('display', 'edit', 'cancel'))) {
			$cache = JFactory::getCache('com_templates');
			$cache->clean();
		}
	}
}