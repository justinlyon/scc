<?php
/**
 * @version		$Id: article.php 17851 2010-06-23 17:39:31Z eddieajau $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Editor Article buton
 *
 * @package Editors-xtd
 * @since 1.5
 */
class plgButtonArticle extends JPlugin
{
	/**
	 * Display the button
	 *
	 * @return array A four element array of (article_id, article_title, category_id, object)
	 */
	function onDisplay($name)
	{
		/*
		 * Javascript to insert the link
		 * View element calls jSelectArticle when an article is clicked
		 * jSelectArticle creates the link tag, sends it to the editor,
		 * and closes the select frame.
		 */
		$js = "
		function jSelectArticle(id, title, catid, object) {
			var tag = '<a href='+'\"index.php?option=com_content&amp;view=article&amp;catid='+catid+'&amp;id='+id+'\">'+title+'</a>';
			jInsertEditorText(tag, '".$name."');
			SqueezeBox.close();
		}";

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);

		JHTML::_('behavior.modal');

		/*
		 * Use the built-in element view to select the article.
		 * Currently uses blank class.
		 */
		$link = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component';

		$button = new JObject();
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_('PLG_ARTICLE_BUTTON_ARTICLE'));
		$button->set('name', 'article');
		$button->set('options', "{handler: 'iframe', size: {x: 770, y: 400}}");

		return $button;
	}
}
