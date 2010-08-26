<?php
/**
 *  $Id$: TestExhibitionAction.php, Aug 13, 2006 2:07:11 PM nchanda
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
require_once WEB_INF . '/actions/ExhibitionAction.php';
require_once('simpletest/web_tester.php');
require_once('simpletest/reporter.php');

class TestExhibitionAction extends WebTestCase {

	private $action = NULL;
	
    function __construct() {
        parent::__construct();
    }
    
    function setUp() {
    	$this->action = new ExhibitionAction();
    }

	function tearDown() {
	}
	
	
	function testTrue()
	{
		$this->assertTrue(true);	
	}
	
		
}

// standalone test
if (! defined('MAIN')) {
    @define('MAIN', true);

	require_once WEB_INF . '/actions/ExhibitionAction.php'; 
	$test = new TestExhibitionAction();
	$test->run(new HtmlReporter());
}
	
?>
