<?php
/**
 *  $Id$: VenueAction.php, Sep 4, 2006 11:55:13 PM nchanda
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
require_once WEB_INF . '/service/VenueService.php';
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/service/EnumeratedValueService.php';
require_once WEB_INF . '/service/GalleryService.php';
require_once WEB_INF . '/beans/Venue.php';
require_once WEB_INF . '/beans/Address.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/beans/PublicationState.php';

require_once ('tachometry/web/BaseAction.php');
require_once ('tachometry/util/CopyBeanOption.php');

class VenueAction extends BaseAction
{
	private $venueService;
	private $eventService;
	private $galleryService;
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
		$addr = new Address();
		$vnue = new Venue();
		$vnue->setAddress($addr);
		$model->setDetail($vnue);
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

		$service = $this->getVenueService();
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
	 * Updates a venue identified by the oid
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
	 * Sets the publication state of the given venues(s) to "Archived"
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
	 * Sets the archived request variable, then calls the setSummaryModel method
	 * in the sub-class
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function viewArchive($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::viewArchive()');

		$_REQUEST['archived'] = true;
		return $this->setSummaryModel($mainframe);
	 }

	/**
	 * Sets the publication state of the given venues(s) to "Published"
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
	 * Sets the publication state of the given venues(s) to "Unpublished"
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
	 * @param int/string the oid for the target venue
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

	 	$vs = $this->getVenueService();
	 	$dpm = new DetailPageModel();

	 	$bean = $vs->getVenueById($oid);
	 	$logger->debug("Address is of class: ". get_class($bean->getAddress()) ." and an oid of:". $bean->getAddress()->getOid());

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
	private function setSummaryModel($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::setSummaryModel()');

		$service = $this->getVenueService();
		$model = new SummaryPageModel();
		$pubStates = null;

		if (isset($_REQUEST['archived'])) {
			$pubStates = array(PublicationState::ARCHIVED);
		}
		$logger->debug("Size of pubStates array: ". count($pubStates));

		$list = $service->getVenuesByPubState($pubStates);
		$logger->debug("Size of venues array: ". count($list));

		// TODO Get Related Events

		$model->setVenues($list);

		return $model;
	}

	/**
	 * Creates a new venue
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	private function create($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::create()");

		$service = $this->getVenueService();
		$gs = $this->getGalleryService();

		$bean = $this->getBeanFromRequest();
		$model = new DetailPageModel();

		$bean->setGallery($gs->createAlbum('Venue', $bean));
		$model->setDetail($service->setupVenue($bean));
		$model->setOptions($this->getDetailOptions());

		return $model;
	}


	/**
	 * Updates and venue by given oid. If there is no oid
	 * it will invoke the create method.  Will also invoke
	 * the linkEvents() method to assign events to this venue.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	private function update($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::update()");

		$bean = $this->getBeanFromRequest();
		$service = $this->getVenueService();
		$model = new DetailPageModel();

		// is this a new event
		if($bean->getOid() == null) {
			$logger->debug("No venue id found.");
			return $this->create($mainframe);
		}

		// Update the venue
		$updated = $service->update($bean);

		// Populate the page model
		$model->setDetail($updated);
		$model->setOptions($this->getDetailOptions());

		return $model;
	}


	/**
	 * Changes the PublicationState for each venue identified by the
	 * list of oids to the value passed by the calling method.
	 *
	 * @access private
	 * @param array A list of oids
	 * @param string the target publication state value
	 */
	 private function changePubState($oids, $state)
	 {
	 	$service = $this->getVenueService();
	 	for($i=0; $i<count($oids); $i++)
		{
			$venue = $service->getVenueById($oids[$i]);
			$venue->setPubState($state);
			$service->update($venue);
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
	 	$exbt = $es->getEventsByPubState('Exhibition');
	 	$logger->debug("Number of Exhibitions: ". count($exbt));
	 	$options['exhibition'] = $exbt;

	 	$prgm = $es->getEventsByPubState('Program');
	 	$logger->debug("Number of Programs: ". count($prgm));
	 	$options['program'] = $prgm;

	 	$crse = $es->getEventsByPubState('Course');
	 	$logger->debug("Number of Courses: ". count($crse));
	 	$options['course'] = $crse;

	 	$gs = new GalleryService();
	 	$gal = $gs->getCategories(Venue::VENUE);
	 	$logger->debug("Number of Galleries: ". count($gal));
	 	$options['gallery'] = $gal;

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
	 * Populates the Venue object from the request
	 * @return bean Venue
	 */
	 private function getBeanFromRequest()
	 {
	 	$venue = new Venue();
	 	$addr = new Address();

	 	$addr->setOid($_REQUEST['aoid']);
	 	$addr->setStreet($_REQUEST['street']);
	 	$addr->setUnit($_REQUEST['unit']);
	 	$addr->setCity($_REQUEST['city']);
	 	$addr->setState($_REQUEST['state']);
	 	$addr->setPostalCode($_REQUEST['postalCode']);
	 	$addr->setPhone($_REQUEST['phone']);

	 	$venue->setOid($_REQUEST['oid']);
	 	$venue->setName($_REQUEST['name']);
	 	$venue->setDescription($_REQUEST['description']);
	 	$venue->setPubState($_REQUEST['pubState']);
	 	$venue->setAddress($addr);

	 	if (isset($_REQUEST['gallery'])) {
	 		$venue->setGallery($_REQUEST['gallery']);
	 	}


	 	$links = array();
	 	//$links['exhibition'] = $_REQUEST['exhibition'];
	 	//$links['program'] = isset($_REQUEST['program']) ? $_REQUEST['program'] : null;
	 	//$links['course'] = isset($_REQUEST['course']) ? $_REQUEST['course'] : null;
	 	$venue->setEvents($links);

	 	return $venue;
	 }


	/**
	 * Link this venue to each of the selected events
	 * by event type.  In the case where
	 */



	private function getVenueService()
	{
		if ($this->venueService == null) {
			$this->venueService = new VenueService();
		}
		return $this->venueService;
	}

	private function getEventService()
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}

	private function getEnumeratedValueService()
	{
		if ($this->enumeratedValueService == null) {
			$this->enumeratedValueService = new EnumeratedValueService();
		}
		return $this->enumeratedValueService;
	}

	private function getGalleryService()
	{
		if ($this->galleryService == null) {
			$this->galleryService = new GalleryService();
		}
		return $this->galleryService;
	}
}
?>

