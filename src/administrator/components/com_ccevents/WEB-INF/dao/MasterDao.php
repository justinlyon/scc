<?php
/**
 *  $Id$: 
 *  Copyright (c) 2008, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/..');
}
require_once WEB_INF . '/base.include.php'; 

require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A class to serve as data access facilitator 
 */
class MasterDao
{
	public $dbo;
	
	/**
	 * Returns the JoomlaDatabaseObject.
	 * @return DBO
	 */
	protected function getDbo()
	{
		if ($this->dbo == null) {
			$this->dbo =& JFactory::getDBO();
		}
		return $this->dbo;
	}
}