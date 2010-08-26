<?php
/**
 *  $Id $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

// Initialize the PDO data model
require_once('ezpdo/ezpdo_runtime.php'); 
epLoadConfig(dirname(__FILE__) . '/config.xml');

// Include key classes from the data model
require_once dirname(__FILE__) . '/../beans/Program.php';
require_once dirname(__FILE__) . '/../beans/Exhibition.php';
require_once dirname(__FILE__) . '/../beans/Course.php';

?>

