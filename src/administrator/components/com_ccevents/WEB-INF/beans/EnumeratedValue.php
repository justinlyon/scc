<?php
/**
 *  $Id: EnumeratedValue.php 194 2006-07-20 08:04:04Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */
require_once dirname(__FILE__) . '/ScopedObject.php';

/**
 * This class defines an enumeration, or constrained set of values associated
 * with a given name. Subclasses may provide convenience methods to improve 
 * usage semantics as appropriate to the enumeration type. Note that all
 * subclasses should provide a class-level ORM binding tag to persist the
 * enumerated values into a single table.
 *  
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm EnumeratedValue
 */
class EnumeratedValue extends ScopedObject
{  
    /**
     * A valid value for the named enumeration
     * 
     * @var string
     * @orm char(255)
     */
    public $value;    
    
    /**
     * An optional description for the given value
     * 
     * @var string
     * @orm clob(512)
     */
    public $description;  
}

?>