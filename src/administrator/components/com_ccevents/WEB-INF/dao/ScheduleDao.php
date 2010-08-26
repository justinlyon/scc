<?php
/**
 *  $Id$: 
 *  Copyright (c) 2008, Tachometry Corporation
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
require_once WEB_INF . '/dao/MasterDao.php';
require_once WEB_INF . '/beans/CalendarEntry.php';
require_once WEB_INF . '/beans/Event.php';
require_once WEB_INF . '/beans/Category.php';
require_once WEB_INF . '/beans/Performance.php';
require_once WEB_INF . '/beans/Schedule.php';

require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A class to serve as data access facilitator 
 */
class ScheduleDao extends MasterDao
{
	
	function __construct() {
		global $logger;
		$logger->debug("ScheduleDao::construct()");
	}
	
	/**
	 * Returns a list of Program scoped CalendarEntry for 
	 * the given date range and and optional program-type filter.
	 * @param int start unix timestamp for start range
	 * @param int end unix timestamp for end range 
	 * @param int filter id - the category to filter by
	 * @return array An array of dates for scheduled Programs
	 */	
	function getProgramEntries($start=null, $end=null, $filter=null) {
		$db = $this->getDbo();
		$query = "";
		if ($start == null) {
			//$query = "SELECT DISTINCT (DATE_FORMAT(FROM_UNIXTIME(startTime),\"%Y-%m-%d\") || DATE_FORMAT(FROM_UNIXTIME(startTime),\"%Y-%m-%d\")) as date from Schedule ORDER BY date";
			$query = "SELECT DISTINCT DATE_FORMAT(FROM_UNIXTIME(startTime),\"%Y-%m-%d\") as date from Schedule ORDER BY date";
		} else {
			$query = "SELECT p., s. * from Schedule where startTime >= $start and endTime < $end";
		}
		$db->setQuery($query);
		return $db->loadResultArray();
	}

	/**
	 * Returns the current active categories for the given
	 * event type and optional school-related marker.  Will
	 * default to program and non-school related
	 * @param string $eventType (Program, Exhibition, Course)
	 * @param boolean looking for school-related items?
	 * @return array of Category
	 */
	function getCurrentCategories($eventType, $school=false)
	{
		if (!$eventType) { $eventType = Event::PROGRAM; }
		$activityType = 'Performance';
		$school_clause = $school ? ' and c.school=1 ' : ' and (c.school=0 or c.school=NULL) ';
		$now = time();
		
		$db = $this->getDbo();
        $query = "select distinct c.eoid as id, c.name as title
			from Category c, _ez_relation_ r
			where r.class_b='Category' and r.oid_b=c.eoid and c.scope = 'Genre' ". $school_clause ."
			and r.class_a='". $eventType ."' and
			  (r.oid_a in
			          (select distinct r.oid_b
			           from _ez_relation_ as r
			           where r.class_b='". $eventType ."' and r.class_a='". $activityType ."' and r.oid_a in
			             (select distinct r.oid_a from _ez_relation_ as r where class_b = 'Schedule' and oid_b in
			                (select distinct s.eoid from Schedule s, _ez_relation_ r
			                        where (s.startTime >". $now ." or s.endTime >". $now ." or s.startTime = -1 or s.endTime = -1)
			                        and (r.class_a = '". $activityType ."' and r.class_b='Schedule' and r.oid_b=s.eoid)
			                )
			             )
			          )
			  or r.oid_a not in
			          (select distinct r.oid_b
			           from _ez_relation_ as r
			           where r.class_b='". $eventType ."' and r.class_a='". $activityType ."')
			  )
			and r.oid_a in
			  (select r.oid_a
			   from _ez_relation_ r, EnumeratedValue ev
			   where r.class_b = 'PublicationState' and r.oid_b = ev.eoid and ev.value='Published' and r.class_a = '". $eventType ."'
			  )
			order by c.name";

		$db->setQuery($query);	
		$result = $db->loadResultArray();	
	}
	
	/** 
	 * Returns a list of performances for the given Program
	 * @param int id
	 * @return array Performances
	 */
	function getPerformances($eventId)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getPerformances($eventId)");
		$result = array();
		
		// this could be refactored as a subselect
		$db	= $this->getDbo();
		$query = 'SELECT distinct a.eoid as oid, a.scope, a.ticketCode' .
				' FROM Activity as a, _ez_relation_ as r, Program as e' .
				' WHERE r.oid_b = a.eoid and r.class_a="Program" and r.class_b="Performance"' .
				'    AND r.oid_a='. $eventId;	
		$db->setQuery($query);	
		$perfs = $db->loadAssocList();
		
		// now get the schedules
		foreach($perfs as $perf) {
			$performance = new Performance($perf);
			
			$query = 'SELECT DISTINCT s.eoid as oid, s.startTime, s.endTime ' .
					' FROM Schedule as s ' .
					' WHERE s.eoid IN ' .
					'    (select r.oid_b ' .
					'     from _ez_relation_ as r' .
					'     where r.class_a="Performance" and r.class_b="Schedule"' .
					'         AND r.oid_a='. $performance->getOid() .')';					
			$db->setQuery($query);
			$schedule = new Schedule($db->loadAssoc());
			$performance->setSchedule($schedule);
			$result[] = $performance;
		}
		return $result;
	}
	
	/**
	 * Returns a list of published categories grouped by
	 * type (Genre, Audience, Series) for the given list of
	 * scoped types.
	 * @types array ('Genre','Audience','Category') optional defaults to Genre, Audience
	 * @return array result['Genre'], Auience
	 */
	function getPublishedCategories($types=null)
	{
		$types = (is_array($types)) ? $types : array('Genre','Audience');
		
		$categories = array();
		if (count($types) > 0) {
			$db	= $this->getDbo();
			foreach	($types as $scope) {
				$query = 'SELECT DISTINCT c.eoid as oid, c.name as name, c.scope as scope, c.school, c.family
					FROM Category as c
					WHERE c.scope = "'. $scope .'"
					AND c.eoid IN (
					
						SELECT DISTINCT r.oid_a
						FROM ( Category as c
						INNER JOIN _ez_relation_ as r ON c.eoid = r.oid_a )
						INNER JOIN EnumeratedValue as ev ON ev.eoid = r.oid_b
						WHERE ev.value="Published"
						AND r.class_a = "Category" 
						AND r.class_b="PublicationState"
						AND c.eoid IN (
						
							SELECT DISTINCT r.oid_b
							FROM ( Program as p
							INNER JOIN _ez_relation_ as r ON p.eoid = r.oid_a )
							WHERE r.class_b="Category"
							AND r.class_a = "Program" 
							AND p.eoid IN (
					
							
								SELECT DISTINCT r.oid_a
								FROM ( Program as p
								INNER JOIN _ez_relation_ as r ON p.eoid = r.oid_a )
								INNER JOIN EnumeratedValue as ev ON ev.eoid = r.oid_b
								WHERE ev.value="Published"
								AND r.class_a = "Program" 
								AND r.class_b="PublicationState"
							)
						)
					)
					ORDER BY c.name ASC';				
				$db->setQuery($query);
				
				$categories[$scope] = array();
				$result = $db->loadAssocList();
				for ($i=0; $i<count($result); $i++) {
					$categories[$scope][$i] = new Category($result[$i]);
				}
			}
		}
		return $categories;
	}
	
}
