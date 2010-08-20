<?php

define('DS',DIRECTORY_SEPARATOR);

define('CKEDITOR_INCLUDES_DIR','includes');

//Get root folder
$dir = explode(DS,dirname(__FILE__));
array_splice($dir,-3);
$base_folder = implode(DS,$dir);
$base_path = '';
$user = '';

define( '_JEXEC', 1 );
define('JPATH_BASE',$base_folder);

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );

/* Load in the configuation file */
require_once( JPATH_CONFIGURATION	.DS.'configuration.php' );

/*load loader class */
require_once(JPATH_LIBRARIES .DS.'loader.php' );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );

/*load joomla loader class */
require_once(JPATH_LIBRARIES .DS.'loader.php' );



require_once(JPATH_LIBRARIES .DS.'joomla'.DS .'methods.php' );

jimport('joomla.base.object');
jimport('joomla.filter.filterinput');
jimport('joomla.factory');
jimport('joomla.error.error');
jimport('joomla.environment.uri');
jimport('joomla.environment.request');
jimport('joomla.language.language');
jimport('joomla.user.user');
jimport('joomla.application.component.model');
jimport('joomla.database.table');
jimport('joomla.html.parameter');
jimport('joomla.plugin.helper');
jimport('joomla.event.dispatcher');	



/* load JCK loader class*/
require_once (CKEDITOR_INCLUDES_DIR . '/loader.php');

//lets set DB configuration
$config = new JConfig();
// Get the global configuration object
$registry =& JFactory::getConfig();
// Load the configuration values into the registry
$registry->loadObject($config);

//set session
jckimport('ckeditor.user.user');
$session =& JCKUser::getSession();

// system events trigger events
jckimport('ckeditor.plugins.helper');

//load CK System plugins
JCKPluginsHelper::storePlugins('default');

$dispatcher =& JDispatcher::getInstance();

$plugin =& JPluginHelper::getPlugin('editors','jckeditor');
$params = new JParameter($plugin->params);

$params =& JPluginHelper::getParams('editors','ckeditor'); 

//import System plugin first
JCKPluginsHelper::importPlugin('default');

$dispatcher->trigger('intialize',array( $params));

$plugin->params = $params->toString();
