<?php
/**
 * @version		$Id: language.php 17858 2010-06-23 17:54:28Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Languages Component Language Model
 *
 * @package		Joomla.Administrator
 * @subpackage	com_languages
 * @since		1.5
 */
class LanguagesModelLanguage extends JModelAdmin
{
	/**
	 * Override to get the table
	 */
	public function getTable()
	{
		return JTable::getInstance('Language');
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app		= JFactory::getApplication('administrator');
		$params		= JComponentHelper::getParams('com_languages');

		// Load the User state.
		if (JRequest::getWord('layout') === 'edit') {
			$langId = (int) $app->getUserState('com_languages.edit.language.id');
			$this->setState('language.id', $langId);
		} else {
			$langId = (int) JRequest::getInt('id');
			$this->setState('language.id', $langId);
		}

		// Load the parameters.
		$this->setState('params', $params);
	}

	/**
	 * Method to get a member item.
	 *
	 * @param	integer	The id of the member to get.
	 * @return	mixed	User data object on success, false on failure.
	 * @since	1.0
	 */
	public function &getItem($langId = null)
	{
		// Initialise variables.
		$langId	= (!empty($langId)) ? $langId : (int) $this->getState('language.id');
		$false		= false;

		// Get a member row instance.
		$table = $this->getTable();

		// Attempt to load the row.
		$return = $table->load($langId);

		// Check for a table object error.
		if ($return === false && $table->getError()) {
			$this->setError($table->getError());
			return $false;
		}

		$value = JArrayHelper::toObject($table->getProperties(1), 'JObject');
		return $value;
	}

	/**
	 * Method to get the group form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_languages.language', 'language', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_languages.edit.language.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param	array	The form data.
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function save($data)
	{
		$langId	= (int) $this->getState('language.id');
		$isNew	= true;

		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('extension');

		$table = $this->getTable();

		// Load the row if saving an existing item.
		if ($langId > 0) {
			$table->load($langId);
			$isNew = false;
		}

		// Bind the data
		if (!$table->bind($data)) {
			$this->setError($table->getError());
			return false;
		}

		// Check the data
		if (!$table->check()) {
			$this->setError($table->getError());
			return false;
		}

		// Trigger the onExtensionBeforeSave event.
		$result = $dispatcher->trigger('onExtensionBeforeSave', array('com_langauges.language', &$table, $isNew));

		// Check the event responses.
		if (in_array(false, $result, true)) {
			$this->setError($table->getError());
			return false;
		}

		// Store the data
		if (!$table->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Trigger the onExtensionAfterSave event.
		$dispatcher->trigger('onExtensionAfterSave', array('com_langauges.language', &$table, $isNew));

		$this->setState('language.id', $table->lang_id);

		return true;
	}

	/**
	 * Method to delete from the database.
	 *
	 * @param	integer	$cid	An array of	numeric ids of the rows.
	 * @return	boolean	True on success/false on failure.
	 */
	public function delete($cid)
	{
		$table = $this->getTable();

		for ($i = 0, $c = count($cid); $i < $c; $i++) {
			// Load the row.
			$return = $table->load($cid[$i]);

			// Check for an error.
			if ($return === false) {
				$this->setError($table->getError());
				return false;
			}

			// Delete the row.
			$return = $table->delete();

			// Check for an error.
			if ($return === false) {
				$this->setError($table->getError());
				return false;
			}
		}

		return true;
	}

	function _orderConditions($table = null)
	{
		$condition = array();
		return $condition;
	}
}