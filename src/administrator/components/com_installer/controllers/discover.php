<?php
/**
 * @version		$Id: discover.php 16457 2010-04-26 00:07:16Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 */
class InstallerControllerDiscover extends JController
{
	/**
	 * Refreshes the cache of discovered extensions.
	 *
	 * @since	1.6
	 */
	public function refresh()
	{
		$model = $this->getModel('discover');
		$model->discover();
		$this->setRedirect(JRoute::_('index.php?option=com_installer&view=discover',false));
	}

	/**
	 * Install a discovered extension.
	 *
	 * @since	1.6
	 */
	function install()
	{
		$model = $this->getModel('discover');
		$model->discover_install();
		$this->setRedirect(JRoute::_('index.php?option=com_installer&view=discover',false));
	}

	/**
	 * Clean out the discovered extension cache.
	 *
	 * @since	1.6
	 */
	function purge()
	{
		$model = $this->getModel('discover');
		$model->purge();
		$this->setRedirect(JRoute::_('index.php?option=com_installer&view=discover',false), $model->_message);
	}
}