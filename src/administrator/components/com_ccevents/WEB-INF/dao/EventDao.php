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
require_once WEB_INF . '/beans/Promotion.php';
require_once WEB_INF . '/beans/Program.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/Course.php';
require_once WEB_INF . '/beans/Genre.php';
require_once WEB_INF . '/dao/MasterDao.php';


/**
 * A class to serve as data access facilitator 
 */
class EventDao extends MasterDao
{

	const EXHIBITION_TABLE = "Exhibition";
	const PROGRAM_TABLE = "Program";
	const COURSE_TABLE = "Course";
	const RELATION_TABLE = "_ez_relation_";
	const SCHEDULE_TABLE = "Schedule";
	
	/**
	 * Returns a promotion bean for the
	 * given scope and id with the following populated values
	 * title, next start time as date, id, primary genre as genre, 
	 * summary, gallery id as image and schedule note 
	 * 
	 * @param String scope
	 * @param int oid of the event
	 * @return Promotion bean
	 */
	function getPromotion($scope, $id) 
	{
		global $logger;
		$logger->debug(get_class($this) . "::getPromotion($scope, $id)");
		
		$db	=& JFactory::getDBO();
		
		// Program or Exhibition differences
		if ($scope == 'Program') {
			$query = 'SELECT distinct e.eoid as id, "Program" as scope, e.title,' .
				'	e.gallery as image, e.summary, e.scheduleNote,' .
				'	s.startTime as start, s.endTime as end ' .
				'	FROM Program as e, Schedule as s, _ez_relation_ as r' .
				'	WHERE s.eoid = r.oid_b ' .
				'		AND r.class_b = "Schedule"' .
				'		AND r.oid_a IN ( ' .
				'			SELECT distinct r1.oid_b ' .
				'			FROM _ez_relation_ as r1 ' .
				'			WHERE oid_a = '. $id .
				'				AND class_a="Program"' .
				'				AND class_b="Performance"' .
				'		) AND e.eoid ='. $id .
				'	ORDER BY s.startTime';
		} else {
			$query = 'SELECT distinct	e.eoid as id, "Exhibition" as scope, e.title, ' .
					'	e.gallery as image, e.summary, e.scheduleNote, ' .
					'	s.startTime as start, s.endTime as end ' .
					' FROM Exhibition as e, Schedule as s, _ez_relation_ as r' .
					' WHERE s.eoid = r.oid_b ' .
					'	AND r.class_b = "Schedule"' .
					'	AND r.class_a = "Exhibition"' .
					'	AND r.oid_a = e.eoid' .
					'	AND e.eoid = '. $id .
					' ORDER BY s.startTime';
		}
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		$promo = new Promotion($rows[0]);

		// get the promotion date
		// in Programs it is the next performance (or the most recent if no next)
		// in Exhibitions it is the start date if future or end date if start date past
		$date = null;
		foreach($rows as $row) {
			if ($scope == "Exhibition") {
				$date = $row['end'];
				if ( $row['start'] > time()) {
					$date = $row['start'];
				} 	
			} else {
				$date = $row['start'];
				if ($date > time()) {
					break;
				}					
			}
		}
		$promo->setDate($date);
			
		// now get the primary genre information
		$query = 'SELECT DISTINCT c.eoid as oid, c.name 
			FROM Category as c, _ez_relation_ as r
			WHERE c.eoid = r.oid_b
			AND r.var_a = "primaryGenre"
			AND r.oid_a = '. $promo->getId();
		$db->setQuery($query);
		$pg = new Genre($db->loadAssoc());
		$promo->setPrimaryGenre($pg);
		return $promo;			
	}
	
	/**
	 * Returns a list of scoped event beans for the
	 * given scope and publication flag
	 * 
	 * @param String scope
	 * @param boolean published only
	 * @return array ScopedEvent
	 */
	function getFeatured($eventType=null, $published=true) 
	{
		global $logger;
		$logger->debug(get_class($this) . "::getFeatured($eventType, $published)");
		
		$eventType = ($eventType) ? $eventType : 'Program';
		
		$db	= $this->getDbo();
		
		// get the featured programs
		$query = 'SELECT DISTINCT e.eoid as oid, e.title, e.gallery';
		if($eventType == 'Program') {
			$query .= ', e.scheduleNote';
		}
		$query .= ' FROM '. $eventType .' as e WHERE e.featured = 1';
		if ($published) {
			$query .= ' AND e.eoid IN ('.
				'SELECT DISTINCT r.oid_a' .
				' FROM _ez_relation_ as r, '. $eventType .' as e, EnumeratedValue as ev'.
				' WHERE (r.class_a = "'. $eventType .'" AND r.class_b = "PublicationState")'.
				'   AND (r.oid_b = ev.eoid AND ev.value="Published") )';	
		}
        
        	// OLD ONE HERE:
/*
		$query = 'SELECT DISTINCT e.eoid as oid, e.title, e.gallery';
		if($eventType == 'Program') {
			$query .= ', e.scheduleNote';
		}
		$query .= ' FROM '. $eventType .' as e, _ez_relation_ as r
					WHERE e.featured = 1';
		if ($published) {
			$query .= ' AND r.oid_a IN ('.
				'SELECT DISTINCT r.oid_a' .
				' FROM _ez_relation_ as r, '. $eventType .' as e, EnumeratedValue as ev'.
				' WHERE (r.class_a = "'. $eventType .'" AND r.class_b = "PublicationState")'.
				'   AND (r.oid_b = ev.eoid AND ev.value="Published") )';	
		}
*/
		$db->setQuery($query);
		$events = $db->loadAssocList();	
		$result = array();
		foreach($events as $row) {
			$event = new $eventType($row);	
			
			// now get the primary genre information
			$query = 'SELECT DISTINCT c.eoid as oid, c.name 
				FROM Category as c, _ez_relation_ as r
				WHERE c.eoid = r.oid_b
				AND r.var_a = "primaryGenre"
				AND r.oid_a = '. $event->getOid();
			$db->setQuery($query);
			$pg = new Genre($db->loadAssoc());
			$event->setPrimaryGenre($pg);
			$result[] = $event;
		}
		return $result;
	}
}
