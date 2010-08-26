<?php
/**
 *  $Id: Category.php 194 2006-07-20 08:04:04Z tevans $
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
 * Defines a container for a group of events
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm Category
 */
class Category extends ScopedObject
{  
    const AUDIENCE = 'Audience';
	const GENRE = 'Genre';
	const SERIES = 'Series';
    
    /**
     * The title for the category
     * 
     * @var string
     * @orm char(255)
     */
    public $name;  

    /**
     * The category subtitle
     * 
     * @var string
     * @orm char(255)
     */
    public $subtitle;    

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
     * A description of the category
     * 
     * @var string
     * @orm clob(512)
     */
    public $description;  

    /**
     * A block of introductory texy
     * 
     * @var string
     * @orm clob(512)
     */
    public $introduction;  

    /**
     * The image resource for this collection
     * 
     * @var string
     * @orm char(255)
     */
    public $image;   

    /**
     * The CMS publication state
     * 
     * @var PublicationState
     * @orm has one PublicationState
     */
    public $pubState;   
    
    /**
     * A list of events for this instance
     * 
     * @var Event
     * @orm has many Event
     */
    public $events;   

	/**
	 * Is this a family-friendly category
	 * 
	 * @var boolean
	 * @orm bool
	 */
	public $family;
	
	/**
	 * Is this a school-related category
	 * 
	 * @var boolean
	 * @orm bool
	 */
	public $school;
	
	/**
	 * Convenience method to get the name as the title
	 * @return string name
	 */
	function getTitle() {
		return $this->getName();	
	}

    /**
     * A convenience method to return a sensible defaut for
     * the alias if none has been explicitly set.  The default
     * will be the name value converted to lowercase with
     * special characters separated by dashes ("-").
     */
    public function get_alias() {
        $result = $this->alias;

        if($result == "") {
            $search = array("'"," ","/");
            $replace = array("","-","-");
            $result = strtolower( str_replace( $search, $replace, $this->name ) );
        }
        return $result;
    }
}
?>
