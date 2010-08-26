<?php
/**
 *  $Id$: ProgramAction.php, Jul 3, 2006 4:24:13 PM nchanda
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
require_once WEB_INF . '/actions/EventAction.php';
require_once WEB_INF . '/beans/Program.php';
require_once WEB_INF . '/beans/Genre.php';
require_once WEB_INF . '/beans/Venue.php';
require_once WEB_INF . '/beans/Audience.php';
require_once WEB_INF . '/beans/Genre.php';
require_once WEB_INF . '/beans/Series.php';
require_once WEB_INF . '/beans/Performance.php';
require_once WEB_INF . '/beans/Schedule.php';
require_once WEB_INF . '/service/GalleryService.php';

/**
 * This class extends the generic EventAction.  All
 * methods specific to the ProgramAction are maintained
 * here.  All generic action methods are implemented
 * in the EventAction class.
 */
class ProgramAction extends EventAction
{
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
		$prgm = new Program();

		$model->setDetail($prgm);
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

		$service = $this->getEventService();
		$oids = $this->getFormOids();

		for($i=0; $i<count($oids); $i++)
		{
			$service->delete('Program',$oids[$i]);
		}

		// TODO: Set the appropriate messages in the model object

		// return the summaries
		return $this->setSummaryModel($mainframe);
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

	 	$bean = $es->getEventById('Program',$oid);

	 	$dpm->setDetail($bean);
	 	$dpm->setOptions($this->getDetailOptions());

	 	return $dpm;
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

		$list = $service->getEventsByPubState('Program',$pubStates);
		$logger->debug("Size of programs array: ". count($list));

		$model->setList($list);

		return $model;
	}

	/**
	 * Creates a new program
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

		$gid = $gs->createAlbum('Program', $bean);
		$logger->debug("Created album with id: ". $gid);
		$bean->setGallery($gid);
		$model->setDetail($service->setupEvent('Program',$bean));
		$model->setOptions($this->getDetailOptions());

		return $model;
	}


	/**
	 * Updates a program by given oid. If there is no oid
	 * it will invoke the create method.  Will also assign
	 * related events and venues.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	protected function update($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::update()");

		$bean = $this->getBeanFromRequest();
		$service = $this->getEventService();
		$model = new DetailPageModel();

		// is this a new event
		if($bean->getOid() == null) {
			$logger->debug("No event id found.");
			return $this->create($mainframe);
		}

		// Update the venue
		$updated = $service->updateEvent('Program',$bean);

		// Populate the page model
		$model->setDetail($updated);
		$model->setOptions($this->getDetailOptions());

		return $model;
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

	 	$es = $this->getEventService();
	 	$exbt = $es->getEventsByPubState('Exhibition');
	 	$logger->debug("Number of Exhibitions: ". count($exbt));
	 	$options['exhibition'] = $exbt;

	 	$crse = $es->getEventsByPubState('Course');
	 	$logger->debug("Number of Courses: ". count($crse));
	 	$options['course'] = $crse;

	 	$vs = $this->getVenueService();
	 	$vnue = $vs->getVenuesByPubState();
	 	$logger->debug("Number of Venues: ". count($vnue));
	 	$options['venue'] = $vnue;

	 	$gc = $es->getCategories('Genre');
	 	$logger->debug("Number of Genres: ". count($gc));
	 	$options['genre'] = $gc;

	 	$ac = $es->getCategories('Audience');
	 	$logger->debug("Number of Audiences: ". count($ac));
	 	$options['audience'] = $ac;

	 	$sc = $es->getCategories('Series');
	 	$logger->debug("Number of Series: ". count($sc));
	 	$options['series'] = $sc;

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

	 	$hour = $ss->getHourArray();
	 	$logger->debug("Number of Hours: ". count($hour));
	 	$options['hour'] = $hour;

	 	$minute = $ss->getMinuteArray(MINUTE_INTERVAL);
	 	$logger->debug("Number of Minutes: ". count($minute));
	 	$options['minute'] = $minute;

	 	$ampm = $ss->getAmpmArray();
	 	$logger->debug("Number of am/pm: ". count($ampm));
	 	$options['ampm'] = $ampm;

	 	$gs = new GalleryService();
	 	$gal = $gs->getCategories(Event::PROGRAM);
	 	$logger->debug("Number of Galleries: ". count($gal));
	 	$options['gallery'] = $gal;

	 	$jcs = $this->getJoomlaContentService();
	 	$prart = $jcs->getArticlesByCategory(PRESS_ACTIVE_CATEGORY_ID);
	 	$options['pressrelease'] = $prart;

 		$caart = $jcs->getArticlesByCategory(COMMENT_ARTICLE_CATEGORY_ID);
	 	//$logger->debug("Number of Articles for Comment Article Category: ". count($caart) ." first item: ". $caart[0]->getTitle());
	 	$options['commentarticle'] = $caart;

	 	$relcat = $jcs->getCategoriesBySection(PRGM_CONTENT_SECTION_ID);
	 	$options['relatedcategory'] = $relcat;

	 	return $options;
	 }

	/**
	 * Populates the Venue object from the request
	 * @return bean Venue
	 */
	 protected function getBeanFromRequest()
	 {
	 	global $logger;

	 	$prgm = new Program($_REQUEST);

	 	$genre = new Genre();
	 	$genre->setOid($_REQUEST['primaryGenre']);
		$prgm->setPrimaryGenre($genre);

		if (isset($_REQUEST['defaultVenue'])) {
		 	$venue = new Venue();
		 	$venue->setOid($_REQUEST['defaultVenue']);
		 	$prgm->setDefaultVenue($venue);
		 	$prgm->setVenues(array($venue));
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
		if (isset($_REQUEST['series'])) {
			foreach ($_REQUEST['series'] as $oid) {
				$category = new Series();
				$category->setOid($oid);
				$cats['series'][] = $category;
			}
		}
		if (isset($cats['audience'])) {
			$logger->debug("Number of audience categories in the form: ". count($cats['audience']));
		}
		if (isset($cats['genre'])) {
			$logger->debug("Number of genre categories in the form: ". count($cats['genre']));
		}
		if (isset($cats['series'])) {
			$logger->debug("Number of series categories in the form: ". count($cats['series']));
		}
		if (isset($cats['audience']) || isset($cats['genre']) || isset($cats['series'])) {
			$prgm->setCategories($cats);
		}

		// related events
		$events = array();
		if (isset($_REQUEST['exhibition'])) {
			foreach ($_REQUEST['exhibition'] as $oid) {
				$exhibition = new Exhibition();
				$exhibition->setOid($oid);
				$events[] = $exhibition;
			}
		}
		if (isset($events)) {
			$logger->debug("Number of related exhibitions in the form: ". count($events));
			$prgm->setExhibitions($events);
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
			$prgm->setCourses($events);
		}
		$activities = array();
		if (isset($_REQUEST['activityChanged']) && $_REQUEST['activityChanged']) {
			// parse delimited attributes as pipe-delimited '|' string
			$startTimes = explode('|',$_REQUEST['activityStartTime']);
			$endTimes = explode('|',$_REQUEST['activityEndTime']);
			$venues = explode('|',$_REQUEST['activityVenueList']);
			$status = explode('|',$_REQUEST['activityStatusList']);
			$tickets = explode('|',$_REQUEST['activityTicketList']);
			for ($index=0; $index < count($venues); $index++) {
				$schedule = new Schedule();
                $stint = strtotime($startTimes[$index]);
                $etint = strtotime($endTimes[$index]);
                $schedule->setStartTime($stint);
                $schedule->setEndTime($etint);


				$venue = new Venue();
				$venue->setOid($venues[$index]);
				$activity = new Performance();
				$activity->setSchedule($schedule);
				$activity->setVenue($venue);
				$activity->setActivityStatus($status[$index]);
				$activity->setTicketCode($tickets[$index]);
				$activities[] = $activity;
			}
		}
		if (isset($activities)) {
			$logger->debug("Number of related performances in the form: ". count($activities));
			$prgm->setChildren($activities);
		}
	 	return $prgm;
	 }

	 /**
	 * Changes the PublicationState for each program identified by the
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
			$prgm = $service->getEventById('Program',$oids[$i]);
			$prgm->setPubState($state);
			$prgm->setChildren(null); // ignore ativity records
			$service->updateEvent('Program',$prgm);
		}
	 }

}

?>
