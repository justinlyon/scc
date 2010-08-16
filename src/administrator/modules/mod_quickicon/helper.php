<?php
/**
 * @version		$Id: helper.php 17339 2010-05-28 23:43:29Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @since		1.6
 */
abstract class QuickIconHelper
{
	/**
	 * Stack to hold default buttons
	 *
	 * @since	1.6
	 */
	protected static $buttons = array();

	/**
	 * Helper method to generate a button in administrator panel
	 *
	 * @param	array	A named array with keys link, image, text, access and imagePath
	 *
	 * @return	string	HTML for button
	 * @since	1.6
	 */
	public static function button($button)
	{
		if (!empty($button['access'])) {
			if (!JFactory::getUser()->authorise($button['access'][0], $button['access'][1])) {
				return '';
			}
		}

		if (empty($button['imagePath'])) {
			$template = JFactory::getApplication()->getTemplate();
			$button['imagePath'] = '/templates/'. $template .'/images/header/';
		}

		ob_start();
		require JModuleHelper::getLayoutPath('mod_quickicon', 'button');
		$html = ob_get_clean();
		return $html;
	}

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons()
	{
		if (empty(self::$buttons)) {
			self::$buttons = array(
				array(
					'link' => JRoute::_('index.php?option=com_content&task=article.add'),
					'image' => 'icon-48-article-add.png',
					'text' => JText::_('MOD_QUICKICON_ADD_NEW_ARTICLE'),
					'access' => array('core.manage', 'com_content')
				),
				array(
					'link' => JRoute::_('index.php?option=com_content'),
					'image' => 'icon-48-article.png',
					'text' => JText::_('MOD_QUICKICON_ARTICLE_MANAGER'),
					'access' => array('core.manage', 'com_content')
				),
				array(
					'link' => JRoute::_('index.php?option=com_categories&extension=com_content'),
					'image' => 'icon-48-category.png',
					'text' => JText::_('MOD_QUICKICON_CATEGORY_MANAGER'),
					'access' => array('core.manage', 'com_content')
				),
				array(
					'link' => JRoute::_('index.php?option=com_media'),
					'image' => 'icon-48-media.png',
					'text' => JText::_('MOD_QUICKICON_MEDIA_MANAGER'),
					'access' => array('core.manage', 'com_media')
				),
				array(
					'link' => JRoute::_('index.php?option=com_menus'),
					'image' => 'icon-48-menumgr.png',
					'text' => JText::_('MOD_QUICKICON_MENU_MANAGER'),
					'access' => array('core.manage', 'com_menus')
				),
				array(
					'link' => JRoute::_('index.php?option=com_users'),
					'image' => 'icon-48-user.png',
					'text' => JText::_('MOD_QUICKICON_USER_MANAGER'),
					'access' => array('core.manage', 'com_users')
				),
				array(
					'link' => JRoute::_('index.php?option=com_modules'),
					'image' => 'icon-48-module.png',
					'text' => JText::_('MOD_QUICKICON_MODULE_MANAGER'),
					'access' => array('core.manage', 'com_modules')
				),
				array(
					'link' => JRoute::_('index.php?option=com_installer'),
					'image' => 'icon-48-extension.png',
					'text' => JText::_('MOD_QUICKICON_EXTENSION_MANAGER'),
					'access' => array('core.manage', 'com_installer')
				),
				array(
					'link' => JRoute::_('index.php?option=com_languages'),
					'image' => 'icon-48-language.png',
					'text' => JText::_('MOD_QUICKICON_LANGUAGE_MANAGER'),
					'access' => array('core.manage', 'com_languages')
				),
				array(
					'link' => JRoute::_('index.php?option=com_config'),
					'image' => 'icon-48-config.png',
					'text' => JText::_('MOD_QUICKICON_GLOBAL_CONFIGURATION'),
					'access' => array('core.manage', 'com_config')
				)
			);
		}

		return self::$buttons;
	}
}