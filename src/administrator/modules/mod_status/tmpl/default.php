<?php
/**
 * @version		$Id: default.php 17460 2010-06-03 11:04:38Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	mod_status
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

$hideLinks	= JRequest::getBool('hidemainmenu');
$output = array();

// Print the logged in users.
if ($params->get('show_loggedin_users', 1)) :
	$output[] = '<span class="loggedin-users">'.$online_num.' '.JText::_('MOD_STATUS_USERS').'</span>';
endif;

//  Print the inbox message.
if ($params->get('show_messages', 1)) :
	$output[] = '<span class="'.$inboxClass.'">'.
			($hideLinks ? '' : '<a href="'.$inboxLink.'">').
			$unread.' '.JText::_('MOD_STATUS_MESSAGES').
			($hideLinks ? '' : '</a>').
			'</span>';
endif;

// Print the Preview link to Main site.
	$output[] = '<span class="viewsite"><a href="'.JURI::root().'" target="_blank">'.JText::_('MOD_STATUS_VIEW_SITE').'</a></span>';

// Print the logout link.
	$output[] = '<span class="logout">' .
			($hideLinks ? '' : '<a href="'.$logoutLink.'">').
			JText::_('MOD_STATUS_LOG_OUT').
			($hideLinks ? '' : '</a>').
			'</span>';

// Print the back-end logged in users.
if ($params->get('show_loggedin_users_admin', 1)) :
	$output[] = '<span class="loggedin-users">'.$count.' '.JText::_('MOD_STATUS_BACKEND_USERS').'</span>';
endif;

// Reverse rendering order for rtl display.
if ($lang->isRTL()) :
	$output = array_reverse($output);
endif;

// Output the items.
foreach ($output as $item) :
	echo $item;
endforeach;