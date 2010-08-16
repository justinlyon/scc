<?php
/**
 * @version		$Id: view.html.php 18212 2010-07-22 06:02:54Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of clients.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class BannersViewClients extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
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
		require_once JPATH_COMPONENT.'/helpers/banners.php';

		$canDo	= BannersHelper::getActions();

		JToolBarHelper::title(JText::_('COM_BANNERS_MANAGER_CLIENTS'), 'banners-clients.png');
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('client.add','JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('client.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {
			if ($this->state->get('filter.published') != 2){
				JToolBarHelper::divider();
				JToolBarHelper::custom('clients.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('clients.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			if ($this->state->get('filter.published') != -1 ) {
				JToolBarHelper::divider();
				if ($this->state->get('filter.published') != 2) {
					JToolBarHelper::archiveList('clients.archive','JTOOLBAR_ARCHIVE');
				}
				else if ($this->state->get('filter.published') == 2) {
					JToolBarHelper::unarchiveList('clients.publish', 'JTOOLBAR_UNARCHIVE');
				}
			}
		}
		if(JFactory::getUser()->authorise('core.manage','com_checkin')) {
			JToolBarHelper::custom('clients.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'clients.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('clients.trash','JTOOLBAR_TRASH');
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_banners');
		}
		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_BANNERS_CLIENTS');
	}
}
