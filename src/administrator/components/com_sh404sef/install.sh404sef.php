<?php
/**
 * SEF module for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: install.sh404sef.php 1436 2010-05-25 17:49:42Z silianacom-svn $
 *
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

global $mainframe;
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.path');
jimport('joomla.html.parameter');
jimport('joomla.filter.filterinput');
jimport('joomla.utilities.string');

$front_live_site = rtrim(str_replace('/administrator', '', JURI::base()), '/');
$database	= & JFactory::getDBO();
// V 1.2.4.t improved upgrade data preservation
// V 1.2.4.q Copy existing config file from /media to current component. Used to recover configuration when upgrading
// V 1.2.4.s check if old file exists before deleting stub config file
$oldConfigFile = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_'
.str_replace('/','_',str_replace('http://', '', $front_live_site)).'.php';
if (JFile::exists($oldConfigFile)) {
  // update old config files from VALID_MOS check to _JEXEC
  $config = JFile::read($oldConfigFile);
  if ($config && strpos( $config, 'VALID_MOS') !== false) {
    $config = str_replace( 'VALID_MOS', '_JEXEC', $config);
    JFile::write( $oldConfigFile, $config);  // write it back
  }
  // now get back old config
  if (JFile::exists( JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'config' . DS . 'config.sef.php')) {
    JFile::delete(JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'config' . DS . 'config.sef.php');
  }
  JFile::copy( $oldConfigFile, JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'.DS.'config'.DS.'config.sef.php' );
}

// restore log files
$folder = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs';
if (JFolder::exists( $folder)) {
  $fileList = JFolder::files( $folder);
  if (!empty( $fileList)) {
    foreach( $fileList as $file) {
      JFile::copy(JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs'.DS.$file,
      JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs'.DS.$file);
    }
  }
}

// restore black/white lists
$folder = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security';
if (JFolder::exists( $folder)) {
  $fileList = JFolder::files( $folder);
  if (!empty( $fileList)) {
    foreach( $fileList as $file) {
      if (JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file)) {
        JFile::delete(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file);
      }
      JFile::copy(JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security'.DS.$file,
      JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file);
    }
  }
}

// restore customized default params
$oldCustomConfigFile = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_'
.str_replace('/','_',str_replace('http://', '', $front_live_site)).'.custom.php';
if (is_readable($oldCustomConfigFile) && filesize($oldCustomConfigFile) > 1000) {
  // update old config files from VALID_MOS check to _JEXEC
  $config = JFile::read($oldCustomConfigFile);
  if ($config && strpos( $config, 'VALID_MOS') !== false) {
    $config = str_replace( 'VALID_MOS', '_JEXEC', $config);
    JFile::write( $oldCustomConfigFile, $config);  // write it back
  }
  if (JFile::exists( JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'custom.sef.php')) {
    JFile::delete(JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'custom.sef.php');
  }
  $result = JFile::copy( $oldCustomConfigFile, JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'custom.sef.php' );
}
$sef_config_class = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'sh404sef.class.php';
// Make sure class was loaded.
if (!class_exists('SEFConfig')) {   // V 1.2.4.T was wrong variable name $SEFConfig_class instead of $sef_config_class
  if (is_readable($sef_config_class)) require_once($sef_config_class);
  else JError::RaiseError( 500, COM_SH404SEF_NOREAD."( $sef_config_class )<br />".COM_SH404SEF_CHK_PERMS);
}
$sefConfig = new SEFConfig();

// install plugins
$status = shInstallPluginGroup( 'system');
$status = shInstallPluginGroup( 'sh404sefcore');

// now we insert the 404 error page into the database
// from version 1.5.5, the default content of 404 page has been largely modified
// to make use of the similar urls plugin (and potentially others)
// so we want to make sure people will have the new version of the 404 error page
shUpdateErrorPage();

// apply various DB updates
shUpdateDBStructure();


// message
if (file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'shsef.php')) {

  // success !
  echo '<div style="text-align: justify;">';
  echo '<h1>sh404SEF installed succesfully! Please read the following</h1>';
  echo 'If it is the first time you use sh404SEF, it has been installed but is <strong>disabled</strong> right now. You must first edit sh404SEF configuration (from the <a href="index.php?option=com_sh404sef" >sh404SEF Components</a> menu item of Joomla backend), <strong>enable it and save</strong> before it will become active. Before you do so, please read the next paragraphs which have important information for you.  If you are upgrading from a previous version of sh404SEF, then all your settings have been preserved, the component is activated and you can start browsing your site frontpage right away.';
  echo '<br /><br />';
  echo '<strong><font color="red">IMPORTANT</font></strong> : sh404SEF can operate under two modes : <strong><font color="red">WITH</font></strong> or <strong><font color="red">WITHOUT .htaccess</font></strong> file. The default setting is now to work <strong>without .htaccess file</strong>. I recommend you use it if you are not familiar with web servers, as it is generally difficult to find the right content for a .htaccess file.<br /><br />';
  echo '<strong>Without .htaccess file</strong> : simply go to sh404SEF configuration screen, review parameters, and save config. You can now browse the frontpage of your site to start generating SEF URL.<br />';
  echo '<strong>With .htaccess</strong> : you must activate this operating mode. To do so, go to sh404SEF configuration, select the Advanced tab, locate the "Rewrite mode" drop-down list and select \'with .htaccess\'. Then Save configuration and answer Ok when prompted to erase URl cache. However, before you can activate sh404SEF, you have to setup a .htaccess file. This file content depends on your hosting setup, so it is nearly impossible to tell you what should be in it. Joomla comes with the most generic .htaccess file. It will probably work right away on your system, or may need adjustments. The Joomla supplied file is called htaccess.txt, is located in the root directory of your site, and must be renamed into .htaccess before it will have any effect. You will find additional information about .htaccess at <a target="_blank" href="http://dev.anything-digital.com/FAQs/sh404SEF/">dev.anything-digital.com/FAQs/sh404SEF/</a>.<br /><br />';
  echo '<strong><font color="red">IMPORTANT</font><strong>: sh404SEF can build SEF URL for many Joomla components. It does it through a <strong>"plugin" system</strong>, and comes with a dedicated plugin for each of Joomla standard components (Contact, Weblinks, Newsfeed, Content of course,...). It also comes with native plugins for common components such as Community Builder, Fireboard, Virtuemart, Sobi2,... sh404SEF can also automatically make use of plugins designed for other SEF components such as OpenSEF or SEF Advanced. Such plugins are often delivered and installed automatically when you install a component. Please note that when using these "foreign" plugins, you may experience compatibility issues.<br />However, Joomla having several hundreds extensions available, not all of them have a plugin to tell sh404SEF how its URL should be built. When it does not have a plugin for a given component, sh404SEF will switch back to Joomla 1.0.x standard SEF URL, similar to mysite.com/component/option,com_sample/task,view/id,23/Itemid,45/. This is normal, and can\'t be otherwise unless someone writes a plugin for this component (your assistance in doing so is very much welcomed! Please post on the support forum if you have written a plugin for a component).<br />';
  echo '<br />';
  echo 'You will also find more documentation on our <a target="_blank" href="http://dev.anything-digital.com/sh404SEF/user-manual.html">web site</a>';
  echo '<br />';

  echo  '<p class="message">Please <strong>read the documentation : it is available on <a href="index.php?option=com_sh404sef&task=info" >sh404SEF main control panel</a></p>';

} else  {
  echo '<strong><font color="red">Sorry, something went wrong while installing sh404SEF on your web site. Please try uninstalling first, then check permissions on your file system, and make sure Joomla can write to the /plugin directory. Or contact your site administrator for assistance. <br>You can also report this on our website at <a target="_blank" href="http://dev.anything-digital.com/Forum/39-sh404SEF/" >our support forum.</a></font>';
}



/**
 * Insert into the content database an uncategorized article
 * which serves as a basis for the 404 error page
 * Article title is __404__
 * Prior to version 1.5.5, the article displayed for 404 errors
 * was titled 404. The new name ensures users who customized
 * will keep their old design in the db. They can either reselect it
 * from the control panel, or customize as well the new __404__ page
 * @return unknown_type
 */
function shUpdateErrorPage( $pageTitle = '__404__') {

  // get a db instance
  $db = & JFactory::getDBO();

  // do we already have a __404__ article?
  $query = 'select id from #__content where catid=0 and sectionid=0 and title=' . $db->quote( $pageTitle);
  $db->setQuery( $query);
  $id = $db->loadResult();

  // if required page is already there, go away
  if (!empty( $id)) {
    return;
  }

  // find about the default page content
  include_once(JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'language/english.php');

  // now we can insert the new page content into the db
  $status = shInsertContent( $pageTitle, COM_SH404SEF_DEF_404_MSG);

  return $status;
}

/**
 * Performs update to db stucture on existing setups
 */
function shUpdateDBStructure() {

  // get a db instance
  $db = & JFactory::getDBO();

  /* Version 2.0. added 'type' and 'hits' columns to aliases table
   CREATE TABLE IF NOT EXISTS `#__sh404sef_aliases` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `newurl` varchar(255) NOT NULL DEFAULT '',
   `alias` varchar(255) NOT NULL DEFAULT '',
   `type` tinyint(3) NOT NULL DEFAULT '0',
   `hits` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`),
   KEY `newurl` (`newurl`),
   KEY `alias` (`alias`),
   KEY `type` (`type`)
   )*/

  // get list of columns
  $columns = $db->getTableFields( '#__sh404sef_aliases');

  // build required statements
  $subQueries = array();

  // check if new columns are there, add if not
  if (empty( $columns['#__sh404sef_aliases']['type'])) {
    $subQueries[]= 'add `type` tinyint(3) not null default "0"';
    $subQueries[]= 'add index `type` ( `type` )';
  }
  if (empty( $columns['#__sh404sef_aliases']['hits'])) {
    $subQueries[]= 'add `hits` int(11) NOT NULL DEFAULT "0"';
  }

  if (!empty( $subQueries)) {
    // aggregate sub-queries
    $subQueries = implode( ', ', $subQueries);

    // prepend query
    $query = 'alter table ' . $db->nameQuote( '#__sh404sef_aliases') . $subQueries;

    // run query
    $db->setQuery( $query);
    $db->query();
    $error = $db->getErrorNum();
    if (!empty( $error)) {
      global $mainframe;
      $mainframe->enqueueMessage( 'Error while upgrading the database : ' . $db->getErrorMsg(true)
      . '. Sh404SEF will probably not operate properly. Please uninstall it, then try again after checking your database server setup. Contact us in case this happens again.');
    }
  }

  // version 2.0 : added separate table for pageids
  /*
   * CREATE TABLE IF NOT EXISTS `#__sh404sef_pageids` (
   `id` int(11) NOT NULL auto_increment,
   `newurl` varchar(255) NOT NULL default '',
   `pageid` varchar(255) NOT NULL default '',
   `type` tinyint(3) NOT NULL DEFAULT '0',
   `hits` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`),
   KEY `newurl` (`newurl`),
   KEY `alias` (`pageid`),
   KEY `type` (`type`)
   ) TYPE=MyISAM CHARACTER SET `utf8`;
   */

  $query = 'CREATE TABLE IF NOT EXISTS `#__sh404sef_pageids` (
        `id` int(11) NOT NULL auto_increment,
        `newurl` varchar(255) NOT NULL default \'\',
        `pageid` varchar(255) NOT NULL default \'\',
        `type` tinyint(3) NOT NULL DEFAULT \'0\',
        `hits` int(11) NOT NULL DEFAULT \'0\',
        PRIMARY KEY (`id`),
        KEY `newurl` (`newurl`),
        KEY `alias` (`pageid`),
        KEY `type` (`type`)
        ) TYPE=MyISAM DEFAULT CHARACTER SET utf8;';

  // run query
  $db->setQuery( $query);
  $db->query();
  $error = $db->getErrorNum();
  if (!empty( $error)) {
    global $mainframe;
    $mainframe->enqueueMessage( 'Error while upgrading the database : ' . $db->getErrorMsg(true)
    . '. Sh404SEF will probably not operate properly. Please uninstall it, then try again after checking your database server setup. Contact us in case this happens again.');
  }
  
}

/**
 * Install all sh404sef plugins available in a given
 * group
 *
 * @param string $group name of group
 * @return boolean, true if success
 */
function shInstallPluginGroup( $group) {

  global $mainframe;

  $sourcePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'plugins'.DS.$group;

  // collect xml manifest files for all plugins in the source dir
  if (JFolder::exists( $sourcePath)) {
    $pluginList = JFolder::files( $sourcePath, '.xml$', $recurse = false, $fullpath = true);
  }

  if (empty( $pluginList)) {
    return false;
  }

  // process each plugin
  $errors = false;
  foreach( $pluginList as $pluginXMLFile) {
    // install the plugin itself
    $status = shInstallPlugin( $sourcePath, $pluginXMLFile, $group);
    // set flag if an error happened, but keep installing
    // other plugins
    $errors = $errors && $status;
    // also display status
    if (!$status) {
      $mainframe->enqueueMessage( 'Error installing sh404sef plugin from ' . $pluginXMLFile);
    }
  }

  // return true if no error at all
  return $errors == false;
}

/**
 * Install a plugin into the database, based on its xml file
 *
 * @param string $sourcePath directory where plugin files are found
 * @param $xmlFileName fullpath to xml manifest file
 * @param string $group name of group
 * @return boolean, true if success
 */
function shInstallPlugin( $sourcePath, $xmlFileName, $group) {


  $status = false;

  // get a Joomla xml file handler
  $xml  =& JFactory::getXMLParser('Simple');

  // read content from disk
  if (!$xml->loadFile($xmlFileName)) {
    return $status;
  }

  $root =& $xml->document;

  // find name of plugin
  $pluginName = $root->getElementByPath( 'name');
  $pluginName = JFilterInput::clean($pluginName->data(), 'string');

  // if we have a valid manifest file, process it
  if (!is_object($root) || $root->name() != 'install' || $root->attributes('type') != 'plugin' || $root->attributes('group') != $group) {
    return $status;
  }

  // process parameters
  $element = $root->getElementByPath( 'params');
  $params = $element->children();

  // build up the ini version of params (to be stored in the params columns of
  // joomla plugins table and extract our information
  // Process each parameter in the $params array.
  $pluginParams = '';
  if (!empty( $params)) {
    foreach ($params as $param) {
      if (!$name = $param->attributes('name')) {
        continue;
      }

      if (!$value = $param->attributes('default')) {
        continue;
      }

      // find element
      if ($name == 'plugin_element') {
        $pluginElement = $value;
      }

      // find folder
      if ($name == 'plugin_folder') {
        $pluginFolder = $value;
      }

      // build raw param string
      $pluginParams .= $name."=".$value."\n";
    }
  }

  // create configuration array
  $shConfig = array('name'=>$pluginName, 'element' => $pluginElement, 'folder'=>$pluginFolder,
      'access'=>0, 'ordering'=>10, 'published' => 1, 'iscore' => 0, 'client_id' => 0, 'checked_out' => 0, 
      'checked_out_time' => '0000-00-00 00:00:00',  'params'=>$pluginParams);

  // search for files
  $element = $root->getElementByPath( 'files');
  $filesElements = $element->children();
  // always include xml manifest file
  $files = array( $pluginElement . '.xml');
  $folders = array( $pluginFolder);
  $foldersToCopy = array();

  // then add other files listed in the manifest
  if (!empty( $filesElements)) {
    foreach($filesElements as $fileElement) {
      if ($fileElement->name() == 'filename') {
        $file = $fileElement->data();
        $files[] = $file;
        // check for subfolders
        if (JString::strpos( $file, '/') !== false) {
          // there is a subfolder in the path, add to list of folders
          $bits = explode( '/', $file);
          // remove the file name itself
          $bits = array_pop( $bits);
          // add remaining folders to list, removing duplicates
          foreach( $bits as $bit) {
            if (!in_array( $bit, $folders)) {
              $folders[] = $bit;
            }
          }
        }
      } else if($fileElement->name() == 'folder') {
        // we should recurse through all sub folders as well!
        $foldersToCopy[] = $fileElement->data();
      }
    }
  }

  // now copy files and insert into db
  if (!empty( $pluginName) && !empty( $pluginElement) && !empty( $pluginFolder)) {
    shInsertPlugin( $sourcePath, $shConfig, $files, $folders, $foldersToCopy);
    $status = true;
  }

  return $status;
}

/**
 * Insert in the db the previously retrieved parameters for a plugin
 * including publication information. Also move files as required
 *
 * @param string $basePath , the base path to get original files from
 * @param array $shConfig an array holding the database parameters of the plugin
 * @param array $files, an array holding list of files from the plugin
 */
function shInsertPlugin( $basePath, $shConfig, $files, $folders, $foldersToCopy) {

  // check data
  if (empty( $files)) {
    return;
  }

  // move the files to target location
  $result = array();
  $resultFolders = array();
  $success = true;
  // create folders as needed
  if (!empty( $folders)) {
    foreach( $folders as $folder) {
      $success = $success && JFolder::create( JPATH_ROOT.DS.'plugins'.DS. $folder);
    }
  }

  // copy raw folders as needed
  if (!empty( $foldersToCopy)) {
    foreach( $foldersToCopy as $folder) {
      $success = $success && JFolder::copy(
      JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'plugins'. DS . $shConfig['folder'] . DS . $folder,
      JPATH_ROOT.DS.'plugins'.DS. $shConfig['folder'] . DS . $folder);
      $result[$folder] = $success;
    }
  }

  // now move files across
  if ($success) {
    foreach( $files as $pluginFile) {

      $target = JPath::clean( JPATH_ROOT.DS.'plugins'.DS.$shConfig['folder'].DS.$pluginFile);
      $source = JPath::clean( $basePath.DS.$pluginFile);
      $success = $success && true === JFile::copy( $source, $target);
      $resultFolders[$pluginFile] = $success;
    }
  }
  // if files moved to destination, setup plugin in Joomla database
  if ($success) {
    // read stored params from disk
    shGetExtensionSavedParams( $shConfig['folder'] . '.' . $shConfig['element'], $shConfig);

    // insert elements in db
    $db = &JFactory::getDBO();
    $sql="INSERT INTO `#__plugins` ( `name`, `element`, `folder`, `access`, `ordering`, `published`,"
    . " `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)"
    . " VALUES ('{$shConfig['name']}', '{$shConfig['element']}', '{$shConfig['folder']}', '{$shConfig['access']}', '{$shConfig['ordering']}',"
    . " '{$shConfig['published']}', '{$shConfig['iscore']}', '{$shConfig['client_id']}', '{$shConfig['checked_out']}',"
    . " '{$shConfig['checked_out_time']}', '{$shConfig['params']}');";
    $db->setQuery( $sql);
    $db->query();
  } else {
    // don't leave anything behind
    foreach( $files as $pluginFile) {
      if ($result[$pluginFile]) {
        // if file was copied, try to delete it
        JFile::delete( JPATH_ROOT.DS.'plugins' . DS . $shConfig['folder'] . DS . $pluginFile);
      }
    }
    // also delete folders
    if (!empty( $resultFolders)) {
      foreach( $resultFolders as $folder) {
        if ($resultFolders[$folder]) {
          // if file was copied, try to delete it
          JFolder::delete( JPATH_ROOT.DS.'plugins' . DS . $shConfig['folder'] . DS . $folder);
        }
      }
    }
    JError::RaiseWarning( 500, JText::_('Could not install plugin'));
  }

  return $success;
}

/**
 * Retrieves stored params of a given extension (module or plugin)
 * (as saved upon uninstall)
 *
 * @param string $extName the module name, including mod_ if a module
 * @param array $shConfig an array holding the database columns of the extension
 * @param array $shPub, an array holding the publication information of the module (only for modules)
 * @return boolean, true if any stored parameters were found for this extension
 */
function shGetExtensionSavedParams( $extName, &$shConfig, &$shPub = null, $useId = false) {

  static $fileList = array();

  // prepare default return value
  $status = false;

  // read all file names in /media/sh404_upgrade_conf dir, for easier processing
  $baseFolder = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf';
  if (JFolder::exists( $baseFolder) && (empty( $fileList) || !isset($fileList[$extName]))) {
    $baseName = $extName . ($useId ? '_[0-9]{1,10}':'').'_'.str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';
    $fileList[$extName] = JFolder::files( $baseFolder, $baseName);
  }

  // extract filename from list we've established previously
  $extFile = isset($fileList[$extName]) && $fileList[$extName] !== false ? array_shift( $fileList[$extName]) : '';
  if (empty( $fileList[$extName])) {
    // prevent infinite loop
    $fileList[$extName] = false;
  }

  if (!empty( $extFile) && JFile::exists( $baseFolder . DS . $extFile)) {
    $status = true; // operation was successful
    include( $baseFolder . DS . $extFile);
  }

  return $status;
}

