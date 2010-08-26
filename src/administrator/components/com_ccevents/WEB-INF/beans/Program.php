<?php
/**
 *  $Id: Program.php 194 2006-07-20 08:04:04Z tevans $
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
 * Extends Event to add program type and audio resources.
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
 * @orm Program
 */
class Program extends Event
{      
    /**
     * The program type
     * 
     * @var ProgramType
     * @orm has one ProgramType
     */
    public $programType;    
    
    /**
	 * Which genre Category should be used by default?
	 * 
	 * @var Category
	 * @orm has one Category
	 */
	public $primaryGenre;
	
    /**
     * Related exhibitions
     * 
     * @var Exhibitions
     * @orm has many Exhibition inverse(programs)
     */
    public $exhibitions;        

    /**
     * Related courses
     * 
     * @var Course
     * @orm has many Course inverse(programs)
     */
    public $courses;         
}

?>
