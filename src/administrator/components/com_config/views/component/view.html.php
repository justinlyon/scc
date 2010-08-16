<?php
/**
 * @version		$Id: view.html.php 15672 2010-03-29 03:11:49Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * @package		Joomla.Administrator
 * @subpackage	com_config
 */
class ConfigViewComponent extends JView
{
	/**
	 * Display the view
	 */
	function display()
	{
		$form		= $this->get('Form');
		$component	= $this->get('Component');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Bind the form to the data.
		if ($form && $component->params) {
			$form->bind($component->params);
		}

		$this->assignRef('form',		$form);
		$this->assignRef('component',	$component);

		$this->document->setTitle(JText::_('JGLOBAL_EDIT_PREFERENCES'));

		parent::display();
		JRequest::setVar('hidemainmenu', true);
	}
}