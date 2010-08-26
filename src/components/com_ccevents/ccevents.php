<?php
/**
 *  $Id$: admin.ccevents.php, Jul 3, 2006 8:39:15 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * This file is the frontend dispatcher for the Joomla framework.
 * It's sole purpose is to instantiate the proper scoped Controller
 * class and invoke the target method.
 * 
 **/
 
// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Require scoped controller
switch (JRequest::getVar('scope')) {
	case 'cldr' : $controller = 'Calendar'; break;
	case 'crse' : $controller = 'Course'; break;
	case 'exbt' : $controller = 'Exhibition'; break;
	case 'home' : $controller = 'HomePage'; break;
	case 'prgm' : $controller = 'Program'; break;
	case 'sers' : $controller = 'Series'; break;
	case 'venu' : $controller = 'Venue'; break;
	default : $controller = 'HomePage';
}

require_once (JPATH_COMPONENT.DS.'controllers'.DS. strtolower($controller) .'.php');

// Create the controller
$classname	= 'CCEvents'. $controller .'Controller';
$controller = new $classname( );

// Perform the Request task, or assign the default
$task = (JRequest::getVar('task')) ? JRequest::getVar('task') : 'execute';
$controller->$task();

// Redirect if set by the controller
$controller->redirect();

?>
