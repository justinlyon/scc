	<?php
/**
 *  $Id$: HomePageAction.php, Sep 4, 2006 11:55:13 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/..');
}
require_once WEB_INF . '/base.include.php'; 
require_once WEB_INF . '/service/HomePageService.php';
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/service/CategoryService.php';
require_once WEB_INF . '/service/ScheduleService.php';
require_once WEB_INF . '/service/EnumeratedValueService.php';
require_once WEB_INF . '/service/GalleryService.php';
require_once WEB_INF . '/actions/MasterAction.php';
require_once WEB_INF . '/beans/HomePage.php';
require_once WEB_INF . '/beans/Address.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/beans/PublicationState.php';

require_once ('tachometry/util/CopyBeanOption.php');

class HomePageAction extends MasterAction
{
	private $homePageService;
	private $eventService;
	private $categoryService;
	private $scheduleService;
	private $enumeratedValueService;


	/**
	 * The default method if no task is given. Will return an initialized 
	 * summary page model bean.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean summary page model bean
	 */
	function execute($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::execute()");
		return $this->summary($mainframe);
	}

	/**
	 * A public wrapper for the private setSummaryModel() method
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the summary page model bean
	 */
	function summary($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::summary()');
		return $this->setSummaryModel($mainframe);
	}

	/**
	 * A public wrapper for the private setDetailModel() method.
	 * @param object  $mainframe The Joonla specific page object
	 * @return bean the detail page model bean
	 */
	function read($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::read()');
		if (!isset($_REQUEST['oid'])) {
			trigger_error('Required OID is not available.', E_USER_ERROR);
			// TODO forward to error page or return message
			return;
		}
		return $this->setDetailModel($_REQUEST['oid']);	
	}

	 /**
	 * Takes no action, but returns an detail page model
	 * @param Array $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	 function setup($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::setup()');
		
		$model = new DetailPageModel();
		$home_page = new HomePage();
		$model->setDetail($home_page);
		$model->setOptions($this->getDetailOptions());
		return $model;
	 }

	
	/**
	 * Deletes the records as identified by the list of oids
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the summary page model bean
	 */
	function delete($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::delete()');
		
		$service = $this->getHomePageService();
		$oids = $this->getFormOids();

		for($i=0; $i<count($oids); $i++)
		{
			$service->delete($oids[$i]);	
		}
		
		// TODO: Set the appropriate messages in the model object
		
		// return the summaries
		return $this->setSummaryModel($mainframe);	
	}
	

	/**
	 * Updates a home_page identified by the oid
	 * If the oid is null, the method will invoke
	 * the create() method. 
	 * @see save()
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	function apply($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::apply()');		
		return $this->update($mainframe);	
	}


	/**
	 * A public wrapper for the update() method.  Will prepare and 
	 * return a list of summaries.
	 * @see apply() Updates then returns the details page
	 * @see update() Updates the exent
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	function save($mainframe)
	{
		global $logger;		
		$logger->debug(get_class($this) . '::save()');
		
		// invoke the update
		$this->update($mainframe);
		
		// return the summaries
		return $this->setSummaryModel($mainframe);
	}

	 /**
	 * Sets the publication state of the given home_pages(s) to "Archived"
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function archive($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::archive()');
		
		$oids = $this->getFormOids();
		$this->changePubState($oids, PublicationState::ARCHIVED);
				
		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }	

	/**
	 * Sets the publication state of the given home_pages(s) to "Published"
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function publish($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::publish()');
		
		$oids = $this->getFormOids();
		$this->changePubState($oids, PublicationState::PUBLISHED);
				
		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }	


	/**
	 * Sets the publication state of the given home_pages(s) to "Unpublished"
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function unpublish($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::unpublish()');
		
		$oids = $this->getFormOids();
		$this->changePubState($oids, PublicationState::UNPUBLISHED);
				
		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }	



	/**
	 * Returns a DetailPageModel bean for the given oid
	 * 
	 * @access private
	 * @param int/string the oid for the target home_page
	 * @return bean DetailPageModel
	 */
	 private function setDetailModel($oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::setDetailModel($oid)");
	 	
	 	if ($oid == null) {
	 		trigger_error("Missing required OID.", E_USER_ERROR);
	 		return;	
	 	}	
	 	
	 	$vs = $this->getHomePageService();
	 	$dpm = new DetailPageModel();
	 	
	 	$bean = $vs->getHomePageById($oid);
	 	
	 	$dpm->setDetail($bean);
	 	$dpm->setOptions($this->getDetailOptions());

	 	return $dpm; 		 	
	 }



	/**
	 * Gets a list of home_pages.  If the $_REQUEST['archived'] attribute
	 * is true, will return the archived list.  Else will return the list
	 * of non-archived home_pages.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the home_pages summary page model bean
	 */
	private function setSummaryModel($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::setSummaryModel()');
		
		$service = $this->getHomePageService();
		$model = new SummaryPageModel();
		$pubStates = null;
		
		if (isset($_REQUEST['archived'])) {
			$pubStates = array(PublicationState::ARCHIVED);
		} 
		$logger->debug("Size of pubStates array: ". count($pubStates));
		
		$list = $service->getHomePagesByPubState($pubStates);
		$logger->debug("Size of home_pages array: ". count($list));
		
		// TODO Get Related Events	
		
		$model->setHomePages($list);
		
		return $model;
	}

	/**
	 * Creates a new home_page
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	private function create($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::create()");

		$service = $this->getHomePageService();
		$bean = $this->getBeanFromRequest();
		$model = new DetailPageModel();
		
		$model->setDetail($service->setupHomePage($bean));
		$model->setOptions($this->getDetailOptions());
		
		return $model;
	}
	
	
	/**
	 * Updates and home_page by given oid. If there is no oid
	 * it will invoke the create method.  Will also invoke
	 * the linkEvents() method to assign events to this home_page.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	private function update($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::update()");
		
		$bean = $this->getBeanFromRequest();
		$service = $this->getHomePageService();
		$model = new DetailPageModel();
		
		// is this a new event
		if($bean->getOid() == null) {
			$logger->debug("No home page id found.");
			return $this->create($mainframe);
		} 
		
		// Update the home_page
		$updated = $service->update($bean);		

		// Populate the page model
		$model->setDetail($updated);
		$model->setOptions($this->getDetailOptions());
	
		return $model;
	}


	/**
	 * Changes the PublicationState for each home_page identified by the 
	 * list of oids to the value passed by the calling method.
	 * 
	 * @access private
	 * @param array A list of oids
	 * @param string the target publication state value
	 */
	 private function changePubState($oids, $state)
	 {
	 	$service = $this->getHomePageService();
	 	for($i=0; $i<count($oids); $i++)
		{
			$home_page = $service->getHomePageById($oids[$i]);
			$home_page->setPubState($state);
			$service->update($home_page);	
		}
	 }


	/**
	 * Returns the associative array with all of the lists required to 
	 * render the html select elements on the detail page.
	 * 
	 * @return array An associative array of option values
	 */
	 private function getDetailOptions()
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::getDetailOptions()');
		
	 	$options = array();
	 	
	 	$evs = $this->getEnumeratedValueService();
	 	$pub = $evs->fetch('PublicationState');
	 	$logger->debug("Number of PubStates: ". count($pub['PublicationState']));
	 	$options['pubState'] = 	$pub['PublicationState'];
	 	
	 	$es = $this->getEventService();
	 	$event = $es->getEventsByPubState('Exhibition');
	 	$logger->debug("Number of Exhibitions: ". count($event));
	 	$options['exhibition'] = $event;
	 	
	 	$event = $es->getEventsByPubState('Program');
	 	$logger->debug("Number of Programs: ". count($event));
	 	$options['program'] = $event;

		$cs = $this->getCategoryService();
		$genres = $cs->getCategories('Genre', PublicationState::PUBLISHED);
	 	$logger->debug("Number of Genres: ". count($genres));
	 	$options['genre'] = $genres;
	 	
	 	$audience = $cs->getCategories('Audience', PublicationState::PUBLISHED);
	 	$logger->debug("Number of Audiences: ". count($audience));
	 	$options['audience'] = $audience;
	 	
	 	$series = $cs->getCategories('Series', PublicationState::PUBLISHED);
	 	$logger->debug("Number of Series: ". count($series));
	 	$options['series'] = $series;
 	
	 	$event = $es->getEventsByPubState('Course');
	 	$logger->debug("Number of Courses: ". count($event));
	 	$options['course'] = $event;
	 		 	
	 	$ss = $this->getScheduleService();
	 	$month = $ss->getMonthArray();
	 	$logger->debug("Number of Months: ". count($month));
	 	$options['month'] = $month; 
	 	
	 	$year = $ss->getYearArray(1,1);
	 	$logger->debug("Number of Years: ". count($year));
	 	$options['year'] = $year;  
	 	
	 	$day = $ss->getDayArray();
	 	$logger->debug("Number of Days: ". count($day));
	 	$options['day'] = $day; 
	 	
        return $options;
	 }


	 /**
	  * Returns an array of oids from the request
	  * @return array oids
	  */
	 private function getFormOids()
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::getFormOids()');
		
	 	$logger->debug('oids: '. $_REQUEST['oids']);
		if(!isset($_REQUEST['oids'])) {
			trigger_error("Required oids are missing", E_USER_ERROR);
		} 
		$oid_array = split(",",$_REQUEST['oids']);
		$logger->debug('length of oid_array: '. count($oid_array));
		return $oid_array;
	 }


	/**
	 * Populates the HomePage object from the request
	 * @return bean HomePage
	 */
	 private function getBeanFromRequest()
	 {
	 	$home_page = new HomePage();
	 	
	 	$home_page->setOid($_REQUEST['oid']);
	 	$home_page->setName($_REQUEST['name']);
	 	$home_page->setPubState($_REQUEST['pubState']);
	 	
		// Format the times
		$startTime = mktime(0,0,0,$_REQUEST['startMonth'],$_REQUEST['startDay'],$_REQUEST['startYear']);
		$home_page->setStartTime($startTime);

	 	for ($index=1; $index <= 13; $index++) {
		 	if (isset($_REQUEST['event'.$index])) {
		 		$method = 'setEvent' . $index;
		 		$home_page->$method($_REQUEST['event'.$index]);
		 	}
	 	}
	 	return $home_page;
	 }


	/**
	 * Link this home_page to each of the selected events
	 * by event type.  In the case where 
	 */



	private function getHomePageService() 
	{
		if ($this->homePageService == null) {
			$this->homePageService = new HomePageService();
		}
		return $this->homePageService;
	}
	
	private function getEventService() 
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}
	
	private function getScheduleService() 
	{
		if ($this->scheduleService == null) {
			$this->scheduleService = new ScheduleService();
		}
		return $this->scheduleService;
	}
	
	private function getEnumeratedValueService() 
	{
		if ($this->enumeratedValueService == null) {
			$this->enumeratedValueService = new EnumeratedValueService();
		}
		return $this->enumeratedValueService;
	}
	
	private function getCategoryService() 
	{
		if ($this->categoryService == null) {
			$this->categoryService = new CategoryService();
		}
		return $this->categoryService;
	}
}
?>
