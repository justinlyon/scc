<?php
/**
 * @version		$Id: view.html.php 17071 2010-05-15 08:03:01Z chdemko $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of template styles.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_templates
 * @since		1.6
 */
class TemplatesViewStyles extends JView
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
		$canDo	= TemplatesHelper::getActions();
		$isSite	= ($state->get('filter.client_id') == 0);

		JToolBarHelper::title(JText::_('COM_TEMPLATES_MANAGER_STYLES'), 'thememanager');

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::makeDefault('styles.setDefault', 'COM_TEMPLATES_TOOLBAR_SET_HOME');
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('style.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.create') && $isSite) {
			JToolBarHelper::addNew('styles.duplicate', 'JTOOLBAR_DUPLICATE');
		}

		if ($canDo->get('core.delete') && $isSite) {
			JToolBarHelper::divider();
			JToolBarHelper::deleteList('', 'styles.delete','JTOOLBAR_DELETE');
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_templates');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_EXTENSIONS_TEMPLATE_MANAGER_STYLES');
	}
}
