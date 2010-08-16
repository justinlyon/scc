<?php
/**
 * @version		$Id: users.php 16739 2010-05-04 06:16:24Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT.'/helpers/route.php';

// Launch the controller.
$controller = JController::getInstance('Users');
$controller->execute(JRequest::getCmd('task', 'display'));
$controller->redirect();