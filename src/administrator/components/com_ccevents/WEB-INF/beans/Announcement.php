<?php
/**
 *  $Id$: Announcement.php, Oct 23, 2006 12:13:05 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
require_once dirname(__FILE__) . '/ScopedObject.php';
/**
 * Defines an announcement for a given section of the
 * cultural center events component.
 * 
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision:$
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm Announcement
 */
class Announcement extends ScopedObject
{ 	
	/**
     * The announcement content
     * 
     * @var string
     * @orm clob(512)
     */
    public $content;  
    
	/**
	 * Should the content be published?
	 * 
	 * @var boolean
	 * @orm bool
	 */
	public $published;

	/**
	 * The global announcment content for the component.
	 * NOTE: This is not a persistant object, but
	 * a convenience attribute to separate the returned
	 * global value and the desired scope content.
	 * 
	 * @var string
	 */
	public $global;
} 
?>
