<?php
/**
 *  $Id: PackageTestSuite.php 133 2006-06-30 09:40:09Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/../../WEB-INF');
}
require_once WEB_INF . '/base.include.php'; 

require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');

class PdoTestSuite extends GroupTest {
    function __construct($path = '.') {
        $this->GroupTest('Package Test Suite (PDO)');
        
        // add new tests below
        $this->addTestFile($path . '/TestEnumeration.php');
        $this->addTestFile($path . '/TestEvent.php');
    }
}

// package test
if (! defined('MAIN')) {
    @define('MAIN', true);

	require_once WEB_INF . '/pdo/model.php'; 
	$test = new PdoTestSuite();
	$test->run(new HtmlReporter());
}

?>
