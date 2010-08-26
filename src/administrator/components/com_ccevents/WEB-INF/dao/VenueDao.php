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
require_once WEB_INF . '/beans/Venue.php';
require_once WEB_INF . '/dao/MasterDao.php';


/**
 * A class to serve as data access facilitator 
 */
class VenueDao extends MasterDao
{

	const VENUE_TABLE = "Venue";
	const RELATION_TABLE = "_ez_relation_";
	
	function getVenueSummaries($pubStates=null) 
	{
		global $logger;
		$logger->debug(get_class($this) . "::getVenues($pubStates)");
		
		$pubStates = ( $pubStates == null ) ? array('Published') : $pubStates;
		$db =& JFactory::getDBO();
		
		// get the featured programs
		$query = 'SELECT DISTINCT v.eoid as oid, v.name as name, ev.value as pubState'.
				' FROM _ez_relation_ as r, Venue as v, EnumeratedValue as ev'.
				' WHERE (r.class_a = "Venue" AND r.class_b = "PublicationState")'.
				'   AND oid_b = ev.eoid AND (';
		$sep = "";
		foreach ($pubStates as $pubState) {
			$query .= $sep . 'ev.value="'. $pubState .'"';	
			$sep = ' OR ';
		}
		$query .= ")";
        
		$db->setQuery($query);
		$venues = $db->loadAssocList();	
		$result = array();
		foreach($venues as $row) {
			$venue = new Venue($row);

			// Get the address
			$query = 'SELECT a.* FROM Address as a, _ez_relation_ as r'.
					' WHERE (r.class_a = "Venue" AND r.class_b = "Address")'.
					' AND a.eoid = r.oid_b AND r.oid_a = '. $venue->getOid();
			$db->setQuery($query);
			$addrs = $db->loadAssocList();
			$addr = $addrs[0];
			$venue->setAddress(new Address($addr));

			// Get the event counts
			$types = array ("Exhibition", "Program", "Course");
			$venueEvents = array ();
			foreach ($types as $type) {
				$query = 'SELECT DISTINCT e.eoid '.
					 ' FROM '. $type .' as e, _ez_relation_ as r '.
					 ' WHERE r.class_a = "'. $type .'" AND r.class_b = "Venue" '.
					 ' AND r.oid_b = '. $venue->getOid();
				$db->setQuery($query);
				$events = $db->loadAssocList();
				foreach ($events as $event) {
					$venueEvents[] = new $type($event);
				}
			}
			$venue->setEvents($venueEvents);

			$result[] = $venue;
		}
		return $result;
	}
}
