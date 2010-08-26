<?php
/**
 *  $Id: Activity.php 194 2006-07-20 08:04:04Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 * 
 */
require_once dirname(__FILE__) . '/ScopedObject.php';
/**
 * Defines an activity that is linked to an event
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm Activity
 */
class Activity extends ScopedObject
{  
    /**
     * A link to the event for this instance
     * 
     * @var Event
     * @orm has one Event inverse(children)
     */
    public $parent;   

    /**
     * The schedule resource link for the activity
     * 
     * @var Schedule
     * @orm composed_of one Schedule
     */
    public $schedule;       
    
    /**
     * The venue for the activity
     * 
     * @var Venue
     * @orm has one Venue
     */
    public $venue;       

    /**
     * The status for this activity (cancelled, sold out, active)
     * 
     * @var EventStatus
     * @orm has one EventStatus
     */
    public $activityStatus;   
    
	/**
	 * The code link to the ticket management system
     * 
     * @var string
     * @orm char(255)
	 */
	public $ticketCode;
}
?>
