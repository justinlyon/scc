<?php
/**
 * @version		$Id: mod_articles_news.php 16235 2010-04-20 04:13:25Z pasamio $
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$list = modArticlesNewsHelper::getList($params);
require JModuleHelper::getLayoutPath('mod_articles_news', $params->get('layout', 'default'));
