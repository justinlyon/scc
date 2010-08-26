<?php
/**
 *  $Id$: ExhibitionAction.php, Jul 3, 2006 4:24:13 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 *	 http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

require_once WEB_INF . '/base.include.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/service/GalleryService.php';
require_once WEB_INF . '/service/PersonService.php';
require_once WEB_INF . '/service/AnnouncementService.php';
require_once WEB_INF . '/service/JoomlaContentService.php';

require_once ('MasterAction.php');

class FrontExhibitionAction extends MasterAction
{
	private $eventService;
	private $galleryService;
	private $personService;
	private $enumeratedValueService;
	private $announcementService;
	private $joomlaContentService;
	
	/**
	 * The default execute method.  
	 * @param Joomla mainframe object
	 * @return bean page model
	 */
	function execute($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::render()');
		return $this->summary($mainframe);
	}
	
	
	/**
	 * Gets the summary data for the special exhibitions.
	 * @param object A joomla mainframe object (or extended mainframe)
	 * @return bean An SummaryPageModel bean.
	 */
	function summary($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::summary()');

		$service = $this->getEventService();
		$gs = $this->getGalleryService();
		$model = new SummaryPageModel();
		$pubStates = array(PublicationState::PUBLISHED);
		$logger->debug("Size of pubStates array: ". count($pubStates));

		$list = $service->getEventsByPubState('Exhibition',$pubStates);
		$logger->debug("Size of exhibitions array: ". count($list));

		// filter out the exhibition categories
		$summary = array();
		$special = array();
		$ongoing = array();
		$upcoming = array();
		foreach ($list as $event) {
			$st = $event->getSchedule()->getStartTime();
			$et = $event->getSchedule()->getEndTime();
			$now = time();
			if ($st<$now && $et>$now ) {
				$event = $this->setGallery($event,true,true); // in the MasterAction class
				$special[] = $event;
			}
			if ($st<$now && $et == 0) {
				$event = $this->setGallery($event,true,true); // in the MasterAction class
				$ongoing[] = $event;
			}
			if ($st>$now) {
				$event = $this->setGallery($event,true,true); // in the MasterAction class
				$upcoming[] = $event;
			}
		}
		$summary = array_merge(array("special"),$special,array("ongoing"),$ongoing,array("upcoming"),$upcoming);
		$logger->debug("Total summary: ". count($summary)-3);

		$annc = $this->getPublishedAnnouncement('Exhibition',true);
		$model->setAnnouncement($annc);

		$model->setList($summary);

		return $model;
	}

	/**
	 * Gets the summary data for the ongoing exhibitions.
	 * @param object A joomla mainframe object (or extended mainframe)
	 * @return bean An SummaryPageModel bean.
	 */
	function ongoing($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::ongoing()');

		$service = $this->getEventService();
		$gs = $this->getGalleryService();
		$model = new SummaryPageModel();
		$pubStates = array(PublicationState::PUBLISHED);
		$logger->debug("Size of pubStates array: ". count($pubStates));

		$list = $service->getEventsByPubState('Exhibition',$pubStates);
		$logger->debug("Size of exhibitions array: ". count($list));

		// filter out the ongoing exhibitions
		$ongoing = array();
		foreach ($list as $event) {
			$st = $event->getSchedule()->getStartTime();
			$et = $event->getSchedule()->getEndTime();
			$now = time();
			if ($st<$now && $et == 0 ) {
				$event = $this->setGallery($event,true,true); // in the MasterAction class
				$ongoing[] = $event;
			}
		}
		$logger->debug("Total ongoing: ". count($ongoing));

		$annc = $this->getPublishedAnnouncement('Exhibition',true);
		$model->setAnnouncement($annc);

		$model->setList($ongoing);

		return $model;
	}


	/**
	 * Gets the summary data for the current exhibitions.
	 * @param object A joomla mainframe object (or extended mainframe)
	 * @return bean An SummaryPageModel bean.
	 */	
	function current($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::current()');
		
		$service = $this->getEventService();
		$gs = $this->getGalleryService();
		$model = new SummaryPageModel();
		$pubStates = array(PublicationState::PUBLISHED);
		$logger->debug("Size of pubStates array: ". count($pubStates));
			
		$list = $service->getEventsByPubState('Exhibition',$pubStates);
		$logger->debug("Size of exhibitions array: ". count($list));	
		
		// filter out the current exhibitions
		$current = array();
		foreach ($list as $event) {
			$st = $event->getSchedule()->getStartTime();
			$et = $event->getSchedule()->getEndTime();
			$now = time();
			if ($st<$now && ($et>$now || $et == 0) ) {

				$event = $this->setGallery($event,true,true); // in the MasterAction class
				$current[] = $event;	
			}
		}		
		$logger->debug("Total current: ". count($current));

		$annc = $this->getPublishedAnnouncement('Exhibition',true);
		$model->setAnnouncement($annc);
		
		$model->setList($current);
		
		return $model;
	}


	/**
	 * Gets the summary data for the upcoming exhibitions.
	 * @param object A joomla mainframe object (or extended mainframe)
	 * @return bean An SummaryPageModel bean.
	 */	
	function upcoming($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::upcoming()');
		
		$service = $this->getEventService();
		$gs = $this->getGalleryService();
		$model = new SummaryPageModel();
		$pubStates = array(PublicationState::PUBLISHED);
		$logger->debug("Size of pubStates array: ". count($pubStates));
			
		$list = $service->getEventsByPubState('Exhibition',$pubStates);
		$logger->debug("Size of exhibitions array: ". count($list));	
		
		// filter for the upcoming exhibitions
		$upcoming = array();
		foreach ($list as $event) {
			$st = $event->getSchedule()->getStartTime();
			$now = time();
			if ($st > $now) {
				$event = $this->setGallery($event,true,true); // in the MasterAction class
				$upcoming[] = $event;	
			}
		}		
		$logger->debug("Total upcoming: ". count($upcoming));

		$annc = $this->getPublishedAnnouncement('Exhibition',true);
		$model->setAnnouncement($annc);
		
		$model->setList($upcoming);
		
		return $model;
	}


	/**
	 * Gets the summary data for the past exhibitions.
	 * @param object A joomla mainframe object (or extended mainframe)
	 * @return bean An SummaryPageModel bean.
	 */	
	function past($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::past()');
		
		// Get the year range, or set it to the current year range
                $selectedRange = (isset($_REQUEST['year'])) ? $_REQUEST['year'] : (date('Y')-1) . "-" . date('Y');
                $startYear = substr($selectedRange, 0, strpos($selectedRange,'-'));
                $endYear = substr($selectedRange, strpos($selectedRange,'-') + 1);
                $startRange = mktime(0,0,0,1,1,$startYear);
                $endRange = mktime(23,59,59,12,31,$endYear);

		$service = $this->getEventService();
		$gs = $this->getGalleryService();
		$model = new SummaryPageModel();
		$pubStates = array(PublicationState::PUBLISHED);
		$logger->debug("Size of pubStates array: ". count($pubStates));
			
		$list = $service->getEventsByPubState('Exhibition',$pubStates);
		$logger->debug("Size of exhibitions array: ". count($list));	
		
		// filter for the past exhibitions
		
		$past = array();
		$years = array();
		foreach ($list as $event) {
			$et = $event->getSchedule()->getEndTime();
			$now = time();
			
			if ( ($event->getPubState() == PublicationState::PUBLISHED && $et<$now && $et > 0) || $event->getPubState() == PublicationState::ARCHIVED ) {
				if ($et != 0) {
					$eYear = date('Y', $et);
					$years[] = $eYear;
				}
				if ($et >= $startRange && $et <= $endRange) {
					$event = $this->setGallery($event,true, true); // in the MasterAction class
					$past[] = $event;	
				}
			}
		}		
		// Sort past array into reverse chronological order by start time ...
		$revChron = array();
		foreach($past as $exhibition)
			$revChron[$exhibition->getSchedule()->getStartTime()] = $exhibition;
		krsort($revChron, SORT_NUMERIC);
		$past = array();
		foreach ($revChron as $exhibition)
			$past[] = $exhibition;

		$logger->debug("Total past: ". count($past));
		$years = array_unique($years);
		sort($years);
		$years = array_reverse($years);
		$model->years = $years;

		$annc = $this->getPublishedAnnouncement('Exhibition',true);
		$model->setAnnouncement($annc);
		
		$model->setList($past);
		
		return $model;
	}

		
	/**
	 * Gets the detail data for the given exhibition.
	 * @param object A joomla mainframe object (or extended mainframe)
	 * @return bean A DetailPageModel bean.
	 */	
	function detail($mainframe)
	{
		$model = new DetailPageModel();
		
		$oid = $_REQUEST['oid'];
		$es = $this->getEventService();
		
		$event = $es->getEventById('Exhibition',$oid);
		
		// Gallery
		$event = $this->setGallery($event,false,false); // in the MasterAction class

		// Artifacts from Highlights gallery
		if ($event->getGallery()->getId() != null) {
			$gs = $this->getGalleryService();
			$hl = $gs->getHighlightsAlbum($event->getGallery()->getId());
			$event->setArtifacts($hl->getImages());
		}
/*		
		// Artifacts (deprecated for Autry)
		$collection = array();
		if ($event->getArtifacts()) {
			$gs = $this->getGalleryService();
			$collection = array();
			$ids = explode(",",$event->getArtifacts());	
			foreach($ids as $id) {
				$collection[] = $gs->getImageById($id);	
			}
		} 
		$event->setArtifacts($collection);
*/		
		// Related Articles
		$articles = array();
		if ($event->getRelatedArticles() > 0) {
			$jcs = $this->getJoomlaContentService();
			$articles = $jcs->getArticlesByCategory($event->getRelatedArticles(), true);	
		}
		$event->setRelatedArticles($articles);
		
		$model->setDetail($event);	
		
		return $model;
	}
	
	
	/**
	 * Loads the artist information for the given artist id
	 * @param object A joomla mainframe object (or extended mainframe)
	 * @return bean A DetailPageModel bean.
	 */
	function artist($mainframe=null)
	{
		global $logger;
		 $logger->debug(get_class($this) . '::artist()');	
		 $model = new DetailPageModel();
		 $id = $_REQUEST['aid']; // artist id
		 $ps = $this->getPersonService();
		 $artist = $ps->getPersonById('Artist',$id);
		 
		 $model->setDetail($artist);
		 return $model;
	}
	
	/**
	 * Loads the image information for the given highlight id
	 * @param object A joomla mainframe object (or extended mainframe)
	 * @return bean A DetailPageModel bean.
	 */
	function highlight($mainframe=null)
	{
		global $logger;
		 $logger->debug(get_class($this) . '::highlight()');	
		 $model = new DetailPageModel();
		 $id = $_REQUEST['eid']; // Gallery2 element id
		 $gs = $this->getGalleryService();
		 $highlight = $gs->getPackagedImage($id);
		 
		 $model->setDetail($highlight);
		 return $model;
	}	
	
	/**
	 * A temporary method of generating test data.  Will be
	 * refactored out once all services have been implemented.
	 * @param bean the EventSUmmaryPage bean
	 * @return bean the EventSUmmaryPage bean w/ stubbed data
	 */
	 private function loadDemoSummaryData($model)
	 {
		 global $logger;
		 $logger->debug(get_class($this) . '::loadTestSummaryData()');
		 
		 // Test Venues
		 require_once WEB_INF .'/beans/Venue.php';
		 $v1 = new Venue();
		 $v1->setName('Hurd Gallery');
		 $v1->setOid(48);
		 $v2 = new Venue();
		 $v2->setName('Taube Courtyard');
		 $v2->setOid(24);
		 $v3 = new venue();
		 $v3->setName('Main Lobby');
		 $v3->setOid(17);
		 $venues = array($v1,$v2,$v3);		 
		 
		 // Test Audience
		 require_once WEB_INF .'/beans/Audience.php';
		 $a1 = new Audience();
		 $a1->setName('All Age Groups');
		 $a2 = new Audience();
		 $a2->setName('Adults');
		 $a3 = new Audience();
		 $a3->setName('Toddlers');
		 $audiences = array($a1,$a2,$a3);
	 
		 $list = $model->getList();
		 foreach ($list as $event) {

			 $event->setFamily($this->randomizeTestBoolean());
			 $event->setAudience($this->randomizeTestArray($audiences,1,1));
		 }
		 $model->setEvents($list);
		 
		 // Page Announcement
		 $msg = "<strong>This is some introductory text about this section of " .
				 "the web site if needed.</strong>  Otherwise this would not be " .
				 "here and everything below would move up so that there isn't a " .
				 "big blank space.";
		 $model->setAnnouncement($msg);
		 
		 return $model;
	 }
	
	
	
	
	/**
	 * A convenience function for randomizing the values
	 * of a given array
	 * @param array The source array
	 * @param int The minimum number of returned items (optional)
	 * @param int The maximum number of returned items (optional)
	 * @return array The randomized array
	 */
	private function randomizeTestArray($list, $minCount=0, $maxCount=null)
	{
		 if ($maxCount == null) {
			 $maxCount = count($list);	
		 }
		 $result = array();
		 $total = rand($minCount,$maxCount);
		 for($i=0;$i<$total;$i++) {
			 $pos = rand(0,(count($list)-1));
			 $result[$i] = $list[$pos];	
		 }
		 return $result;
	}
	
	/**
	 * A convenience function for randomizing the values
	 * of a boolean (true|false)
	 * @return boolean A randomized boolean
	 */
	private function randomizeTestBoolean()
	{	
		$bool = FALSE;
		if (rand(0,1) == 1) {
			$bool = TRUE;
		}
		return $bool;		
	}
	
	private function getEventService() 
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}

	private function getGalleryService() 
	{
		if ($this->galleryService == null) {
			$this->galleryService = new GalleryService();
		}
		return $this->galleryService;
	}
	
	private function getEnumeratedValueService()
	{
		if ($this->enumeratedValueService == null) {
			$this->enumeratedValueService = new EnumeratedValueService();
		}
		return $this->enumeratedValueService;	
	}
	
	private function getAnnouncementService()
	{
		if ($this->announcementService == null) {
			$this->announcementService = new AnnouncementService();
		}
		return $this->announcementService;	
	}
	
	private function getJoomlaContentService()
	{
		if ($this->joomlaContentService == null) {
			$this->joomlaContentService = new JoomlaContentService();
		}
		return $this->joomlaContentService;	
	}
	
	private function getPersonService()
	{
		if ($this->personService == null) {
			$this->personService = new PersonService();
		}
		return $this->personService;	
	}
}

