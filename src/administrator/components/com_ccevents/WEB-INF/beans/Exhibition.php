<?php
/**
 *  $Id: Exhibition.php 194 2006-07-20 08:04:04Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */
require_once dirname(__FILE__) . '/Event.php';

/**
 * Extends Event to provide user-defined sorting features.
 *
 * This class uses the EZPDO framework to provide persistence
 * and ORM services to an underlying relational database 
 * (e.g. MySQL, Oracle, etc.). Instances of this class are
 * automatically synchronized with the database. Refer to
 * {@link http://www.ezpdo.net/} for more information.
 *
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm Exhibition
 */
class Exhibition extends Event
{  

    /**
     * Related programs
     * 
     * @var Program
     * @orm has many Program inverse(exhibitions)
     */
    public $programs;        

    /**
     * Related courses
     * 
     * @var Course
     * @orm has many Course inverse(exhibitions)
     */
    public $courses;  
    
    /**
     * Related artists
     * 
     * @var Artist
     * @orm has many Artist inverse(exhibitions)
     */
    public $artists; 
    
   /**
    * Related Artist Objects (stored in the artit's gallery)
    * 
    * @var String (comma separated list of g2 image ids)
    * @orm char(255)
    */
   public $artifacts;

   /**
    * A convenience methon that returns the first venue in the venues list.
    *
    * @return Venue
    */
   public function getDefaultVenue()
   {
      if (is_array($this->venues) && count($this->venues) > 0)
         return $this->venues[0];
      return "";
   }
}

?>
