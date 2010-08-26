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
require_once WEB_INF . '/beans/CalendarEntry.php';

require_once ('tachometry/util/ListBean.php');
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A class to serve as data access facilitator 
 */
class CalendarDao
{
	function __construct() {
		global $logger;
		$logger->debug("CalendarDao::construct()");
	}
	
	/**
	 * Returns a list of Program scoped CalendarEntry for 
	 * the given date range and and optional program-type filter.
	 * @param int start unix timestamp for start range
	 * @param int end unix timestamp for end range 
	 * @param int filter id - the category to filter by
	 */	
	function getProgramEntries($start=null, $end=null, $filter=null) {
		if ($start == null) {
			$db = $this->getDbo();
			$query = "SELECT DISTINCT (DATE_FORMAT(FROM_UNIXTIME(startTime),"%Y-%m-%d"), DATE_FORMAT(FROM_UNIXTIME(startTime),"%Y-%m-%d")) as date, from Schedule ORDER BY date;
			$db->setQuery($query);
		} else {
			$db	= $this->getDbo();
			$query = "SELECT p., s. * from Schedule where startTime >= 1207105200 and startTime < 1207105300";
			$db->setQuery($query);	
		}
	}
	
}
