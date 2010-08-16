<?php
/**
 * @version		$Id: view.html.php 18126 2010-07-14 06:38:38Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a redirect link.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_redirect
 * @since		1.6
 */
class RedirectViewLink extends JView
{
	protected $item;
	protected $form;
	protected $state;

	/**
	 * Display the view
	 *
	 * @since	1.6
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
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$canDo		= RedirectHelper::getActions();

		JToolBarHelper::title(JText::_('COM_REDIRECT_MANAGER_LINK'), 'redirect');

		// If not checked out, can save the item.
		if ($canDo->get('core.edit')) {
			JToolBarHelper::apply('link.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('link.save', 'JTOOLBAR_SAVE');
		}

		// This component does not support Save as Copy due to uniqueness checks.
		// While it can be done, it causes too much confusion if the user does
		// not change the Old URL.

		if ($canDo->get('core.edit') && $canDo->get('core.create')) {
			JToolBarHelper::custom('link.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		if (empty($this->item->id)) {
			JToolBarHelper::cancel('link.cancel', 'JTOOLBAR_CANCEL');
		} else {
			JToolBarHelper::cancel('link.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::help('JHELP_COMPONENTS_REDIRECT_MANAGER_EDIT');
	}
}
