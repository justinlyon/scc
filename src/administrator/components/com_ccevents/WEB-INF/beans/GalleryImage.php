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
 
class CompositeImage extends Resource
{	
	/**
	 * title
	 * @var string
	 */	
	public $title;
	
	/**
	 * parent album id
	 * @var int
	 */
	public $parent;
	
	/**
	 * summary
	 * @var string
	 */
	public $summary;
	
	/**
	 * caption (usully uses summary, but can be overridden)
	 * @var string
	 */
	public $caption;
	
	/**
	 * keywords
	 * @var string
	 */
	public $keywords;
	
	/**
	 * description
	 * @var string
	 */
	public $description;
	
	/**
	 * mime type
	 * @var string
	 */
	public $mimeType;
	
	/**
	 * small version
	 * @var DerivitiveImage
	 */
	public $small;
	
	/**
	 * medium version
	 * @var DerivitiveImage
	 */
	public $medium;
	
	/**
	 * large version
	 * @var DerivitiveImage
	 */
	public $large;
	
	/**
	 * base name without markers
	 * @var string
	 */
	public $basename;
} 
 
 
class DerivativeImage extends Resource
{  
	/**
	 * id
	 * @var int
	 */
	public $id;
	
	/**
	 * url
	 * @var string
	 */
	public $url;
	
	/**
	 * width
	 * @var int
	 */
	public $width;
	
	/**
	 * height
	 * @var string
	 */
	public $height;	
	
	/**
	 * size
	 * @var string
	 */
	public $size;	 
}