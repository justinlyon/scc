<?php
/**
 *  $Id: ProjectTestSuite.php 133 2006-06-30 09:40:09Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
@define('MAIN', true);

if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/../WEB-INF');
}
require_once WEB_INF . '/base.include.php'; 
require_once WEB_INF . '/pdo/model.php'; 

require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');

$test = &new GroupTest('Project Test Suite (all tests)');

// add other test suites/files below as needed
require_once 'pdo/PackageTestSuite.php';
$test->addTestCase(new PdoTestSuite('pdo'));

require_once 'service/PackageTestSuite.php';
$test->addTestCase(new ServiceTestSuite('service'));

require_once 'web/PackageTestSuite.php';
$test->addTestCase(new WebTestSuite('web'));

$test->run(new HtmlReporter());

?>