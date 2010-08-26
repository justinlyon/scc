<?php
/**
 *  $Id $
 *  Copyright (c) 2006, Tachometry Corporation
 *      http://www.tachometry.com
 *
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

 /**
  * Localized constants (can vary by deployment)
  */

  // run from within the eclipse workspace:
  define('SERVER_BASE_DIR','/Applications/MAMP/htdocs/scc/src');

  // run from the XAMPP apache htdocs directory:
  // define('SERVER_BASE_DIR','c:/tools/xampp/htdocs');

  // shared third-party dependencies (auto-appended to include path)
  //define('SERVER_LIB_DIR', SERVER_BASE_DIR . '/includes');

  // base directory for this application
  define('WEBAPP_BASE_DIR', SERVER_BASE_DIR . '/administrator/components/com_ccevents');

  // Set the local error reporting
  error_reporting(E_ALL ^ E_NOTICE);
  ini_set('display_errors', 1);

  // Set the base dir for other includes
  set_include_path(get_include_path() . PATH_SEPARATOR . WEBAPP_BASE_DIR.DS.'WEB-INF'.DS.'lib' . PATH_SEPARATOR . '/usr/local/PEAR' . PATH_SEPARATOR . SERVER_BASE_DIR);
  
?>
