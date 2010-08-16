<?php
/**
 * @version		$Id: helper.php 17852 2010-06-23 17:40:30Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	mod_articles_archive
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modArchiveHelper
{
	function getList(&$params)
	{
		//get database
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('MONTH(created) AS created_month, created, id, title, YEAR(created) AS created_year');
		$query->from('#__content');
		$query->where('state = 2 AND checked_out = 0');
		$query->group('created_year DESC, created_month DESC');

		$db->setQuery($query, 0, intval($params->get('count')));
		$rows = $db->loadObjectList();

		$app	= JFactory::getApplication();
		$menu	= $app->getMenu();
		$item	= $menu->getItems('link', 'index.php?option=com_content&view=archive', true);
		$itemid = isset($item) ? '&Itemid='.$item->id : '';

		$i		= 0;
		$lists	= array();
		foreach ($rows as $row) {
			$date = JFactory::getDate($row->created);

			$created_month	= $date->format("n");
			$month_name		= $date->format("F");
			$created_year	= $date->format("Y");

			$lists[$i]->link	= JRoute::_('index.php?option=com_content&view=archive&year='.$created_year.'&month='.$created_month.$itemid);
			$lists[$i]->text	= JText::sprintf('MOD_ARTICLES_ARCHIVE_DATE',$month_name,$created_year);
			$i++;
		}
		return $lists;
	}
}
