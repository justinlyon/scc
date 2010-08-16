<?php
/**
 * @version		$Id: helper.php 17854 2010-06-23 17:43:55Z eddieajau $
 * @package		Joomla.Framework
 * @subpackage	Client
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die();

/**
 * Client helper class
 *
 * @static
 * @package		Joomla.Framework
 * @subpackage	Client
 * @since		1.5
 */
class JClientHelper
{
	/**
	 * Method to return the array of client layer configuration options
	 *
	 * @param	string	Client name, currently only 'ftp' is supported
	 * @param	boolean	Forces re-creation of the login credentials. Set this to
	 *					true if login credentials in the session storage have changed
	 *
	 * @return	array	Client layer configuration options, consisting of at least
	 *					these fields: enabled, host, port, user, pass, root
	 * @since	1.5
	 */
	public static function getCredentials($client, $force=false)
	{
		static $credentials = array();

		$client = strtolower($client);

		if (!isset($credentials[$client]) || $force) {
			// Initialise variables.
			$config = JFactory::getConfig();

			// Fetch the client layer configuration options for the specific client
			switch ($client) {
				case 'ftp':
					$options = array(
						'enabled'	=> $config->get('ftp_enable'),
						'host'		=> $config->get('ftp_host'),
						'port'		=> $config->get('ftp_port'),
						'user'		=> $config->get('ftp_user'),
						'pass'		=> $config->get('ftp_pass'),
						'root'		=> $config->get('ftp_root')
					);
					break;

				default:
					$options = array(
						'enabled'	=> false,
						'host'		=> '',
						'port'		=> '',
						'user'		=> '',
						'pass'		=> '',
						'root'		=> ''
					);
					break;
			}

			// If user and pass are not set in global config lets see if its in the session
			if ($options['enabled'] == true && ($options['user'] == '' || $options['pass'] == '')) {
				$session = JFactory::getSession();
				$options['user'] = $session->get($client.'.user', null, 'JClientHelper');
				$options['pass'] = $session->get($client.'.pass', null, 'JClientHelper');
			}

			// If user or pass are missing, disable this client
			if ($options['user'] == '' || $options['pass'] == '') {
				$options['enabled'] = false;
			}

			// Save the credentials for later use
			$credentials[$client] = $options;
		}

		return $credentials[$client];
	}

	/**
	 * Method to set client login credentials
	 *
	 * @param	string	Client name, currently only 'ftp' is supported
	 * @param	string	Username
	 * @param	string	Password
	 *
	 * @return	boolean	True if the given login credentials have been set and are valid
	 * @since	1.5
	 */
	public static function setCredentials($client, $user, $pass)
	{
		$return = false;
		$client = strtolower($client);

		// Test if the given credentials are valid
		switch ($client) {
			case 'ftp':
				$config = JFactory::getConfig();
				$options = array(
					'enabled'	=> $config->get('ftp_enable'),
					'host'		=> $config->get('ftp_host'),
					'port'		=> $config->get('ftp_port'),
				);

				if ($options['enabled']) {
					jimport('joomla.client.ftp');
					$ftp = JFTP::getInstance($options['host'], $options['port']);

					// Test the conection and try to log in
					if ($ftp->isConnected()) {
						if ($ftp->login($user, $pass)) {
							$return = true;
						}
						$ftp->quit();
					}
				}
				break;

			default:
				break;
		}

		if ($return) {
			// Save valid credentials to the session
			$session = JFactory::getSession();
			$session->set($client.'.user', $user, 'JClientHelper');
			$session->set($client.'.pass', $pass, 'JClientHelper');

			// Force re-creation of the data saved within JClientHelper::getCredentials()
			JClientHelper::getCredentials($client, true);
		}

		return $return;
	}

	/**
	 * Method to determine if client login credentials are present
	 *
	 * @static
	 * @param	string	Client name, currently only 'ftp' is supported
	 * @return	boolean	True if login credentials are available
	 * @since	1.5
	 */
	public static function hasCredentials($client)
	{
		$return = false;
		$client = strtolower($client);

		// Get (unmodified) credentials for this client
		switch ($client) {
			case 'ftp':
				$config = JFactory::getConfig();
				$options = array(
					'enabled'	=> $config->get('ftp_enable'),
					'user'		=> $config->get('ftp_user'),
					'pass'		=> $config->get('ftp_pass')
				);
				break;

			default:
				$options = array(
					'enabled'	=> false,
					'user'		=> '',
					'pass'		=> ''
				);
				break;
		}

		if ($options['enabled'] == false) {
			// The client is disabled in global config, so let's pretend we are OK
			$return = true;
		} else if ($options['user'] != '' && $options['pass'] != '') {
			// Login credentials are available in global config
			$return = true;
		} else {
			// Check if login credentials are available in the session
			$session = JFactory::getSession();
			$user = $session->get($client.'.user', null, 'JClientHelper');
			$pass = $session->get($client.'.pass', null, 'JClientHelper');
			if ($user != '' && $pass != '') {
				$return = true;
			}
		}

		return $return;
	}

	/**
	 * Determine wether input fields for client settings need to be shown
	 *
	 * If valid credentials were passed along with the request, they are saved to the session.
	 * This functions returns an exeption if invalid credentials have been given or if the
	 * connection to the server failed for some other reason.

	 * @static
	 * @return	boolean|JExeption	True, if FTP settings should be shown, or an exeption
	 * @since	1.5
	 */
	public static function setCredentialsFromRequest($client)
	{
		// Determine wether FTP credentials have been passed along with the current request
		$user = JRequest::getString('username', null, 'POST', JREQUEST_ALLOWRAW);
		$pass = JRequest::getString('password', null, 'POST', JREQUEST_ALLOWRAW);
		if ($user != '' && $pass != '')
		{
			// Add credentials to the session
			if (JClientHelper::setCredentials($client, $user, $pass)) {
				$return = false;
			} else {
				$return = JError::raiseWarning('SOME_ERROR_CODE', JText::_('JLIB_CLIENT_ERROR_HELPER_SETCREDENTIALSFROMREQUEST_FAILED'));
			}
		}
		else
		{
			// Just determine if the FTP input fields need to be shown
			$return = !JClientHelper::hasCredentials('ftp');
		}

		return $return;
	}
}