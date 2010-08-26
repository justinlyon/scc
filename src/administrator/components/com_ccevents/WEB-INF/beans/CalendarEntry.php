
<?php
/**
 *  $Id$: CalendarEntry.php, Oct 25, 2006 7:13:16 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
require_once('tachometry/util/BaseBean.php');

/**
 * Defines a container for the calendar entry.  Note that
 * this is not a PDO object. It is a simple object to
 * hold structured calendar helper elements.
 * 
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class CalendarEntry extends BaseBean
{  
	/**
     * The startTime
     * 
     * @var int (timestamp)
     */
    public $startTime;
    
	/**
     * The event title
     * 
     * @var string
     */
    public $title;
    
    /**
     * The event oid
     * 
     * @var int
     */
    public $oid;

	/**
     * The event's primary genre id'
     * 
     * @var int
     */
    public $fid;

	/**
     * The event scope
     * 
     * @var string
     */
    public $scope;

    /**
     * The primaryGenre
     * 
     * @var string
     */
    public $genre;
    
    /**
     * The summary
     * 
     * @var string
     */
    public $summary;
    
    /**
     * A link to the resource gallery (photos, etc.)
     *
     * @var int
     * @orm int
     */
    public $gallery;

	/**
     * The event's audience categories
     * 
     * @var array of Category
     */
    public $family;
}
?>

