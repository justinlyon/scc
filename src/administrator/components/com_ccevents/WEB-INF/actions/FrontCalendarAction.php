<?php
/**
 *  $Id$: FrontCalendarAction.php, Sep 18, 2006 8:19:19 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
require_once WEB_INF . '/actions/MasterAction.php'; 
require_once WEB_INF . '/beans/Event.php';
require_once WEB_INF . '/beans/Promotion.php';
require_once WEB_INF . '/beans/CalendarForm.php';
require_once WEB_INF . '/beans/CalendarEntry.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/service/ScheduleService.php';
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/service/HomePageService.php';
require_once WEB_INF . '/service/GalleryService.php';
require_once ('tachometry/util/BeanUtil.php');

class FrontCalendarAction extends MasterAction
{ 
	private $scheduleService;
	private $eventService;
	private $homePageService;
	private $galleryService;
	const USE_PROMOS = 'true'; // should we get the promos
	const USE_ENTRIES = 'false'; // should we get the free-form entries
	const CAL_PROMO_START = 10; // the start position of the calendar entries in the home page
	const CAL_PROMO_END = 13; // the end position of the calendar entries in the home page
	
	/**
	 * The default method if no task is given. Will invoke the 
	 * month viewpage renderer
	 * @param object $mainframe The Joomla specific page object
	 * @return bean summary page model bean
	 */
	function execute($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::execute()");
		return $this->month($mainframe);
	}
	
        /**
         * Will return the list of events for the list view renderer
         * @param object $mainframe The Joomla specific page object
         * @return bean summary page model bean
         */
        function events($mainframe)
        {
                global $logger;
                $logger->debug(get_class($this) . "::events()");

                $ss = $this->getScheduleService();
                $es = $this->getEventService();
                $model = new SummaryPageModel();
		$cal = $this->getBeanFromRequest();

                $date = (isset($_REQUEST['date']) && $_REQUEST['date'] > 0) ? $_REQUEST['date'] : date('Ymd');
                $days = (isset($_REQUEST['days']) && $_REQUEST['days'] > 0) ? $_REQUEST['days'] : 15;
                $limit = (isset($_REQUEST['limit']) && $_REQUEST['limit'] > 0) ? $_REQUEST['limit'] : null;

                $startDate = strtotime($date);
                $endDate = $startDate + ($days * 86400);
                $start = mktime(0,0,0,date("n",$startDate),date("j",$startDate),date("Y",$startDate));
                $end = mktime(23,59,59,date("n",$endDate),date("j",$endDate),date("Y",$endDate));
                // get the list of schedules for their oids
                $schedules = $ss->getSchedulesForRange($start,$end);

		// Convert schedules to arrays for the mini months
		// This section gets ALL of the events and packs them into the array
		$scheduledDates = $ss->getUniqueScheduledDates();
		foreach ($scheduledDates as $eventDate) {
			$year = date('Y', strtotime($eventDate));
			$month = date('n', strtotime($eventDate));
			$day = date('j', strtotime($eventDate));
			if (!isset($events[$year]))
				$events[$year] = array();
			if (!isset($events[$year][$month]))
				$events[$year][$month] = array();
			$events[$year][$month][] = $day;
		}

/* This may be needed in the future, if for some reason you don't want to use the above code to get ALL the event dates
		// Get schedule objects for this, prev, and next months for the mini calendar
		$thisMonthStart = strtotime(date('Ym', $startDate) . "01");
		$thisMonthEnd   = strtotime(date('Ym', $startDate) . "01 +1 month -1 second");
		$prevMonthStart = strtotime(date('Ym', $startDate) . "01 -1 month");
		$prevMonthEnd   = strtotime(date('Ym', $startDate) . "01 -1 second");
		$nextMonthStart = strtotime(date('Ym', $startDate) . "01 +1 month");
		$nextMonthEnd   = strtotime(date('Ym', $startDate) . "01 +2 month -1 second");
		$thisMonthSchedule = $ss->getSchedulesForRange($thisMonthStart,$thisMonthEnd);
		$prevMonthSchedule = $ss->getSchedulesForRange($prevMonthStart,$prevMonthEnd);
		$nextMonthSchedule = $ss->getSchedulesForRange($nextMonthStart,$nextMonthEnd);
		
		$events = array();
		$list = array();
		// Previous Month
		$currYear = date('Y', $prevMonthStart);
		$currMonth = date('n', $prevMonthStart);
		$events[$currYear] = array();
		$list = array();
		foreach ($prevMonthSchedule as $event) {
			if (date('Ym', $event->getStartTime()) == date('Ym', $prevMonthStart))
				$list[] = date('j', $event->getStartTime());
			if (date('Ymd', $event->getStartTime()) != date('Ymd', $event->getEndTime()) && date('Ym', $event->getEndTime()) == date('Ym', $prevMonthStart))
				$list[] = date('j', $event->getEndTime());
		}
		sort($list);
		$list = array_unique($list);
		$events[$currYear][$currMonth] = $list;
		// This Month
		$currYear = date('Y', $thisMonthStart);
		$currMonth = date('n', $thisMonthStart);
		if (!isset($events[$currYear]))
			$events[$currYear] = array();
		$list = array();
		foreach ($thisMonthSchedule as $event) {
			if (date('Ym', $event->getStartTime()) == date('Ym', $thisMonthStart))
				$list[] = date('j', $event->getStartTime());
			if (date('Ymd', $event->getStartTime()) != date('Ymd', $event->getEndTime()) && date('Ym', $event->getEndTime()) == date('Ym', $thisMonthStart))
				$list[] = date('j', $event->getEndTime());
		}
		sort($list);
		$list = array_unique($list);
		$events[$currYear][$currMonth] = $list;
		// Next Month
		$currYear = date('Y', $nextMonthStart);
		$currMonth = date('n', $nextMonthStart);
		if (!isset($events[$currYear]))
			$events[$currYear] = array();
		$list = array();
		foreach ($nextMonthSchedule as $event) {
			if (date('Ym', $event->getStartTime()) == date('Ym', $nextMonthStart))
				$list[] = date('j', $event->getStartTime());
			if (date('Ymd', $event->getStartTime()) != date('Ymd', $event->getEndTime()) && date('Ym', $event->getEndTime()) == date('Ym', $nextMonthStart))
				$list[] = date('j', $event->getEndTime());
		}
		sort($list);
		$list = array_unique($list);
		$events[$currYear][$currMonth] = $list;
*/

                // now get the events (only get so many if the limit is set)
                $max = ($limit && count($schedules) > $limit) ? $limit : count($schedules);
                $cals = array();
		$cals[] = $events;
                for($i=0; $i<$max; $i++) {
                        $sched = $schedules[$i];
                        $logger->debug("Finding event by schedule id: ". $sched->getOid());
                        $event = $es->getEventBySchedule($sched);
                        $logger->debug("The event has a title of: ". $event->getTitle());

                        // only add published events
                        if ($event->getPubState() == 'Published') {
                                // start time
                                if ($sched->getStartTime() >= $start) {
                                        $events[] = $event;
                                        if ($this->isFilter($event)) {
                                                $cals[] = $this->setCalendarEntry($sched,$event);
                                        }
                                }
                                // exhibition end time
                                if ($event->getScope() == Event::EXHIBITION && $sched->getEndTime() != 0 && $sched->getEndTime() < $end) {
                                        $events[] = $event;
                                        if ($this->isFilter($event)) {
                                                $cals[]= $this->setCalendarEntry($sched,$event,true);
                                        }
                                }
                        }      
                }
                $logger->debug("Number of events: ". count($events));
echo "<!--";
print_r($cals);
echo "-->";
                $model->setList($cals);
		$model->setOptions($this->getOptions($events));
                return $model;
        }

	/**
	 * Will return the list of events for the month view renderer
	 * @param object $mainframe The Joomla specific page object
	 * @return bean summary page model bean
	 */
	function month($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::month()");
		return $this->setSummaries($mainframe);
	}
	
	/**
	 * Will return the list of events for the flat text view renderer
	 * @param object $mainframe The Joomla specific page object
	 * @return bean summary page model bean
	 */
	function text($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::text()");
		return $this->setSummaries($mainframe);
	}

	/**
	 * Will return the list of events for the given number of days in the
	 * future (defaults to 60) and an optional limit 
	 * @param object $mainframe The Joomla specific page object
	 * @return bean summary page model bean
	 */
	function feed($mainframe=null)
	{
		global $logger;
		$logger->debug(get_class($this) . "::feed()");
		
		$ss = $this->getScheduleService();
		$es = $this->getEventService();
		$model = new SummaryPageModel();
		
		$days = (isset($_REQUEST['days']) && $_REQUEST['days'] > 0) ? $_REQUEST['days'] : 60;
		$limit = (isset($_REQUEST['limit']) && $_REQUEST['limit'] > 0) ? $_REQUEST['limit'] : null;
		
		$today = time();
		$endday = $today + ($days * 86400);
		$start = mktime(12,0,0,date("n",$today),date("j",$today),date("Y",$today));
		$end = mktime(11,59,59,date("n",$endday),date("j",$endday),date("Y",$endday));
		// get the list of schedules for their oids
		$schedules = $ss->getSchedulesForRange($start,$end);
	
		// now get the events (only get so many if the limit is set)
		$max = ($limit && count($schedules) > $limit) ? $limit : count($schedules);	
		$cals = array();
		for($i=0; $i<$max; $i++) {
			$sched = $schedules[$i];
			$logger->debug("Finding event by schedule id: ". $sched->getOid());	
			$event = $es->getEventBySchedule($sched);
			$logger->debug("The event has a title of: ". $event->getTitle());
							
			// only add published events
			if ($event->getPubState() == 'Published') {
				// start time
				if ($sched->getStartTime() > $start) {
					$events[] = $event;
					if ($this->isFilter($event)) {
						$cals[] = $this->setCalendarEntry($sched,$event);
					}
				} 
				// exhibition end time
				if ($event->getScope() == Event::EXHIBITION && $sched->getEndTime() < $end) {
					$events[] = $event;
					if ($this->isFilter($event)) {
						$cals[]= $this->setCalendarEntry($sched,$event,true);
					}
				}
			}	
		}
		$logger->debug("Number of events: ". count($events));
		$model->setList($cals);
		return $model;
	}
	
	/**
	 * Compiles the list of events and activities for the calendar
	 * @param object $mainframe The Joomla specific page object
	 * @return bean summary page model bean
	 */
	private function setSummaries($mainframe)
	{
		global $mosConfig_live_site, $logger;
		$logger->debug(get_class($this) . "::setSummaries()");
		
		$ss = $this->getScheduleService();
		$model = new SummaryPageModel();
		$cal = $this->getBeanFromRequest();
		$start = CalendarForm::getMonthStart($cal);
		$end = CalendarForm::getMonthEnd($cal);		

		if (FrontCalendarAction::USE_PROMOS) {
			$promos = $this->getPromos();
			$list = array();
			for ($i=0; $i<count($promos); $i++) {
				$promo = $promos[$i];	
				$list[] = $promo;
			}
			$model->setAnnouncement($list);	
		}
		
		// get the list of schedules for their oids
		$schedules = $ss->getSchedulesForRange($start,$end);
	
		// get the events for the scheudles in the range
		$es = $this->getEventService();
		$events = array();
		$cals = array();
		foreach ($schedules as $sched) {
			$logger->debug("Finding event by schedule id: ". $sched->getOid());	
			$event = $es->getEventBySchedule($sched);
			$logger->debug("The event has a title of: ". $event->getTitle());
			
			// only add published events
			if ($event->getPubState() == 'Published') {
				// start time
				if ($sched->getStartTime() > $start) {
					$events[] = $event;
					if ($this->isFilter($event)) {
						$cals[] = $this->setCalendarEntry($sched,$event);
					}
				} 
				// exhibition end time
				if ($event->getScope() == Event::EXHIBITION && $sched->getEndTime() < $end) {
					$events[] = $event;
					if ($this->isFilter($event)) {
						$cals[]= $this->setCalendarEntry($sched,$event,true);
					}
				}
			}	
		}
		
		$logger->debug("Number of events: ". count($events));
		
		$model->setSelected($cal);
		$model->setList($cals);	
		$model->setOptions($this->getOptions($events));

		return $model;

	}
	/**
	 * Returns the promos for the calendar.  This currently
	 * uses the home page manager, but may change.
	 * @return array of Promotion beans
	 */
	function getPromos() {
		global $logger;
		$logger->debug(get_class($this) . "::getPromos()");
		
		$result = array();
		
		$es = $this->getEventService();
		$hps = $this->getHomePageService();
		$gs = $this->getGalleryService();
		$promos = $hps->getCurrentHomepage();		
		$start = FrontCalendarAction::CAL_PROMO_START;
		$end = FrontCalendarAction::CAL_PROMO_END;
		for($i=$start; $i<=$end; $i++) {
			$getter = 'getEvent'. $i;	
	 		$entry = $promos->$getter();
			
			$event = $hps->splitString($entry); // returns an assoc array [scope, id] 
			if (count($event) > 0) {
				$promo = $es->getPromotion($event['scope'],$event['id']);
				switch ($promo->getScope()) {
					case 'Program' : $scope = 'prgm'; break;
					case 'Exhibition': $scope = 'exbt'; break;	
				}	
				$image = $gs->getAlbumThumbnail($promo->getImage(),'small',$promo->getScope());		
				$promo->setImage($image);
				$link = JRoute::_('index.php?option=com_ccevents&scope='. $scope .'&task=detail&oid='. $promo->getId() . ($scope=='prgm' ? '&fid=' . $promo->getPrimaryGenre()->getOid() : ''));			
				$promo->setLink($link);
				$result[] = $promo;
			}
		}
		return $result;	
	}
	
	/**
	 * Gets the appropriate elements from the form (or request)
	 * and adds them to a convenience bean object.
	 * 
	 * @access private
	 * @return bean SummaryPageModel
	 */
	 private function getBeanFromRequest()
	 {
	 	$bean = new CalendarForm();	
	 	$now = time();
	 	
	 	$month = (isset($_REQUEST['month'])) ? $_REQUEST['month'] : date("m",$now);
	 	$year = (isset($_REQUEST['year'])) ? $_REQUEST['year'] : date("Y",$now);
	 	$category = (isset($_REQUEST['category']) && $_REQUEST['category'] > 0 ) ? $_REQUEST['category'] : null;
	 	
	 	$bean->setMonth($month);
	 	$bean->setYear($year);
	 	$bean->setCategory($category);
	 	
	 	return $bean;
	 }
	 
	/**
	 * Builds the array of options for the page renderer
	 * @access private
	 * @param array the list of events (to get categories)
	 * @return array an associate array keyed by attribute type
	 */
	 private function getOptions($events)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::getOptions($events)");
	 	$options = array();
	 	
	 	// set the category select options
	 	$ss = $this->getScheduleService();
		$options['category'] = $ss->getPublishedCategories(array('Genre','Audience'));	
		
		// set the month options
		$options['month']['value'] = array('1','2','3','4','5','6','7','8','9','10','11','12');
		$options['month']['text'] = array('January','February','March','April','May','June',
										'July','August','September','October','November','December');
	
		// TODO: this should be refactored to get the year range of actual entries
		// but that will add overhead to this process and should be done when
		// we do a more thorough evaluation of calendar optimization.  
		// Currently it will start at 2006 and add all years to one greater than today.
		$year = date("Y");
		$year_array = array();
		for($i=2006; $i<=$year+1; $i++) {
			$year_array[] = $i;	
		}
		$options['year']['value'] = $year_array;
		
		$logger->debug("number of option types: ". count($options));
		return $options;									
	}
	
	/**
	 * Returns a list of CalendarEntry beans for the given event 
	 * 
	 * @param bean Schedule
	 * @param bean subclassed Event
	 * @param boolean end is this an endTime entry (default to false)
	 * @return bean CalendarEntry
	 */
	private function setCalendarEntry($sched, $event, $end=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setCalendarEntry($sched, $event, $end)");
		
		$ce = new CalendarEntry();
		$ce->setOid($event->getOid());
		$ce->setScope(get_class($event));
		$ce->setStartTime($sched->getStartTime());
		$ce->setSummary($event->getSummary());
		if ($event->getDefaultVenue())
			$ce->setVenue($event->getDefaultVenue()->getName());
		if ($event->getGallery() > 0 && $_REQUEST['task'] != "feed")
			$event = $this->setGallery($event,true,true); // from MasterAction
		$ce->setGallery($event->getGallery());
		if ($ce->getScope() != Event::EXHIBITION && $event->getPrimaryGenre()) {
			$ce->setFid($event->getPrimaryGenre()->getOid()); // the primary genre id
		}
		if ($ce->getScope() == Event::EXHIBITION) {
			// check for endTime flag
			if (!$end) {			
				$ce->setTitle($event->getTitle() . " opens");
			} else {
				$ce->setTitle($event->getTitle() . " closes");
				$ce->setStartTime($sched->getEndTime());	
			}
			$ce->setGenre(Event::EXHIBITION);
		} else {
			$ce->setTitle($event->getTitle());
			if ($event->getPrimaryGenre()) {
				$ce->setGenre($event->getPrimaryGenre()->getName());
			} else $ce->setGenre($ce->getScope());
		}
			
		$family = false;
		$cats = $event->getCategories();
		if (isset($cats['Audience'])) {
			$family = $this->isFamilyFriendly($cats['Audience']);
		}
		$ce->setFamily($family);		
		return $ce;
	}	
	/**
	 * returns the current published categories for the given
	 * list of events
	 * 
	 * @param array the list of events
	 * @return array (oid,name) (ordered by alpha name)
	 */
	private function getCurrentCategories($events) 
	{
		global $logger;
		$logger->debug(get_class($this) . "::getCurrentCategories($events)");
		$result = array();
/*
		$genres = array();
		$auds = array();
		
		$gkeys = array();
		$akeys = array();
		
		foreach ($events as $event) {
			if ($event->getScope() != 'Exhibition') {
			
				$pgoid = $event->getPrimaryGenre()->getOid();			
				if (!isset($genres[$pgoid])) {
					$name = $event->getPrimaryGenre()->getName();
					$genres[$pgoid] = array('oid'=>$pgoid,'name'=>$name);
					$gkeys[] = $name;
				}	
				
				$cats = $event->getCategories();
				if (count($cats) > 0) {
					if (isset($cats['Genre'])) {
						foreach ($cats['Genre'] as $gen) {
							$coid = $gen->getOid();
							$name = $gen->getName();
							if (!isset($genres[$coid])) {
								$genres[$coid] = array('oid'=>$coid,'name'=>$name);
								$gkeys[] = $name;
							} 
						}
					}	
					if (isset($cats['Audience'])) {
						foreach ($cats['Audience'] as $aud) {
							$coid = $aud->getOid();
							$name = $aud->getName();
							if (!isset($auds[$coid])) {
								$auds[$coid] = array('oid'=>$coid,'name'=>$name);
								$akeys[] = $name;
							} 
						}
					}
				}
			}
		}
		
		array_multisort($gkeys,$genres);
		array_multisort($akeys,$auds);
		
		$result[] = array('oid'=>'-1','name'=>'Exhibitions');
		foreach($genres as $gen) {
			$result[] = $gen;
		}
		$result[] = array('oid'=>'0','name'=>'----');
		foreach($auds as $aud) {
			$result[] = $aud;
		}	
*/
		return $result;		
	}
	/**
	 * returns true if no category filter was set on the request,
	 * or if the given event contains the given filter
	 */
	private function isFilter($event) {
		$filter = isset($_REQUEST['fid']) ? $_REQUEST['fid'] : null;	
		if ($filter == -1 || $filter > 0) {
			
			// check the exhibitions
			if ($event->getScope() == Event::EXHIBITION) {
				return ($filter == -1);	
			}
			
			// check the programs
			else{ 
				$cats = $event->getCategories();
				$genres = isset($cats['Genre']) ? $cats['Genre'] : array();
				$auds = isset($cats['Audience']) ? $cats['Audience'] : array();
				$ids = array();
				$ids[] = $event->getPrimaryGenre()->getOid();
				foreach ($genres as $gen) {
					$ids[] = $gen->getOid();	
				}				
				foreach ($auds as $aud) {
					$ids[] = $aud->getOid();	
				}
				return (in_array($filter,$ids));	
			}			
		}
		return true; // no filter applied, return true
	}
	private function getScheduleService() 
	{
		if ($this->scheduleService == null) {
			$this->scheduleService = new ScheduleService();
		}
		return $this->scheduleService;
	}
	
	private function getEventService() 
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}
	
	private function getHomePageService() 
	{
		if ($this->homePageService == null) {
			$this->homePageService = new HomePageService();
		}
		return $this->homePageService;
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

