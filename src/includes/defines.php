<?php
/**
 * @version		$Id: defines.php 14551 2010-02-04 06:47:48Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	Application
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Joomla! Application define.
 */

//Global definitions.
//Joomla framework path definitions.
$parts = explode(DS, JPATH_BASE);

//Defines.
define('JPATH_ROOT',			implode(DS, $parts));

define('JPATH_SITE',			JPATH_ROOT);
define('JPATH_CONFIGURATION',	JPATH_ROOT);
define('JPATH_ADMINISTRATOR',	JPATH_ROOT.DS.'administrator');
define('JPATH_LIBRARIES',		JPATH_ROOT.DS.'libraries');
define('JPATH_PLUGINS',			JPATH_ROOT.DS.'plugins'  );
define('JPATH_INSTALLATION',	JPATH_ROOT.DS.'installation');
define('JPATH_THEMES',			JPATH_BASE.DS.'templates');
define('JPATH_CACHE',			JPATH_BASE.DS.'cache');
define('JPATH_MANIFESTS',		JPATH_ADMINISTRATOR.DS.'manifests');