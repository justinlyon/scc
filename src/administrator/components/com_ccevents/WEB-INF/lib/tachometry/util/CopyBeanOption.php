<?php
/*
 *  $Id: CopyBeanOption.php 711 2008-04-17 01:36:14Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

require_once 'BaseBean.php';

/**
 * This "bean" class defines standard configuration parameter
 * for use in the BeanUtils::copyBean method.
 *
 * In a web application, it is common to copy bean values
 * between instances.  This bean class allows an extensible
 * container to modify the BeanUtil::copyBean method without
 * breaking backward compatibility.
 *
 * @author Nik Chanda <nchanda@tachometry.com
 * @version $Revision: 512 $
 * @package com.tachometry.util
 * @see BeanUtils
 */
class CopyBeanOption extends BaseBean
{
	/**
     * Should strict rules be enforced
     * @var boolean default=FALSE
     */
    public $strict = FALSE;

    /**
     * Should the target bean's variables be used to
     * determine the set of copy attributes
     * @var boolean default=FALSE
     */
    public $useTargetVars = FALSE;

    /**
     * Should the copy ignore null values from the
     * source bean
     * @var boolean default=FALSE
     */
    public $ignoreNullValues = FALSE;

    /**
     * Array of attributes that should be included in the copy
     * operation
     * @var array [string]
     */
    public $includes = array();

    /**
     * Array of attributes that should be excluded from the copy
     * operation
     * @var array [string]
     */
    public $excludes = array();

    
    public function __construct($source=null) {
		parent::__construct($source);
	}
}
?>
