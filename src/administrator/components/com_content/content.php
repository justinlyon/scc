<?php
/**
 * @version		$Id: content.php 14963 2010-02-21 09:48:58Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_content')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependencies
jimport('joomla.application.component.controller');

$controller = JController::getInstance('Content');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
