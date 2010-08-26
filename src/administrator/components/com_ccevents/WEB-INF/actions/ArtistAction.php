<?php
/**
 *  $Id$:
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
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/actions/MasterAction.php';
require_once WEB_INF . '/service/PersonService.php';
require_once WEB_INF . '/service/EnumeratedValueService.php';
require_once WEB_INF . '/service/GalleryService.php';
require_once WEB_INF . '/service/EventService.php';

class ArtistAction extends MasterAction
{
	private $personService;
	private $enumeratedValueService;
	private $eventService;

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
	 * A public wrapper for the private setDetailModel() method
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the detail page model bean
	 */
	function read($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::read()');
		return $this->setDetailModel($mainframe);
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
		$person = new Artist();
		$model->setDetail($person);
		$model->setOptions($this->getDetailOptions());
		return $model;
	 }

	/**
	 * Updates a person identified by the oid
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
	 * @see update() Updates the category
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
	 * Creates a new person
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	private function create($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::create()");

		$service = $this->getPersonService();
		$gs = $this->getGalleryService();
		$bean = $this->getBeanFromRequest();
		$model = new DetailPageModel();

		$albumName = $bean->getLastName() ."_". $bean->getFirstName();
		$bean->setGallery($gs->createAlbum(Person::ARTIST, $bean, $albumName));
		$model->setDetail($service->setup($bean));
		$model->setOptions($this->getDetailOptions());

		return $model;
	}

	/**
	 * Updates a poerson by given oid. If there is no oid
	 * it will invoke the create method.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	private function update($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::update()");
		$bean = $this->getBeanFromRequest();

		if($bean->getOid() == null) {
			$logger->debug("No person id found.");
			return $this->create($mainframe);
		}

		$service = $this->getPersonService();
		$model = new DetailPageModel();

		// Update the person
		$updated = $service->update($bean);

		// Populate the page model
		$model->setDetail($updated);
		$model->setOptions($this->getDetailOptions());

		return $model;
	}

	/**
	 * A public wrapper for the private setSummaryModel() method
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the summary page model bean
	 */
	function delete($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::delete()');

		$service = $this->getPersonService();
		$oids = $this->getFormOids();

		for($i=0; $i<count($oids); $i++)
		{
			$service->delete('Artist',$oids[$i]);
		}
		return $this->setSummaryModel($mainframe);
	}

	 /**
	 * Sets the publication state of the given person(s) to "Archived"
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function archive($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::archive()');

		$oids = $this->getFormOids();
		$logger->debug("Size of incoming oids: ". count($oids));
		$this->changePubState($oids, PublicationState::ARCHIVED);

		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }

	/**
	 * Sets the publication state of the given cperson(s) to "Published"
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
	 * Sets the publication state of the given cperson(s) to "Published"
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
	 * Changes the PublicationState for each person identified by the
	 * list of oids to the value passed by the calling method.
	 *
	 * @access private
	 * @param array A list of oids
	 * @param string the target publication state value
	 */
	 private function changePubState($oids, $state)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::changePubState($oids, $state)");

	 	$service = $this->getPersonService();
	 	for($i=0; $i<count($oids); $i++)
		{
			$logger->debug("Changing pubState for person oid: ". $oids[$i]);
			$person = $service->getPersonById('Artist',$oids[$i]);
			$person->setPubState($state);
			$service->update($person);
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
	 	$options['pubState'] = 	$pub['PublicationState'];

	 	$gs = new GalleryService();
	 	$gal = $gs->getChildAlbums(Person::ARTIST);
	 	$options['gallery'] = $gal;

	 	$es = $this->getEventService();
	 	$exbt = $es->getEventsByPubState('Exhibition');
	 	$options['exhibition'] = $exbt;

	 	return $options;
	 }



	/**
	 * Gets a list of people.  If the $_REQUEST['archived'] attribute
	 * is true, will return the archived list.  Else will return the list
	 * of non-archived venues.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the venues summary page model bean
	 */
	private function setSummaryModel($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::setSummaryModel()');

		$service = $this->getPersonService();
		$model = new SummaryPageModel();
		$pubStates = null;

		if (isset($_REQUEST['archived'])) {
			$pubStates = array(PublicationState::ARCHIVED);
		}
		$logger->debug("Size of pubStates array: ". count($pubStates));

		$list = $service->getPersons(Person::ARTIST, $pubStates);
		$logger->debug("Size of person array: ". count($list));

		$model->setList($list);

		return $model;
	}

	/**
	 * Returns the populated detail page model
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the detail page model bean
	 */
	private function setDetailModel($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setDetailModel()");

		$model = new DetailPageModel();
		$service = $this->getPersonService();

		if (!isset($_REQUEST['oid'])) {
			return $this->setSummaryModel($mainframe);
		}

		$detail = $service->getPersonById('Artist',$_REQUEST['oid']);
		$model->setDetail($detail);
		$model->setOptions($this->getDetailOptions());

		return $model;
	}

	/**
	 * Populates the Person object from the request
	 * @return bean Person
	 */
	 private function getBeanFromRequest()
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::getBeanFromRequest()");

	 	$person = new Artist($_REQUEST);
	 	
	 	// related events
		$events = array();
		if (isset($_REQUEST['exhibition'])) {
			foreach ($_REQUEST['exhibition'] as $oid) {
					$event = new Exhibition();
					$event->setOid($oid);
					$events[] = $event;
				}
		}
		if ($events) {
			$logger->debug("Number of related exhibitions in the form: ". count($events));
			$person->setExhibitions($events);
		}

		// gallery
		if (isset($_REQUEST['gallery'])) {
			$person->setGallery($_REQUEST['gallery']);
		}

	 	return $person;
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

	private function getPersonService()
	{
		if ($this->personService == null) {
			$this->personService = new PersonService();
		}
		return $this->personService;
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

	private function getEventService()
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}
}