<?php
/**
 * sh404SEF support for com_login component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_login.php 1241 2010-04-11 17:22:24Z silianacom-svn $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & shRouter::shGetConfig();  
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_registration', $shLangIso, 'COM_SH404SEF_LOST_PASSWORD');
// ------------------  load language file - adjust as needed ----------------------------------------
                                           
       
// do something about that Itemid thing
if (!preg_match( '/Itemid=[0-9]+/i', $string)) { // if no Itemid in non-sef URL
  //global $Itemid;
  if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid)) {
    $string .= '&Itemid='.$shCurrentItemid;  // append current Itemid
    $Itemid = $shCurrentItemid;
    shAddToGETVarsList('Itemid', $Itemid); // V 1.2.4.m
  }   
  if ($sefConfig->shInsertTitleIfNoItemid)
  	$title[] = $sefConfig->shDefaultMenuItemName ? $sefConfig->shDefaultMenuItemName : getMenuTitle($option, (isset($task) ? @$task : null), $shCurrentItemid, null, $shLangName );
  $shItemidString = $sefConfig->shAlwaysInsertItemid ? 
    COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$shCurrentItemid
    : '';
} else {  // if Itemid in non-sef URL
  $shItemidString = $sefConfig->shAlwaysInsertItemid ? 
    COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$Itemid
    : '';
}
  
// optional first part of URL, to be set in language file
if (!empty($sh_LANG[$shLangIso]['COM_SH404SEF_REGISTRATION'])) 
  $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_REGISTRATION'];

$task = isset($task) ? @$task : null;

switch ($task) {
  case 'register':
    $title[] =  $sh_LANG[$shLangIso]['COM_SH404SEF_REGISTER'];
  break;
  case 'lostPassword':
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_LOST_PASSWORD'];
  break;
  default:  // we are login in
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_LOGIN'];
  break;
}
    
if (!empty($title))
  if (!empty($sefConfig->suffix)) {
	  $title[count($title)-1] .= $sefConfig->suffix;
  }
  else {
	  $title[] = '/';
  }

shRemoveFromGETVarsList('option');
if (!empty($Itemid))
  shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('lang');
if (!empty($task))
  shRemoveFromGETVarsList('task');

// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------
	
?>
