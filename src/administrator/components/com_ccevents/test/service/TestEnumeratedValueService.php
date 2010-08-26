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
require_once WEB_INF . '/service/EnumeratedValueService.php';
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');

class TestEnumeratedValueService extends UnitTestCase {

	private $service = NULL;
	
    function __construct() {
        parent::__construct();
    }
    
    function setUp() {
    	$this->service = new EnumeratedValueService();
    }

	function tearDown() {
	}
	
	function testFetch() {
		// magic cookies - change as needed when new values are added
		// refer to the the database setup script (config/setup/init.php)
		$pubStateCount = 3;
		$eventStatusCount = 3;
		$programTypeCount = 3;
		$resourceTypeCount = 2;
		
		$result = $this->service->fetch();
		$this->assertEqual(count($result),4);
		$this->assertEqual(count($result['PublicationState']),$pubStateCount);
		$this->assertEqual(count($result['EventStatus']),$eventStatusCount);
		$this->assertEqual(count($result['ProgramType']),$programTypeCount);
		$this->assertEqual(count($result['ResourceType']),$resourceTypeCount);
		
		$result = $this->service->fetch('PublicationState');
		$this->assertEqual(count($result),1);
		$this->assertEqual(count($result['PublicationState']),$pubStateCount);
		
		$result = $this->service->fetch('EventStatus');
		$this->assertEqual(count($result),1);
		$this->assertEqual(count($result['EventStatus']),$eventStatusCount);
		
		$result = $this->service->fetch('ProgramType');
		$this->assertEqual(count($result),1);
		$this->assertEqual(count($result['ProgramType']),$programTypeCount);
		
		$result = $this->service->fetch('ResourceType');
		$this->assertEqual(count($result),1);
		$this->assertEqual(count($result['ResourceType']),$resourceTypeCount);
		
		
	}
}

// standalone test
if (! defined('MAIN')) {
    @define('MAIN', true);

	require_once WEB_INF . '/service/EnumeratedValueService.php'; 
	$test = new TestEnumeratedValueService();
	$test->run(new HtmlReporter());
}
?>
