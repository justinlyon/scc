<?php
/**
 * @version		$Id: user.php 18094 2010-07-12 11:30:55Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * User model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @since		1.6
 */
class UsersModelUser extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	*/
	public function getTable($type = 'User', $prefix = 'JTable', $config = array())
	{
		$table = JTable::getInstance($type, $prefix, $config);
		return $table;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		$result = parent::getItem($pk);

		// Get the dispatcher and load the users plugins.
		$dispatcher	= JDispatcher::getInstance();
		JPluginHelper::importPlugin('user');

		// Trigger the data preparation event.
		$results = $dispatcher->trigger('onContentPrepareData', array('com_users.user', $result));

		return $result;
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_users.user', 'user', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_users.edit.user.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		// TODO: Maybe this can go into the parent model somehow?
		// Get the dispatcher and load the users plugins.
		$dispatcher	= JDispatcher::getInstance();
		JPluginHelper::importPlugin('user');

		// Trigger the data preparation event.
		$results = $dispatcher->trigger('onContentPrepareData', array('com_users.profile', $data));

		// Check for errors encountered while preparing the data.
		if (count($results) && in_array(false, $results, true)) {
			$this->setError($dispatcher->getError());
		}

		return $data;
	}

	/**
	 * Override preprocessForm to load the user plugin group instead of content.
	 *
	 * @param	object	A form object.
	 * @param	mixed	The data expected for the form.
	 * @throws	Exception if there is an error in the form event.
	 * @since	1.6
	 */
	protected function preprocessForm(JForm $form, $data)
	{
		parent::preprocessForm($form, $data, 'user');
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
		// Initialise variables;
		$dispatcher = JDispatcher::getInstance();
		$table		= $this->getTable();
		$pk			= (!empty($data['id'])) ? $data['id'] : (int) $this->getState('user.id');
		$isNew		= true;

		// Include the content plugins for events.
		JPluginHelper::importPlugin('user');

		// Load the row if saving an existing record.
		if ($pk > 0) {
			$table->load($pk);
			$isNew = false;
		}

		// The password field is a special case.
		if (!empty($data['password'])) {
			// Generate a password hash.
			jimport('joomla.user.helper');
			$salt  = JUserHelper::genRandomPassword(32);
			$crypt = JUserHelper::getCryptedPassword($data['password'], $salt);
			$data['password'] = $crypt.':'.$salt;
		} else {
			// Do nothing to the password field.
			unset($data['password']);
		}

		// Bind the data.
		if (!$table->bind($data)) {
			$this->setError($table->getError());
			return false;
		}

		// Prepare the row for saving.
		$this->prepareTable($table);

		// Check the data.
		if (!$table->check()) {
			$this->setError($table->getError());
			return false;
		}

		// Get the old user.
		$old = JUser::getInstance($table->id);

		// Merge the table back into the raw data for plugin processing.
		$data = array_merge($data, $table->getProperties(true));

		// Trigger the onUserBeforeSave event.
		$result = $dispatcher->trigger('onUserBeforeSave', array($old->getProperties(true), $isNew, $data));
		if (in_array(false, $result, true)) {
			$this->setError($table->getError());
			return false;
		}

		// Store the data.
		if (!$table->store()) {
			$this->setError($table->getError());
			return false;
		}

		// Insert the ID into the data if this is a new user.
		// Otherwise the AfterSave plugins won't work.
		if ($isNew) {
			$data['id'] = $table->id;
		}

		$user = JFactory::getUser();
		if ($user->id == $table->id) {
			$registry = new JRegistry;
			$registry->loadJSON($table->params);
			$user->setParameters($registry);
		}

		// Trigger the onAftereStoreUser event
		$dispatcher->trigger('onUserAfterSave', array($data, $isNew, true, null));

		$this->setState('user.id', $table->id);

		return true;
	}

	/**
	 * Method to delete rows.
	 *
	 * @param	array	An array of item ids.
	 * @return	boolean	Returns true on success, false on failure.
	 * @since	1.6
	 */
	public function delete(&$pks)
	{
		// Initialise variables.
		$user	= JFactory::getUser();
		$table	= $this->getTable();
		$pks	= (array) $pks;

		// Trigger the onUserBeforeSave event.
		JPluginHelper::importPlugin('user');
		$dispatcher = JDispatcher::getInstance();

		if (in_array($user->id, $pks)) {
			$this->setError(JText::_('COM_USERS_USERS_ERROR_CANNOT_DELETE_SELF'));
			return false;
		}

		// Iterate the items to delete each one.
		foreach ($pks as $i => $pk) {
			if ($table->load($pk)) {
				// Access checks.
				$allow = $user->authorise('core.edit.state', 'com_users');

				if ($allow) {
					// Get user data for the user to delete.
					$user = JFactory::getUser($pk);

					// Fire the onUserBeforeDelete event.
					$dispatcher->trigger('onUserBeforeDelete', array($table->getProperties()));

					if (!$table->delete($pk)) {
						$this->setError($table->getError());
						return false;
					} else {
						// Trigger the onUserAfterDelete event.
						$dispatcher->trigger('onUserAfterDelete', array($user->getProperties(), true, $this->getError()));
					}
				} else {
					// Prune items that you can't change.
					unset($pks[$i]);
					JError::raiseWarning(403, JText::_('JERROR_CORE_DELETE_NOT_PERMITTED'));
				}
			} else {
				$this->setError($table->getError());
				return false;
			}
		}

		return true;
	}

	/**
	 * Method to block user records.
	 *
	 * @param	array	The ids of the items to publish.
	 * @param	int		The value of the published state
	 *
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	function block(&$pks, $value = 1)
	{
		// Initialise variables.
		$app		= JFactory::getApplication();
		$dispatcher	= JDispatcher::getInstance();
		$user		= JFactory::getUser();
		$table		= $this->getTable();
		$pks		= (array) $pks;

		JPluginHelper::importPlugin('user');

		// Access checks.
		foreach ($pks as $i => $pk) {
			if ($value == 1 && $pk == $user->get('id')) {
				// Cannot block yourself.
				unset($pks[$i]);
				JError::raiseWarning(403, JText::_('COM_USERS_USERS_ERROR_CANNOT_DELETE_SELF'));

			} else if ($table->load($pk)) {
				$old	= $table->getProperties();
				$allow	= $user->authorise('core.edit.state', 'com_users');

				// Prepare the logout options.
				$options = array(
					'clientid' => array(0, 1)
				);

				if ($allow) {
					$table->block = (int) $value;

					if (!$table->check()) {
						$this->setError($table->getError());
						return false;
					}

					// Trigger the onUserBeforeSave event.
					$dispatcher->trigger('onUserBeforeSave', array($old, false));

					// Store the table.
					if (!$table->store()) {
						$this->setError($table->getError());
						return false;
					}

					// Trigger the onAftereStoreUser event
					$dispatcher->trigger('onUserAfterSave', array($table->getProperties(), false, true, null));

					// Log the user out.
					if ($value) {
						$app->logout($table->id, $options);
					}
				} else {
					// Prune items that you can't change.
					unset($pks[$i]);
					JError::raiseWarning(403, JText::_('JERROR_CORE_EDIT_STATE_NOT_PERMITTED'));
				}
			}
		}

		return true;
	}

	/**
	 * Method to activate user records.
	 *
	 * @param	array	The ids of the items to activate.
	 *
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	function activate(&$pks)
	{
		// Initialise variables.
		$dispatcher	= JDispatcher::getInstance();
		$user		= JFactory::getUser();
		$table		= $this->getTable();
		$pks		= (array) $pks;

		// Access checks.
		foreach ($pks as $i => $pk) {
			if ($table->load($pk)) {
				$old	= $table->getProperties();
				$allow	= $user->authorise('core.edit.state', 'com_users');

				if (empty($table->activation)) {
					// Ignore activated accounts.
					unset($pks[$i]);
				} else if ($allow) {
					$table->block		= 0;
					$table->activation	= '';

					if (!$table->check()) {
						$this->setError($table->getError());
						return false;
					}

					// Trigger the onUserBeforeSave event.
					$dispatcher->trigger('onUserBeforeSave', array($old, false));

					// Store the table.
					if (!$table->store()) {
						$this->setError($table->getError());
						return false;
					}

					// Fire the onAftereStoreUser event
					$dispatcher->trigger('onUserAfterSave', array($table->getProperties(), false, true, null));
				} else {
					// Prune items that you can't change.
					unset($pks[$i]);
					JError::raiseWarning(403, JText::_('JERROR_CORE_EDIT_STATE_NOT_PERMITTED'));
				}
			}
		}

		return true;
	}

	/**
	 * Perform batch operations
	 *
	 * @param	array	An array of variable for the batch operation
	 * @param	array	An array of IDs on which to operate
	 * @since	1.6
	 */
	public function batch($config, $user_ids)
	{
		// Ensure there are selected users to operate on.
		if (empty($user_ids)) {
			$this->setError(JText::_('COM_USERS_USERS_NO_ITEM_SELECTED'));
			return false;
		} else if (!empty($config)) {
			// Only run operations if a config array is present.
			// Ensure there is a valid group.
			$group_id = JArrayHelper::getValue($config, 'group_id', 0, 'int');

			if ($group_id < 1) {
				$this->setError(JText::_('COM_USERS_ERROR_INVALID_GROUP'));
				return false;
			}

			// Get the system ACL object and set the mode to database driven.
			$acl = JFactory::getACL();
			$oldAclMode = $acl->setCheckMode(1);

			$groupLogic	= JArrayHelper::getValue($config, 'group_logic');
			switch ($groupLogic) {
				case 'set':
					$doDelete		= 2;
					$doAssign		= true;
					break;

				case 'del':
					$doDelete		= true;
					$doAssign		= false;
					break;

				case 'add':
				default:
					$doDelete		= false;
					$doAssign		= true;
					break;
			}

			// Remove the users from the group(s) if requested.
			if ($doDelete) {
				// Purge operation, remove the users from all groups.
				if ($doDelete === 2) {
					$this->_db->setQuery(
						'DELETE FROM `#__user_usergroup_map`' .
						' WHERE `user_id` IN ('.implode(',', $user_ids).')'
					);
				} else {
					// Remove the users from the group.
					$this->_db->setQuery(
						'DELETE FROM `#__user_usergroup_map`' .
						' WHERE `user_id` IN ('.implode(',', $user_ids).')' .
						' AND `group_id` = '.$group_id
					);
				}

				// Check for database errors.
				if (!$this->_db->query()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}

			// Assign the users to the group if requested.
			if ($doAssign) {
				// Build the tuples array for the assignment query.
				$tuples = array();
				foreach ($user_ids as $id) {
					$tuples[] = '('.$id.','.$group_id.')';
				}

				$this->_db->setQuery(
					'INSERT IGNORE INTO `#__user_usergroup_map` (`user_id`, `group_id`)' .
					' VALUES '.implode(',', $tuples)
				);

				// Check for database errors.
				if (!$this->_db->query()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}

			// Set the ACL mode back to it's previous state.
			$acl->setCheckMode($oldAclMode);
		}

		return true;
	}

	/**
	 * Gets the available groups.
	 *
	 * @return	array
	 * @since	1.6
	 */
	public function getGroups()
	{
		$model = JModel::getInstance('Groups', 'UsersModel', array('ignore_request' => true));
		return $model->getItems();
	}

	/**
	 * Gets the groups this object is assigned to
	 *
	 * @return	array
	 * @since	1.6
	 */
	public function getAssignedGroups($userId = null)
	{
		// Initialise variables.
		$userId = (!empty($userId)) ? $userId : (int)$this->getState('user.id');

		if (empty($userId)) {
			$result = array();
			$config = JComponentHelper::getParams('com_users');
			if ($groupId = $config->get('new_usertype')) {
				$result[$groupId] = null;
			}
		} else {
			jimport('joomla.user.helper');
			$result = JUserHelper::getUserGroups($userId);
		}

		return $result;
	}
}
