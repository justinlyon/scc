<?php
/**
 *  $Id: Resource.php 153 2006-07-05 19:06:39Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 */

require_once('tachometry/util/BaseBean.php');

/**
 * Defines linked resources for third-party imtegration
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 153 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class Resource extends BaseBean
{  
    /**
     * The name of the resource
     * 
     * @var string
     * @orm char(255)
     */
    public $name;  

    /**
     * A description of the resource
     * 
     * @var string
     * @orm clob(512)
     */
    public $description;  

    /**
     * A link to the resource (e.g. URL, plugin/redirect target)
     * 
     * @var string
     * @orm char(255)
     */ 
    public $target;  
    
    /**
     * The resource type
     * 
     * @var ResourceType
     * @orm has one ResourceType
     */
    public $resourceType;    
    
}
?>
