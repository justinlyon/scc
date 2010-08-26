<?php
/**
 *  $Id$: EventPage.php, Aug 29, 2006 8:15:28 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

require_once ('tachometry/util/BaseBean.php');

/**
 * Bean container to hold the structured page object
 * for the Event Summary Page.
 *
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.page.bean
 */
class EventSummaryPage extends BaseBean
{  
    /**
     * The list of events
     * @var array
     */
    public $events;  
    
    /**
     * The page announcement
     * @var string
     */
     public $announcment;
     
     /**
      * The type of collection being viewed
      * (e.g. Current or Upcoming)
      */
     public $viewType;
}

/**
 * Bean container to hold the structured page object
 * for the Event Detail Page.
 *
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.page.bean
 */
class EventDetailPage extends BaseBean
{  
    /**
     * The event title
     * 
     * @var string
     */
    public $title;  
} 
 
?>
