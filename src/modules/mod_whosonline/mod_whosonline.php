<?php
/**
 * @version		$Id: mod_whosonline.php 14565 2010-02-04 06:59:25Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	mod_whosonline
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the whosonline functions only once
require_once dirname(__FILE__).DS.'helper.php';

$showmode = $params->get('showmode', 0);

if ($showmode == 0 || $showmode == 2) {
	$count	= modWhosonlineHelper::getOnlineCount();
}

if ($showmode > 0) {
	$names	= modWhosonlineHelper::getOnlineUserNames();
}
$linknames = $params->get('linknames', 0);
require JModuleHelper::getLayoutPath('mod_whosonline', $params->get('layout', 'default'));
