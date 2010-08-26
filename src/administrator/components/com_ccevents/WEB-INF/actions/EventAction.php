<?php
/**
 *  $Id$: EventAction.php, Sep 17, 2006 11:32:14 AM nchanda
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
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/service/EnumeratedValueService.php';
require_once WEB_INF . '/service/VenueService.php';
require_once WEB_INF . '/service/ScheduleService.php';
require_once WEB_INF . '/service/GalleryService.php';
require_once WEB_INF . '/service/JoomlaContentService.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/EventStatus.php';
require_once WEB_INF . '/beans/PageModel.php';

require_once ('tachometry/web/BaseAction.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * The EventAction class holds all common and generic methods
 * for the event subclass actions.  (e.g. ExhibitionAction,
 * ProgramAction, CourseAction).  It is not intended to be called
 * directly.
 */

abstract class EventAction extends BaseAction
{
	protected $eventService;
	protected $enumeratedValueService;
	protected $venueService;
	protected $scheduleService;
	protected $galleryService;
	protected $joomlaContentService;


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
	 * Takes no action, but returns a list of nonarchived events
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the summary page model bean
	 */
	 function cancel($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::cancel()');
		return $this->setSummaryModel($mainframe);
	 }


	/**
	 * A public wrapper for the private update method.
	 * (will return the DetailPageModel)
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
	 * Sets the publication state of the given events(s) to "Archived"
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
	 * Sets the publication state of the given program(s) to "Published"
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
	 * Sets the publication state of the given program(s) to "Unpublished"
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
	  * Returns an array of oids from the request
	  * @return array oids
	  */
	 protected function getFormOids()
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


	abstract function delete($mainframe);

	abstract function setup($mainframe);

	abstract protected function update($mainframe);

	abstract protected function setSummaryModel($mainframe);

	abstract protected function setDetailModel($mainframe);

	abstract protected function changePubState($oids, $state);

	abstract protected function getBeanFromRequest();


	protected function getVenueService()
	{
		if ($this->venueService == null) {
			$this->venueService = new VenueService();
		}
		return $this->venueService;
	}

	protected function getEventService()
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}

	protected function getEnumeratedValueService()
	{
		if ($this->enumeratedValueService == null) {
			$this->enumeratedValueService = new EnumeratedValueService();
		}
		return $this->enumeratedValueService;
	}

	protected function getScheduleService()
	{
		if ($this->scheduleService == null) {
			$this->scheduleService = new ScheduleService();
		}
		return $this->scheduleService;
	}

	protected function getGalleryService()
	{
		if ($this->galleryService == null) {
			$this->galleryService = new GalleryService();
		}
		return $this->galleryService;
	}

	protected function getJoomlaContentService()
	{
		if ($this->joomlaContentService == null) {
			$this->joomlaContentService = new JoomlaContentService();
		}
		return $this->joomlaContentService;
	}
}


?>

