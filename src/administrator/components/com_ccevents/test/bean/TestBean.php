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

require_once WEB_INF . '/base.include.php'; 

require_once('tachometry/util/BaseBean.php');

require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');

class TestBean extends UnitTestCase {

    function __construct() {
        parent::__construct();
    }
    
    function setUp() {
    }

	function tearDown() {
	}
	
	function testDemoBean() {
		$bean = new DemoBean(); // defined in BaseBean file
		
		// Java style methods
		$bean->setDemo('v1');
		$this->assertEqual($bean->getDemo(), 'v1');
		
		// PHP style methods
		$bean->set_demo('v2');
		$this->assertEqual($bean->get_demo(), 'v2');

		// direct access (not recommended)
		$bean->demo = 'v3';
		$this->assertEqual($bean->demo, 'v3');

		$this->assertError($bean->testUnknown());
	}
}

// standalone test
if (! defined('MAIN')) {
    @define('MAIN', true);

	$test = new TestBean();
	$test->run(new HtmlReporter());
}
?>
