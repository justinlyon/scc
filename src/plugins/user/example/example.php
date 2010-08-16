<?php
/**
 * @version		$Id: example.php 17851 2010-06-23 17:39:31Z eddieajau $
 * @package		Joomla
 * @subpackage	JFramework
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Example User Plugin
 *
 * @package		Joomla
 * @subpackage	JFramework
 * @since		1.5
 */
class plgUserExample extends JPlugin
{
	/**
	 * Example store user method
	 *
	 * Method is called before user data is stored in the database
	 *
	 * @param	array		holds the old user data
	 * @param	boolean		true if a new user is stored
	 * @param	array		holds the new user data
	 */
	function onUserBeforeSave($user, $isnew, $new)
	{
		$app = JFactory::getApplication();
	}

	/**
	 * Example store user method
	 *
	 * Method is called after user data is stored in the database
	 *
	 * @param	array		holds the new user data
	 * @param	boolean		true if a new user is stored
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onUserAfterSave($user, $isnew, $success, $msg)
	{
		$app = JFactory::getApplication();

		// convert the user parameters passed to the event
		// to a format the external application

		$args = array();
		$args['username']	= $user['username'];
		$args['email']		= $user['email'];
		$args['fullname']	= $user['name'];
		$args['password']	= $user['password'];

		if ($isnew)
		{
			// Call a function in the external app to create the user
			// ThirdPartyApp::createUser($user['id'], $args);
		}
		else
		{
			// Call a function in the external app to update the user
			// ThirdPartyApp::updateUser($user['id'], $args);
		}
	}

	/**
	 * Example store user method
	 *
	 * Method is called before user data is deleted from the database
	 *
	 * @param	array		holds the user data
	 */
	function onUserBeforeDelete($user)
	{
		$app = JFactory::getApplication();
	}

	/**
	 * Example store user method
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param	array		holds the user data
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onUserAfterDelete($user, $succes, $msg)
	{
		$app = JFactory::getApplication();

		// only the $user['id'] exists and carries valid information

		// Call a function in the external app to delete the user
		// ThirdPartyApp::deleteUser($user['id']);
	}

	/**
	 * This method should handle any login logic and report back to the subject
	 *
	 * @access	public
	 * @param	array	holds the user data
	 * @param	array	extra options
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function onUserLogin($user, $options)
	{
		// Initialise variables.
		$success = false;

		// Here you would do whatever you need for a login routine with the credentials
		//
		// Remember, this is not the authentication routine as that is done separately.
		// The most common use of this routine would be logging the user into a third party
		// application.
		//
		// In this example the boolean variable $success would be set to true
		// if the login routine succeeds

		// ThirdPartyApp::loginUser($user['username'], $user['password']);

		return $success;
	}

	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @access public
	 * @param array holds the user data
	 * @return boolean True on success
	 * @since 1.5
	 */
	function onUserLogout($user)
	{
		// Initialise variables.
		$success = false;

		// Here you would do whatever you need for a logout routine with the credentials
		//
		// In this example the boolean variable $success would be set to true
		// if the logout routine succeeds

		// ThirdPartyApp::loginUser($user['username'], $user['password']);

		return $success;
	}
}
