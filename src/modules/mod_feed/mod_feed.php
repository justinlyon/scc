<?php
/**
 * @version		$Id: mod_feed.php 15983 2010-04-10 06:58:29Z hackwar $
 * @package		Joomla.Site
 * @subpackage	mod_feed
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$rssurl	= $params->get('rssurl', '');
$rssrtl	= $params->get('rssrtl', 0);

//check if feed URL has been set
if (empty ($rssurl))
{
	echo '<div>';
	echo JText::_('MOD_FEED_ERR_NO_URL');
	echo '</div>';
	return;
}

$feed = modFeedHelper::getFeed($params);
require JModuleHelper::getLayoutPath('mod_feed', $params->get('layout', 'default'));
