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
 * Defines the album for the gallery2 integration
 * 
 * @author Nik Chanda
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class GalleryAlbum extends Resource
{  
	/**
	 * Gallery 2 id 
	 * @var int
	 */
	public $id;
	
	/**
	 * Gallery 2 parent id
	 * @var int parent id
	 */
	public $parent;
	 
	/**
	 * Gallery 2 Title
	 * @string title
	 */
	public $title;
	
	/**
	 * Gallery 2 pathComponent
	 * @string
	 */
	public $pathComponent;
	
	/**
	 * Gallery 2 url -- the url to the directory containing images
	 * @string
	 */
	public $url;
	
	/**
	 * A list of GalleryImage
	 * @var array of GalleryImage
	 */
	public $images;
	 
	/**
	 * A list of GalleryVideo
	 * @var array of GalleryVideo
	 */
	public $videos;
	 
}