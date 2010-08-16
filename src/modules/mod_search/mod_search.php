<?php
/**
 * @version		$Id: mod_search.php 15983 2010-04-10 06:58:29Z hackwar $
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$button			= $params->get('button', '');
$imagebutton	= $params->get('imagebutton', '');
$button_pos		= $params->get('button_pos', 'left');
$button_text	= $params->get('button_text', JText::_('MOD_SEARCH_SEARCHBUTTON_TEXT'));
$width			= intval($params->get('width', 20));
$maxlength		= $width > 20 ? $width : 20;
$text			= $params->get('text', JText::_('MOD_SEARCH_SEARCHBOX_TEXT'));
$set_Itemid		= intval($params->get('set_itemid', 0));
$moduleclass_sfx = $params->get('moduleclass_sfx', '');

if ($imagebutton) {
	$img = modSearchHelper::getSearchImage($button_text);
}
$mitemid = $set_Itemid > 0 ? $set_Itemid : JRequest::getInt('Itemid');
require JModuleHelper::getLayoutPath('mod_search', $params->get('layout', 'default'));
