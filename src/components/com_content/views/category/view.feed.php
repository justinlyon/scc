<?php
/**
 * @version		$Id: view.feed.php 17855 2010-06-23 17:46:38Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
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
	function display()
	{
		$app = JFactory::getApplication();

		$doc	= JFactory::getDocument();
		$params = $app->getParams();

		// Get some data from the model
		JRequest::setVar('limit', $app->getCfg('feed_limit'));
		$category	= $this->get('Category');
		$rows		= $this->get('Items');

		$doc->link = JRoute::_(ContentHelperRoute::getCategoryRoute($category->id));

		foreach ($rows as $row)
		{
			// strip html from feed item title
			$title = $this->escape($row->title);
			$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');

			// Compute the article slug
			$row->slug = $row->alias ? ($row->id . ':' . $row->alias) : $row->id;

			// url link to article
			// & used instead of &amp; as this is converted by feed creator
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catid), false);

			// strip html from feed item description text
			// TODO: Only pull fulltext if necessary (actually, just get the necessary fields).
			$description	= ($params->get('feed_summary', 0) ? $row->introtext/*.$row->fulltext*/ : $row->introtext);
			$author			= $row->created_by_alias ? $row->created_by_alias : $row->author;
			@$date			= ($row->created ? date('r', strtotime($row->created)) : '');

			// load individual item creator class
			$item = new JFeedItem();
			$item->title		= $title;
			$item->link			= $link;
			$item->description	= $description;
			$item->date			= $date;
			$item->category		= $row->category;

			// loads item info into rss array
			$doc->addItem($item);
		}
	}
}
