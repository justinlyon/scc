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
if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/WEB-INF');
}
require_once WEB_INF . '/base.include.php'; 
require_once WEB_INF . '/LocalDispatcher.php';
 
$scope = $_REQUEST['scope'];
$task= $_REQUEST['task'];

// Call the dispatch method
$dispatcher = new LocalDispatcher();
$ad = $dispatcher->dispatch($scope, $task); 

$logger->debug("admin.ccevents complete");
?>
