<?php
/**
 * @version		$Id: newsfeeds.php 16402 2010-04-24 00:34:07Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Newsfeeds list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_newsfeeds
 * @since		1.6
 */
class NewsfeedsControllerNewsfeeds extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 */
	public function &getModel($name = 'Newsfeed', $prefix = 'NewsfeedsModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}