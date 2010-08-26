<?php
/**
 *  $Id$: CalendarForm.php, Oct 25, 2006 7:13:16 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
require_once('tachometry/util/BaseBean.php');

/**
 * Defines a container for the calendar form.  Note that
 * this is not a PDO object. It is a simple object to
 * hold structured form elements.
 * 
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm Category
 */
class CalendarForm extends BaseBean
{  
	/**
     * The selected month
     * 
     * @var int
     */
    public $month;
    
	/**
     * The selected year
     * 
     * @var int
     */
    public $year;
    
    /**
     * The optional category oid
     * 
     * @var int
     */
    public $category;

	/**
	 * Returns the first second for the identified
	 * month in the given CalendarForm.
	 * @param bean CalendarForm
	 * @return int (timestamp) first second of given month
	 */
	public function getMonthStart($cal)
	{
		global $logger;	
		$logger->debug(get_class($this) . "::getMonthStart($cal)");
		
                return mktime(0,0,0,$cal->getMonth(),1,$cal->getYear());
	}
    
    
    /**
	 * Returns the last second for the identified
	 * month in the given CalendarForm.
	 * @param bean CalendarForm
	 * @return int (timestamp) last second of given month
	 */
	public function getMonthEnd($cal)
	{
		global $logger;	
		$logger->debug(get_class($this) . "::getMonthEnd($cal)");
		
		$start = CalendarForm::getMonthStart($cal);
		$days = date('t',$start);
		return mktime(23,59,59,$cal->getMonth(),$days,$cal->getYear());
	}
}
?>
