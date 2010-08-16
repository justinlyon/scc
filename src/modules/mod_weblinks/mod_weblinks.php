<?php
/**
 * @version		$Id: mod_weblinks.php 16235 2010-04-20 04:13:25Z pasamio $
 * @package		Joomla.Site
 * @subpackage	mod_related_items
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the weblinks functions only once
require_once dirname(__FILE__).DS.'helper.php';

$list = modWeblinksHelper::getList($params);

if (!count($list)) {
	return;
}
require JModuleHelper::getLayoutPath('mod_weblinks',$params->get('layout', 'default'));
