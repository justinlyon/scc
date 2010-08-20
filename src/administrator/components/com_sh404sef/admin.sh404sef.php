<?php
/**
 * SEF module for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: admin.sh404sef.php 1413 2010-05-23 20:59:42Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


// Ensure that user has access to this function.
$user = &JFactory::getUser();
if (!($user->usertype == 'Super Administrator' || $user->usertype == 'Administrator')) {
  $mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

// Setup paths.
$sef_config_class = JPATH_ADMINISTRATOR.'/components/com_sh404sef/sh404sef.class.php';
$sef_config_file  = JPATH_ADMINISTRATOR.'/components/com_sh404sef/config/config.sef.php';

// Make sure class was loaded.
if (!class_exists('SEFConfig')) {
  if (is_readable($sef_config_class)) {
    require_once($sef_config_class);
  }  else {
    JError::RaiseError( 500, COM_SH404SEF_NOREAD."( $sef_config_class )<br />".COM_SH404SEF_CHK_PERMS);
  }
}

// testing JLanguage16
jimport('joomla.language.language');
$j16Language =& shjlang16Helper::getLanguage();
$loaded = $j16Language->load( 'com_sh404sef', JPATH_BASE);

// include sh404sef default language file
shIncludeLanguageFile();

// find about specific controller requested
$cName = JRequest::getCmd( 'c');

// get controller from factory
$controller = Sh404sefFactory::getController( $cName);

// read and execute task
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();


