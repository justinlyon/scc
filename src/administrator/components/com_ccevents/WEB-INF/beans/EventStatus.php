<?php
/**
 *  $Id: EventStatus.php 194 2006-07-20 08:04:04Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */
require_once dirname(__FILE__) . '/EnumeratedValue.php';

/**
 * This class defines the valid event status values
 *  
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm EnumeratedValue
 */
class EventStatus extends EnumeratedValue
{  
	const ACTIVE = 'Active';
	const SOLDOUT = 'Sold Out';
	const CANCELLED = 'Cancelled';
}

?>