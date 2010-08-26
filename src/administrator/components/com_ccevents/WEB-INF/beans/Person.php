<?php
/**
 *  $Id: Person.php 194 2006-07-20 08:04:04Z tevans $
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
 * Defines the events for a person
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm Person
 */
class Person extends ScopedObject
{  
    const ARTIST = "Artist";
    const INSTRUCTOR = "Instructor";
    const PERFORMER = "Performer";
    
    
    /**
     * A font-end display name for the person
     * 
     * @var string
     * @orm char(128)
     */
    public $firstName;
    
    /**
     * A font-end display name for the person
     * 
     * @var string
     * @orm char(128)
     */
    public $lastName;
    
    /**
     * A font-end display name for the person
     * 
     * @var string
     * @orm char(255)
     */
    public $displayName;  
    
   /**
     * A title alias to be used for extended functionality (SEF, etc)
     * NOTE: The convenience method below will return a sensible default
     * if no alias is explicitly defined for the object.
     *
     * @var string
     * @orm char(255)
     */
    public $alias;

    /**
     * The title as in job role for the person
     * 
     * @var string
     * @orm char(255)
     */
    public $title; 

    /**
     * A biographical summary for the person
     * 
     * @var string
     * @orm clob(5120)
     */
    public $summary;
    
    /**
     * Indicates whether this is a role (true) or an individual
     * 
     * @var bool
     * @orm bool
     */  
     public $role;

    /**
     * A link to the address/phone component
     * 
     * @var Address
     * @orm has one Address
     */ 
    public $address;  

	/**
     * A link to the resource gallery (photos, etc.)
     * 
     * @var int
     * @orm int
     */ 
    public $gallery; 

	/**
     * The CMS publication state
     * 
     * @var PublicationState
     * @orm has one PublicationState
     */
    public $pubState;  
    
	/**
	 * Returns true if this instance describes a role
	 * @return Boolean
	 */
	function isRole() {
		return $this->role;
	}

	/**
	 * Returns true if this instance describes an individual
	 * @return Boolean
	 */
	function isIndividual() {
		return !($this->role);
	}
	
	/**
	 * Returns the displayName if set, or firstName lastName
	 * if not set.
	 * @return string
	 */
	function getFriendlyName() {
		$name = ($this->displayName) ? $this->displayName : $this->firstName() ." ". $this->lastName();
		return $name;
	}	

    /**
     * A convenience method to return a sensible defaut for
     * the alias if none has been explicitly set.  The default
     * will be the title value converted to lowercase with
     * special characters separated by dashes ("-").
     */
    public function get_alias() {
        $result = $this->alias;

        if($result == "") {
            $search = array("'"," ","/");
            $replace = array("","-","-");
            $result = strtolower( str_replace( $search, $replace, $this->getFriendlyName() ) );
        }
        return $result;
    }

}
?>
