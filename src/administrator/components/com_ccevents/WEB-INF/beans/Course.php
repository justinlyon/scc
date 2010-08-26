<?php
/**
 *  $Id: Course.php 194 2006-07-20 08:04:04Z tevans $
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
 * Extends Event to describe a classroom-based group activity.
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
 * @orm Course
 */
class Course extends Event
{  
    /**
     * Partner name 
     * organizations.
     * 
     * @var string
     * @orm char(255)
     */
    public $partnerName; 
    
    /**
     * Partner course number for course offered by third party
     * organizations.
     * 
     * @var string
     * @orm char(255)
     */
    public $partnerCode;    

    /**
     * A resource link to course registration information
     * 
     * @var Resource
     * @orm has one Resource
     */
    public $registration;    

	/**
     * A product bean as a convenience *(not and orm object)
     * @var Product
     */
	public $product;
    
	/**
	 * Which genre Category should be used by default?
	 * 
	 * @var Category
	 * @orm has one Category
	 */
	public $primaryGenre;
	
	/**
     * A name for the instructor of the class
     * 
     * @var string
     * @orm char(128)
     */
    public $instructor;  

    /**
     * A biographical summary for the instructor
     * 
     * @var string
     * @orm clob(5120)
     */
    public $instructorBio;
    

    /**
     * Related programs
     * 
     * @var Program
     * @orm has many Program inverse(courses)
     */
    public $programs;        

    /**
     * Related exhibitions
     * 
     * @var Exhibition
     * @orm has many Exhibition inverse(courses)
     */
    public $exhibitions;        
}

?>

