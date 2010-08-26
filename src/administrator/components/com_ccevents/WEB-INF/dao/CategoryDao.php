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
require_once WEB_INF . '/beans/Category.php';
require_once WEB_INF . '/dao/MasterDao.php';


/**
 * A class to serve as data access facilitator 
 */
class CategoryDao extends MasterDao
{

	const VENUE_TABLE = "Category";
	const RELATION_TABLE = "_ez_relation_";
	
	function getCategorySummaries($scope=null, $pubStates=null) 
	{
		global $logger;
		$logger->debug(get_class($this) . "::getCategorySummaries($scope, $pubStates)");
		
		$pubStates = ( $pubStates == null ) ? array('Published') : $pubStates;
		$db =& JFactory::getDBO();
		
		// get the categories for this scope and pubstate
		$query = 'SELECT DISTINCT c.eoid as oid, c.name as name, c.family, c.school, ev.value as pubState'.
				' FROM _ez_relation_ as r, Category as c, EnumeratedValue as ev'.
				' WHERE (c.scope = "'. $scope .'" AND r.class_a = "Category"'.
				' AND r.class_b = "PublicationState") AND oid_b = ev.eoid AND (';
		$sep = "";
		foreach ($pubStates as $pubState) {
			$query .= $sep . 'ev.value = "'. $pubState .'"';	
			$sep = ' OR ';
		}
		$query .= ")";
        
		$db->setQuery($query);
		$categories = $db->loadAssocList();	
		$result = array();
		foreach ($categories as $row) {
			$category = new Category($row);

			// Get the event counts
			// $types = array ("Exhibition", "Program", "Course");
			$types = array ("Program");
			$categoryEvents = array ();
			foreach ($types as $type) {
				$query = 'SELECT DISTINCT e.eoid '.
					 ' FROM '. $type .' as e, _ez_relation_ as r '.
					 ' WHERE r.class_a = "'. $type .'" AND r.class_b = "Category" '.
					 ' AND r.oid_b = '. $category->getOid();
				$db->setQuery($query);
				$events = $db->loadAssocList();
				foreach ($events as $event) {
					$categoryEvents[] = new $type($event);
				}
			}
			$category->setEvents($categoryEvents);

			$result[] = $category;
		}
		return $result;
	}
}
