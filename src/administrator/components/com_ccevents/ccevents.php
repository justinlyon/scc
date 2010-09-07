<?php
/**
 *  $Id$: ccevents.php, Sep 2, 2010 11:31:15 PM jlyon
 *  Copyright (c) 2010, Tachometry Corporation
 *  http://www.tachometry.com
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

// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
else {
	// Require scoped controller
	switch (JRequest::getWord('scope')) {
        case 'home' : $controller = 'HomePage'; break;
        case 'annc' : $controller = 'Announcement'; break;
        case 'prgm' : $controller = 'Program'; break;
        case 'exbt' : $controller = 'Exhibition'; break;
        case 'cldr' : $controller = 'Calendar'; break;
	    case 'crse' : $controller = 'Course'; break;
	    case 'sers' : $controller = 'Series'; break;
	    case 'venu' : $controller = 'Venue'; break;
	    default : $controller = 'HomePage';
    }
    
	$path = JPATH_COMPONENT.DS.'controllers'.DS.strtolower($controller).'.php';
	if (file_exists($path)) {
	    require_once $path;
	}
}

// Create the controller
$classname  = 'CCEventsController' . ucwords($controller);
$controller = new $classname( );

// Perform the Request task
$controller->execute(JRequest::getWord('task'));

// Redirect if set by the controller
$controller->redirect();