<?php
/**
 * @version		$Id: view.html.php 16991 2010-05-12 15:56:56Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of search terms.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_search
 * @since		1.5
 */
class SearchViewSearches extends JView
{
	protected $enabled;
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
		$this->enabled		= $this->state->params->get('enabled');

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
		$canDo	= SearchHelper::getActions();

		JToolBarHelper::title(JText::_('COM_SEARCH_MANAGER_SEARCHES'), 'search.png');
		JToolBarHelper::custom('searches.reset', 'refresh.png', 'refresh_f2.png', 'JSEARCH_RESET', false);

		JToolBarHelper::divider();
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_search');
		}
		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_SEARCH');
	}
}