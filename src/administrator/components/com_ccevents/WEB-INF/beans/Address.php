<?php
/**
 *  $Id: Address.php 194 2006-07-20 08:04:04Z tevans $
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
 * Defines the address for a particular venue
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class Address extends Resource
{  
	/**
	 * Street address
	 * @var string
	 * @orm char(255)
	 */
	 public $street;
	 
	/**
	 * Unit, apartment or suite
	 * @var string
	 * @orm char(255)
	 */
	 public $unit;
	  
	/**
	 * City
	 * @var string
	 * @orm char(255)
	 */
	 public $city;
	   
	/**
	 * State code (2 character representation of the state)
	 * @var string
	 * @orm char(2) 
	 **/
	 public $state;
	 
	/**
	 * Postal or "zip code"
	 * @var string
	 * @orm char(255)
	 */
	 public $postalCode;
	 
	 
	 /**
	  * Phone number associated with the address
	  * @var string
	  * @orm char(255)
	  */
	  public $phone;
}
?>
