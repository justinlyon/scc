<?php
/**
 * @version		$Id: vote.php 17851 2010-06-23 17:39:31Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Vote plugin.
 *
 * @package		Joomla
 * @subpackage	plg_vote
 */
class plgContentVote extends JPlugin
{
	/**
	 * @since	1.6
	 */
	public function onContentBeforeDisplay($context, &$row, &$params, $page=0)
	{
		$uri = JFactory::getURI();

		$id = $row->id;
		$html = '';

		if (isset($row->rating_count) && $params->get('show_vote') && !$params->get('popup'))
		{
			$html .= '<form method="post" action="' . $uri . '">';
			$img = '';

			// Look for images in template if available.
			$starImageOn = JHTML::_('image','system/rating_star.png', NULL, NULL, true);
			$starImageOff = JHTML::_('image','system/rating_star_blank.png', NULL, NULL, true);
			for ($i=0; $i < $row->rating; $i++) {
				$img .= $starImageOn;
			}
			for ($i=$row->rating; $i < 5; $i++) {
				$img .= $starImageOff;
			}
			$html .= '<span class="content_rating">';
			$html .= JText::_('PLG_VOTE_USER_RATING') .':'. $img .'&#160;/&#160;';
			$html .= intval($row->rating_count);
			$html .= "</span>\n<br />\n";

			if (!$params->get('intro_only'))
			{
				$html .= '<span class="content_vote">';
				$html .= JText::_('PLG_VOTE_POOR');
				$html .= '<input type="radio" alt="vote 1 star" name="user_rating" value="1" />';
				$html .= '<input type="radio" alt="vote 2 star" name="user_rating" value="2" />';
				$html .= '<input type="radio" alt="vote 3 star" name="user_rating" value="3" />';
				$html .= '<input type="radio" alt="vote 4 star" name="user_rating" value="4" />';
				$html .= '<input type="radio" alt="vote 5 star" name="user_rating" value="5" checked="checked" />';
				$html .= JText::_('PLG_VOTE_BEST');
				$html .= '&#160;<input class="button" type="submit" name="submit_vote" value="'. JText::_('PLG_VOTE_RATE') .'" />';
				$html .= '<input type="hidden" name="task" value="vote" />';
				$html .= '<input type="hidden" name="option" value="com_content" />';
				$html .= '<input type="hidden" name="cid" value="'. $id .'" />';
				$html .= '<input type="hidden" name="url" value="'.  $uri .'" />';
				$html .= '</span>';
			}
			$html .= '</form>';
		}
		return $html;
	}
}
