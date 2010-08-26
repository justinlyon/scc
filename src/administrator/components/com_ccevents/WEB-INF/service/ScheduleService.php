<?php
/**
 *  $Id$: ScheduleService.php, Sep 21, 2006 7:52:43 AM nchanda
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
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Schedule.php';
require_once WEB_INF . '/beans/Event.php';
require_once WEB_INF . '/dao/ScheduleDao.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A service class to serve both as data access facilitator and
 * API contract.  Note the convention that all public getters shall
 * return a bean or array of beans.   The private "fetch" methods
 * will return a PDO object or array of PDO objects.  Clients of 
 * the service should only call methods that will return bean objects
 * unless there is valid reason to use the PDO directly.
 */
class ScheduleService
{
	public $dao;
		
	/**
	 * Returns the schedule objects for a given date range
	 * based on the schedule's start time.
	 * @param int(timestamp) first second in the range
	 * @param int(timestamp) last second in the range
	 * @return array A list of schedule beans
	 */
	public function getSchedulesForRange($start,$end)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getSchedulesForRange($start,$end)");
		
		$result = array();
		$epm = epManager::instance();
		
		$result = $epm->find("from Schedule where (startTime between ? and ?) or (endTime between ? and ?) order by startTime",$start,$end,$start,$end);
		$logger->debug("Number of schedules found in range: ". count($result));
		$schedules = array();
		if (count($result > 0)) {
			foreach($result as $sched) {
				$schedules[] = new Schedule($sched->epGetVars(),true);	
			}	
		}
		return $schedules;
	} 
	
	/**
	 * Returns an array of dates for which there is a scheduled event
	 * @return array A list of dates in 'Ymd' format
	 */
	public function getUniqueScheduledDates()
	{
		global $logger;
		$logger->debug(get_class($this) . "::getUniqueScheduledDates()");

		$dao = $this->getDao();
		return $dao->getProgramEntries();
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
		global $logger;
		$logger->debug(get_class($this) . "::getCurrentCategories($eventType, $school)");
		
		$dao = $this->getScheduleDao();
		return $dao->getCurrentCategories($eventType, $school);
	}


	/**
	 * Returns the list of scoped activities 
	 * for the given event type and id. 
	 * NOTE: Currently only program / performance is implemented
	 * @param String event type (default='Program')
	 * @param int event id
	 * @return array of scoped Activity (e.g. Performance)
	 */
	function getActivities($eventType=Event::Program, $id)
	{
		switch ($eventType) {
			case 'Program' :
			default : $getter = 'getPerformances';
		}
		
		$dao = $this->getDao();
		$activities = $dao->$getter($id);
		return $activities;
	}



	/**
	 * A convenience method to get an array of months
	 * in the form array('1'=>'January','2'=>'February') 
	 * 
	 * @return array A list of indexed months
	 */
	public function getMonthArray() 
	{
		$month = array('1'=>'January','2'=>'February','3'=>'March','4'=>'April',
					'5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September',
					'10'=>'October','11'=>'November','12'=>'December');
		return $month;	
	}
	
	/**
	 * Returns an array of 4-digit year values representing
	 * the current range of scheduled events.  Accepts two
	 * integer parameters representing the number of years
	 * before and after the currently scheduled events respectively.
	 * If no events are scheduled, then the current year will be used 
	 * as a default.
	 * 
	 * @param int $before The number of years before the first scheduled event
	 * @param int $after The number of years after the last scheduled event
	 * @return array 4-digit year values
	 */
	public function getYearArray($before=null, $after=null) 
	{
		$first = date("Y",$this->getFirstScheduled());
		$last = date("Y",$this->getLastScheduled());
		
		$init = intval($first) - $before;
		$cap = intval($last) + $after;
		
		$year = array();
		for ($i=$init; $i<=$cap; $i++) {
			$year[] = $i;	
		}
		
		return $year;		
	}
	
	/**
	 * Returns an array of numeric values representing
	 * the days of the month. If no input is given it 
	 * will return an array of 31. The mixed input will
	 * try to determine the appropriate month value.
	 * 
	 * @param mixed (string = month name), 
	 * 				(1 or 2 digit number = month number 1-12),
	 * 				(16-digit number = timestamp)
	 * @return array days of the given month
	 */
	public function getDayArray($month=null)
	{
		// TODO implement logic to support this
		
		$day = array();
		for ($i=0; $i<31; $i++) {
			$day[] = $i+1;
		}
		return $day;
	}

	/**
	 * Returns an array of numeric values representing
	 * the hours of the day. If the military flag is true,
	 * the range will be from 1-24. If the ascending flag 
	 * is true, the method will return a list from 1-n.
	 * The default value returned will be a list from 12-1
	 * 
	 * @param boolean military
	 * @param boolean ascending (true = ascending)
	 * @return array hours in a day
	 */
	public function getHourArray($military=false, $ascending=false)
	{
		$range = ($military) ? 24 : 12;
		$hour = array();
		
		if ($ascending) {
			for ($i=0; $i<$range; $i++) {
				$hour[] = $i+1;
			}	
		} else {
			for ($i=$range; $i>0; $i--) {
				$hour[] = $i;
			}
		}
		
		return $hour;
	}	
	

	/**
	 * Returns an array of numeric values representing
	 * the minutes of the hour in increments represented by
	 * the given interval. If no interval is selected, it will 
	 * default to 15 minute blocks.
	 * 
	 * @param interval (e.g 5= 5 minutes, 10 = 10 minutes)
	 * @return array minute blocks in the hour
	 */
	public function getMinuteArray($interval=null)
	{
		if (!($interval >= 0 && $interval < 30)) {
			$interval = 15;
		}
		
		$minute = array();
		for ($i=0; $i<60; $i++) {
			if ( $i % $interval == 0) {
				 
				$minute[] = ($i < 10) ? '0'.$i : $i;
			}	
		}
		return $minute;
	}

	/**
	 * Returns an array of am/pm values
	 * 
	 * @return array ampm
	 */
	public function getAmpmArray()
	{
		return array('AM','PM');
	}


	/**
	 * Returns an alphabetical associative array of all 
	 * genres with at least one published event.
	 * (e.g. array(array(oid=20,name=Family)))
	 * 
	 * @return array The array of ordered genres 
	 */
	public function getPublishedGenreArray()
	{
		global $logger;
		
		$epm = epManager::instance();
		// TODO: enhance select to only genres that have active programs/exhibitions
		$result = $epm->find('from Category where scope = ? order by name','Genre');
		
		//convert to array
		$genres = array();
		for($i=0; $i<count($result); $i++) {
			$g = $result[$i];
			$genres[$i]['oid'] = $g->getOid();
			$genres[$i]['name'] = $g->getName(); 		
		}
		return $genres;
	}
	
	/**
	 * Returns the list of published categories for the 
	 * given array of types (e.g. array('Genre','Audience','Series'))
	 * @param array() scoped categories (optional)
	 * @return array keyed list (e.g. array['Genre'][list of Category beans])
	 */
	function getPublishedCategories($scopes)
	{
		$dao = $this->getDao();
		$scopes = (is_array($scopes)) ? $scopes : null;
		return $dao->getPublishedCategories($scopes);
	}
	
	
	/**
	 * Returns the timestamp for the first scheduled start time
	 * 
	 * @access private
	 * @return int Timestamp of first scheduled startTime (min)
	 */
	private function getFirstScheduled()
	{
		global $logger;
		$logger->debug(get_class($this) . "::getFirstScheduled()");
		
		$epm = epManager::instance();
		$first = $epm->find("min(startTime) from Schedule where startTime > 0");
		$logger->debug("First scheduled timestamp: ". $first);
		return $first;
	}

	/**
	 * Returns the timestamp for the last scheduled start time
	 * 
	 * @access private
	 * @return int Timestamp of last scheduled startTime (max)
	 */
	private function getLastScheduled()
	{
		//TODO Get this from the database
		return time();	
	}
	
	private function getDao() 
	{
		if ($this->dao == null) {
			$this->dao = new ScheduleDao();
		}
		return $this->dao;
	}

}
 
?>

