<?php
/**
 *  $Id: TestEvent.php 133 2006-06-30 09:40:09Z tevans $
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

class TestEvent extends UnitTestCase {

	private $pdo = NULL;
	
    function __construct() {
        parent::__construct();
    }
    
    function setUp() {
    	$this->pdo = epManager::instance();
    }

	function tearDown() {
	}
	
	function testBasicEvent() {

		$e1 = $this->pdo->create('Event');

		// setters
		$e1->setTitle(get_class($this) . ': ' . date('Y-m-d_H:i:s'));
		$e1->setSubtitle('This is a test');
		$e1->setDescription('Auto-generated by SimpleTest');
		$e1->setSummary('Midsummer Woodwind Concert Series');
		$e1->setScheduleNote('Rainchecks will be issued in case of inclement weather');
		$e1->setPricing('$10 for Adults; 12 and under free');
		$e1->setTicketDesc('General Seating (outdoor)');
		$e1->setTicketUrl('http://ticketmaster.skirball.org/');

		// persistence
		$this->assertTrue($e1->getOid() == 0);
		$this->assertTrue($this->pdo->commit($e1));
		$this->assertTrue($e1->getOid() > 0);
		
		// search/compare
		$events = $this->pdo->find($e1, EP_GET_FROM_DB); // skip cache
		$this->assertTrue(is_array($events));
		$this->assertEqual(count($events), 1);
		$e2 = $events[0];
		//	$this->assertTrue($e1->epMatches($e2));
		$this->assertCopy($e1, $e2);

		// getters
		$this->assertEqual($e1->getOid(), $e2->getOid());
		$this->assertEqual($e1->getTitle(), $e2->getTitle());
		$this->assertEqual($e1->getSubtitle(), $e2->getSubtitle());
		$this->assertEqual($e1->getDescription(), $e2->getDescription());
		$this->assertEqual($e1->getSummary(), $e2->getSummary());
		$this->assertEqual($e1->getScheduleNote(), $e2->getScheduleNote());
		$this->assertEqual($e1->getPricing(), $e2->getPricing());
		$this->assertEqual($e1->getTicketDesc(), $e2->getTicketDesc());
		$this->assertEqual($e1->getTicketUrl(), $e2->getTicketUrl());
		
		$this->assertTrue($this->pdo->delete($e2));
	}
	
	function testSetupEvent() {

		$event = $this->pdo->create('Exhibition');

		// some local attributes
		$event->setTitle(get_class($this) . ': ' . date('Y-m-d_H:i:s'));
		$event->setSubtitle('This is a test');
		$event->setDescription('Auto-generated by SimpleTest');
		$this->assertTrue($event->getOid() == 0);
		$this->assertTrue($this->pdo->commit($event));
		$this->assertTrue($event->getOid() > 0);
		
		// linked object (association)
		$venue = $this->pdo->create('Venue');
		$venue->setName('Venue linked to event ' . $event->getOid() );
		$venue->setDescription('Auto-generated by SimpleTest');
		$event->setDefaultVenue($venue);
		$this->assertTrue($venue->getOid() == 0);

		$this->assertTrue($this->pdo->commit($event));
		
		// commit should include venue
		$this->assertTrue($venue->getOid() > 0);
		$this->assertEqual($venue, $event->getDefaultVenue());
		
		// linked object (composition)
		$gallery = $this->pdo->create('Gallery');
		$gallery->setName('Gallery linked to event ' . $event->getOid() );
		$gallery->setDescription('Auto-generated by SimpleTest');
		$event->setGallery($gallery);
		$this->assertTrue($gallery->getOid() == 0);

		$this->assertTrue($this->pdo->commit($event));
		
		// commit should include gallery
		$this->assertTrue($gallery->getOid() > 0);
		$this->assertEqual($gallery, $event->getGallery());
		
		// ensure that the event can be found via its venue
		$events = $this->pdo->find('from Exhibition where defaultVenue.name = ?', $venue->getName() );
		$this->assertEqual(count($events), 1);
		$this->assertEqual($events[0]->getOid(), $event->getOid());
		$this->assertCopy($events[0], $event);
		
		// ensure that the event can be found via its gallery
		$events = $this->pdo->find('from Exhibition where gallery.name = ?', $gallery->getName());
		$this->assertEqual(count($events), 1);
		$this->assertEqual($events[0]->getOid(), $event->getOid());
		$this->assertCopy($events[0], $event);
		
		$this->assertTrue($this->pdo->delete($event));

		$this->assertTrue(is_array($this->pdo->find($venue))); // association
		$this->assertFalse($this->pdo->find($gallery));  // composition
		
		$this->assertTrue($this->pdo->delete($venue));
	}
}

// standalone test
if (! defined('MAIN')) {
    @define('MAIN', true);

	require_once WEB_INF . '/pdo/model.php'; 
	$test = new TestEvent();
	$test->run(new HtmlReporter());
}
?>