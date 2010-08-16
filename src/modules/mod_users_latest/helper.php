<?php
/**
 * @version		$Id: helper.php 17852 2010-06-23 17:40:30Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	mod_users_latest
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modUsersLatestHelper
{
	// get users sorted by activation date

	function getUsers($params)
	{
		$db		= JFactory::getDbo();
		$result	= null;
		$query	= $db->getQuery(true);
		$query->select('a.id, a.name, a.username, a.activation');
		$query->order('a.activation DESC');
		$query->from('#__users AS a');
		$db->setQuery($query,0,$params->get('shownumber'));;
		$result = $db->loadObjectList();
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->stderr());
		}

		return $result;
	}
}
