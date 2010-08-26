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
 
if (!defined('WEB_INF')) {
    @define('WEB_INF', realpath(dirname(__FILE__) . '/../../WEB-INF'));
}

// Set the relative path and redirect to the 'admin.ccevent.php'

require_once realpath(dirname(__FILE__) . '/../../app/admin/admin.ccevents.php');

?>
