<?php
/**
 * @version		$Id: banners.php 17855 2010-06-23 17:46:38Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JController::getInstance('Banners');
$controller->execute(JRequest::getVar('task','click'));
$controller->redirect();
