<?php
/**
 *  $Id$: Editor.php, Oct 13, 2006 11:18:53 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

require_once('tachometry/util/BaseBean.php');
 
/**
 * A configurator class to hold the attributes of 
 * the editor configuration.  This class is specifically
 * designed to support the attributes of the Joomla
 * editor object, but may be extended to support
 * other object configurations.
 */
class Editor extends BaseBean
{  
	const SMALL = "small";
	const MEDIUM = "medium";
	const LARGE = "large";
	
	
	/**
     * The friendly name of the editor field.  
     * 
     * @var string
     */
    public $name;	

	/**
     * The content of the editor field
     * 
     * @var string
     */
    public $content;    

	/**
     * The name of the value field.  This is the 
     * name of the form element that will be persisted
     * through database connection or PDO.
     * 
     * @var string
     */
    public $valueField;  

	/**
     * The width of the editor
     * 
     * @var string
     */
    public $width;  
    
    /**
     * The height of the editor
     * 
     * @var string
     */
    public $height;
    
	/**
     * The number of rows in the editor
     * 
     * @var string
     */
    public $rows;  
    
    /**
     * The number of columns in the editor
     * 
     * @var string
     */
    public $cols;          
		
} 
?>
