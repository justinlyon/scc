<?php
/**
 * @version		$Id: update.php 17858 2010-06-23 17:54:28Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 */
class InstallerControllerUpdate extends JController {

	/**
	 * Update a set of extensions.
	 *
	 * @since	1.6
	 */
	function update()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$model	= $this->getModel('update');
		$uid	= JRequest::getVar('cid', array(), '', 'array');

		JArrayHelper::toInteger($uid, array());
		if ($model->update($uid)) {
			$cache = JFactory::getCache('mod_menu');
			$cache->clean();
		}
		$this->setRedirect(JRoute::_('index.php?option=com_installer&view=update',false));
	}

	/**
	 * Find new updates.
	 *
	 * @since	1.6
	 */
	function find()
	{
		// Find updates
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$model	= $this->getModel('update');
		$model->purge();
		$result = $model->findUpdates();
		$this->setRedirect(JRoute::_('index.php?option=com_installer&view=update',false));
		//$view->display();
	}

	/**
	 * Purges updates.
	 *
	 * @since	1.6
	 */
	function purge()
	{
		// Purge updates
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$model = $this->getModel('update');
		$model->purge();
		$this->setRedirect(JRoute::_('index.php?option=com_installer&view=update',false), $model->_message);
	}
}