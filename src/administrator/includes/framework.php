<?php
/**
 * @version		$Id: framework.php 17837 2010-06-22 22:49:50Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	Application
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/*
 * Joomla! system checks.
 */

@set_magic_quotes_runtime(0);
@ini_set('zend.ze1_compatibility_mode', '0');

/*
 * Installation check, and check on removal of the install directory.
 */
if (!file_exists(JPATH_CONFIGURATION.DS.'configuration.php') || (filesize(JPATH_CONFIGURATION.DS.'configuration.php') < 10) /*|| file_exists(JPATH_INSTALLATION.DS.'index.php')*/) {
	header('Location: ../installation/index.php');
	exit();
}

/*
 * Joomla! system startup
 */

// System includes.
require_once JPATH_LIBRARIES.DS.'joomla'.DS.'import.php';

// Pre-Load configuration.
require_once JPATH_CONFIGURATION.DS.'configuration.php';

// System configuration.
$CONFIG = new JConfig();

if (@$CONFIG->error_reporting === 0) {
	error_reporting(0);
} else if (@$CONFIG->error_reporting > 0) {
	error_reporting($CONFIG->error_reporting);
	ini_set('display_errors', 1);
}

define('JDEBUG', $CONFIG->debug);

unset($CONFIG);

/*
 * Joomla! framework loading.
 */

// System profiler.
if (JDEBUG) {
	jimport('joomla.error.profiler');
	$_PROFILER = JProfiler::getInstance('Application');
}

// Joomla! library imports.
jimport('joomla.application.menu');
jimport('joomla.user.user');
jimport('joomla.environment.uri');
jimport('joomla.html.html');
jimport('joomla.html.parameter');
jimport('joomla.utilities.utility');
jimport('joomla.event.event');
jimport('joomla.event.dispatcher');
jimport('joomla.language.language');
jimport('joomla.utilities.string');