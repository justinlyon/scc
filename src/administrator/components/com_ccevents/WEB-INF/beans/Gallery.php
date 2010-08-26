<?php
/**
 *  $Id: Gallery.php 194 2006-07-20 08:04:04Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */
require_once dirname(__FILE__) . '/Resource.php';

/**
 * Defines the gallery for a particular event
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class Gallery extends Resource
{  
	
	/**
	 * A list of gallery images.  May need refactoring.
	 * @var array of Image
	 */
	 public $images;
}

class Image extends BaseBean
{
	/**
	 * The URL of the image
	 * @var string
	 */
	public $url;

	/**
	 * The Author of the image / photo credit
	 * @var string
	 */
	public $author;

	/**
	 * The Title of the image
	 * @var string
	 */
	public $title;

	/**
	 * A Description of the image
	 * @var string 
	 */
	public $description;
	
	/**
	 * The id of the image
	 * @var int
	 */
	public $id;
}

?>
