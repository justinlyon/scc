<?php
/**
 *  $Id$: ExhibitionAction.php, Jul 3, 2006 4:24:13 PM nchanda
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
require_once WEB_INF . '/beans/Artist.php';
require_once WEB_INF . '/beans/Audience.php';
require_once WEB_INF . '/beans/Course.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/Genre.php';
require_once WEB_INF . '/beans/Person.php';
require_once WEB_INF . '/beans/Program.php';
require_once WEB_INF . '/beans/Schedule.php';
require_once WEB_INF . '/beans/Venue.php';
require_once WEB_INF . '/actions/EventAction.php';
require_once WEB_INF . '/service/PersonService.php';

require_once ('tachometry/web/BaseAction.php');
require_once ('tachometry/util/CopyBeanOption.php');

class ExhibitionAction extends EventAction
{

	 private $personService;

	 /**
	 * Takes no action, but returns a detail page model
	 * @param Array $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	 function setup($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::setup()');

		$model = new DetailPageModel();
		$exbt = new Exhibition();

		$model->setDetail($exbt);
		$model->setOptions($this->getDetailOptions());
		return $model;
	 }


	/**
	 * Deletes the event identified by the request scoped eventId
	 * @param Array $mainframe The Joomla specific page object
	 * @return The page model array
	 */
	function delete($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::delete()');

		$service = $this->getEventService();
		$oids = $this->getFormOids();

		for($i=0; $i<count($oids); $i++)
		{
			$service->delete("Exhibition",$oids[$i]);
		}

		// TODO: Set the appropriate messages in the model object

		// clean up the order
		$this->reorder();

		// return the summaries
		return $this->setSummaryModel($mainframe);
	}


	 /**
	 * Changes the PublicationState for each exhibition identified by the
	 * list of oids to the value passed by the calling method.
	 *
	 * @access private
	 * @param array A list of oids
	 * @param string the target publication state value
	 */
	 protected function changePubState($oids, $state)
	 {
	 	$service = $this->getEventService();
	 	for($i=0; $i<count($oids); $i++)
		{
			$prgm = $service->getEventById('Exhibition',$oids[$i]);
			$prgm->setPubState($state);
			$service->updateEvent('Exhibition',$prgm);
		}

		// clean up the order
		$this->reorder();
	 }

	/**
	 * Creates a new exhibition, ordered in the next
	 * display order position.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	protected function create($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::create()");

		$service = $this->getEventService();
		$gs = $this->getGalleryService();

		$bean = $this->getBeanFromRequest();
		$model = new DetailPageModel();

		$bean->setGallery($gs->createAlbum('Exhibition', $bean));
		$bean->setDisplayOrder($service->getNextDisplayOrder('Exhibition'));
		$model->setDetail($service->setupEvent('Exhibition',$bean));
		$model->setOptions($this->getDetailOptions());

		return $model;
	}


	/**
	 * Updates an exhibition by given oid. If there is no oid
	 * it will invoke the create method.  Will also assign
	 * related events and venues.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	protected function update($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::update($)");

		$bean = $this->getBeanFromRequest();
		$service = $this->getEventService();
		$model = new DetailPageModel();

		// is this a new event
		if($bean->getOid() == null) {
			$logger->debug("No event id found.");
			return $this->create($mainframe);
		}

		// Update the event
		$updated = $service->updateEvent('Exhibition',$bean);

		// clean up the order
		$this->reorder();

		// Populate the page model
		$model->setDetail($updated);

		$artists = $updated->getArtists();
		$options = $this->getDetailOptions();
		$options['artifact'] = $this->getArtifactOptions($artists);
		$model->setOptions($options);

		return $model;
	}


	/**
	 * sets the EventStatus to the value set by the incoming
	 * request and returns the summary model
	 */
	function toggleEventStatus($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::toggleEventStatus()');

		$status = $this->getFormToggleValue();
		$oids = $this->getFormOids(); // should be an array of 1
		$service = $this->getEventService();
		$logger->debug("\n\nIncomong oid:". $oids[0]);

		$event_bean = $service->getEventById('Exhibition',$oids[0]);
		$logger->debug("\n\nEvent Object oid:". $event_bean->getOid());
		$event_bean->setEventStatus($status);

		$copyOption = new CopyBeanOption();
		$copyOption->setIgnoreNullValues(true);
		$service->updateEvent('Exhibition',$event_bean,$copyOption);

		// return the summaries
		return $this->setSummaryModel($mainframe);
	}


	/**
	 * Instantiates an Exhibition bean object and copies all
	 * valid incoming form elements to the bean object
	 * @return The valid Exhibition bean
	 */
	protected function getBeanFromRequest()
	{
		global $logger;
		$logger->debug(get_class($this) . "::getBeanFromRequest()");

		$service = $this->getEventService();

		// TODO: Add validator here
		$exhibit = new Exhibition($_REQUEST);
		$logger->debug("exhibition object: $exhibit");

		if (isset($_REQUEST['displayOrder']) && intval($_REQUEST['displayOrder']) > 0 ) {
			$exhibit->setDisplayOrder($_REQUEST['displayOrder']);
		}

		// Format the times
		$logger->debug("Start Time: ". $_REQUEST['startMonth'] .",". $_REQUEST['startDay'] .",". $_REQUEST['startYear']);
		$startTime = mktime(0,0,0,$_REQUEST['startMonth'],$_REQUEST['startDay'],$_REQUEST['startYear']);
		$logger->debug("Start Time (mktime)". $startTime);

		// find out if this is a recurring event
		$endTime = mktime(0,0,0,$_REQUEST['endMonth'],$_REQUEST['endDay'],$_REQUEST['endYear']);
		if ($_REQUEST['close_type'] == 'ongoing') {
			$endTime = 0;
		}

		// load the schedule
		$schedule = new Schedule();
		if (isset($_REQUEST['scheduleOid'])) { $schedule->setOid(intval($_REQUEST['scheduleOid']));	}
		$schedule->setStartTime($startTime);
		$schedule->setEndTime($endTime);
		$exhibit->setSchedule($schedule);

		// venues
		if (isset($_REQUEST['venue'])) {
			$venues = array();
			foreach ($_REQUEST['venue'] as $oid) {
				$venue = new Venue();
				$venue->setOid($oid);
				$venues[] = $venue;
			}
			$logger->debug("Number of venues in the form: ". count($venues));
			$exhibit->setVenues($venues);
		}

		// categories
		$cats = array();
		if (isset($_REQUEST['audience'])) {
			foreach ($_REQUEST['audience'] as $oid) {
				$category = new Audience();
				$category->setOid($oid);
				$cats['audience'][] = $category;
			}
		}
		if (isset($_REQUEST['genre'])) {
			foreach ($_REQUEST['genre'] as $oid) {
				$category = new Genre();
				$category->setOid($oid);
				$cats['genre'][] = $category;
			}
		}
		if (isset($cats['audience'])) {
			$logger->debug("Number of audience categories in the form: ". count($cats['audience']));
		}
		if (isset($cats['genre'])) {
			$logger->debug("Number of genre categories in the form: ". count($cats['genre']));
		}
		if (isset($cats['audience']) || isset($cats['genre'])) {
			$exhibit->setCategories($cats);
		}

		// related events
		$events = array();
		if (isset($_REQUEST['program'])) {
		foreach ($_REQUEST['program'] as $oid) {
				$program = new Program();
				$program->setOid($oid);
				$events[] = $program;
			}
		}
		if (isset($events)) {
			$logger->debug("Number of related programs in the form: ". count($events));
			$exhibit->setPrograms($events);
		}
		$events = array();
		if (isset($_REQUEST['course'])) {
			foreach ($_REQUEST['course'] as $oid) {
				$course = new Course();
				$course->setOid($oid);
				$events[] = $course;
			}
		}
		if (isset($events)) {
			$logger->debug("Number of related courses in the form: ". count($events));
			$exhibit->setCourses($events);
		}

		// gallery
		if (isset($_REQUEST['gallery'])) {
			$exhibit->setGallery($_REQUEST['gallery']);
		}

		// artists
		if (isset($_REQUEST['person'])) {
			$persons = array();
			foreach ($_REQUEST['person'] as $oid) {
				$person = new Artist();
				$person->setOid($oid);
				$persons[] = $person;
			}
			$logger->debug("Number of persons in the form: ". count($persons));
			$exhibit->setArtists($persons);
		}

		// artifacts
		if (isset($_REQUEST['artifact'])) {
			$artifacts = array();
			foreach ($_REQUEST['artifact'] as $id) {
				$artifacts[] = $id;
			}
			$artlist = implode(",",$artifacts);
			$logger->debug("Number of persons in the form: ". count($artifacts));
			$exhibit->setArtifacts($artlist);
		}

		return $exhibit;
	}


	/**
	 * Positions the given exhibition element one position "higher" in display order
	 * @param Array $mainframe The Joomla specific page object
	 * @return The exhibition summaries array
	 */
	 function orderUp($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::orderUp()');
		if(isset($_REQUEST['oids'])){
			$oid = $_REQUEST['oids'];
			$service = $this->getEventService();

			// Get the event to be moved
			$event0 = $service->getEventById('Exhibition',$oid);
			$cur_order = intval($event0->getDisplayOrder());

			$logger->debug("current display order: $cur_order");

			// Get the event that is currently in the target position
			$event1 = $service->getEventByOrderIndex('Exhibition',$cur_order-1,'Published');
			$logger->debug("index of next event: ". $event1->getOid());

			// Set the display orders
			$event1->setDisplayOrder($cur_order);
			$event0->setDisplayOrder(intval($cur_order-1));
			$service->updateEvent('Exhibition',$event0);
			$service->updateEvent('Exhibition',$event1);

			// Reorder all to clean up
			$this->reorder();
		}
		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }

	 /**
	 * Positions the given exhibition element one position "lower" in display order
	 * @param Array $mainframe The Joomla specific page object
	 * @return The exhibition summaries array
	 */
	 function orderDown($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::orderDown()');
		if(isset($_REQUEST['oids'])){
			$oid = $_REQUEST['oids'];
			$service = $this->getEventService();

			// Get the event to be moved
			$event0 = $service->getEventById('Exhibition',$oid);
			$cur_order = $event0->getDisplayOrder();
			$logger->debug("current display order: $cur_order");

			// Get the event that is currently in the target position
			$event1 = $service->getEventByOrderIndex('Exhibition',$cur_order+1,'Published');
			$logger->debug("index of next event: ". $event1->getOid());

			// Set the display orders
			$event1->setDisplayOrder($cur_order);
			$event0->setDisplayOrder($cur_order+1);
			$service->updateEvent('Exhibition',$event0);
			$service->updateEvent('Exhibition',$event1);

			// Reorder all to clean up
			$this->reorder();
		}
		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }

	 /**
	  * cleans up the displayOrder for all exhibitions.
	  * Orders non-archived Exhibitions by displayOrder and start date
	  * Then sets the displayOrder to the appropriate value based on
	  * index location of the set of exhibitions.
	  * displayOrder will start at 1 for user friendly numbering
	  * @return void
	  */
	 private function reorder()
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::reorder()');

		$service = $this->getEventService();
		$events = $service->getEventsByPubState('Exhibition',null);
		$logger->debug('Number of events: '. count($events));

		// Update the displayOrder
		for($i=0; $i<count($events); $i++)
		{
			$event = $events[$i];
			$event->setDisplayOrder($i+1);
			$service->updateEvent('Exhibition', $event);
		}
	 }



	 /**
	  * Returns the value from the request $_REQUEST['toggle_value']
	  * @return string eventState value
	  */
	 private function getFormToggleValue()
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::getFormToggleValue()');

	 	$logger->debug('toggle_value: '. $_REQUEST['toggle_value']);
		if(!isset($_REQUEST['toggle_value'])) {
			trigger_error("Required toggle_value is missing", E_USER_ERROR);
		}
		$value = $_REQUEST['toggle_value'];
		return $value;
	 }


	 /**
	 * Gets a list of venues.  If the $_REQUEST['archived'] attribute
	 * is true, will return the archived list.  Else will return the list
	 * of non-archived venues.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the venues summary page model bean
	 */
	protected function setSummaryModel($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::setSummaryModel()');

		$service = $this->getEventService();
		$model = new SummaryPageModel();
		$pubStates = null;

		if (isset($_REQUEST['archived'])) {
			$pubStates = array(PublicationState::ARCHIVED);
		}
		$logger->debug("Size of pubStates array: ". count($pubStates));

		$list = $service->getEventsByPubState('Exhibition',$pubStates);
		$logger->debug("Size of exhibitions array: ". count($list));

		$model->setList($list);

		return $model;
	}


	/**
	 * Returns a DetailPageModel bean for the given oid
	 *
	 * @access private
	 * @param int/string the oid for the target venue
	 * @return bean DetailPageModel
	 */
	 protected function setDetailModel($oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::setDetailModel($oid)");

	 	if ($oid == null) {
	 		trigger_error("Missing required OID.", E_USER_ERROR);
	 		return;
	 	}

	 	$es = $this->getEventService();
	 	$dpm = new DetailPageModel();

	 	$bean = $es->getEventById('Exhibition',$oid);
	 	$dpm->setDetail($bean);

	 	$artists = $bean->getArtists();
	 	$options = $this->getDetailOptions();
	 	$options['artifact'] = $this->getArtifactOptions($artists);
	 	$dpm->setOptions($options);

	 	return $dpm;
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

	 	$status = $evs->fetch('EventStatus');
	 	$logger->debug("Number of EventStatus: ". count($status['EventStatus']));
	 	$options['eventStatus'] = 	$status['EventStatus'];

	 	$vs = $this->getVenueService();
	 	$vnue = $vs->getVenuesByPubState();
	 	$logger->debug("Number of Venues: ". count($vnue));
	 	$options['venue'] = $vnue;

	 	$es = $this->getEventService();
	 	$prgm = $es->getEventsByPubState('Program');
	 	$logger->debug("Number of Programs: ". count($prgm));
	 	$options['program'] = $prgm;

	 	$crse = $es->getEventsByPubState('Course');
	 	$logger->debug("Number of Courses: ". count($crse));
	 	$options['course'] = $crse;

	 	$gc = $es->getCategories('Genre');
	 	$logger->debug("Number of Genres: ". count($gc));
	 	$options['genre'] = $gc;

	 	$ac = $es->getCategories('Audience');
	 	$logger->debug("Number of Audiences: ". count($ac));
	 	$options['audience'] = $ac;

	 	$ss = $this->getScheduleService();
	 	$month = $ss->getMonthArray();
	 	$logger->debug("Number of Months: ". count($month));
	 	$options['month'] = $month;

	 	$year = $ss->getYearArray(1,GRACE_YEAR_FORWARD);
	 	$logger->debug("Number of Years: ". count($year));
	 	$options['year'] = $year;

	 	$day = $ss->getDayArray();
	 	$logger->debug("Number of Days: ". count($day));
	 	$options['day'] = $day;

	 	$gs = $this->getGalleryService();
	 	$gal = $gs->getChildAlbums(Event::EXHIBITION);
	 	$logger->debug("Number of Galleries: ". count($gal));
	 	$options['gallery'] = $gal;

	 	$ps = $this->getPersonService();
	 	$pers = $ps->getPersons(Person::ARTIST);
	 	$logger->debug("Number of People: ". count($pers));
	 	$options['person'] = $pers;

	 	$jcs = $this->getJoomlaContentService();
	 	$prart = $jcs->getArticlesByCategory(PRESS_ACTIVE_CATEGORY_ID);
//	 	$logger->debug("Number of Articles for Press Release Category: ". count($prart) ." first item: ". $prart[0]->getTitle());
	 	$options['pressrelease'] = $prart;

 		$caart = $jcs->getArticlesByCategory(COMMENT_ARTICLE_CATEGORY_ID);
//	 	$logger->debug("Number of Articles for Comment Article Category: ". count($caart) ." first item: ". $caart[0]->getTitle());
	 	$options['commentarticle'] = $caart;

	 	$relcat = $jcs->getCategoriesBySection(EXBT_CONTENT_SECTION_ID);
	 	$logger->debug("Number of Categories for Exhibition Section: ". count($relcat));
	 	$options['relatedcategory'] = $relcat;

	 	return $options;
	 }

	/**
	 * Returns the list of artifacts for the give artists
	 */
	function getArtifactOptions($artists)
	{
		$gs = $this->getGalleryService();
		$artifacts = array();
	 	if ($artists) {
	 		for($i=0; $i<count($artists); $i++) {
	 			$artist = $artists[$i];
				if ($artist->getGallery()) {
					$artifacts[] = $gs->getPackagedAlbum($artist->getGallery());
				}
	 		}
	 	}
	 	return $artifacts;
	}



	private function getPersonService()
	{
		if ($this->personService == null) {
			$this->personService = new PersonService();
		}
		return $this->personService;
	}

}

?>
