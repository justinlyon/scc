<?php
/**
 *  $Id: Event.php 194 2006-07-20 08:04:04Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */

require_once dirname(__FILE__) . '/ScopedObject.php';

/**
 * Base class for all events. An event is a scheduled set of
 * closely related activities that are linked/grouped in several 
 * ways to support multi-dimensional browsing for website users
 * (by date, interest area, location, presentation type, etc.).
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
 * @orm Event
 */
class Event extends ScopedObject
{  
    const EXHIBITION = "Exhibition";
    const PROGRAM = "Program";
    const COURSE = "Course";
    
    /**
     * The event title
     * 
     * @var string
     * @orm char(255)
     */
    public $title;    
    

    /**
     * The event subtitle
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
     * The event summary (short description)
     * 
     * @var string
     * @orm clob(512)
     */
    public $summary;

    /**
     * The event description
     * 
     * @var string
     * @orm clob(5120)
     */
    public $description;

    /**
     * The optional sponsor credit
     * 
     * @var string
     * @orm clob(5120)
     */
    public $credit;
    
    /**
     * An optional note on the schedule information
     * 
     * @var string
     * @orm clob(512)
     */
    public $scheduleNote;    
    
    /**
     * The ticket pricing information
     * 
     * @var string
     * @orm char(255)
     */
    public $pricing;    

    /**
     * The contact information
     * 
     * @var string
     * @orm char(255)
     */
    public $contact;
    
    /**
     * The ticket description
     * 
     * @var string
     * @orm clob(512)
     */
    public $ticketDesc;

    /**
     * The URL link to the ticket management system
     * 
     * @var string
     * @orm char(255)
     */
    public $ticketUrl;   
    
	/**
     * An optional title for additional information
     * 
     * @var string
     * @orm char(255)
     */
    public $addtitle;    

	/**
     * An optional WYSISYG field for additional information
     * 
     * @var string
     * @orm clob(5120)
     */
    public $addinfo;

	/**
     * An second optional title for additional information
     * 
     * @var string
     * @orm char(255)
     */
    public $addtitle2;    

	/**
     * An second optional WYSISYG field for additional information
     * 
     * @var string
     * @orm clob(5120)
     */
    public $addinfo2;
    
    /**
     * The default event venue
     * 
     * @var Venue
     * @orm has one Venue
     */
    public $defaultVenue;        
    
    /**
     * The event venues
     * 
     * @var Venue
     * @orm has many Venue inverse(events)
     */
    public $venues;        
    
    /**
     * The status/availability for this event
     * 
     * @var EventStatus
     * @orm has one EventStatus
     */
    public $status;   

    /**
     * The CMS publication state
     * 
     * @var PublicationState
     * @orm has one PublicationState
     */
    public $pubState;   

    /**
     * The event availability status
     * 
     * @var EventStatus
     * @orm has one EventStatus
     */
    public $eventStatus;   
    
    /**
     * The categories this event is a member of
     * 
     * @var Category
     * @orm has many Category
     */
    public $categories;       
    
    /**
     * A link to the resource gallery (photos, etc.)
     * 
     * @var int
     * @orm int
     */ 
    public $gallery;
    
    /**
     * The schedule resource link for this event
     * 
     * @var Schedule
     * @orm composed_of one Schedule
     */
    public $schedule;
    
    /**
     * The list of activities for this event
     * 
     * @var Activity
     * @orm composed_of many Activity inverse(parent)
     */
    public $children;          

   
    /**
     * User-defined sorting index (for list display)
     * 
     * @var int
     * @orm int(5)
     */
    public $displayOrder;    

	/**
	 * A resource link to the recorded performance
	 * 
	 * @var Resource
	 * @orm has one Resource
	 */
	 public $podcast;

	/**
	 * A url to a an audio file
	 * 
	 * @var string
     * @orm char(255)
	 */
	 public $audioClip;

	/**
	 * A url to a video file
	 * 
	 * @var string
     * @orm char(255)
	 */
	 public $videoClip;


	/**
	* A url to an external rendering of this event
        * @var string
        * @orm char(255)
        */
        public $externalLink;


	/**
	 * An id link to a content item representing the press release
	 * 
     * @var int
     * @orm int(11)
	 */
	 public $pressRelease;

	/**
	 * An id link to a content item representing the comment functionality
	 * 
     * @var int
     * @orm int(11)
	 */
	 public $commentArticle;
	 
	/**
	 * An id link to a content category representing related content items
	 * 
     * @var int
     * @orm int(11)
	 */
	 public $relatedArticles;
	 
    /**
     * featured
     * 
     * @var boolean
	 * @orm bool
     */
    public $featured;
    
	/**
	 * A convenience method to determine the age category 
	 * to sort by
	 * 
	 * @return Category
	 */
	public function get_sort_age() {
		$cats = $this->getCategories();
		$result = null;
		if ( isset($cats['Audience']) && count($cats['Audience']) > 0 ) {
			$result = $cats['Audience'][0];
		}
		return $result;
	}

	/**
	 * A convenience method to determine the series category 
	 * to sort by
	 * 
	 * @return Category
	 */
	public function get_sort_series() {
		$cats = $this->getCategories();
		$result = null;
		if ( isset($cats['Series']) && count($cats['Series']) > 0 ) {
			$result = $cats['Series'][0];
		}
		return $result;
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
            $result = strtolower( str_replace( $search, $replace, $this->title ) );
        }
        return $result;
    }


}

?>
