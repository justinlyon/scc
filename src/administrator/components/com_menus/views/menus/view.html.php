<?php
/**
 * @version		$Id: view.html.php 17071 2010-05-15 08:03:01Z chdemko $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * The HTML Menus Menu Menus View.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_menus
 * @version		1.6
 */
class MenusViewMenus extends JView
{
	protected $items;
	protected $modules;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->modules		= $this->get('Modules');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::display($tpl);
		$this->addToolbar();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_MENUS_VIEW_MENUS_TITLE'), 'menumgr.png');

		JToolBarHelper::custom('menu.add', 'new.png', 'new_f2.png', 'JTOOLBAR_NEW', false);
		JToolBarHelper::custom('menu.edit', 'edit.png', 'edit_f2.png', 'JTOOLBAR_EDIT', true);
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'menus.delete','JTOOLBAR_DELETE');
		JToolBarHelper::divider();
		JToolBarHelper::custom('menus.rebuild', 'refresh.png', 'refresh_f2.png', 'JTOOLBAR_REBUILD', false);
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_menus');
		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_MENUS_MENU_MANAGER');
	}
}
