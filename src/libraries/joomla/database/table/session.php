<?php
/**
 * @version		$Id: session.php 16903 2010-05-07 16:50:47Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Session table
 *
 * @package		Joomla.Framework
 * @subpackage	Table
 * @since		1.0
 */
class JTableSession extends JTable
{
	/**
	 * Constructor
	 * @param database A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__session', 'session_id', $db);

		$this->guest	= 1;
		$this->username = '';
	}

	function insert($sessionId, $clientId)
	{
		$this->session_id	= $sessionId;
		$this->client_id	= $clientId;

		$this->time = time();
		$ret = $this->_db->insertObject($this->_tbl, $this, 'session_id');

		if (!$ret) {
			$this->setError(JText::sprintf('JLIB_DATABASE_ERROR_STORE_FAILED', strtolower(get_class($this)), $this->_db->stderr()));
			return false;
		} else {
			return true;
		}
	}

	function update($updateNulls = false)
	{
		$this->time = time();
		$ret = $this->_db->updateObject($this->_tbl, $this, 'session_id', $updateNulls);

		if (!$ret) {
			$this->setError(JText::sprintf('JLIB_DATABASE_ERROR_STORE_FAILED', strtolower(get_class($this)), $this->_db->stderr()));
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Destroys the pesisting session
	 */
	function destroy($userId, $clientIds = array())
	{
		$clientIds = implode(',', $clientIds);

		$query = 'DELETE FROM #__session'
			. ' WHERE userid = '. $this->_db->Quote($userId)
			. ' AND client_id IN ('.$clientIds.')'
			;
		$this->_db->setQuery($query);

		if (!$this->_db->query()) {
			$this->setError($this->_db->stderr());
			return false;
		}

		return true;
	}

	/**
	* Purge old sessions
	*
	* @param int	Session age in seconds
	* @return mixed Resource on success, null on fail
	*/
	function purge($maxLifetime = 1440)
	{
		$past = time() - $maxLifetime;
		$query = 'DELETE FROM '. $this->_tbl .' WHERE (time < \''. (int) $past .'\')'; // Index on 'VARCHAR'
		$this->_db->setQuery($query);

		return $this->_db->query();
	}

	/**
	 * Find out if a user has a one or more active sessions
	 *
	 * @param int $userid The identifier of the user
	 * @return boolean True if a session for this user exists
	 */
	function exists($userid)
	{
		$query = 'SELECT COUNT(userid) FROM #__session'
			. ' WHERE userid = '. $this->_db->Quote($userid);
		$this->_db->setQuery($query);

		if (!$result = $this->_db->loadResult()) {
			$this->setError($this->_db->stderr());
			return false;
		}

		return (boolean) $result;
	}

	/**
	 * Overloaded delete method
	 *
	 * We must override it because of the non-integer primary key
	 *
	 * @access public
	 * @return true if successful otherwise returns and error message
	 */
	function delete($oid=null)
	{
		//if (!$this->canDelete($msg))
		//{
		//	return $msg;
		//}

		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = $oid;
		}

		$query = 'DELETE FROM '.$this->_db->nameQuote($this->_tbl).
				' WHERE '.$this->_tbl_key.' = '. $this->_db->Quote($this->$k);
		$this->_db->setQuery($query);

		if ($this->_db->query())
		{
			return true;
		}
		else
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	}
}
