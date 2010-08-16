<?php
/**
 * @version		$Id: mod_unread.php 14276 2010-01-18 14:20:28Z louis $
 * @package		Joomla.Administrator
 * @subpackage	mod_unread
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include dependancies.
require_once dirname(__FILE__).'/helper.php';

$unread = ModUnreadHelper::getCount();

if ($unread !== false) {
	// Set the inbox link.
	$inboxLink = JRequest::getInt('hidemainmenu') ? null : JRoute::_('index.php?option=com_messages');

	require JModuleHelper::getLayoutPath('mod_unread', $params->get('layout', 'default'));
}
