<?php
/**
 *  $Id: Schedule.php 194 2006-07-20 08:04:04Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */
require_once dirname(__FILE__) . '/Resource.php';

/**
 * Defines the schedule defined for a particular event or activity
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class Schedule extends Resource
{  
    /**
     * The unix timestamp for the event start time
     * 
     * @var datetime
     * @orm datetime
     */
    public $startTime;    
    
    /**
     * The unix timestamp for the event end time
     * 
     * @var datetime
     * @orm datetime
     */
    public $endTime; 
    
    /**
     * The scope of the schedule entry
     * (e.g. Exhibition, Program, Performance, etc.)
     * 
     * @var string
     * @orm char(255)
     */
     public $scope;
     
}
?>
