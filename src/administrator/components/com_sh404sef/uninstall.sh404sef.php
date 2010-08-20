<?php

/**
 * SEF extension for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2009-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: uninstall.sh404sef.php 1479 2010-06-30 10:36:54Z silianacom-svn $
 */


defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $mainframe;
jimport('joomla.filesystem.file');
$front_live_site = JString::rtrim(str_replace('/administrator', '', JURI::base()), '/');

// V 1.2.4.t improved upgrading
function shDeletetable( $tableName) {
  $database	= & JFactory::getDBO();
  $sql = 'DROP TABLE #__'.$tableName;
  $database->setQuery( $sql);
  $database->query();
}

function shDeleteAllSEFUrl( $kind) {

  $database	= & JFactory::getDBO();
  $sql = 'DELETE FROM #__redirection WHERE ';
  If ($kind == 'Custom')
  $where = '`dateadd` > \'0000-00-00\' and `newurl` != \'\';';
  else
  $where = '`dateadd` = \'0000-00-00\';';
  $database->setQuery($sql.$where);
  $database->query();
}

/*
 *
 * Start of running code
 *
 */

$database	= & JFactory::getDBO();
// V 1.2.4.t before uninstalling modules, save their settings, if told to do so
$sef_config_class = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'sh404sef.class.php';
// Make sure class was loaded.
if (!class_exists('SEFConfig')) {
  if (is_readable($sef_config_class)) require_once($sef_config_class);
  else
  JError::RaiseError(500, COM_SH404SEF_NOREAD."( $sef_config_class )<br />".COM_SH404SEF_CHK_PERMS);
}
$sefConfig = new SEFConfig();
if (!$sefConfig->shKeepStandardURLOnUpgrade && !$sefConfig->shKeepCustomURLOnUpgrade) {
  shDeleteTable('redirection');
  shDeleteTable('sh404sef_aliases');
}
elseif (!$sefConfig->shKeepStandardURLOnUpgrade)
shDeleteAllSEFUrl('Standard');
elseif (!$sefConfig->shKeepCustomURLOnUpgrade) {
  shDeleteAllSEFUrl('Custom');
  shDeleteTable('sh404sef_aliases');
}
if (!$sefConfig->shKeepMetaDataOnUpgrade)
shDeleteTable('sh404SEF_meta');

// preserve configuration or not ?
if (!$sefConfig->shKeepConfigOnUpgrade) {
  JFile::delete( JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_'
  .str_replace('/','_',str_replace('http://', '', $front_live_site)).'.php');
  JFile::delete( JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_'
  .str_replace('/','_',str_replace('http://', '', $front_live_site)).'.custom.php');
  if ($handle = opendir(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs'.DS)) {
    while (false !== ($file = readdir($handle))) {
      if ($file != '.' && $file != '..')
      JFile::delete(JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs'.DS.$file);
    }
    closedir($handle);
  }
  if ($handle = opendir(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security/')) {
    while (false !== ($file = readdir($handle))) {
      if ($file != '.' && $file != '..')
      JFile::delete(JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security'.DS.$file);
    }
    closedir($handle);
  }
}
// must move log files out of the way, otherwise administrator/com_sh404sef/logs will not be deleted
// and next installation of com_sh404sef will fail
else { // if we keep config
  // make dest dir
  @mkdir(JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs');
  @mkdir(JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security');
  if ($handle = opendir(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs'.DS)) {
    while (false !== ($file = readdir($handle))) {
      if ($file != '.' && $file != '..' && $file != 'index.html' )
      @rename(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs'.DS.$file,
      JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs'.DS.$file);
    }
    closedir($handle);
  }
  if ($handle = opendir(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS)) {
    while (false !== ($file = readdir($handle))) {
      if ($file != '.' && $file != '..' && $file != 'index.html')
      @rename(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file,
      JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security'.DS.$file);
    }
    closedir($handle);
  }
}


// remove system plugin
shSaveDeletePluginParams( 'shsef', 'system', $folders = null);
shSaveDeletePluginParams( 'shjlang16', 'system', $folders = array( 'shjlang16'));
shSaveDeletePluginParams( 'shmobile', 'system', $folders = array( 'shmobile'));

// remove core plugins
shSaveDeletePluginGroup( 'sh404sefcore');

// remove extensions plugins
//shSaveDeletePluginGroup( 'sh404sefext');

// display results
echo '<h3>sh404SEF has been succesfully uninstalled. </h3>';
echo '<br />';
if ($sefConfig->shKeepStandardURLOnUpgrade)
echo '- automatically generated SEF url have not been deleted (table #__redirection)<br />';
else
echo '- automatically generated SEF url have been deleted<br />';
echo '<br />';
if ($sefConfig->shKeepCustomURLOnUpgrade)
echo '- custom SEF url and aliases have not been deleted (table #__redirection and sh404sef_aliases)<br />';
else
echo '- custom SEF url and aliases have been deleted<br />';
echo '<br />';
if ($sefConfig->shKeepMetaDataOnUpgrade)
echo '- Custom Title and META data have not been deleted (table #__sh404SEF_meta)<br />';
else
echo '- Custom Title and META data have been deleted<br />';
echo '<br />';

/**
 *
 * utility functions
 *
 */
/**
 * Writes an extension parameter to a disk file, located
 * in the /media directory
 *
 * @param string $extName the extension name
 * @param array $shConfig associative array of parameters of the extension, to be written to disk
 * @param array $pub, optional, only if module, an array of the menu item id where the module is published
 * @return boolean, true if no error
 */
function shWriteExtensionConfig( $extName, $params) {

  if (empty($params)) {
    return;
  }

  // calculate target file name
  $extFile = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf'.DS. $extName .'_'
  .str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';

  // remove previous if any
  if (JFile::exists( $extFile)) {
    JFile::delete( $extFile);
  }

  // prepare data for writing
  $data = '<?php // Extension params save file for sh404sef
//    
if (!defined(\'_JEXEC\')) die(\'Direct Access to this location is not allowed.\');';
  $data .= "\n";

  if (!empty( $params)) {
    foreach( $params as $key => $value) {
      $data .= '$'. $key . ' = ' . var_export($value, true) . ';';
      $data .= "\n";
    }
  }

  // write to disk
  $success = JFile::write( $extFile, $data);

  return $success !== false;
}

/**
 * Save parameters, then delete a plugin
 *
 * @param string $pluginName, the plugin name, mathcing 'element' column in plugins table
 * @param string $folder, the plugin folder (ie : 'content', 'search', 'system',...
 */
function shSaveDeletePluginParams( $pluginName, $folder, $folders = null) {

  $db = & JFactory::getDBO();

  // read plugin param from db
  $sql = 'SELECT * FROM `#__plugins` WHERE `element`= \''.$pluginName.'\' and `folder`= \''.$folder.'\'';
  $db->setQuery($sql);
  $result = $db->loadAssocList();

  if (!empty( $result)) {
    // remove plugin db id
    unset($result[0]['id']);

    // write everything on disk
    shWriteExtensionConfig( $pluginName, array('shConfig' => $result[0]));

    // now remove plugin details from db
    $db->setQuery( "DELETE FROM `#__plugins` WHERE `element`= '" . $pluginName . "' and `folder`= '".$folder."';");
    $db->query();
  }

  // delete the plugin files
  $basePath = JPATH_ROOT.DS.'plugins'. DS . $folder . DS;
  if ($folder != '' && JFile::exists($basePath . $pluginName.'.php')) {
    JFile::delete( array( $basePath . $pluginName.'.php', $basePath . $pluginName.'.xml'));
  }

  // delete plugin additional folders
  if (!empty( $folders)) {
    foreach ($folders as $aFolder) {
      if (JFolder::exists( $basePath . $aFolder)) {
        JFolder::delete( $basePath . $aFolder);
      }
    }
  }
}

/**
 * Save params, then delete plugin, for all plugins
 * in a given group
 *
 * @param $group the group to be deleted
 * @return none
 */
function shSaveDeletePluginGroup( $group) {

  $unsafe = array( 'authentication', 'content', 'editors', 'editors-xtd', 'search', 'system', 'xmlrpc');
  if (in_array( $group, $unsafe)) {
    // safety net : we don't want to delete the whole system or content folder
    return false;
  }

  // read list of plugins from db
  $db = & JFactory::getDBO();

  // read plugin param from db
  $sql = 'SELECT * FROM `#__plugins` WHERE `folder`= \''.$group.'\'';
  $db->setQuery($sql);
  $pluginList = $db->loadAssocList();

  if (empty( $pluginList)) {
    return true;
  }

  // for each plugin
  foreach( $pluginList as $plugin) {
    // remove plugin db id
    unset($plugin['id']);

    // write everything on disk
    shWriteExtensionConfig( $plugin['folder'] . '.' . $plugin['element'], array('shConfig' => $plugin));

    // now remove plugin details from db
    $db->setQuery( "DELETE FROM `#__plugins` WHERE `element`= '" . $plugin['element'] . "' and `folder`= '".$plugin['folder']."';");
    $db->query();

  }

  // now delete the files for the whole group
  if (JFolder::exists( JPATH_ROOT.DS.'plugins'. DS . $group)) {
    JFolder::delete( JPATH_ROOT.DS.'plugins'. DS . $group);
  }

}

