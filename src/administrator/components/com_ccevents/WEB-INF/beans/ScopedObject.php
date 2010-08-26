<?php
/**
 *  $Id: ScopedObject.php 153 2006-07-05 19:06:39Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */
require_once('tachometry'.DS.'util'.DS.'BaseBean.php');

/**
 * This class defines standard semantics for ORM inheritance based
 * upon a given scope parameter. Subclasses should define additional 
 * attributes as appropriate to the enumeration type. Note that all
 * subclasses should provide a class-level ORM binding tag to persist the
 * enumerated values into a single table.
 *  
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 153 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
abstract class ScopedObject extends BaseBean
{  
    /**
     * The scope name for the enumerated set (shared by all values)
     * 
     * @var string
     * @orm char(255) index(ev_scope)
     */
    public $scope;


    /**
     * Constructor coerces the scope of the object to the given name
     * or causes it to match the (sub)class name for each instance 
     * 
     * @param String Name for the enumeration 
     */
    public function __construct($source = null, $name = FALSE) {
    	parent::__construct($source);
		if (!$name) {
			$this->scope = get_class($this);
		} else {
			$this->scope = $name;
		}
    } 
}

?>
