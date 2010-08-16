<?php
/**
 * @version		$Id: view.html.php 17132 2010-05-17 06:16:06Z chdemko $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of newsfeeds.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_newsfeeds
 * @since		1.6
 */
class NewsfeedsViewNewsfeeds extends JView
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
		$state	= $this->get('State');
		$canDo	= NewsfeedsHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_NEWSFEEDS_MANAGER_NEWSFEEDS'), 'newsfeeds.png');
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('newsfeed.add','JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('newsfeed.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::custom('newsfeeds.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('newsfeeds.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('newsfeeds.archive','JTOOLBAR_ARCHIVE');
		}
		if(JFactory::getUser()->authorise('core.manage','com_checkin')) {
			JToolBarHelper::custom('newsfeeds.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
		if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'newsfeeds.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('newsfeeds.trash','JTOOLBAR_TRASH');
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_newsfeeds');
		}
		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_NEWSFEEDS_FEEDS');
	}
}
