<?php
/**
 * @version		$Id: mod_online.php 14276 2010-01-18 14:20:28Z louis $
 * @package		Joomla.Administrator
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the mod_online functions only once.
require_once dirname(__FILE__).'/helper.php';

// Get layout data.
$count = modOnlineHelper::getOnlineCount();

if ($count !== false) {
	// Render the module.
	require JModuleHelper::getLayoutPath('mod_online', $params->get('layout', 'default'));
}