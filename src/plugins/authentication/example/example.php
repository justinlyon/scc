<?php
/**
 * @version		$Id: example.php 16736 2010-05-04 06:08:34Z eddieajau $
 * @package		Joomla
 * @subpackage	JFramework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Example Authentication Plugin
 *
 * @package		Joomla
 * @subpackage	JFramework
 * @since 1.5
 */
class plgAuthenticationExample extends JPlugin
{
	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @access	public
	 * @param	array	$credentials	Array holding the user credentials
	 * @param	array	$options		Array of extra options
	 * @param	object	$response		Authentication response object
	 * @return	boolean
	 * @since	1.5
	 */
	function onUserAuthenticate($credentials, $options, &$response)
	{
		/*
		 * Here you would do whatever you need for an authentication routine with the credentials
		 *
		 * In this example the mixed variable $return would be set to false
		 * if the authentication routine fails or an integer userid of the authenticated
		 * user if the routine passes
		 */
		$success = true;
		$response->type = 'Example';
		if ($success)
		{
			$response->status			= JAUTHENTICATE_STATUS_SUCCESS;
			$response->error_message	= '';
			// You may also define other variables:
			/*
			$yourUser					= YourClass::getUser($credentials);
			$response->email			= $yourUser->email;
			$response->fullname			= $yourUser->name;
			*/
			return true;
		}
		else
		{
			$response->status			= JAUTHENTICATE_STATUS_FAILURE;
			$response->error_message	= 'Could not authenticate';
			return false;
		}
	}
}
