<?php
/**
 * sh404SEF support for Chronoforms component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_chronocontact.php 1241 2010-04-11 17:22:24Z silianacom-svn $
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

 
// do something about that Itemid thing
if (!preg_match( '/Itemid=[0-9]+/i', $string)) { // if no Itemid in non-sef URL
  //global $Itemid;
  if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid)) {
    $string .= '&Itemid='.$shCurrentItemid;  // append current Itemid
    $Itemid = $shCurrentItemid;
    shAddToGETVarsList('Itemid', $Itemid); // V 1.2.4.m
  }
  if ($sefConfig->shInsertTitleIfNoItemid)
  $title[] = $sefConfig->shDefaultMenuItemName ?
  $sefConfig->shDefaultMenuItemName : getMenuTitle($option, null, $shCurrentItemid );
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
  COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$shCurrentItemid
  : '';
} else {  // if Itemid in non-sef URL
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
  COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$Itemid
  : '';
}

// get the contact form name and clean i, as CF allows any char in the form name
$chronoformname = isset($chronoformname) ? @$chronoformname : null;
if (!is_null( $chronoformname)) {
  $chronoformname = preg_replace('/[^A-Za-z0-9_]/', '', $chronoformname);
}

$task = isset($task) ? @$task : null;
$Itemid = isset($Itemid) ? @$Itemid : null;
$shName = shGetComponentPrefix($option);
$shName = empty($shName) ? getMenuTitle($option, (isset($view) ? @$view : null), $Itemid ) : $shName;
if (!empty($shName) && $shName != '/') $title[] = $shName;  // V x

switch (strtolower($task)) {
  case 'send' :
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_CHRONOCONTACT_SEND'];
    shRemoveFromGETVarsList('task');
    break;
  case 'extra' :
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_CHRONOCONTACT_SEND'];
    shRemoveFromGETVarsList('task');
    break;
  default:
    break;
}

// now add form name
if (!empty($chronoformname)) {
  $title[] = $chronoformname;
  shRemoveFromGETVarsList('chronoformname');  
}

// remove used vars
shRemoveFromGETVarsList('option');
if (!empty($Itemid))
shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('lang');

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
  $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

?>
