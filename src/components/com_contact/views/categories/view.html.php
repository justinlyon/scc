<?php
/**
 * @version		$Id: view.html.php 17855 2010-06-23 17:46:38Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Content categories view.
 *
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @since 1.6
 */
class ContactViewCategories extends JView
{
	protected $state = null;
	protected $item = null;
	protected $items = null;
	protected $pagination = null;

	/**
	 * Display the view
	 *
	 * @return	mixed	False on error, null otherwise.
	 */
	function display($tpl = null)
	{
		// Initialise variables
		$state		= $this->get('State');
		$items		= $this->get('Items');
		$parent		= $this->get('Parent');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		if ($items === false) {
			//TODO Raise error for missing category here
		}

		if ($parent == false) {
			//TODO Raise error for missing parent category here
		}

		$params = &$state->params;

		$items = array($parent->id => $items);

		$this->assign('maxLevel',	$params->get('maxLevel', -1));
		$this->assignRef('params',		$params);
		$this->assignRef('parent',		$parent);
		$this->assignRef('items',		$items);

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if($menu)
		{
			$this->params->def('page_heading', $this->params->def('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('COM_CONTACT_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = htmlspecialchars_decode($app->getCfg('sitename'));
		}
		elseif ($app->getCfg('sitename_pagetitles', 0)) {
			$title = JText::sprintf('JPAGETITLE', htmlspecialchars_decode($app->getCfg('sitename')), $title);
		}
		$this->document->setTitle($title);
	}
}
