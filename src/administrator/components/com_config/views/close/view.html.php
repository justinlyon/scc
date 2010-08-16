<?php
/**
 * @version		$Id: view.html.php 16885 2010-05-07 07:51:18Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * This view is displayed after successfull saving of config data.
 * Use it to show a message informing about success or simply close a modal window.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_config
 */
class ConfigViewClose extends JView
{
	/**
	 * Display the view
	 */
	function display()
	{
		// close a modal window
		JFactory::getDocument()->addScriptDeclaration('window.parent.SqueezeBox.close();');
	}
}
