<?php
/**
 * @version		$Id: helper.php 17852 2010-06-23 17:40:30Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	mod_related_items
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';

class modRelatedItemsHelper
{
	function getList($params)
	{
		$db			= JFactory::getDbo();
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();
		$userId		= (int) $user->get('id');
		$count		= intval($params->get('count', 5));
		$groups		= implode(',', $user->authorisedLevels());
		$date		= JFactory::getDate();

		$option		= JRequest::getCmd('option');
		$view		= JRequest::getCmd('view');

		$temp		= JRequest::getString('id');
		$temp		= explode(':', $temp);
		$id			= $temp[0];

		$showDate	= $params->get('showDate', 0);
		$nullDate	= $db->getNullDate();
		$now		= $date->toMySQL();
		$related	= array();
		$query		= $db->getQuery(true);

		if ($option == 'com_content' && $view == 'article' && $id)
		{
			// select the meta keywords from the item

			$query->select('metakey');
			$query->from('#__content');
			$query->where('id = ' . (int) $id);
			$db->setQuery($query);

			if ($metakey = trim($db->loadResult()))
			{
				// explode the meta keys on a comma
				$keys = explode(',', $metakey);
				$likes = array ();

				// assemble any non-blank word(s)
				foreach ($keys as $key)
				{
					$key = trim($key);
					if ($key) {
						$likes[] = ',' . $db->getEscaped($key) . ','; // surround with commas so first and last items have surrounding commas
					}
				}

				if (count($likes))
				{
					// select other items based on the metakey field 'like' the keys found
					$query->clear();
					$query->select('a.id');
					$query->select('a.title');
					$query->select('DATE_FORMAT(a.created, "%Y-%m-%d") as created');
					$query->select('a.catid');
					$query->select('cc.access AS cat_access');
					$query->select('cc.published AS cat_state');
					$query->select('CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug');
					$query->select('CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug');
					$query->from('#__content AS a');
					$query->leftJoin('#__content_frontpage AS f ON f.content_id = a.id');
					$query->leftJoin('#__categories AS cc ON cc.id = a.catid');
					$query->where('a.id != ' . (int) $id);
					$query->where('a.state = 1');
					$query->where('a.access IN (' . $groups . ')');
					$query->where('(CONCAT(",", REPLACE(a.metakey, ", ", ","), ",") LIKE "%'.implode('%" OR CONCAT(",", REPLACE(a.metakey, ", ", ","), ",") LIKE "%', $likes).'%")'); //remove single space after commas in keywords)
					$query->where('(a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).')');
					$query->where('(a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).')');

					// Filter by language
					if ($app->getLanguageFilter()) {
						$query->where('a.language in (' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
					}

					$db->setQuery($query);
					$temp = $db->loadObjectList();

					if (count($temp))
					{
						foreach ($temp as $row)
						{
							if ($row->cat_state == 1)
							{
								$row->route = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug));
								$related[] = $row;
							}
						}
					}
					unset ($temp);
				}
			}
		}

		return $related;
	}
}
