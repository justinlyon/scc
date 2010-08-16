<?php
/**
 * @version		$Id: view.html.php 16991 2010-05-12 15:56:56Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Users mail view.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_users
 */
class UsersViewMail extends JView
{
	/**
	 * @var object form object
	 */
	protected $form;

	/**
	 * Display the view
	 */
	function display($tpl = null)
	{
		// Get data from the model
		$this->form = $this->get('Form');

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

		JToolBarHelper::title(JText::_('COM_USERS_MASS_MAIL'), 'massmail.png');
		JToolBarHelper::custom('mail.send', 'send.png', 'send_f2.png', 'COM_USERS_TOOLBAR_MAIL_SEND_MAIL', false);
		JToolBarHelper::cancel('mail.cancel','JTOOLBAR_CANCEL');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_users');
		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_USERS_MASS_MAIL_USERS');
	}
}
