<?php
/**
 * @version		$Id: search.php 15649 2010-03-27 18:08:22Z hackwar $
 * @package		Joomla.Site
 * @subpackage	Search
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

// Create the controller
$controller = JController::getInstance('Search');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();