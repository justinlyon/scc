<?php
/**
 *  $Id: TestEnumeration.php 131 2006-06-30 09:35:58Z tevans $
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

class TestEnumeration extends UnitTestCase {

	private $pdo = NULL;
	
    function __construct() {
        parent::__construct();
    }
    
    function setUp() {
    	$this->pdo = epManager::instance();
    }

	function tearDown() {
	}
	
	function testCreateDeletePubState() {

		$t = $this->pdo->create(TestEnumeration::PUB_STATE);

		$this->assertTrue($t->getScope() == TestEnumeration::PUB_STATE);
		$t->value = "Published"; 
		$t->setDescription("This content has been published to the live website");
		$this->assertTrue($this->assertTrue($t->oid == 0));
		$this->pdo->commit($t);
		$this->assertTrue($t->oid > 0);
		$this->assertTrue($t->isPublished());
		
		$this->assertTrue($this->pdo->delete($t));
	}

	function testCreateDeleteEventStatus() {

		$t = $this->pdo->create(TestEnumeration::EVENT_STATUS);

		$this->assertTrue($t->getScope() == TestEnumeration::EVENT_STATUS);
		$t->value = "Sold Out"; 
		$t->setDescription("There are no tickets available for this event");
		$this->assertTrue($t->oid == 0);
		$this->assertTrue($this->pdo->commit($t));
		$this->assertTrue($t->oid > 0);
		
		$this->assertTrue($this->pdo->delete($t));
	}

	function testCreateDeleteProgramType() {

		$t = $this->pdo->create(TestEnumeration::PROGRAM_TYPE);

		$this->assertTrue($t->getScope() == TestEnumeration::PROGRAM_TYPE);
		$t->value = "Family"; 
		$t->setDescription("Program content is family-friendly");
		$this->assertTrue($t->oid == 0);
		$this->assertTrue($this->pdo->commit($t));
		$this->assertTrue($t->oid > 0);
		
		$this->assertTrue($this->pdo->delete($t));
	}

	function testCreateDeleteResourceType() {

		$t = $this->pdo->create(TestEnumeration::RESOURCE_TYPE);

		$this->assertTrue($t->getScope() == TestEnumeration::RESOURCE_TYPE);
		$t->value = "Joomla"; 
		$t->setDescription("Content management component");
		$this->assertTrue($t->oid == 0);
		$this->assertTrue($this->pdo->commit($t));
		$this->assertTrue($t->oid > 0);
		
		$this->assertTrue($this->pdo->delete($t));
	}

	function testFindEnumerations() {
		
		// find by example (single scope)
		$filter = $this->pdo->create(TestEnumeration::PUB_STATE);
		$values = $this->pdo->find($filter);
		$this->assertTrue(count($values) > 0);
		foreach ($values as $enum) {
			$this->assertTrue($enum->getScope() == TestEnumeration::PUB_STATE);
		}

		// find by query (all entries)
		$count = $this->pdo->find("count(*) from EnumeratedValue");
		$this->assertTrue($count > count($values));
		$values = $this->pdo->find("from EnumeratedValue");
		$this->assertTrue($count > 0 && count($values) == $count);
	}

	const PUB_STATE = 'PublicationState';
	const EVENT_STATUS = 'EventStatus';
	const PROGRAM_TYPE = 'ProgramType';
	const RESOURCE_TYPE = 'ResourceType';
}

// standalone test
if (! defined('MAIN')) {
    @define('MAIN', true);

	require_once WEB_INF . '/pdo/model.php'; 
	$test = new TestEnumeration();
	$test->run(new HtmlReporter());
}
?>
