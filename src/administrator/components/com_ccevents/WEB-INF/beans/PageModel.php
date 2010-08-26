<?php
/**
 *  $Id$: PageModel.php, Sep 5, 2006 7:18:50 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
require_once ('tachometry/util/BaseBean.php');

/**
 * Bean container to hold the structured page object
 * for a standard Summary Page.
 *
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccvenues
 * @subpackage share.page.bean
 */
class SummaryPageModel extends BaseBean
{  
    /**
     * The list of summary elements
     * @var array
     */
    public $list;  
    
    /**
     * The pagination object
     * @var Pagination
     */
     public $pagination;
     
    /**
     * The page announcement
     * @var string
     */
     public $announcement;
     
    /**
     * An array of the related items by key.
     * (e.g. $related = array('venue'=>'2','exhibition'=>'1','course'=>'4'))
     */
     public $related;
     
     /**
      * An mixed array of selected elements keyed by attribute type
      * (e.g. $selected['month'] = integer month value, 
      * $selected['genre'] = integer genre oid)
      * @var array
      */
     public $selected;
}

/**
 * Bean container to hold the structured page object
 * for the standard Detail Page.
 *
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccvenues
 * @subpackage share.page.bean
 */
class DetailPageModel extends BaseBean
{  
	/**
	 * The primary bean element
	 * @var $bean
	 */
	 public $detail;
	 
	 /**
     * The page announcement
     * @var string
     */
     public $announcement;
     
     /**
      * An array of options keyed by attribute type
      * (e.g. $options['pubState'] = list of PublicationState beans)
      * @var array
      */
     public $options;
     
     /**
      * An mixed array of selected eleements keyed by attribute type
      * (e.g. $selected['month'] = integer month value, 
      * $selected['genre'] = integer genre oid)
      * @var array
      */
     public $selected;
} 
 
?>
