<?php
/**
 * @version		$Id: pagebreak.php 17851 2010-06-23 17:39:31Z eddieajau $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Editor Pagebreak buton
 *
 * @package Editors-xtd
 * @since 1.5
 */
class plgButtonPagebreak extends JPlugin
{
	/**
	 * Display the button
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	function onDisplay($name)
	{
		$app = JFactory::getApplication();

		$doc = JFactory::getDocument();
		$template = $app->getTemplate();

		$link = 'index.php?option=com_content&amp;view=article&amp;layout=pagebreak&amp;tmpl=component&amp;e_name='.$name;

		JHtml::_('behavior.modal');

		$button = new JObject;
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_('PLG_EDITORSXTD_PAGEBREAK_BUTTON_PAGEBREAK'));
		$button->set('name', 'pagebreak');
		$button->set('options', "{handler: 'iframe', size: {x: 400, y: 100}}");

		return $button;
	}
}