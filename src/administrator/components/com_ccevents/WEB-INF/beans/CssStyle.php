<?php
/**
 *  $Id: CssStyle.php 153 2006-07-05 19:06:39Z tevans $
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
 * Defines a stylesheet specification
 * 
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 153 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 */
class CssStyle extends BaseBean
{
	const CSS_CLASS = 'class';
	const CSS_ID = 'id';

    /**
     * The CSS selector for the stylesheet definition 
     * 
     * @var string
     * @orm char(255)
     */
    public $selector;  

    /**
     * The CSS type (ID or CLASS) 
     * 
     * @var string
     * @orm char(255)
     */
    public $cssType;  

    /**
     * A user-friendly description of the style
     * 
     * @var string
     * @orm clob(512)
     */
    public $description;  
  
  /**
   * Constructor - set the CSS type to the given value or CSS_CLASS
   * @param string 
   */
    public function __construct($type = '') { 
		if ($type == '') {
			$this->cssType = CssStyle::CSS_CLASS;
		} else {
			$this->cssType = $type;
		}
    } 
   
}
?>
