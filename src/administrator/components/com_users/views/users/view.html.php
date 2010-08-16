<?php
/**
 * @version		$Id: view.html.php 17071 2010-05-15 08:03:01Z chdemko $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of users.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @since		1.6
 */
class UsersViewUsers extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

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
		$canDo	= UsersHelper::getActions();

		JToolBarHelper::title(JText::_('COM_USERS_VIEW_USERS_TITLE'), 'user');

		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('user.add', 'new.png', 'new_f2.png','JTOOLBAR_NEW', false);
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::custom('user.edit', 'edit.png', 'edit_f2.png','JTOOLBAR_EDIT', true);
		}

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::custom('users.activate', 'publish.png', 'publish_f2.png', 'COM_USERS_TOOLBAR_ACTIVATE', true);
			JToolBarHelper::custom('users.block', 'unpublish.png', 'unpublish_f2.png', 'COM_USERS_TOOLBAR_BLOCK', true);
		}

		if ($canDo->get('core.delete')) {
			JToolBarHelper::divider();
			JToolBarHelper::deleteList('', 'users.delete','JTOOLBAR_DELETE');
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_users');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_USERS_USER_MANAGER');
	}
}
