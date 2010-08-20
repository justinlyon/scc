<?php
/**
 * sh404SEF support for com_poll component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_poll.php 1379 2010-05-09 19:23:06Z silianacom-svn $
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
$shLangIso = shLoadPluginLanguage( 'com_poll', $shLangIso, 'COM_SH404SEF_POLL_VOTE');
// ------------------  load language file - adjust as needed ----------------------------------------

$task = isset($task) ? $task : null; 
switch ($task) {
  case 'vote':
	  $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_POLL_VOTE'];
	break;
  default:
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_POLL_RESULTS'];
    shMustCreatePageId( 'set', true);                                         
  break;
}

if (!empty($id)) {
   $query = 'SELECT title, id FROM #__polls WHERE id = "'.$id.'"';
   $database->setQuery($query);
   if (shTranslateURL($option, $shLangName))
     $pollTitle = $database->loadObject( );
   else  $pollTitle = $database->loadObject( false);
   if ($database->getErrorNum()) {
    JError::raiseError(500, $database->stderr() );
   } 
   else $title[] = $pollTitle->title;
  }
else $title[] = '/'; // V 1.2.4.s
    
shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('lang');
if (!empty($task))
  shRemoveFromGETVarsList('task');
if (!empty($id))  
  shRemoveFromGETVarsList('id');

// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------

?>
