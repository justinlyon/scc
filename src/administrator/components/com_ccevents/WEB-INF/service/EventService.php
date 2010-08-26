<?php
/**
 *  $Id $
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
require_once WEB_INF . '/pdo/model.php';
require_once WEB_INF . '/beans/Audience.php';
require_once WEB_INF . '/beans/Artist.php';
require_once WEB_INF . '/beans/Category.php';
require_once WEB_INF . '/beans/Course.php';
require_once WEB_INF . '/beans/Event.php';
require_once WEB_INF . '/beans/EventStatus.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/GalleryBean.php';
require_once WEB_INF . '/beans/Genre.php';
require_once WEB_INF . '/beans/Performance.php';
require_once WEB_INF . '/beans/Person.php';
require_once WEB_INF . '/beans/Program.php';
require_once WEB_INF . '/beans/Promotion.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Schedule.php';
require_once WEB_INF . '/beans/Seminar.php';
require_once WEB_INF . '/beans/Series.php';
require_once WEB_INF . '/beans/Venue.php';
require_once WEB_INF . '/dao/EventDao.php'; // the placeholder for future PDO deprication
require_once WEB_INF . '/service/VenueService.php';
require_once WEB_INF . '/service/PersonService.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A service class to serve both as data access facilitator and
 * API contract.  Not the convention that all pulic getters shall
 * return a bean or array of beans.   The private "fetch" methods
 * will return a PDO object or array of PDO objects.  Clients of
 * the service should only call methods that will return bean objects.
 */
class EventService
{
	public $dao;
	public $personService;

	/**
	 * Creates a new Event using the given event type (subclass) and bean.
	 *
	 * @param string eventType The event type (e.g. Exhibition, Program, Course)
	 * @param object bean The inbound Event as a bean
	 * @return The new event as a bean
	 */
	function setupEvent($eventType=null, $bean)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setupEvent($eventType, $bean)");

		if ($eventType == null) {
			trigger_error("Required event type is missing", E_USER_ERROR);
		}

		// Get a new event PDO for the subclassed event
		$b2p = strtolower($eventType) ."BeanToPdo";
		$pdo = $this->$b2p($bean);
		$logger->debug("pdo: ", $pdo);

		// Commit the populated PDO
		$epm = epManager::instance();
		$logger->debug("epm: ", $epm);
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to commit created event.", E_USER_ERROR);
		}


		// Copy from PDO to bean
		$p2b = strtolower($eventType) ."PdoToBean";
		$logger->debug("p2b: ", $p2b);
		return $this->$p2b($pdo);
	}

	/**
	 * Updates an Event of the given event type (subclass).
	 *
	 * @param string eventType The event type (e.g. Exhibition, Program, Course)
	 * @param bean The inbound Event as a bean
	 * @param bean CopyOptionBean to support the ignore of null values
	 * @return The modified event as a bean
	 */
	function updateEvent($eventType=null, $bean, $copyOption=null)
	{
		global $logger;
		$logger->debug(get_class($this) . "::updateEvent($eventType, $bean)");

		if ($eventType == null) {
			trigger_error("Required event type is missing", E_USER_ERROR);
			return;
		}
		if ($bean->getOid() == null) {
			trigger_error('Invalid Event: oid is missing', E_USER_ERROR);
			return;
		}

		// Get a new event PDO for the subclassed event
		$b2p = strtolower($eventType) ."BeanToPdo";
		$pdo = $this->$b2p($bean);

		// Commit the populated PDO
		$epm = epManager::instance();
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to commit created event.", E_USER_ERROR);
		}

		// Copy from PDO to bean
		$p2b = strtolower($eventType) ."PdoToBean";
		return $this->$p2b($pdo);
	}

	/**
	 * Returns all categories of the given type for the given event, or all categories
	 * for the given type if the eventId is null.
	 * @param string categoryType The category type (e.g. Genre, Audience, Series)
	 * @param int eventId The target event
	 * @return Category[] or empty array if not found
	 */
	function getCategories($categoryType=null, $eventId=null)
	{
		global $logger;

		$logger->debug(get_class($this) . "::getCategories($categoryType, $eventId)");

		if ($categoryType == null) {
			trigger_error("Required category type is missing", E_USER_ERROR);
		}

		$pdo = epManager::instance();
		$result = array();
		if ($eventId == null) {
			$cats = $pdo->find('from Category where scope = ? order by name', $categoryType);
			foreach ($cats as $cat) {
				$result[] = new $categoryType($cat->epGetVars(),true);
			}
		} else {
			$events = $pdo->find('from Event where oid = ? order by categories.name', $eventId);
			if (count($events) == 1) {
				$cats = $events[0]->getCategories();
				foreach ($cats as $cat) {
					if ($cat->getScope() == $categoryType) {
						$result[] = new $categoryType($cat->epGetVars(),true);
					}
				}
			} else {
				if (count($events) > 1) {
					trigger_error("Ambiguous result; find by primary key [$eventId] returned more than one event", E_USER_ERROR);
				}
			}
		}
		return $result;
	}

	/**
	 * Returns the scoped Category bean for the given id
	 *
	 * @param string scope The category type (e.g. Audience, Genre)
	 * @param int $oid The oid of the target category
	 * @return Category (subclassed by scope)
	 */
	function getCategoryById($scope,$id)
	{
		if (!$scope || !$id) {
			return null;
		}

		$pdo = $this->fetchCategoryById($scope,$id);
		$bean = new $scope($pdo->epGetVars(),true);
		return $bean;
	}

	/**
	 * Returns the list of scoped event beans for the events
	 * marked as "featured." NOTE: this method uses the
	 * DAO to begin migration away from EZPDO
	 * @param string event type (Program, Course, Exhibition)
	 * @param boolean published only (default sto true)
	 * @return array Event beans
	 */
	function getFeatured($eventType, $published=true)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getFeatured($eventType, $published)");

		$dao = $this->getDao();
		$events = $dao->getFeatured($eventType, $published);

		return $events;
	}




	/**
	 * Returns all venues for the given event, or all venues if the
	 * argument is null.
	 * @param int eventId The target event
	 * @return Venue[] or empty array if not found
	 */
	function getVenues($eventId=null)
	{
		global $logger;

		$logger->debug(get_class($this) . "::getVenues($eventId)");

		$pdo = epManager::instance();
		$result = array();
		if ($eventId == null) {
			$result = $pdo->find('from Venue order by name');
		} else {
			$events = $pdo->find('from Event where oid = ? order by venues.name', $eventId);
			if (count($events) == 1) {
				$result = $events[0]->getVenues();
			} else {
				if (count($events) > 1) {
					trigger_error("Ambiguous result; find by primary key [$eventId] returned more than one event", E_USER_ERROR);
				}
			}
		}
		return $result;
	}

	/**
	 * Returns all events of the given type for the given publication status, or
	 * all "non-archived" events for the given type if the pubStates array is null.
	 * @param string eventType The event type (e.g. Exhibition, Program, Course)
	 * @param array pubStates An array of status keys (e.g. Published, Unpublished, Archived, etc.)
	 * @param int category The oid of a category for sub-select
	 * @return Event[] or empty array if not found
	 */
	function getEventsByPubState($eventType=null, $pubStates=null, $category=null)
	{
		global $logger;

		$logger->debug(get_class($this) . "::getEventsByPubState($eventType, $pubStates, $category)");

		if ($eventType == null) {
			trigger_error("Required event type is missing", E_USER_ERROR);
			return;
		}
		$pdo = epManager::instance();

		$result = array();
		$criteria = array();
		if ( $pubStates == null || count($pubStates) == 0 ) {
			$find = "from $eventType as e where e.pubState is null or e.pubState.value != ? ";
			array_push($criteria,PublicationState::ARCHIVED);
		} else {
			$find = "from $eventType as e where (";
			for( $i=0; $i<count($pubStates); $i++ )
			{
				$find .= '(e.pubState.value = "'. $pubStates[$i] .'" or ';
			}
			$find .= 'e.pubState is null))';
		}
		if ($category != null) {
			$find .= " and ((e.categories.contains(cat) and cat.oid = ?) or e.primaryGenre.oid = $category)";
			array_push($criteria,$category);
		}
		$find .=  " order by displayOrder";
		$logger->debug("DB Query: $find");
		$logger->debug("DB Criteria: ". implode(',',$criteria));
		$result = $pdo->find($find,$criteria);

		// Convert PDOs to Beans
		$p2b = strtolower($eventType) ."PdoToBean";
		$listOfBeans = array();
        foreach($result as $pdo) 	{
			$listOfBeans[] = $this->$p2b($pdo);
		}
		return $listOfBeans;
	}

	/**
	 * Returns all published events of the given type that contain the given Category id
	 *
	 * @param string eventType The event type (e.g. Exhibition, Program, Course)
	 * @param int category The oid of a category for sub-select
	 * @return Event[] or empty array if not found
	 */
	function getPublishedEventsByCategory($eventType=null, $category=null)
	{
		global $logger;

		$logger->debug(get_class($this) . "::getPublishedEventsByCategory($eventType, $category)");

		if ($eventType == null) {
			trigger_error("Required event type is missing", E_USER_ERROR);
			return;
		}
		if ($category == null) {
			trigger_error("Required category id is missing", E_USER_ERROR);
			return;
		}
		$pdo = epManager::instance();

		$result = array();
		$find = "from $eventType as e where e.pubState.value = '". PublicationState::PUBLISHED ."'";
		$find .= " and e.categories.contains(?) order by displayOrder";

		$logger->debug("DB Query: $find");
		$result = $pdo->find($find,$category);

		// Convert PDOs to Beans
		$p2b = strtolower($eventType) ."PdoToBean";
		$listOfBeans = array();
		foreach($result as $pdo) 	{
			$listOfBeans[] = $this->$p2b($pdo);
		}
		return $listOfBeans;
	}

	/**
	 * Returns an event bean for the given event type and event id
	 * This is a public wrapper for the private fetchEventById() method.
	 * @see fetchEventById()
	 * @param string eventType The event type (e.g. Exhibition, Program, Course)
	 * @param int oid the oid for the target event
	 * @return Event or empty array if not found
	 */
	function getEventById($eventType, $oid)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getEventById($eventType, $oid)");
		$logger->debug("oid: ". $oid);

		$pdo = $this->fetchEventById($eventType, $oid);

		$logger->debug("pdo oid: ". $pdo->getOid());
		$p2b = strtolower($eventType) ."PdoToBean";
		return $this->$p2b($pdo);
	}

	/**
	 * Returns the appropriatly scoped event bean object for
	 * the given schedule bean.  The method will view the
	 * scope of the given schedule bean to determine which class
	 * of event should be returned.
	 *
	 * @param bean Schedule
	 * @return bean Subclass of Event (Exhibition, Program, Course)
	 */
	function getEventBySchedule($sched)
	{
		global $logger;
       		global $eventCache;
		$logger->debug(get_class($this) . "::getEventBySchedule($sched)");
		$scope = $sched->getScope();
		$epm = epManager::instance();
		$event = FALSE;

		$logger->debug("Scope of the given schedule id ". $sched->getOid() .": ". $sched->getScope());

		if ($scope == Event::EXHIBITION) {
			$pdo = $epm->find('from Exhibition where schedule.oid = ?',$sched->getOid());
			$event = $this->exhibitionPdoToBean($pdo[0]);
		}
		elseif ($scope == 'Performance') {
			$pdo = $epm->find('from Performance where schedule.oid = ?',$sched->getOid());
			$logger->debug("Size of pdo array: ". count($pdo));
			$act = $pdo[0];
   			$event = $this->programPdoToBean($act->getParent());
		}
		elseif ($scope == 'Seminar') {
			$pdo = $epm->find('from Seminar where schedule.oid = ?',$sched->getOid());
			$act = $pdo[0];
			$event = $this->coursePdoToBean($act->getParent());
		}

		if ($event === FALSE) {
			trigger_error("Invalid event: $sched->getOid() not found", E_USER_ERROR);
			return;
		}
		if (is_array($event) > 1) {
			trigger_error("Invalid event: ambiguous results for $sched->getOid()", E_USER_ERROR);
			return;
		}

		$logger->debug("Event is of type: ". get_class($event));
		return $event;
	}

	/**
	 * Returns an array of sub-typed Events (Exhibition, Course, Program)
	 * for the given search string.  The event title and description will
	 * be searched for the maximaum level of entries that match the given
	 * search string.  A single event type may be searched, or an array of
	 * Event types may be supplied.  Only published events will be returned.
	 *
	 * @param array $eventTypes (Exhibition, Program, Course)
	 * @param array $phrases the search phases to look for
	 * @param int $limit an optional maximum number to return for each given type
	 * @return array Event (sub-classed event beans)
	 */
	public function searchPublishedEvents($eventTypes, $phrases, $limit=0)
	{
		global $logger;
		$logger->debug(get_class($this) . "::searchPublishedEvents($eventTypes, $phrases, $limit)");

		$result = array();
		$epm = epManager::instance();

		$where = ' where ';
		for($i=0; $i<count($phrases); $i++) {
			$where .= '(e.title like "'. $phrases[$i] .'" or e.summary like "'. $phrases[$i] .'" or e.description like "'. $phrases[$i] .'") ';
			if ($i < count($phrases)-1) {
				$where .= " or ";
			}
		}

		foreach($eventTypes as $et) {
			$find = "from $et as e $where ";
			$find .= " and e.pubState.value = '". PublicationState::PUBLISHED ."'";
			if ($limit > 0) {
				$find .= " limit 0, $limit";
			}

			$logger->debug("DB Query: ". $find ." [implode(' ',$phrases)]");
			$pdos = $epm->find($find);
			foreach ($pdos as $pdo) {
				$p2b = strtolower($pdo->getScope()) ."PdoToBean";
				$result[] = $this->$p2b($pdo);
			}
		}

		$logger->debug("number of found events in searchPublishedEvents: ". count($result));
		return $result;
	}

	/**
	 * Retrieves the event by the given id, then invokes the
	 * native delete method on the PDO object.
	 * @param string eventType
	 * @param int The oid for the target event
	 * @return void
	 */
	 function delete($eventType, $oid)
	 {
	 	global $logger;

		$logger->debug(get_class($this) . "::delete($eventType, $oid)");

		if ($eventType == null) {
			trigger_error("Required event type is missing", E_USER_ERROR);
		} else if ($oid == null) {
			trigger_error("Required oid is missing", E_USER_ERROR);
		}
		$event = $this->fetchEventById($eventType, $oid);
		$event->delete();
	 }

	 /**
	  * Returns the most recently added event by the type.
	  * Will return an empty event bean if no events are found
	  * @param string the event subclass name
	  * @return Event sublass object
	  */
	 function getLastEventByType($eventType)
	 {
	 	global $logger;

		$logger->debug(get_class($this) . "::getLastEventByType($eventType)");
		if ($eventType == null) {
			trigger_error("Required event type is missing", E_USER_ERROR);
		}
		$epm = epManager::instance();
		try {
			$oid = $epm->find("MAX(oid) from $eventType");
		} catch (Exception $e) {
			$logger->notice("No rows exception: ". $e);
			return new $eventType();
		}
		$logger->debug("last $eventType oid: $oid");
		return $this->getEventById($eventType, $oid);
	 }

	 /**
	  * Returns the typed event for the given order index (integer value)
	  * Will return an empty bean if no event is found
	  * @param string the event subclass name
	  * @param int the value of the displayOrder
	  * @param string PubState (optional) the target publication state (e.g. 'Published')
	  * @return Event sublass object
	  */
	 function getEventByOrderIndex($eventType, $orderIndex, $pubState=null)
	 {
	 	global $logger;

		$logger->debug(get_class($this) . "::getEventByOrderIndex($eventType, $orderIndex)");
		if ($eventType == null) {
			trigger_error("Required event type is missing", E_USER_ERROR);
		}
		if ($orderIndex == null) {
			trigger_error("Required order index is missing", E_USER_ERROR);
		}
		$epm = epManager::instance();
		try {
			if (!$pubState) {
				$result = $epm->find("from $eventType where displayOrder=?",$orderIndex);
			} else {
				$result = $epm->find("from $eventType where displayOrder=? and pubState.value=?",$orderIndex,$pubState);
			}
		} catch (Exception $e) {
			$logger->notice("No rows exception: ". $e);
			return new $eventType();
		}
		if (count($result) == 0) {
			trigger_error("Invalid Event: orderIndex ($orderIndex) not found", E_USER_ERROR);
			return;
		}
		if (count($result) > 1) {
			trigger_error("Invalid Event: ambiguous results for orderIndex ($orderIndex)", E_USER_ERROR);
			return;
		}
		$pdo = $result[0];
		$p2b = strtolower($eventType) ."PdoToBean";
		return $this->$p2b($pdo);
	 }


	 /**
	  * A public wrapper to return a list of events based on the display
	  * order.
	  */

	 /**
	  * Return the PublicationState PDO for the given value
	  * @param string The PublicationSatte value
	  * @return PublicationState PDO
	  */
	  function fetchPubState($value)
	  {
	  	global $logger;
		$logger->debug(get_class($this) . "::fetchPubState($value)");

	  	if ( is_string($value)) {
	  		$pdo = epManager::instance();
			$template = $pdo->create('PublicationState');
			$template->setValue($value);
			$pubStates = $pdo->find($template);
			if (count($pubStates) > 0) {
				return $pubStates[0];
			} else {
				$logger->debug("No PublicationStates matched value: $value");
				return false;
			}

		}
	  }

	 /**
	  * Return the Schedule PDO for the given bean, creating
	  * a new instance as needed.
	  * @param bean The Schedule bean
	  * @return Schedule PDO
	  */
	  function fetchSchedule($bean, $scope)
	  {
	  	global $logger;
		$logger->debug(get_class($this) . "::fetchSchedule($bean)");
  		$mgr = epManager::instance();
		if (empty($bean->oid) || $bean->getOid() == 0) {
			$schedule = $mgr->create('Schedule');
			$schedule->setStartTime($bean->getStartTime());
			$schedule->setEndTime($bean->getEndTime());
			$schedule->setScope($scope);
			$schedule->commit();
		} else {
			$schedule = $mgr->get('Schedule',$bean->getOid());
		}

		return $schedule;
	  }


	/**
	* Return the EventStatus PDO for the given value
	* @param string The EventStatus value
	* @return EventStatus PDO
	* */
	function fetchEventStatus($value)
	{
		global $logger;
		$logger->debug(get_class($this) . "::fetchEventStatus($value)");

		if ( is_string($value)) {
	  		$pdo = epManager::instance();
			$template = $pdo->create('EventStatus');
			$template->setValue($value);
			$states = $pdo->find($template);
			if (count($states) > 0) {
				return $states[0];
			} else {
				$logger->debug("No EventStatus matched value: $value");
				return false;
			}
		}
	}


	/**
	* Returns the integer value representing the position one higher
	* than the current last position for the given event type.
	* (e.g if the last ordered entry is has a display order of 10, the
	* returned value will be 11).  Will return 1 if no entries are found.
	* @param string The type (subclass) of event
	* @return int Value representing the next displayOrder value
	*/
	function getNextDisplayOrder($eventType)
	{
		global $logger;

		$logger->debug(get_class($this) . "::getNextDisplayOrder($eventType)");
		if ($eventType == null) {
			trigger_error("Required event type is missing", E_USER_ERROR);
		}
		$pdo = epManager::instance();
		try {
			$order = $pdo->find("MAX(displayOrder) from $eventType");
		} catch (Exception $e) {
			$logger->notice("No rows exception: ". $e);
			return 1; // the next displayOrder should be 1
		}
		$logger->debug("max $eventType displayOrder: $order");
		return intval($order)+1;
	}


	/**
	 * Returns an Event PDO for the given event type and event id.
	 * @param string eventType The event type (e.g. Exhibition, Program, Course)
	 * @param int oid the oid for the target event
	 * @return Event or empty array if not found
	 */
	 function fetchEventById($eventType, $oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::fetchEventById($eventType, $oid)");

		$epm = epManager::instance();
		$event = $epm->get($eventType, $oid);
		if ($event === FALSE) {
			trigger_error("Invalid $eventType: $oid not found", E_USER_ERROR);
			return;
		}
		if (is_array($event) > 1) {
			trigger_error("Invalid $eventType: ambiguous results for $oid", E_USER_ERROR);
			return;
		}
		$logger->debug("Returning event: ". get_class($event));
		return $event;
	 }


	/**
	 * Converts the given program PDO to a bean object.
	 * This includes the conversion from nested lists
	 * of PDO objects to usable lists of oids/names to be used
	 * by the page renderer.
	 *
	 * @access private
	 * @param pdo $pdo Program
	 * @return bean Program
	 */
	 private function programPdoToBean($pdo)
	 {
		require_once WEB_INF . '/beans/Performance.php';

		global $logger;
	  	$logger->debug(get_class($this) . "::programPdoToBean($pdo)");
	  	$copyOption = new CopyBeanOption();
		$copyOption->setUseTargetVars(true);
		$copyOption->setScalarsOnly(true);

		$bean = new Program($pdo->epGetVars());

	  	// primaryGenre to bean
	  	$genre = $pdo->getPrimaryGenre();
	  	$ga = ($genre != null) ? $genre->epGetVars() : null;
		$pg = new Genre($ga);
		$bean->setPrimaryGenre($pg);

	  	// pubState to a string
	  	$ps = '';
	  	if ($pdo->getPubState() != null) {
	  		$ps = $pdo->getPubState()->getValue();
	  	}
	  	$bean->setPubState($ps);

	  	// eventStatus to a string
	  	$es = '';
	  	if ($pdo->getEventStatus() != null) {
	  		$es = $pdo->getEventStatus()->getValue();
	  	}
	  	$bean->setEventStatus($es);

	  	// default venue from pdo to bean
	  	$dven = $pdo->getDefaultVenue();
	  	$dv = ($dven != null) ? $dven->epGetVars() : null;
	  	$bean->setDefaultVenue(new Venue($dv));

	  	// venues from array of pdos to array of venue bean
/*
	  	$vens = array();
	  	if ($pdo->getVenues() != null) {
	  		foreach ($pdo->getVenues() as $ven) {
	  			$vens[] = new Venue($ven->epGetVars());
	  		}
	  	}
	  	$bean->setVenues($vens);
*/
	  	// categories from array of pdos to keyed array of oids
	  	$cats = array();
	  	if($pdo->getCategories() != null) {
	  		foreach ($pdo->getCategories() as $cat) {
	  			$scope = $cat->getScope();
		  		$cats[$scope][] = new $scope($cat->epGetVars());
	  		}
	  	}
	  	$bean->setCategories($cats);

	  	// related exhibitions from array of pdos to keyed array of oids
	  	$exhibitions = $pdo->getExhibitions();
		if ($exhibitions != null) {
			$related = array();
			foreach ($exhibitions as $event) {
				$related[] = new Exhibition($event->epGetVars());
			}
			$bean->setExhibitions($related);
		}

	  	// related courses from array of pdos to keyed array of oids
	  	$courses = $pdo->getCourses();
		if ($courses != null) {
			$related = array();
			foreach ($courses as $event) {
				$related[] = new Course($event->epGetVars());
			}
			$bean->setCourses($related);
		}

	  	// related performances from array of pdos to array of activities
	  	$children = $pdo->getChildren();
		if ($children != null) {
			$activities = array();
			foreach ($children as $activity) {
				$scope = $activity->getScope();
				$perf = new $scope($activity->epGetVars());
				$perf->setActivityStatus(new EventStatus($activity->getActivityStatus()->epGetVars()));
				$perf->setSchedule(new Schedule($activity->getSchedule()->epGetVars()));
				if ($activity->getVenue()) {
					$perf->setVenue(new Venue($activity->getVenue()->epGetVars()));
				}
				$activities[] = $perf;
			}
			$bean->setChildren($activities);
		}

		return $bean;

//		// gallery
//		// TODO get gallery relationship
	 }

	/**
	 * Converts the incoming program bean object to PDO instances.
	 * This includes the conversion from nested list of
	 * linked elements stored as arrays of oids to their
	 * PDO instances.
	 *
	 * @access private
	 * @param bean $bean Program
	 * @param bean $copyOption an option CopyOptionBean (to ignore null values)
	 * @return pdo Program
	 */
	 private function programBeanToPdo($bean, $copyOption=null)
	 {
	 	global $logger;
	 	$logger->debug(get_class($this) . "::programBeanToPdo($bean)");

	 	if (get_class($bean) != 'Program') {
	 		trigger_error("Incoming object is not a valid Program", E_USER_ERROR);
	 		return;
	 	}
	 	if ($copyOption==null) {
	 		$copyOption = new CopyBeanOption();
	 		$copyOption->setScalarsOnly(true);
	 	}

	 	// Check to see if there is a event OID
	 	if ($bean->getOid() > 0) {
	 		$pdo = $this->fetchEventById('Program',$bean->getOid());
	 	} else {
	 		// Get a new event PDO
			$epm = epManager::instance();
			$pdo = $epm->create('Program');
	 	}

		// Copy the bean values over the top of the PDO values
		BeanUtil::copyBean($bean, $pdo, $copyOption);

		// primaryGenre from oid to object instance
		$cat = $bean->getPrimaryGenre();
	
		if ($cat->getOid() > 0) {
			$pg = $this->fetchCategoryById('Genre',$cat->getOid());
			$pdo->setPrimaryGenre($pg);			
		}

		// default venue from oid to object instance
	  	$dven = $bean->getDefaultVenue();
	  	if ($dven->getOid() > 0) {
			$ven = $this->fetchVenueById($dven->getOid());
			$pdo->setDefaultVenue($ven);
		}

		// pubState from string to pdo
		$pubState = $this->fetchPubState($bean->getPubState());
		$pdo->setPubState($pubState);

		// eventStatus from string to pdo
		$eventStatus = $this->fetchEventStatus($bean->getEventStatus());
		$pdo->setEventStatus($eventStatus);

		// venues from array of oids to array of pdos
		$venues = $bean->getVenues();
		if ($venues != null) {
			$vpdos = array();
			foreach ($venues as $venue) {
				if ($venue->getOid() == 0) { continue; }
				$vpdos[] = $this->fetchVenueById($venue->getOid());
			}
			$pdo->getVenues()->removeAll();
			$pdo->setVenues($vpdos);
		}

		// categories from keyed array of oids to array of pdos
		$cats = $bean->getCategories();
		if ($cats != null) {
			$cpdos = array();
			foreach ($cats as $key=>$value) {
				foreach ($value as $cat) {
					if ($cat->getOid() == 0) { continue; }
					$cpdos[] = $this->fetchCategoryById(ucfirst($key),$cat->getOid());
				}
			}
			$pdo->getCategories()->removeAll();
			$pdo->setCategories($cpdos);
		}

		// related courses from keyed array of oids to array of pdos
		$courses = $bean->getCourses();
		if ($courses != null) {
			$epdos = array();
			foreach ($courses as $course) {
				if ($course->getOid() == 0) { continue; }
				$epdos[] = $this->fetchEventById('Course',$course->getOid());
			}
			$pdo->getCourses()->removeAll();
			$pdo->setCourses($epdos);
		}

		// related exhibitions from keyed array of oids to array of pdos
		$exhibitions = $bean->getExhibitions();
		if ($exhibitions != null) {
			$epdos = array();
			foreach ($exhibitions as $exhibition) {
				if ($exhibition->getOid() == 0) { continue; }
				$epdos[] = $this->fetchEventById('Exhibition',$exhibition->getOid());
			}
			$pdo->getExhibitions()->removeAll();
			$pdo->setExhibitions($epdos);
		}

		// performances from array of activity beans
		$activities = $bean->getChildren();
		$pdo->setChildren(Array());
		if ($activities != null) {
			$epm = epManager::instance();
			$children = $pdo->getChildren();
			if ($children != null) {
				foreach ($children as $child) {
					$epm->delete($child);
				}
			}
			$children = array();
			foreach ($activities as $actbean) {		
				if (empty($actbean->getVenue()->oid)) { continue; }
				$actpdo = $epm->create('Performance');
				$actpdo->setTicketCode($actbean->getTicketCode()); 
				$schedule = $actbean->getSchedule();				
				$actpdo->setSchedule($this->fetchSchedule($schedule,'Performance'));
				$actpdo->setActivityStatus($this->fetchEventStatus($actbean->getActivityStatus()));
				$actpdo->setVenue($this->fetchVenueById($actbean->getVenue()->getOid()));
				$children[] = $actpdo;
			}
			$pdo->setChildren($children);
		}
	 	return $pdo;
	 }

	/**
	 * Converts the given course PDO to a bean object.
	 * This includes the conversion from nested lists
	 * of PDO objects to usable lists of oids/names to be used
	 * by the page renderer.
	 *
	 * @access private
	 * @param pdo $pdo Course
	 * @return bean Course
	 */
	 private function coursePdoToBean($pdo)
	 {
		require_once WEB_INF . '/beans/Seminar.php';

		global $logger;
	  	$logger->debug(get_class($this) . "::coursePdoToBean($pdo)");
	  	$copyOption = new CopyBeanOption();
		$copyOption->setUseTargetVars(true);
		$copyOption->setScalarsOnly(true);

		$bean = new Course($pdo->epGetVars());

	  	// primaryGenre to bean
	  	$genre = $pdo->getPrimaryGenre();
	  	$ga = ($genre != null) ? $genre->epGetVars() : null;
	  	$bean->setPrimaryGenre(new Genre($ga));

	  	// pubState to a string
	  	$ps = '';
	  	if ($pdo->getPubState() != null) {
	  		$ps = $pdo->getPubState()->getValue();
	  	}
	  	$bean->setPubState($ps);

	  	// eventStatus to a string
	  	$es = '';
	  	if ($pdo->getEventStatus() != null) {
	  		$es = $pdo->getEventStatus()->getValue();
	  	}
	  	$bean->setEventStatus($es);

	  	// default venue from pdo to bean
	  	$dven = $pdo->getDefaultVenue();
	  	$logger->debug("Getting default venue from the course pdo: ". $pdo->getDefaultVenue());
	  	$dv = ($dven != null) ? $dven->epGetVars() : null;
	  	$bean->setDefaultVenue(new Venue($dv));
	  	$logger->debug("Setting default venue in the course bean: ". $bean->getDefaultVenue()->getName());

	  	// venues from array of pdos to array of venue bean
	  	$vens = array();
	  	if ($pdo->getVenues() != null) {
	  		foreach ($pdo->getVenues() as $ven) {
	  			$vens[] = new Venue($ven->epGetVars());
	  		}
	  	}
	  	$bean->setVenues($vens);

	  	// categories from array of pdos to keyed array of oids
	  	$cats = array();
	  	if($pdo->getCategories() != null) {
	  		foreach ($pdo->getCategories() as $cat) {
	  			$scope = $cat->getScope();
	  			$cats[$scope][] = new $scope($cat->epGetVars());
	  		}
	  	}
	  	$bean->setCategories($cats);

	  	// related exhibitions from array of pdos to keyed array of oids
	  	$exhibitions = $pdo->getExhibitions();
		if ($exhibitions != null) {
			$related = array();
			foreach ($exhibitions as $event) {
				$related[] = new Exhibition($event->epGetVars());
			}
			$bean->setExhibitions($related);
		}

	  	// related programs from array of pdos to keyed array of oids
	  	$programs = $pdo->getPrograms();
		if ($programs != null) {
			$related = array();
			foreach ($programs as $event) {
				$related[] = new Program($event->epGetVars());
			}
			$bean->setPrograms($related);
		}

	  	// related performances from array of pdos to array of activities
	  	$children = $pdo->getChildren();
		if ($children != null) {
			$activities = array();
			foreach ($children as $activity) {
				$scope = $activity->getScope();
				$perf = new $scope($activity->epGetVars());
				$perf->setActivityStatus(new EventStatus($activity->getActivityStatus()->epGetVars()));
				$perf->setSchedule(new Schedule($activity->getSchedule()->epGetVars()));
				if ($activity->getVenue()) {
					$perf->setVenue(new Venue($activity->getVenue()->epGetVars()));
				}
				$activities[] = $perf;
			}
			$bean->setChildren($activities);
		}
		return $bean;
	 }

	/**
	 * Converts the incoming course bean object to PDO instances.
	 * This includes the conversion from nested list of
	 * linked elements stored as arrays of oids to their
	 * PDO instances.
	 *
	 * @access private
	 * @param bean $bean Course
	 * @param bean $copyOption an option CopyOptionBean (to ignore null values)
	 * @return pdo Course
	 */
	 private function courseBeanToPdo($bean, $copyOption=null)
	 {
	 	global $logger;
	 	$logger->debug(get_class($this) . "::courseBeanToPdo($bean)");

	 	if (get_class($bean) != 'Course') {
	 		trigger_error("Incoming object is not a valid Course", E_USER_ERROR);
	 		return;
	 	}
	 	if ($copyOption==null) {
	 		$copyOption = new CopyBeanOption();
	 		$copyOption->setScalarsOnly(true);
	 	}

	 	// Check to see if there is a event OID
	 	if ($bean->getOid() > 0) {
	 		$pdo = $this->fetchEventById('Course',$bean->getOid());
	 	} else {
	 		// Get a new event PDO
			$epm = epManager::instance();
			$pdo = $epm->create('Course');
	 	}

		// Copy the bean values over the top of the PDO values
		BeanUtil::copyBean($bean, $pdo, $copyOption);

		// primaryGenre from oid to object instance
		$cat = $bean->getPrimaryGenre();
		if ($cat->getOid() > 0) {
			$pg = $this->fetchCategoryById('Genre',$cat->getOid());
			$pdo->setPrimaryGenre($pg);
		}

		// pubState from string to pdo
		$pubState = $this->fetchPubState($bean->getPubState());
		$pdo->setPubState($pubState);

		// eventStatus from string to pdo
		$eventStatus = $this->fetchEventStatus($bean->getEventStatus());
		$pdo->setEventStatus($eventStatus);

		// venues from array of oids to array of pdos
		$venues = $bean->getVenues();
		if ($venues != null) {
			$vpdos = array();
			foreach ($venues as $venue) {
				if ($venue->getOid() == 0) { continue; }
				$vpdos[] = $this->fetchVenueById($venue->getOid());
			}
			$pdo->getVenues()->removeAll();
			$pdo->setVenues($vpdos);
		}

		// categories from keyed array of oids to array of pdos
		$cats = $bean->getCategories();
		if ($cats != null) {
			$cpdos = array();
			foreach ($cats as $key=>$value) {
				foreach ($value as $cat) {
					if ($cat->getOid() == 0) { continue; }
					$cpdos[] = $this->fetchCategoryById(ucfirst($key),$cat->getOid());
				}
			}
			$pdo->getCategories()->removeAll();
			$pdo->setCategories($cpdos);
		}

		// related programs from keyed array of oids to array of pdos
		$programs = $bean->getPrograms();
		if ($programs != null) {
			$epdos = array();
			foreach ($programs as $program) {
				if ($program->getOid() == 0) { continue; }
				$epdos[] = $this->fetchEventById('Program',$program->getOid());
			}
			$pdo->getPrograms()->removeAll();
			$pdo->setPrograms($epdos);
		}

		// related exhibitions from keyed array of oids to array of pdos
		$exhibitions = $bean->getExhibitions();
		if ($exhibitions != null) {
			$epdos = array();
			foreach ($exhibitions as $exhibition) {
				if ($exhibition->getOid() == 0) { continue; }
				$epdos[] = $this->fetchEventById('Exhibition',$exhibition->getOid());
			}
			$pdo->getExhibitions()->removeAll();
			$pdo->setExhibitions($epdos);
		}

		// performances from array of activity beans
		$activities = $bean->getChildren();
		if ($activities != null) {
			$epm = epManager::instance();
			$children = $pdo->getChildren();
			foreach ($children as $child) {
				$epm->delete($child);
			}
			$children = array();
			foreach ($activities as $bean) {
				if (empty($bean->getVenue()->oid)) { continue; }
				$activity = $epm->create('Seminar');
				$activity->setTicketCode($bean->getTicketCode());
				$activity->setSchedule($this->fetchSchedule($bean->getSchedule(),'Seminar'));
				$activity->setActivityStatus($this->fetchEventStatus($bean->getActivityStatus()));
				$activity->setVenue($this->fetchVenueById($bean->getVenue()->getOid()));
				$children[] = $activity;
			}
			$pdo->setChildren($children);
		}

	 	return $pdo;
	 }


	/**
	 * Converts the given exhibition PDO to a bean object.
	 * This includes the conversion from nested lists
	 * of PDO objects to usable lists of oids/names to be used
	 * by the page renderer.
	 *
	 * @access private
	 * @param pdo $pdo Program
	 * @return bean Program
	 */
	 private function exhibitionPdoToBean($pdo)
	 {
		global $logger;
	  	$logger->debug(get_class($this) . "::exhibitionPdoToBean($pdo)");

		$bean = new Exhibition($pdo->epGetVars());

	  	// pubState to a string
	  	$ps = '';
	  	if ($pdo->getPubState() != null) {
	  		$ps = $pdo->getPubState()->getValue();
	  	}
	  	$bean->setPubState($ps);

	  	// eventStatus to a string
	  	$es = '';
	  	if ($pdo->getEventStatus() != null) {
	  		$es = $pdo->getEventStatus()->getValue();
	  	}
	  	$bean->setEventStatus($es);

	  	// schedule
	  	$schedule = $pdo->getSchedule();
	  	if ($schedule) {
	  		$bean->setSchedule(new Schedule($schedule->epGetVars()));
	  	} else {
	  		$bean->setSchedule(new Schedule());
	  	}

	  	// venues from array of pdos to array of venue bean
	  	$vens = array();
	  	if ($pdo->getVenues() != null) {
	  		foreach ($pdo->getVenues() as $ven) {
	  			$vens[] = new Venue($ven->epGetVars());
	  		}
	  	}
	  	$bean->setVenues($vens);

	  	// categories from array of pdos to keyed array of oids
	  	$cats = array();
	  	if($pdo->getCategories() != null) {
	  		foreach ($pdo->getCategories() as $cat) {
	  			$scope = $cat->getScope();
	  			$cats[$scope][] = new $scope($cat->epGetVars());
	  		}
	  	}
	  	$bean->setCategories($cats);

	  	// related programs from array of pdos to keyed array of oids
	  	$programs = $pdo->getPrograms();
		if ($programs != null) {
			$related = array();
			foreach ($programs as $event) {
				$rp = new Program($event->epGetVars());
				$ps = $event->getPubState()->getValue();
				$rp->setPubState($ps);

				// primary genre
				if ($event->getPrimaryGenre()) {
					$pg = $event->getPrimaryGenre();
					$prpg = new Category(array("oid"=>$pg->getOid(),"name"=>$pg->getName()));
					$rp->setPrimaryGenre($prpg);
				}

				$acts = array();
				foreach($event->getChildren() as $perf) {
					$sch = new Performance($perf->epGetVars());
					$sch->setSchedule(new Schedule($perf->schedule->epGetVars()));
					$acts[] = $sch;
				}
                usort($acts, array(&$this, "orderPerformances"));
				$rp->setChildren($acts);
                // Using "Nextevent" so we can use orderProgramsByNextevent; really is firstEvent
                $rp->setNextevent($acts[0]->schedule->getStartTime());
				$related[] = $rp;
			}
            usort($related, array(&$this, "orderProgramsByNextevent"));
			$bean->setPrograms($related);
		}

	  	// related courses from array of pdos to keyed array of oids
	  	$courses = $pdo->getCourses();
		if ($courses != null) {
			$related = array();
			foreach ($courses as $event) {
				$related[] = new Course($event->epGetVars());
			}
			$bean->setCourses($related);
		}

		// related artists
	  	$artists = $pdo->getArtists();
		if ($artists != null) {
			$related = array();
			foreach ($artists as $person) {
				$related[] = new Artist($person->epGetVars());
			}
			$bean->setArtists($related);
		}

		return $bean;
	 }

	/**
	 * Converts the incoming exhibition bean object to PDO instances.
	 * This includes the conversion from nested list of
	 * linked elements stored as arrays of oids to their
	 * PDO instances.
	 *
	 * @access private
	 * @param bean $bean an Exhibition bean
	 * @param bean $copyOption an optional CopyOptionBean (for ignore null values)
	 */
	 private function exhibitionBeanToPdo($bean, $copyOption=null)
	 {
	 	global $logger;
	  	$logger->debug(get_class($this) . "::exhibitionBeanToPdo($bean,$copyOption)");

	 	if (get_class($bean) != 'Exhibition') {
	 		trigger_error("Incoming object is not a valid Event", E_USER_ERROR);
	 		return;
	 	}
	 	if ($copyOption==null) {
	 		$copyOption = new CopyBeanOption();
	 		$copyOption->setScalarsOnly(true);
	 	}

	 	// Check to see if there is a event OID
	 	if ($bean->getOid() > 0) {
	 		$pdo = $this->fetchEventById('Exhibition',$bean->getOid());
	 	} else {
	 		// Get a new event PDO
			$epm = epManager::instance();
			$pdo = $epm->create('Exhibition');
	 	}

		// Copy the bean values over the top of the PDO values
		BeanUtil::copyBean($bean, $pdo, $copyOption);

		// schedule pdo
		$schedule = $this->fetchSchedule($bean->getSchedule(),'Exhibition');
//print_r($schedule);
//print_r($bean->getSchedule());
$bean->getSchedule()->setScope('Exhibition');
		BeanUtil::copyBean($bean->getSchedule(), $schedule, $copyOption);
//print_r($schedule);
		$pdo->setSchedule($schedule);
//print_r($pdo->getSchedule());

		// pubState from string to pdo
		$pubState = $this->fetchPubState($bean->getPubState());
		$pdo->setPubState($pubState);

		// eventStatus from string to pdo
		$eventStatus = $this->fetchEventStatus($bean->getEventStatus());
		$pdo->setEventStatus($eventStatus);

		// venues from array of oids to array of pdos
		$venues = $bean->getVenues();
		if ($venues != null) {
			$vpdos = array();
			foreach ($venues as $venue) {
				if ($venue->getOid() == 0) { continue; }
				$vpdos[] = $this->fetchVenueById($venue->getOid());
			}
			$pdo->getVenues()->removeAll();
			$pdo->setVenues($vpdos);
		}

		// categories from keyed array of oids to array of pdos
		$cats = $bean->getCategories();
		if ($cats != null) {
			$cpdos = array();
			foreach ($cats as $key=>$value) {
				foreach ($value as $cat) {
					if ($cat->getOid() == 0) { continue; }
					$cpdos[] = $this->fetchCategoryById(ucfirst($key),$cat->getOid());
				}
			}
			$pdo->getCategories()->removeAll();
			$pdo->setCategories($cpdos);
		}

		// related programs from keyed array of oids to array of pdos
		$programs = $bean->getPrograms();
		if ($programs != null) {
			$epdos = array();
			foreach ($programs as $program) {
				if ($program->getOid() == 0) { continue; }
				$epdos[] = $this->fetchEventById('Program',$program->getOid());
			}
			$pdo->getPrograms()->removeAll();
			$pdo->setPrograms($epdos);
		}

		// related courses from keyed array of oids to array of pdos
		$courses = $bean->getCourses();
		if ($courses != null) {
			$epdos = array();
			foreach ($courses as $course) {
				if ($course->getOid() == 0) { continue; }
				$epdos[] = $this->fetchEventById('Course',$course->getOid());
			}
			$pdo->getCourses()->removeAll();
			$pdo->setCourses($epdos);
		}

		// related artists
		$artists = $bean->getArtists();
		if ($artists != null) {
			$ps = $this->getPersonService();
			$epdos = array();
			foreach ($artists as $artist) {
				if ($artist->getOid() == 0) { continue; }
				$epdos[] = $ps->fetchPersonById('Artist',$artist->getOid());
			}
			$pdo->getArtists()->removeAll();
			$pdo->setArtists($epdos);
		}

		return $pdo;
	 }

	/**
	 * Returns a PDO instance for the target Category. Currently
	 * all subclasses of Category are managed in the same PDO table.
	 * Therefore, the scope is not actually needed.  Adding it to the
	 * API however will allow for the separation of these subsclasses
	 * if required in the future.
	 *
	 * @param string scope The category type (e.g. Audience, Genre)
	 * @param int $oid The oid of the target category
	 * @return pdo The Category PDO
	 */
	 private function fetchCategoryById($scope,$oid)
	 {

	 	$pdo = epManager::instance();
		$cat = $pdo->get('Category', $oid);
		if ($cat === FALSE) {
			trigger_error("Invalid Category: $oid not found", E_USER_ERROR);
			return;
		}
		if (is_array($cat)) {
			trigger_error("Invalid Category: ambiguous results for $oid", E_USER_ERROR);
			return;
		}
		return $cat;
	 }


	/**
	 * Returns a Promotion for the given scoped event.
	 * NOTE: This uses the DAO class to increase performance
	 * @param String scope
	 * @param int oid of the event
	 * @return Promotion bean
	 */
	function getPromotion($scope, $id) {
	 	global $logger;
	  	$logger->debug(get_class($this) . "::getPromotion($scope, $id)");
		$dao = $this->getDao();
		return $dao->getPromotion($scope, $id);
	}


	 /**
	  * Invokes the venue service to retrieve the venue PDO
	  * instance for the given OID.
	  *
	  * @access private
	  * @param int $oid
	  * @return pdo Venue PDO
	  */
	 private function fetchVenueById($oid)
	 {
	 	$vs = new VenueService();
	 	return $vs->fetchVenueById($oid);
	 }


	private function getPersonService()
	{
		if ($this->personService == null) {
			$this->personService = new PersonService();
		}
		return $this->personService;
	}

	private function getDao()
	{
		if ($this->dao == null) {
			$this->dao = new EventDao();
		}
		return $this->dao;
	}

	/**
          * Sorts Performance objects by schedule start time
          *
          * @access private
          * @param object $perfObj1
          * @param object $perfObj2
          * @return int
          */
         private function orderPerformances($perfObj1,$perfObj2)
         {
                $start1 = $perfObj1->getSchedule()->getStartTime();
                $start2 = $perfObj2->getSchedule()->getStartTime();
		if($start1 < $start2)   {
            		$result = -1;
        	} elseif($start1 == $start2)    {
            		$result = 0;
        	} else {
            		$result = 1;
        	}
                return $result;
         }
   
     	/**
          * Sorts Program objects by nextEvent
          *
          * @access private
          * @param object $progObj1
          * @param object $progObj2
          * @return int
          */
         private function orderProgramsByNextevent($progObj1,$progObj2)
         {
                $start1 = $progObj1->getNextevent();
                $start2 = $progObj2->getNextevent();
        	if($start1 < $start2)   {
            		$result = -1;
        	} elseif($start1 == $start2)    {
            		$result = 0;
        	} else {
            		$result = 1;
        	}
		return $result;
	}
}

?>
