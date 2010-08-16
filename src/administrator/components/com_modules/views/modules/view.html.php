<?php
/**
 * @version		$Id: view.html.php 17858 2010-06-23 17:54:28Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of modules.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_modules
 * @since		1.6
 */
class ModulesViewModules extends JView
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
		$state	= $this->get('State');
		$canDo	= ModulesHelper::getActions();

		JToolBarHelper::title(JText::_('COM_MODULES_MANAGER_MODULES'), 'module.png');

		if ($canDo->get('core.create')) {
			//JToolBarHelper::addNew('module.add');
			$bar = JToolBar::getInstance('toolbar');
			$bar->appendButton('Popup', 'new', 'JTOOLBAR_NEW', 'index.php?option=com_modules&amp;view=select&amp;tmpl=component', 850, 400);
		}

		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('module.edit','JTOOLBAR_EDIT');
		}

		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('modules.duplicate', 'copy.png', 'copy_f2.png','JTOOLBAR_DUPLICATE', true);
		}

		if ($canDo->get('core.edit')) {
			JToolBarHelper::divider();
			JToolBarHelper::custom('modules.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('modules.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
		}

		if (JFactory::getUser()->authorise('core.manage','com_checkin')) {
			JToolBarHelper::divider();
			JToolBarHelper::custom('modules.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}

		if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'modules.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('modules.trash','JTOOLBAR_TRASH');
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_modules');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_EXTENSIONS_MODULE_MANAGER');
	}
}
