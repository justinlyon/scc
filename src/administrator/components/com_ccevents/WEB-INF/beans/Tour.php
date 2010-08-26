<?php
/**
 *  $Id $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */
require_once dirname(__FILE__) . '/Activity.php';

/**
 * Extends Activity to define an activity led by a docent.
 *
 * This class uses the EZPDO framework to provide persistence
 * and ORM services to an underlying relational database 
 * (e.g. MySQL, Oracle, etc.). Instances of this class are
 * automatically synchronized with the database. Refer to
 * {@link http://www.ezpdo.net/} for more information.
 *
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm Activity
 */
class Tour extends Activity
{  
    /**
     * Convenience method for the tour leader (docent)
     * 
     * @return Person
     */
    public function getDocent() {
    	return $this->getPerson();
    }    

}

?>
