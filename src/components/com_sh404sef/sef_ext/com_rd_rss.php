<?php
/**
 * sh404SEF support for com_rd_rss component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_rd_rss.php 1241 2010-04-11 17:22:24Z silianacom-svn $
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
$shLangIso = shLoadPluginLanguage( 'com_rd_rss', $shLangIso, 'COM_SH404SEF_RD_RSS');
// ------------------  load language file - adjust as needed ----------------------------------------


$title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_RD_RSS'];
       
// fetch contact name
if (!empty($id)) {
  $query  = "SELECT name, id FROM #__rd_rss" ;
  $query .= "\n WHERE id=".$id;
  $database->setQuery( $query );
  if (!shTranslateUrl($option, $shLangName)) // V 1.2.4.m
    $result = $database->loadObject(false);
  else $result = $database->loadObject();
	if (!empty($result)) $title[] = $result->name;
	else $title[] = $id;
}    

$title[] = '/';
shRemoveFromGETVarsList('option');
if (!empty($Itemid))
  shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('lang');
shRemoveFromGETVarsList('id');

// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------
	
?>
