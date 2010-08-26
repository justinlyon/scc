<?php
/**
 *  $Id:$
 *  Copyright (c) 2008, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */
require_once dirname(__FILE__) . '/Person.php';

/**
 * Defines a person who leads exhibits in exhibitions
 * 
 * @author Nik Chanda
 * @version $Revision: $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm Person
 */
class Artist extends Person
{  
	/**
     * Related exhibitions
     * 
     * @var Exhibition
     * @orm has many Exhibition inverse(artists)
     */
    public $exhibitions;
}
?>