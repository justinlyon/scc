<?php
/**
 * @version		$Id: helper.php 14537 2010-02-04 00:29:14Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		Joomla.Site
 * @subpackage	mod_unread
 * @since		1.6
 */
abstract class ModUnreadHelper
{
	/**
	 * Count the number of unread messages.
	 *
	 * @return	mixed	The number of unread messages, or false on error.
	 */
	public static function getCount()
	{
		// Initialise variables.
		$db		= JFactory::getDbo();
		$user	= JFactory::getUser();

		// Get the number of unread messages in your inbox.
		$query	= $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from('#__messages');
		$query->where('state = 0 AND user_id_to = '.(int) $user->get('id'));

		$result = (int) $db->setQuery($query)->loadResult();

		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
			return false;
		}

		return $result;
	}
}
