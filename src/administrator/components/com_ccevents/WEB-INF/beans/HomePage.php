<?php
/**
 *  $Id: HomePage.php 153 2006-07-05 19:06:39Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */

require_once('tachometry/util/BaseBean.php');

/**
 * Defines the Events home page
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 153 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class HomePage extends BaseBean
{  
    /**
     * The name of the home page
     * 
     * @var string
     * @orm char(255)
     */
    public $name;  

    /**
     * The CMS publication state
     * 
     * @var PublicationState
     * @orm has one PublicationState
     */
    public $pubState;   

    /**
     * The unix timestamp for the publish time
     * 
     * @var datetime
     * @orm datetime
     */
    public $startTime;    
    
    /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event1; 

    /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event2; 

   /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event3; 

    /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event4; 

   /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event5; 

    /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event6; 

    /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event7; 

    /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event8; 

    /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event9; 
    
    /**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event10; 
    
	/**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event11; 
    
	/**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event12; 
    
	/**
     * An event to be displayed on the home page in the form Class.ID 
     * 
     * @var String
     * @orm char(255)
     */
    public $event13; 
}
?>
