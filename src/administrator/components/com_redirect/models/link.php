<?php
/**
 * @version		$Id: link.php 17015 2010-05-13 06:37:40Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Redirect link model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_redirect
 * @since		1.6
 */
class RedirectModelLink extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_REDIRECT';
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	*/
	public function getTable($type = 'Link', $prefix = 'RedirectTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_redirect.link', 'link', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_redirect.edit.link.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * Method to activate links.
	 *
	 * @param	array	An array of link ids.
	 * @param	string	The new URL to set for the redirect.
	 * @param	string	A comment for the redirect links.
	 * @return	boolean	Returns true on success, false on failure.
	 * @since	1.6
	 */
	public function activate(&$pks, $url, $comment = null)
	{
		// Initialise variables.
		$user	= JFactory::getUser();
		$db		= $this->getDbo();

		// Sanitize the ids.
		$pks = (array) $pks;
		JArrayHelper::toInteger($pks);

		// Populate default comment if necessary.
		$comment = (!empty($comment)) ? $comment : JText::sprintf('COM_REDIRECT_REDIRECTED_ON', JHTML::_('date',time()));

		// Access checks.
		if (!$user->authorise('core.edit', 'com_redirect')) {
			$pks = array();
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			return false;
		}

		if (!empty($pks)) {
			// Update the link rows.
			$db->setQuery(
				'UPDATE `#__redirect_links`' .
				' SET `new_url` = '.$db->Quote($url).', `published` = 1, `comment` = '.$db->Quote($comment) .
				' WHERE `id` IN ('.implode(',', $pks).')'
			);
			$db->query();

			// Check for a database error.
			if ($error = $this->_db->getErrorMsg())
			{
				$this->setError($error);
				return false;
			}
		}
		return true;
	}
}