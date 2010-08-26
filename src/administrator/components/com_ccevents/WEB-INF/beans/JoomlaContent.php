<?php
/**
 *  $Id: $
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
 * Defines a container for a Joomla section
 * 
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: $
 * @package com.ccevents
 */
class JoomlaSection extends BaseBean
{  
	/**
     * The id of the section
     * @var int(11)
     */
	public $id;
	
	/**
     * The title of the section
     * @var string (text)
     */
    public $title;

	/**
     * The name of the section
     * @var string (text)
     */
    public $name;

	/**
     * The alias of the section
     * @var string [varchar(255)]
     */
    public $alias;

	/**
     * The image of the section
     * @var string [text]
     */
    public $image;

	/**
     * The scope of the section
     * @var string [varchar(50)]
     */
    public $scope;

	/**
     * The image_position of the section
     * @var string [varchar(90)]
     */
    public $image_position;
    
	/**
     * The description of the section
     * @var string [text]
     */
    public $description;
    
	/**
     * The flag if the section is published
     * @var boolean [tinyint(1)]
     */
    public $published;
    
    /**
     * Is the element checked_out
     * @var int [int(11))]
     */
    public $checked_out;
    
   	/**
     * The date/time the item was checked out
     * @var datetime [datetime]
     */
    public $checked_out_time;
    
   	/**
     * The ordering of this section in relation with other sections
     * @var int [int(11))]
     */
    public $ordering;
    
   	/**
     * The access value
     * @var int [tinyint(3)]
     */
    public $access;
    
    /**
     * The number of times the section has been viewed
     * @var int [int(11)]
     */
    public $count;
    
   	/**
     * The parameters for the section
     * @var string [text]
     */
    public $params;
    
   	/**
     * A list of categories for the section
     * @var ListBean [categories]
     */
    public $categories;
    
}


/**
 * Defines a container for a Joomla category
 * 
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: $
 * @package com.ccevents
 */
class JoomlaCategory extends BaseBean
{  
	/**
     * The id of the category
     * @var int(11)
     */
	public $id;
	
	
	/**
     * The id of the parent category (usually 0)
     * @var int(11)
     */
	public $parent_id;
	
	/**
     * The title of the category
     * @var string (text)
     */
    public $title;

	/**
     * The name of the category
     * @var string (text)
     */
    public $name;

	/**
     * The alias of the category
     * @var string [varchar(255)]
     */
    public $alias;

	/**
     * The image of the category
     * @var string [text]
     */
    public $image;

	/**
     * The parent section of the category
     * @var int [varchar(150)]
     */
    public $section;

	/**
     * The image_position of the category
     * @var string [varchar(90)]
     */
    public $image_position;
    
	/**
     * The description of the category
     * @var string [text]
     */
    public $description;
    
	/**
     * The flag if the section is category
     * @var boolean [tinyint(1)]
     */
    public $published;
    
    /**
     * Is the element checked_out
     * @var int [int(11))]
     */
    public $checked_out;
    
   	/**
     * The date/time the item was checked out
     * @var datetime [datetime]
     */
    public $checked_out_time;
    
	/**
     * The editor defined for the category (usually blank)
     * @var string [varchar(150)]
     */
    public $editor;

   	/**
     * The ordering of this category in relation with other categories
     * @var int [int(11))]
     */
    public $ordering;
    
   	/**
     * The access value
     * @var int [tinyint(3)]
     */
    public $access;
    
    /**
     * The number of times the category has been viewed
     * @var int [int(11)]
     */
    public $count;
    
   	/**
     * The parameters for the category
     * @var string [text]
     */
    public $params;
    
    /**
     * A list of articles for the category
     * @var ListBean [articles]
     */
    public $articles;

}


/**
 * Defines a container for a Joomla article
 * 
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: $
 * @package com.ccevents
 */
class JoomlaArticle extends BaseBean
{  
	/**
     * The id of the article
     * @var int(11)
     */
	public $id;
	
	/**
     * The title of the article
     * @var string (text)
     */
    public $title;

	/**
     * The alias of the category
     * @var string [varchar(255)]
     */
    public $alias;

	/**
     * The title-alias of the category
     * @var string [text)]
     */
    public $title_alias;

	/**
     * The introtext of the category
     * @var string (mediumtext)
     */
    public $introtext;

	/**
     * The fulltext of the category
     * @var string (mediumtext)
     */
    public $fulltext;

	/**
     * The publication state of the article
     * @var int [tinyint(3)]
     */
	public $state;
	
	/**
     * The id of the section
     * @var int [int(11))]
     */
	public $sectionid;
	
	public $mask;
	
	/**
     * The id of the parent category
     * @var int [int(11))]
     */
	public $catid;
	
	public $created;
	
	public $created_by;
	
	public $created_by_alias;

	public $modified;
	
	public $modified_by;
	
	public $checked_out;
	
	public $checked_out_time;
	
	public $publish_up;
	
	public $publish_down;
	
	/**
     * The images of the category
     * @var string [text]
     */
    public $images;
    
    public $urls;
    
    public $attribs;
    
    public $version;
    
    public $parentid;
    
    public $ordering;
    
    public $metakey;
    
    public $metadesc;
    
    public $access;
    
    public $hits;
    
    public $metadata;

}

/**
 * Defines a container for a Joomla Comment
 * 
 * @author Nik Chanda <nchanda@tachometry.com>
 * @version $Revision: $
 * @package com.ccevents
 */
class JoomlaComment extends BaseBean
{  
	/**
     * The id of the article
     * @var int(11)
     */
	public $id;
	
	/**
	 * The id of the article
	 * @var int(11)
     */
	public $article;
	
	/**
	 * The title of the comment
	 * @var char(255)
     */
	public $title;
	
	/**
	 * The comment 
	 * @var text
     */
	public $comment;
	
	/**
	 * The name of the person who left the comment
	 * @var name(255)
     */
	public $name;
	
	/**
	 * The date the comment was made
	 * @var datetime
	 */
	public $date;
	
	/**
	 * The boolean marker of a featured item
	 * @var int (ahould be 1 or 0);
	 */
	public $featured;
}
?>