<?php
/**
 * @version		$Id: categories.php 17851 2010-06-23 17:39:31Z eddieajau $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

/**
 * Categories Search plugin
 *
 * @package		Joomla
 * @subpackage	Search
 * @since		1.6
 */
class plgSearchCategories extends JPlugin
{
	/**
	 * @return array An array of search areas
	 */
	function onContentSearchAreas()
	{
		static $areas = array(
		'categories' => 'PLG_SEARCH_CATEGORIES_CATEGORIES'
		);
		return $areas;
	}

	/**
	 * Categories Search method
	 *
	 * The sql must return the following fields that are
	 * used in a common display routine: href, title, section, created, text,
	 * browsernav
	 * @param string Target search string
	 * @param string mathcing option, exact|any|all
	 * @param string ordering option, newest|oldest|popular|alpha|category
	 * @param mixed An array if restricted to areas, null if search all
	 */
	function onContentSearch($text, $phrase='', $ordering='', $areas=null)
	{
		$db		= JFactory::getDbo();
		$user	= JFactory::getUser();
		$app	= JFactory::getApplication();
		$groups	= implode(',', $user->authorisedLevels());
		$searchText = $text;

		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
				return array();
			}
		}

		$sContent		= $this->params->get('search_content',		1);
		$sArchived		= $this->params->get('search_archived',		1);
		$limit			= $this->params->def('search_limit',		50);
		$state			= array();
		if ($sContent) {
			$state[]=1;
		}
		if ($sArchived) {
			$state[]=2;
		}


		$text = trim($text);
		if ($text == '') {
			return array();
		}

		switch ($ordering) {
			case 'alpha':
				$order = 'a.title ASC';
				break;

			case 'category':
			case 'popular':
			case 'newest':
			case 'oldest':
			default:
				$order = 'a.title DESC';
		}

		$text	= $db->Quote('%'.$db->getEscaped($text, true).'%', false);
		$query	= $db->getQuery(true);

		$return = array();
		if (!empty($state)) {
			$query->select('a.title, a.description AS text, "" AS created, "2" AS browsernav, a.id AS catid, '
						.'CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug');
			$query->from('#__categories AS a');
			$query->where('(a.title LIKE '. $text .' OR a.description LIKE '. $text .') AND a.published IN ('.implode(',',$state).') AND a.extension = \'com_content\''
						.'AND a.access IN ('. $groups .')' );
			$query->group('a.id');
			$query->order($order);
			if ($app->isSite() && $app->getLanguageFilter()) {
				$query->where('a.language in (' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
			}

			$db->setQuery($query, 0, $limit);
			$rows = $db->loadObjectList();

			if ($rows) {
				$count = count($rows);
				for ($i = 0; $i < $count; $i++) {
					$rows[$i]->href = ContentHelperRoute::getCategoryRoute($rows[$i]->slug);
					$rows[$i]->section	= JText::_('JCATEGORY');
				}

				$return = array();
				foreach($rows AS $key => $category) {
					if (searchHelper::checkNoHTML($category, $searchText, array('name', 'title', 'text'))) {
						$return[] = $category;
					}
				}
			}
		}
		return $return;
	}
}
