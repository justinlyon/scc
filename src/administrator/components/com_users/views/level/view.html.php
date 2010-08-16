<?php
/**
 * @version		$Id: view.html.php 18212 2010-07-22 06:02:54Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a user view level.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @since		1.6
 */
class UsersViewLevel extends JView
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}


		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', 1);

		$user		= JFactory::getUser();
		$isNew	= ($this->item->id == 0);
		$canDo		= UsersHelper::getActions();

		JToolBarHelper::title(JText::_($isNew ? 'COM_USERS_VIEW_NEW_LEVEL_TITLE' : 'COM_USERS_VIEW_EDIT_LEVEL_TITLE'), 'levels-add');

		if ($canDo->get('core.edit'))
		{
			JToolBarHelper::apply('level.apply','JTOOLBAR_APPLY');
			JToolBarHelper::save('level.save','JTOOLBAR_SAVE');
			JToolBarHelper::custom('level.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

			// If an existing item, can save to a copy.
			if (!$isNew && $canDo->get('core.create'))
			{
				JToolBarHelper::custom('level.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			}

			if (empty($this->item->id))
			{
				JToolBarHelper::cancel('level.cancel','JTOOLBAR_CANCEL');
			} else {
				JToolBarHelper::cancel('level.cancel', 'JTOOLBAR_CLOSE');
			}

			JToolBarHelper::divider();
			JToolBarHelper::help('JHELP_USERS_ACCESS_LEVELS_EDIT');
		}
	}
}