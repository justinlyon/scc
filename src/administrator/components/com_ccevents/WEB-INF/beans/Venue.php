<?php
/**
 *  $Id: Venue.php 153 2006-07-05 19:06:39Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 *    http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */

require_once('tachometry/util/BaseBean.php');

/**
 * Defines the events for a venue
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 153 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class Venue extends BaseBean
{  
    const VENUE = "Venue";
    
    /**
     * The name of the venue
     * 
     * @var string
     * @orm char(255)
     */
    public $name;  


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
     * A description of the venue
     * 
     * @var string
     * @orm clob(512)
     */
    public $description;  

    /**
     * A link to the address/phone component
     * 
     * @var Address
     * @orm has one Address
     */ 
    public $address;  
    
    /**
     * The CMS publication state
     * 
     * @var PublicationState
     * @orm has one PublicationState
     */
    public $pubState;   
    
    /**
     * A link to the resource gallery (photos, etc.)
     * 
     * @var int
     * @orm int
     */ 
    public $gallery;   
    
    /**
     * The venues' events. 
     * Note: From the incoming form this will be an
     * associaive array of oids keyed by type. 
     * (e.g. $events['Exhibition'] = array(oids)).
     * 
     * The result will be a list of typed events.
     * 
     * @var array Event
     * @orm has many Event inverse(venues)
     */
    public $events; 
    
    
   /**
    * A convenience method to get the name by title
    */
   public function getTitle() {
      return ($this->name);   
   }
   
   /**
    * A convenience method to set the name by title
    */
   public function setTitle($newName) {
      $this->name = $newName;   
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
            $result = strtolower( str_replace( $search, $replace, $this->name ) );
        }
        return $result;
    }

}
?>
