<?php
/**
 *  $Id: $
 *  Copyright (c) 2008, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */

require_once('tachometry/util/BaseBean.php');

/**
 * Defines the generic Promotion object
 * 
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: $
 * @package com.ccevents
 */
class Promotion extends BaseBean
{ 
	public $id;
	
	public $scope;
	
	public $link;
	
	public $image;
	
	public $summary;
	
	public $date;
	
	public $scheduleNote;
	
	public $genre;
}