<?php
/**
 * @version		$Id: content.php 17165 2010-05-17 15:59:19Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Content component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class ContentHelper
{
	public static $extention = 'com_content';

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('JGLOBAL_ARTICLES'),
			'index.php?option=com_content&view=articles',
			$vName == 'articles'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_CONTENT_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_content',
			$vName == 'categories');
		JSubMenuHelper::addEntry(
			JText::_('COM_CONTENT_SUBMENU_FEATURED'),
			'index.php?option=com_content&view=featured',
			$vName == 'featured'
		);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @param	int		The article ID.
	 *
	 * @return	JObject
	 */
	public static function getActions($categoryId = 0, $articleId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($articleId) && empty($categoryId)) {
			$assetName = 'com_content';
		}
		else if (empty($articleId)) {
			$assetName = 'com_content.category.'.(int) $categoryId;
		}
		else {
			$assetName = 'com_content.article.'.(int) $articleId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}