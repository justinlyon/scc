<?php
/**
 * version $Id: view.html.php 18148 2010-07-15 02:26:36Z infograf768 $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since 1.5
 */
class ContentViewCategory extends JView
{
	protected $state;
	protected $items;
	protected $category;
	protected $children;
	protected $pagination;

	protected $lead_items = array();
	protected $intro_items = array();
	protected $link_items = array();
	protected $columns = 1;

	function display($tpl = null)
	{
		$app	= JFactory::getApplication();
		$user	= JFactory::getUser();

		// Get some data from the models
		$state		= $this->get('State');
		$params		= $state->params;
		$items		= $this->get('Items');
		$category	= $this->get('Category');
		$children	= $this->get('Children');
		$parent		= $this->get('Parent');
		$pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		if ($category == false) {
			return JError::raiseWarning(404, JText::_('JGLOBAL_CATEGORY_NOT_FOUND'));
		}

		if ($parent == false) {
			//TODO Raise error for missing parent category here
		}

		// Check whether category access level allows access.
		$user	= JFactory::getUser();
		$groups	= $user->authorisedLevels();
		if (!in_array($category->access, $groups)) {
			return JError::raiseError(403, JText::_("JERROR_ALERTNOAUTHOR"));
		}

		// PREPARE THE DATA
		// Get the metrics for the structural page layout.
		$numLeading	= $params->def('num_leading_articles', 1);
		$numIntro	= $params->def('num_intro_articles', 4);
		$numLinks	= $params->def('num_links', 4);

		// Compute the article slugs and prepare introtext (runs content plugins).
		for ($i = 0, $n = count($items); $i < $n; $i++) {
			$item = &$items[$i];
			$item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

			// No link for ROOT category
			if ($item->parent_alias == 'root') {
				$item->parent_slug = null;
			}

			$item->event = new stdClass();

			$dispatcher = JDispatcher::getInstance();

			// Ignore content plugins on links.
			if ($i < $numLeading + $numIntro) {
				$item->introtext = JHtml::_('content.prepare', $item->introtext);

				$results = $dispatcher->trigger('onContentAfterTitle', array('com_content.article', &$item, &$item->params, 0));
				$item->event->afterDisplayTitle = trim(implode("\n", $results));

				$results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.article', &$item, &$item->params, 0));
				$item->event->beforeDisplayContent = trim(implode("\n", $results));

				$results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.article', &$item, &$item->params, 0));
				$item->event->afterDisplayContent = trim(implode("\n", $results));
			}
		}

		// For blog layouts, preprocess the breakdown of leading, intro and linked articles.
		// This makes it much easier for the designer to just interrogate the arrays.
		if ($this->_layout == 'blog') {
			$max = count($items);

			// The first group is the leading articles.
			$limit = $numLeading;
			for ($i = 0; $i < $limit && $i < $max; $i++) {
				$this->lead_items[$i] = &$items[$i];
			}

			// The second group is the intro articles.
			$limit = $numLeading + $numIntro;
			// Order articles across, then down (or single column mode)
			for ($i = $numLeading; $i < $limit && $i < $max; $i++) {
				$this->intro_items[$i] = &$items[$i];
			}

			$this->columns = max(1, $params->def('num_columns', 1));
			$order = $params->def('multi_column_order', 1);

			if ($order == 0 && $this->columns > 1) {
				// call order down helper
				$this->intro_items = ContentHelperQuery::orderDownColumns($this->intro_items, $this->columns);
			}

			// The remainder are the links.
			for ($i = $numLeading + $numIntro; $i < $max; $i++) {
				$this->link_items[$i] = &$items[$i];
			}
		}

		$children = array($category->id => $children);

		$this->assign('maxLevel', $params->get('maxLevel', -1));
		$this->assignRef('state', $state);
		$this->assignRef('items', $items);
		$this->assignRef('category', $category);
		$this->assignRef('children', $children);
		$this->assignRef('params', $params);
		$this->assignRef('parent', $parent);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('user', $user);

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway	= $app->getPathway();
		$title		= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('JGLOBAL_ARTICLES'));
		}

		$id = @$menu->query['id'];

		if ($menu && $menu->query['view'] != 'article' && $id != $this->category->id) {
			$this->params->set('page_subheading', $this->category->title);
			$path = array($this->category->title  => '');
			$category = $this->category->getParent();

			while ($id != $category->id && $category->id > 1) {
				$path[$category->title] = ContentHelperRoute::getCategoryRoute($category->id);
				$category = $category->getParent();
			}

			$path = array_reverse($path);

			foreach ($path as $title => $link) {
				$pathway->addItem($title, $link);
			}
		}

		$title = $this->params->get('page_title', '');

		if (empty($title)) {
			$title = htmlspecialchars_decode($app->getCfg('sitename'));
		} elseif ($app->getCfg('sitename_pagetitles', 0)) {
			$title = JText::sprintf('JPAGETITLE', htmlspecialchars_decode($app->getCfg('sitename')), $title);
		}

		$this->document->setTitle($title);

		if ($this->category->metadesc) {
			$this->document->setDescription($this->category->metadesc);
		}

		if ($this->category->metakey) {
			$this->document->setMetadata('keywords', $this->category->metakey);
		}

		if ($app->getCfg('MetaTitle') == '1') {
			$this->document->setMetaData('title', $this->category->getMetadata()->get('page_title'));
		}

		if ($app->getCfg('MetaAuthor') == '1') {
			$this->document->setMetaData('author', $this->category->getMetadata()->get('author'));
		}

		$mdata = $this->category->getMetadata()->toArray();

		foreach ($mdata as $k => $v) {
			if ($v) {
				$this->document->setMetadata($k, $v);
			}
		}

		// Add feed links
		if ($this->params->get('show_feed_link', 1)) {
			$link = '&format=feed&limitstart=';
			$attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
			$this->document->addHeadLink(JRoute::_($link . '&type=rss'), 'alternate', 'rel', $attribs);
			$attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
			$this->document->addHeadLink(JRoute::_($link . '&type=atom'), 'alternate', 'rel', $attribs);
		}
	}
}