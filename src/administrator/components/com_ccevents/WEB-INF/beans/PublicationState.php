<?php
/**
 *  $Id: PublicationState.php 194 2006-07-20 08:04:04Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 * 
 */
require_once dirname(__FILE__) . '/EnumeratedValue.php';

/**
 * This class defines the valid states for content publication
 *  
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 194 $
 * @package com.ccevents
 * @subpackage share.pdo (persistent data objects)
 * @orm EnumeratedValue 
 */
class PublicationState extends EnumeratedValue
{
	const PUBLISHED = 'Published';
	const UNPUBLISHED = 'Unpublished';
	const ARCHIVED = 'Archived';
	
	/**
	 * Returns true if the publication state is "published"
	 * @return Boolean
	 */
	function isPublished() {
		return (strcasecmp($this->value, PublicationState::PUBLISHED) == 0);
	}
}

?>