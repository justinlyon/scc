<?php
/**
 * @version		$Id: mod_related_items.php 16306 2010-04-21 18:47:28Z louis $
 * @package		Joomla.Site
 * @subpackage	mod_related_items
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$cacheparams = new stdClass;
$cacheparams->cachemode = 'safeuri';
$cacheparams->class = 'modRelatedItemsHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = array('id'=>'int','Itemid'=>'int');

$list = JModuleHelper::ModuleCache ($module, $params, $cacheparams);

if (!count($list)) {
	return;
}

$showDate = $params->get('showDate', 0);

require JModuleHelper::getLayoutPath('mod_related_items', $params->get('layout', 'default'));
