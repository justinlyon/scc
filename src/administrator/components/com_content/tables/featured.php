<?php
/**
 * @version		$Id: featured.php 14276 2010-01-18 14:20:28Z louis $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	Content
 */
class ContentTableFeatured extends JTable
{
	/**
	 * @var int Primary key
	 */
	var $content_id	= null;

	/**
	 * @var int
	 */
	var $ordering	= null;

	/**
	 * @param	JDatabase	A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__content_frontpage', 'content_id', $db);
	}
}