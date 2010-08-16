<?php
/**
 * @version		$Id: mod_banners.php 14276 2010-01-18 14:20:28Z louis $
 * @package		Joomla.Site
 * @subpackage	mod_banners
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$headerText	= trim($params->get('header_text'));
$footerText	= trim($params->get('footer_text'));

require_once JPATH_ROOT . '/administrator/components/com_banners/helpers/banners.php';
BannersHelper::updateReset();
$list = &modBannersHelper::getList($params);
require JModuleHelper::getLayoutPath('mod_banners', $params->get('layout', 'default'));
