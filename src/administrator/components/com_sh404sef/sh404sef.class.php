<?php
/**
 * SEF extension for Joomla! 1.5
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2009-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: sh404sef.class.php 1482 2010-06-30 17:36:34Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport('joomla.filesystem.file');

DEFINE ('SH404SEF_IS_INSTALLED', 1);

DEFINE ('sh404SEF_URLTYPE_404', -2);
DEFINE ('sh404SEF_URLTYPE_NONE', -1);
DEFINE ('sh404SEF_URLTYPE_AUTO', 0);
DEFINE ('sh404SEF_URLTYPE_CUSTOM', 1);
DEFINE ('sh404SEF_MAX_SEF_URL_LENGTH', 255);

DEFINE ('sh404SEF_HOMEPAGE_CODE', 'index.php?'.md5('sh404SEF Homepage url code'));

DEFINE ('SH404SEF_STANDARD_ADMIN', 1);  // define possible levels for adminstration complexity
DEFINE ('SH404SEF_ADVANCED_ADMIN', 2);

if (!defined('sh404SEF_ADMIN_ABS_PATH')) {
  define('sh404SEF_ADMIN_ABS_PATH', str_replace('\\','/',dirname(__FILE__)).'/');
}
if (!defined('sh404SEF_ABS_PATH')) {
  define('sh404SEF_ABS_PATH', str_replace( '/administrator/components/com_sh404sef', '', sh404SEF_ADMIN_ABS_PATH) );
}
if (!defined('sh404SEF_FRONT_ABS_PATH')) {
  define('sh404SEF_FRONT_ABS_PATH', sh404SEF_ABS_PATH.'components/com_sh404sef/');
}

// V 1.2.4.m
global $shHomeLink;
$shHomeLink = null;

// compatibility stuff
$lang =& JFactory::getLanguage();
$GLOBALS['shMosConfig_lang']   = $lang->get('backwardlang', 'english');
$GLOBALS['shMosConfig_locale']   = $lang->get('tag', 'en-GB');
$shTemp = explode( '-', $GLOBALS['shMosConfig_locale']);
$GLOBALS['shMosConfig_shortcode']   = $shTemp[0] ? $shTemp[0] : 'en';
$GLOBALS['shConfigLiveSite'] = JString::rtrim( JURI::base(), '/');
$GLOBALS['shConfigFrontLiveSite'] = str_replace( '/administrator', '', $GLOBALS['shConfigLiveSite']);

// include sub-libraries
include_once( sh404SEF_ADMIN_ABS_PATH . 'shMosSEF.class.php');
include_once( sh404SEF_ADMIN_ABS_PATH . 'sh404SEFMeta.class.php');
include_once( sh404SEF_ADMIN_ABS_PATH . 'SEFConfig.class.php');
include_once( sh404SEF_ADMIN_ABS_PATH . 'shSimpleLogger.class.php');
include_once( sh404SEF_ADMIN_ABS_PATH . 'sh_Net_URL.class.php');
include_once( sh404SEF_ADMIN_ABS_PATH . 'shJConfig.class.php');

// set of utility functions

function shSortURL($string) {
  // URL must be like : index.php?param2=xxx&option=com_ccccc&param1=zzz
  // URL returned will be ! index.php?option=com_ccccc&param1=zzz&param2=xxx
  $ret = '';
  $st = str_replace('&amp;', '&',$string);
  $st = str_replace('index.php', '', $st);
  $st = str_replace('?', '', $st);
  parse_str( $st,$shVars);
  if (count($shVars) > 0) {
    ksort($shVars);  // sort URL array
    $shNewString = '';
    $ret = 'index.php?';
    foreach ($shVars as $key => $value) {
      if (strtolower($key) != 'option') { // option is always first parameter
        if( is_array($value) ) {
          foreach($value as $k=>$v) {  // fix for arrays, thanks doorknob
            $shNewString .= '&'.$key.'[]='.$v;
          }
        } else {
          $shNewString .= '&'.$key.'='.$value;
        }
      } else {
        $ret .= $key.'='.$value;
      }
    }
    $ret .= $ret == 'index.php?' ? JString::ltrim( $shNewString, '&') : $shNewString;
  }
  return $ret;
}

/**
 * Disable caching of Joomfish language selection module
 *
 * Caching would otherwise new SEF urls in non-default language to
 * be created.
 *
 */
function shDisableJFModuleCaching() {

  // load module data
  $db = & JFactory::getDBO();
  $query = "select * from #__modules where module='mod_jflanguageselection'";
  $db->setQuery( $query);
  $module = $db->loadObject();
  if (empty( $module)) {
    // joomfish module not here, do nothing
    return;
  }
  $params = new JParameter( $module->params );
  $cache_href = $params->get( 'cache_href');

  // set caching to false
  if ($cache_href != 0) {
    // change setting
    $params->set( 'cache_href', 0);
    $newParam = $params->toArray();
    // save these new params
    $row =& JTable::getInstance('module');
    $row->load( $module->id);
    $row->bind( array( 'params' => $newParam));
    $row->store();
    global $mainframe;
    $mainframe->enqueueMessage( COM_SH404SEF_JC_MODULE_CACHING_DISABLED);
  }
}

// returns found languages, but will check request language ($_GET or $_POST)
// and use that over user lang if it exists
// returns a lnguage code : en, fr, sp
function shDecideRequestLanguage() {

  $reqLang = JRequest::getVar( 'lang', '' );
  if( $reqLang != '' )
  $finalLang = $reqLang;
  else
  $finalLang = shDiscoverUserLanguage();
  return $finalLang;
}

/** The function finds the language which is to be used for the user/session
 *
 * It is possible to choose the language based on the client browsers configuration,
 * the activated language of the configuration and the language a user has choosen in
 * the past. The decision of this order is done in the JoomFish configuration.
 *
 * This is a modified copy of what's available in Joomfish system bot.
 * Returns a language code : en, fr, sp
 */

function shDiscoverUserLanguage() {

  $shCookieLang = shGetCookieLanguage();
  $userLang = empty( $shCookieLang) ? shGetParamUserLanguage() : $shCookieLang;
  return $userLang;
}

// returns language code (en, fr, sp after lookign up Joomfish params
// probably does not work with NokKaew
function shGetParamUserLanguage() {
  global $shMosConfig_lang, $shMosConfig_locale, $shMosConfig_shortcode, $_MAMBOTS;

  if (!shIsMultilingual())
  return $shMosConfig_shortcode;

  $database =& JFactory::getDBO();
  // check if param query has previously been processed
  $determitLanguage     = 1;
  $newVisitorAction   = "browser";
  if ($newVisitorAction=="browser" && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ) {
    // no language chooses - assume from browser configuration
    // language negotiation by Kochin Chang, June 16, 2004
    // retrieve active languages from database
    $active_lang = null;
    $activeLanguages = shGetActiveLanguages();
    if( count( $activeLanguages ) == 0 ) {
      return $shMosConfig_shortcode;
    }
    foreach ($activeLanguages as $lang) {
      $active_lang[] = $lang->iso;
    }
    // figure out which language to use
    $browserLang = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    foreach( $browserLang as $lang ) {
      $shortLang = JString::substr( $lang, 0, 2 );
      if( in_array($lang, $active_lang) ) {
        $client_lang = $lang;
        break;
      }
      if ( in_array($shortLang, $active_lang) ) {
        $client_lang = $shortLang;
        break;
      }
    }
    // if language is still blank then use first active language!
    if (empty($client_lang)) {
      $client_lang = $activeLanguages[0]->iso;
    }
  } elseif ($newVisitorAction=="joomfish"){
    // This list is ordered already!
    $activeLanguages = shGetActiveLanguages();
    if( count( $activeLanguages ) == 0 ) {
      return $shMosConfig_shortcode;
    }
    else {
      $client_lang = $activeLanguages[0]->iso;
    }
     
  } else {// otherwise default use site default language
    $activeLanguages = shGetActiveLanguages();
    if( count( $activeLanguages ) == 0 ) {
      return $shMosConfig_shortcode;
    }
    foreach ($activeLanguages as $lang) {
      if ($lang->code == $shMosConfig_locale){
        $client_lang = $lang->iso;
        break;
      }
    }
    // if language is still blank then use first active language!
    if ($client_lang==""){
      $client_lang = $activeLanguages[0]->iso;
    }
  }
  return $client_lang;
}

function shGetCookieLanguage() {

  $jfCookie = JRequest::getVar( 'jfcookie', null, 'COOKIE' );
  if (isset($jfCookie["lang"]) && $jfCookie["lang"] != "") {
    $lang = $jfCookie["lang"];
  } else {
    $lang = '';
  }
  return $lang;
}

/**
 * Check if user session exists. Adapted from Joomla original code
 */
function shLookupSession() {

  global $mainframe;

  return false;  // does not work in 1.5. Not needed anyway, as long as multilingual 303 redirect is not solved

  $database =& JFactory::getDBO();
  // initailize session variables
  $session  = new mosSession( $database );
  $option = strval( strtolower( JRequest::getVar( 'option' ) ) );
  $mainframe = new mosMainFrame( $database, $option, '.' );
  // purge expired sessions
  $session->purge('core');  // can't purge as $mainframe is not initialized yet
  // Session Cookie `name`
  // WARNING : I am using the Hack from
  $sessionCookieName  = mosMainFrame::sessionCookieName();
  // Get Session Cookie `value`
  $sessioncookie    = strval( JRequest::getVar( $sessionCookieName, null, 'COOKIE' ) );
  // Session ID / `value`
  $sessionValueCheck  = mosMainFrame::sessionCookieValue( $sessioncookie );
  // Check if existing session exists in db corresponding to Session cookie `value`
  // extra check added in 1.0.8 to test sessioncookie value is of correct length
  $ret = false;
  if ( $sessioncookie && strlen($sessioncookie) == 32 && $sessioncookie != '-' && $session->load($sessionValueCheck) )
  $ret = true;
  unset($mainframe);
  return $ret;
}

// redirect user according to its language preference
function shGuessLanguageAndRedirect( $queryString) {

  if (!sh404SEF_DE_ACTIVATE_LANG_AUTO_REDIRECT
  && shIsMultilingual() == 'joomfish') {
    $cookieLang = shGetCookieLanguage();
    $sessionExists = shLookupSession();
    $reqLang = shGetUrlVar( $queryString, 'lang', '');
    $targetLang = '';
    if (empty($cookieLang)) {  // this is really first visit (or visitor does not accept cookie)
      $discoveredLang = shGetParamUserLanguage();
      if ( $discoveredLang != $reqLang)
      $targetLang = $discoveredLang;
    }
    if (!empty($targetLang)) { // 303 redirect to same URL in preferred language
      $queryString = shSetURLVar( 'index.php?'.$queryString, 'lang', $targetLang);
      $target = JRoute::_( $queryString);
      _log('Redirecting (303) to user language |cookie = '.$cookieLang. '|session='.$sessionExists.'|req='.$reqLang.'|target='.$targetLang);
      shRedirect( $target, '', 303);
    }
  }
}

// 1.2.4.t 10/08/2007 12:17:37 return false if not multilingual
function shIsMultilingual() {
  global $mainframe;

  static $shIsMultiLingual = null;

  if (is_null( $shIsMultiLingual)) {
    $conf =& JFactory::getConfig();
    $shIsMultiLingual = !is_null( $conf->getValue( 'multilingual_support', null)) ? 'joomfish' : false;
  }
  return $shIsMultiLingual;

}

// 1.2.4.t 10/08/2007 12:17:37 return true if param is default language
function shIsDefaultLang( $langName) {

  return $langName == shGetDefaultLang();
}

// 1.2.4.t 10/08/2007 12:17:37 return true if param is default language
function shGetDefaultLang() {

  $type = shIsMultilingual();
  switch ($type) {
    case false:
      $shDefaultLang = $GLOBALS['shMosConfig_locale'];
      break;
    case 'joomfish':
      $conf =& JFactory::getConfig();
      $shDefaultLang = $conf->getValue( 'config.defaultlang');
      break;
  }
  return $shDefaultLang;
}


function shAdjustToRewriteMode( $url) {
  //$sefConfig = shRouter::shGetConfig();
  return $url;
}

function shFinalizeURL( $url) {
  $sefConfig = shRouter::shGetConfig();
  if (!empty($url) && (strpos($url, '/index.php?/') === false)) {  // V w 27/08/2007 13:38:34 sh_NetURL does not work if
    $URI = new sh_Net_URL($url);                       // using this rewrite mode as the added ? fools it if there is indeed
    if (!empty($URI->path)) {                          // a query string. Better not do anything
      $url = $URI->protocol.'://'.$URI->host.(!sh404SEF_USE_NON_STANDARD_PORT || empty($URI->port) ? '' : ':'.$URI->port);
      $url .= $sefConfig->shEncodeUrl ? shUrlEncode( $URI->path) :  $URI->path;
      if (count($URI->querystring) > 0) {
        $shTemp = '';
        foreach ($URI->querystring as $key=>$value) {
          if(is_array($value)) {  // array fix, thanks doorknob
            foreach( $value as $k=>$v) {
              $shTemp .= '&'.$key.'[]='.($sefConfig->shEncodeUrl ? shUrlEncode($v) : $v);
            }
          } else {
            $shTemp .= '&'.$key.'='.($sefConfig->shEncodeUrl ? shUrlEncode($value) : $value);
          }
        }

        $shTemp = JString::ltrim( $shTemp, '&');  // V x 02/09/2007 21:17:19
        $url .= '?'. $shTemp;  // V x 02/09/2007 21:17:24
      }
      if ($URI->anchor)
      $url .= '#'.($sefConfig->shEncodeUrl ? shUrlEncode($URI->anchor) : $URI->anchor);
    }
  }
  // V 1.2.4.s hack to workaround Virtuemart/SearchEngines issue with cookie check
  // V 1.2.4.t fixed bug, was checking for vmcchk instead of vmchk
  if (shIsSearchEngine() && (strpos( $url, 'vmchk') !== false)) {
    $url = str_replace('vmchk/', '', $url);  // remove check,
    //cookie will be forced if user agent is searchengine
  }
  $url = shAdjustToRewriteMode ($url);
  $url = str_replace('&amp;', '&', $url);  // when Joomla wil turn that into &amp; we are sur we won't have &amp;amp;
  return $url;
}

// V 1.2.4.p compatibility function with SEFAdvance
function sefencode( $string) {
  return titleToLocation( $string);
}

function titleToLocation(&$title)
{
  $sefConfig = shRouter::shGetConfig();
  $title = JString::trim($title);
  $debug = 0;
  if ($debug) $t[] = $title;
  $shRep = $sefConfig->shGetReplacements();
  if (!empty($shRep))
  $title = strtr($title, $shRep);
  if ($debug) $t[] = $title;
  $shStrip = $sefConfig->shGetStripCharList();
  if (!empty($shStrip))
  $title = str_replace( $shStrip, '', $title);
  if ($debug) $t[] = $title;
  // V 1.2.4.t remove spaces
  $title = preg_replace( '/[\s]+/iU', $sefConfig->replacement, $title);
  if ($debug) $t[] = $title;
  $title = str_replace('\'', $sefConfig->replacement, $title);
  $title = str_replace('"', $sefConfig->replacement, $title);
  // V x strip # as it breaks anchor management
  $title = str_replace('#', $sefConfig->replacement, $title);
  // V u - 26/08/2007 10:26:58 remove question marks
  $title = str_replace('?', $sefConfig->replacement, $title);
  if ($debug) $t[] = $title;
  $title = str_replace('\\', $sefConfig->replacement, $title);
  if ($debug) $t[] = $title;
  // V 1.2.4.t remove duplicate replacement chars
  if (!empty($sefConfig->replacement))  // V x protect/allow empty
  $title = preg_replace('/'.preg_quote($sefConfig->replacement).'{2,}/', $sefConfig->replacement, $title);
  if ($debug) $t[] = $title;
  $title = JString::trim( $title, str_replace('|', '', $sefConfig->friendlytrim));  // V 1.2.4.t add SEF URL trimming of user set characters
  $title = $sefConfig->LowerCase ? JString::strtolower($title) : $title;  // V w 27/08/2007 13:11:48
  if ($debug) $t[] = $title;
  if ($debug && strpos($t[0], '\'') !== false) {
    var_dump($t);
    die();
  }
  return $title;
}

// V x utility 01/09/2007 22:18:55 function to remove mosmsg var from url
function shCleanUpMosMsg( $string) {
  return preg_replace( '/(&|\?)mosmsg=[^&]*/i', '', $string);
}

// V x utility  function to remove a variable from an URL
function shCleanUpVar( $string, $var) {
  return preg_replace( '/(&|\?)'.preg_quote($var, '/').'=[^&]*/i', '', $string);
}

// V x utility 01/09/2007 22:18:55 function to return mosmsg var from url
function shGetMosMsg( $string) {
  $matches = array();
  $result = preg_match( '/(&|\?)mosmsg=[^&]*/i', $string, $matches);
  if (!empty($matches))
  return JString::trim( $matches[0], '&?');
  else return '';
}

// V x utility function to return lang var from url
function shGetURLLang( $string) {
  $matches = array();
  $string = str_replace('&amp;', '&', $string); // normalize
  $result = preg_match( '/(&|\?)lang=[^&]*/i', $string, $matches);
  if (!empty($matches)) {
    $result = JString::trim( $matches[0], '&?');
    $result = str_replace('lang=', '', $result);
    return shGetNameFromIsoCode($result);
  }
  else return '';
}

// V x utility function to return a var from url
function shGetURLVar( $string, $var, $default = '') {
  $matches = array();
  $string = str_replace('&amp;', '&', $string); // normalize
  $result = preg_match( '/(&|\?)'.preg_quote($var, '/').'=[^&]*/i', $string, $matches);
  if (!empty($matches)) {
    $result = JString::trim( $matches[0], '&?');
    $result = str_replace($var.'=', '', $result);
    return $result;
  }
  else return $default;
}

// V x utility function to set  a var in an url
function shSetURLVar( $string, $var, $value, $canBeEmpty = false) {
  if (empty( $string) || empty($var)) return $string;
  if ( !$canBeEmpty && empty( $value)) {
    return $string;
  }
  $string = str_replace('&amp;', '&', $string); // normalize
  $exp = '/(&|\?)'.preg_quote($var, '/').'=[^&]*/i';
  $result = preg_match( $exp, $string);
  if ($result)  // var already in URL
  $result = preg_replace( $exp, '$1'.$var.'='.$value, $string);
  else {  // var does not exist in URL
    $result = $string.(strpos( $string, '?') !== false ? '&':'?').$var.'='.$value;
    $result = shSortURL($result);
  }
  return $result;
}

// V 1.2.4.q utility function to clean language and pagination info from url
function shCleanUpPag( $string) {
  $shTempString = preg_replace( '/(&|\?)limit=[^&]*/i', '', $string);
  $shTempString = preg_replace( '/(&|\?)limitstart=[^&]*/i', '', $shTempString);
  return $shTempString;
}

// V 1.2.4.t utility function to clean language from url
function shCleanUpLang( $string) {
  return preg_replace( '/(&|\?)lang=[a-zA-Z]{2}/iU', '', $string);
}

// V 1.2.4.q utility function to clean language and pagination info from url
function shCleanUpLangAndPag( $string) {
  $shTempString = shCleanUpLang( $string);
  $shTempString = shCleanUpPag($shTempString);
  return $shTempString;
}

// V 1.2.4.t utility function to clean anchor from url
function shCleanUpAnchor( $string) {
  $bits = explode('#', $string);
  return $bits[0];
}


// V 1.2.4.t
function shIncludeLanguageFile() {
  if (defined( 'COM_SH404SEF_REDIR_404')) return;
  if (shFileExists(sh404SEF_ADMIN_ABS_PATH.'language/'.$GLOBALS['shMosConfig_lang'].'.php')) {
    include_once(sh404SEF_ADMIN_ABS_PATH.'language/'.$GLOBALS['shMosConfig_lang'].'.php');
  }
  else {
    include_once(sh404SEF_ADMIN_ABS_PATH.'language/english.php');
  }
}


function shGETGarbageCollect() {  // V 1.2.4.m moved to main component from plugins
  // builds up a string using all remaining GET parameters, to be appended to the URL without any sef transformation
  // those variables passed litterally must be removed from $string as well, so that they are not stored in DB
  global $shGETVars;
  $sefConfig = shRouter::shGetConfig();
  if (!$sefConfig->shAppendRemainingGETVars || empty($shGETVars)) return '';
  $ret = '';
  ksort($shGETVars);
  foreach ($shGETVars as $param => $value) {
    if( is_array($value) ) {
      foreach($value as $k=>$v) {
        $ret .= '&'.$param.'[]='.$v;
      }
    } else {
      $ret .= '&'.$param.'='.$value;
    }

  }
  return $ret;
}

function shRebuildNonSefString( $string) { // V 1.2.4.m moved to main component from plugins
  // rebuild a non-sef string, removing all GET vars that were not turned into SEF
  // as we do not want to store them in DB

  global $shRebuildNonSef;
  $sefConfig = & shRouter::shGetConfig();
  if (!$sefConfig->shAppendRemainingGETVars || empty($shRebuildNonSef)) return $string;
  $shNewString = '';
  if (!empty($shRebuildNonSef)) {
    foreach ($shRebuildNonSef as $param) {  // need to sort, and still place option in first pos.
      if (strpos($param, 'sh404SEF_title=') !== false)
      $param = str_replace('sh404SEF_title=', 'title=', $param);
      $shNewString .= $param;
    }
    $ret = shSortUrl('index.php?'.JString::ltrim( $shNewString, '&'));
  }
  return $ret;
}


function shRemoveFromGETVarsList( $paramName) {
  global $shGETVars, $shRebuildNonSef;

  $sefConfig = shRouter::shGetConfig();
  if (!$sefConfig->shAppendRemainingGETVars) return null;
  if (!empty($paramName)) {
    if (isset($shGETVars[$paramName])) {
      $shValue = $shGETVars[$paramName];
      $shRebuildNonSef[] = '&'.$paramName.'='.$shValue;  // build up a non-sef string with the GET vars used to
      // build the SEF string. This string will be the one stored in db instead of
      // the full, original one
      unset( $shGETVars[@$paramName]);
    }
  }
}

function shAddToGETVarsList( $paramName, $paramValue) {  // V 1.2.4.m
  global $shGETVars, $shRebuildNonSef;
  if (empty( $paramName)) return;
  $shGETVars[$paramName] = $paramValue;
  // check and remove from $shRebuildNonSef, in case this param was previously added to the list, using shRemoveFromGETVarsList
  if (!empty($shRebuildNonSef)) {
    $indexFound = -1;
    $index = -1;
    foreach($shRebuildNonSef as $item) {
      $index++;
      if ($item == '&'.$paramName.'='.$paramValue) {
        $indexFound = $index;
        break;
      }
    }
    if ($indexFound > -1) {
      unset( $shRebuildNonSef[$indexFound]);
    }
  }
}

function shFinalizePlugin( $string, $title, &$shAppendString, $shItemidString,
$limit, $limitstart, $shLangName, $showall = null) { // V 1.2.4.s
  global $shGETVars;
  if (!empty($shItemidString))
  $title[] = $shItemidString; // V 1.2.4.m
  // stitch back additional parameters, not sef-ified
  $shAppendString .= shGETGarbageCollect();  // add automatically all GET variables that had not been used already
  if (!empty($shAppendString))
  $shAppendString = '?'.JString::ltrim( $shAppendString, '&'); // don't add to $string, otherwise it will be stored in the DB
  return sef_404::sefGetLocation( shRebuildNonSefString( $string), $title, null,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null),
  (isset($showall) ? @$showall : null)
  );
}

function shInitializePlugin($lang, &$shLangName, &$shLangIso, $option) {
  global $shMosConfig_lang, $shMosConfig_locale;

  $conf =& JFactory::getConfig();
  $configDefaultLanguage = $conf->getValue('config.language');
   
  $shLangName = empty($lang) ? $shMosConfig_locale : shGetNameFromIsoCode( $lang);
  $shLangIso = (shTranslateUrl($option, $shLangName)) ?
  (isset($lang) ? $lang : shGetIsoCodeFromName( $shMosConfig_locale))
  : (isset($configDefaultLanguage) ? shGetIsoCodeFromName($configDefaultLanguage) : shGetIsoCodeFromName( $shMosConfig_locale));
  if (strpos($shLangIso, '_') !== false) {   //11/08/2007 14:30:16 mambo compat
    $shTemp = explode( '_', $shLangIso);
    $shLangIso = $shTemp[0];
  }

  // reset pageid creation : the plugin must turn it on by itself
  shMustCreatePageId( 'set', false);

  // added protection : do not SEF if component is not installed. Do not attempt to build SEF URL
  // if component is not installed, or else plugin may try to read from comp DB tables. This will cause DB table names
  // to be displayed
  return !sh404SEF_CHECK_COMP_IS_INSTALLED
  || ( sh404SEF_CHECK_COMP_IS_INSTALLED &&
  shFileExists(sh404SEF_ABS_PATH.'components/'.$option.'/'.str_replace('com_', '',$option).'.php'));
}

function shLoadPluginLanguage ( $pluginName, $language, $defaultString, $path = '') {  // V 1.2.4.m
  global $sh_LANG;
  // load the Language File
  $path = JString::rtrim( $path, DS) . DS;
  $path = $path == DS ? sh404SEF_ADMIN_ABS_PATH .'language'.DS.'plugins'.DS : $path;
  if (shFileExists( $path .$pluginName.'.php' )) {
    include_once( $path . $pluginName.'.php' );
  }
  else JError::RaiseWarning( 500, 'sh404SEF - missing language file for plugin '.$pluginName.'.');

  if (!isset($sh_LANG[$language][$defaultString]))
  return 'en';
  else return $language;
}

function shInsertIsoCodeInUrl($compName, $shLang = null) {  // V 1.2.4.m
  global $shMosConfig_lang, $shMosConfig_locale;
  $sefConfig = & shRouter::shGetConfig();

  $shLang = empty($shLang) ? $shMosConfig_locale : $shLang;  // V 1.2.4.q
  if (empty($compName) || !$sefConfig->shInsertLanguageCode  // if no compname or global param is off
  || $sefConfig->shLangInsertCodeList[$shLang] == 2  // set to not insertcode
  || ( $sefConfig->shLangInsertCodeList[$shLang] == 0 && shGetDefaultlang() == $shLang) // or set to default
  )  // but this is default language
  return false;
  $compName = str_replace('com_', '', $compName);
  return !in_array($compName, $sefConfig->notInsertIsoCodeList);
}

function shTranslateUrl ($compName, $shLang = null) {  // V 1.2.4.m  // V 1.2.4.q added $shLang param
  global $shMosConfig_lang, $shMosConfig_locale;

  $sefConfig = & shRouter::shGetConfig();

  $shLang = empty($shLang) ? $shMosConfig_locale : $shLang;
  if (empty($compName) || !$sefConfig->shTranslateURL
  || $sefConfig->shLangTranslateList[$shLang] == 2 ) // set to not translate
  return false;
  $compName = str_replace('com_', '', $compName);
  $result = !in_array($compName, $sefConfig->notTranslateURLList);
  return $result;
}

// V 1.2.4.q returns true if current page is home page.
function shIsCurrentPageHome() {
  global $option, $shHomeLink;

  $currentPage = shSortUrl( preg_replace( '/(&|\?)lang=[a-zA-Z]{2,3}/iU', '', empty($_SERVER['QUERY_STRING']) ? '' : $_SERVER['QUERY_STRING'])); // V 1.2.4.t
  $currentPage = JString::ltrim( str_replace('index.php', '', $currentPage), '/');
  $currentPage = JString::ltrim( $currentPage, '?');
  $shHomePage = preg_replace( '/(&|\?)lang=[a-zA-Z]{2,3}/iU', '', $shHomeLink);
  $shHomePage = JString::ltrim( str_replace('index.php', '', $shHomePage), '/');
  $shHomePage = JString::ltrim( $shHomePage, '?');
  return  $currentPage == $shHomePage;
}

function shUrlEncode( $path) {
  $ret = $path;
  if (!empty($path)) {
    $bits = explode('/', $path);
    $enc = array();
    if (count($bits)) {
      foreach ($bits as $key=>$value) {
        $enc[$key] = rawurlencode($value);
      }
      $ret = implode($enc,'/');
    }
  }
  return $ret;
}
function shUrlDecode( $path) {
  $ret = $path;
  if (!empty($path)) {
    $bits = explode('/', $path);
    $dec = array();
    if (count($bits)) {
      foreach ($bits as $key=>$value) {
        $dec[$key] = rawurldecode($value);
      }
      $ret = implode($dec,'/');
    }
  }
  return $ret;
}

// returns default items per page from menu items params. menu item selected by its id taken from a URL
function shGetDefaultDisplayNumFromURL($url, $includeBlogLinks = false) {
   
  $menuItemid = shGetURLVar($url, 'Itemid');
  return shGetDefaultDisplayNum($menuItemid, $url, $fromSession = true, $includeBlogLinks);
}

/**
 * Compared to shGetDefaultDisplayNum, this function only reads default
 * num items per page out of configuration and url requested, regardless of values
 * stored in session
 *
 * @param $url
 * @return unknown_type
 */
function shGetDefaultDisplayNumFromConfig( $url, $includeBlogLinks = false) {

  $menuItemid = shGetURLVar($url, 'Itemid');
  return shGetDefaultDisplayNum($menuItemid, $url, $fromSession = false, $includeBlogLinks);

}


// returns default items per page from menu items params. menu item selected by its id taken from a URL
function shGetDefaultDisplayNum($menuItemid, $url, $fromSession = false, $includeBlogLinks = false) {

  global $mainframe;

  // default value is general configuration list length param
  $ret = $mainframe->getCfg( 'list_limit', 10 );

  // get elements of the url
  $option = shGetURLVar($url, 'option');
  $layout = shGetURLVar( $url, 'layout');
  if (empty( $layout)) {
    $layout = 'default';
  }
  $view = shGetURLVar( $url, 'view');

  // is this a sobi2 url ? we must read config from database
  if ($option == 'com_sobi2') {
    $itemsPerLine = (int) shGetSobi2Config( 'itemsInLine', 'frontpage');
    $linesPerPage = (int) shGetSobi2Config( 'lineOnSite', 'frontpage');
    return $itemsPerLine * $linesPerPage;
  }

  // if there is a menu item, we can try read more params
  if (!empty($menuItemid)) {

    // itemid, try read params from the menu item
    $menu = & shRouter::shGetMenu();
    $menuItem = $menu->getItem($menuItemid);  // load menu item from DB
    if (empty($menuItem)) return $ret;  // if none, default
    $params = new JParameter( $menuItem->params );  // get params from menu item

    // layout = blog and frontpage
    if ( ($option =='com_content' && $layout == 'blog')
    || ($option == 'com_content' && $view == 'frontpage')) {
      $num_leading_articles = $params->get('num_leading_articles');
      $num_intro_articles = $params->get('num_intro_articles');
      //adjust limit and listLimit for page calculation as blog views include
      //# of links in the limit value, while it should not be included for
      // page number calculation
      $num_links = $includeBlogLinks ? $params->get('num_links') : 0;

      $ret = $num_leading_articles + $num_intro_articles + $num_links;  // calculate how many items on a page
      return $ret;
    }

    // elements with a display_num parameter
    $displayNum = intval($params->get('display_num'));
    $ret = !empty( $displayNum) ? $displayNum : $ret;
  }

  if ($fromSession) {
    // now handle special cases
    if ( $option =='com_content' && $layout != 'blog' && ($view == 'category' || $view == 'section')) {
      global $mainframe;
      $limit = $mainframe->getUserStateFromRequest( 'com_content.sh.' . $view . '.' . $layout . '.limit', 'limit', null);
      if (!is_null($limit)) {
        return $limit;
      }
    }

    if ($option == 'com_contact') {
      global $mainframe;
      $limit = $mainframe->getUserState( $option . '.' . $view. '.limit');
      if (!is_null($limit)) {
        return $limit;
      }
    }

    if ($option == 'com_weblinks') {
      global $mainframe;
      $limit = $mainframe->getUserState( $option . '.limit');
      if (!is_null($limit)) {
        return $limit;
      }
    }
  }

  // return calculated value
  return $ret;
}

function getSefUrlFromDatabase($url, &$sefString)  // V 1.2.4.t
{
  $database =& JFactory::getDBO();
  $query = "SELECT oldurl, dateadd FROM #__redirection WHERE newurl = '".$database->getEscaped($url)."'";
  $database->setQuery($query); // 10/08/2007 22:10:05 mambo compat
  if ($result = $database->loadObject()) {
    $sefString = $result->oldurl;
    if (empty($result->oldurl))
    return sh404SEF_URLTYPE_404;
    return $result->dateadd == '0000-00-00' ? sh404SEF_URLTYPE_AUTO : sh404SEF_URLTYPE_CUSTOM;
  } else
  return sh404SEF_URLTYPE_NONE;
}

// V 1.2.4.t check both cache and DB
function shGetSefURLFromCacheOrDB($string, &$sefString) {
  $sefConfig = shRouter::shGetConfig();
  if (empty($string)) return sh404SEF_URLTYPE_NONE;
  $sefString = '';
  $urlType = sh404SEF_URLTYPE_NONE;
  if ($sefConfig->shUseURLCache)
  $urlType = shGetSefURLFromCache($string, $sefString);
  // Check if the url is already saved in the database.
  if ($urlType == sh404SEF_URLTYPE_NONE) {
    $urlType = getSefUrlFromDatabase($string, $sefString);
    if ($urlType == sh404SEF_URLTYPE_NONE || $urlType == sh404SEF_URLTYPE_404)
    return $urlType;
    else {
      if ($sefConfig->shUseURLCache) {
        shAddSefURLToCache( $string, $sefString, $urlType);
      }
    }
  }
  return $urlType;
}

// add URL to DB and cache. URL must no exists, this is insert, not update
function shAddSefUrlToDBAndCache( $nonSefUrl, $sefString, $rank, $urlType) {

  $database =& JFactory::getDBO();
  $sefString = JString::ltrim( $sefString, '/'); // V 1.2.4.t just in case you forgot to remove leading slash
  switch ($urlType) {
    case sh404SEF_URLTYPE_AUTO :
      $dateAdd = '0000-00-00';
      break;
    case sh404SEF_URLTYPE_CUSTOM :
      $dateAdd = date("Y-m-d");
      break;
    case sh404SEF_URLTYPE_NONE :
      return null;
      break;
  }
  $query = '';
  if ($urlType == sh404SEF_URLTYPE_AUTO) {  // before adding a full sef, we must check it does not already exists as a 404
    $query = 'SELECT id, newurl FROM #__redirection where oldurl=\''.$sefString.'\' AND ( newurl= \'\' OR newurl=\''.addslashes(urldecode($nonSefUrl)).'\')';
    _log('Querying for 404 : '.$query);
    $database->setQuery($query);
    $result = $database->loadObject(); // instead of inserting, we must update this 404 record
    if (!empty($result)) {
      if ($result->newurl == $nonSefUrl) {
        // url already in db, nothing to do
        _log( 'url already in db, nothing to do');
        return true;
      }
      $query = 'UPDATE #__redirection SET '.  // V 1.2.4.q
        "newurl='".addslashes(urldecode($nonSefUrl))."', rank='".$rank."', dateadd='".$dateAdd.'\' '
        ."WHERE oldurl = '".$sefString."';";
    } else {
      $query = '';
    }
  }
  if (empty($query)) {
    $query = "INSERT INTO #__redirection (oldurl, newurl, rank, dateadd) ".  // V 1.2.4.q
      "VALUES ('".$sefString."', '".addslashes(urldecode($nonSefUrl))."', '".$rank."', '".$dateAdd."')";  // V 1.2.4.q
  }
  _log('Querying to insert/update sef record : '.$query);
  $database->setQuery($query);
  if (!$database->query()) {
    _log('Bad query '. $query);
  }
  // shumisha 2007-03-13 added URL caching, need to store this new URL
  shAddSefURLToCache( $nonSefUrl, $sefString, $urlType);

  // create pageId : get a pageId model, and ask url creation
  jimport('joomla.application.component.model');
  $model = & JModel::getInstance( 'pageids', 'Sh404sefModel');
  $model->createPageId( $sefString, $nonSefUrl);

}

/**
 * Returns true if current sef url being created can have a pageId
 * Can be set from within a plugin, otherwise default to false
 * Reset to false upon each creation of a new sef url in shInitializePlugin()
 *
 * @param unknown_type $action
 * @param unknown_type $value
 * @return unknown
 */
function shMustCreatePageId( $action = 'get', $value = false) {

  jimport('joomla.application.component.model');
  $model = & JModel::getInstance( 'pageids', 'Sh404sefModel');
  $mustCreate = $model->mustCreatePageId( $action, $value);

  return $mustCreate;
}

// V 1.2.4.t build up a string with a page number
function shBuildPageNumberString( $pagenum) {
  $sefConfig = shRouter::shGetConfig();

  if ($sefConfig->pagetext && (false !== strpos($sefConfig->pagetext, '%s'))){
    return str_replace('%s', $pagenum, $sefConfig->pagetext);
  } else {
    return $pagenum;
  }
}

function shReadFile($shFileName, $asString = false){
  $ret = array();
  if (is_readable($shFileName)) {
    $shFile = fOpen($shFileName, 'r');
    do {
      $shRead = fgets($shFile,1024);
      if (!empty($shRead) && JString::substr($shRead, 0, 1) != '#') $ret[] = JString::trim(stripslashes($shRead));
    }
    while (!feof($shFile));
    fclose($shFile);
  }
  if ($asString)
  $ret = implode("\n", $ret);
  return $ret;
}

function shSaveFile($shFileName, $fileData){
  if (empty($shFileName)) return;
  $fileIsThere = file_exists($shFileName);
  if (!$fileIsThere || ($fileIsThere && is_writable($shFileName))) {
    if (is_array($fileData)) {
      $fileData = implode("\n",$fileData); //make sure we write a string
    }
    JFile::Write( $shFileName, empty($fileData) ? '':$fileData);
  }
}

// shumisha utility function to obtain iso code from language name
function shGetIsoCodeFromName($langName) {
  global $shIsoCodeCache, $shMosConfig_lang, $shMosConfig_locale, $shMosConfig_shortcode;

  $database =& JFactory::getDBO();
  if (!isset( $shIsoCodeCache[$langName])) {
    $type = shIsMultilingual();
    if ($type != false) {
      if ($type == 'joomfish') {
        $select = 'iso, shortcode, code';
      }
      $query = 'SELECT '.($type == 'joomfish' ? $select :'mambo,name')
      .' FROM '.($type == 'joomfish' ? '#__languages':'#__nok_language').' WHERE 1';
      $database->setQuery($query);
      $rows = $database->loadObjectList();
      foreach ($rows as $row) {
        if ($type == 'joomfish')
        $jfIsoCode = empty($row->shortcode) ? $row->iso:$row->shortcode;
        $shIsoCodeCache[($type == 'joomfish' ? $row->code:$row->name)] = ($type == 'joomfish' ? $jfIsoCode:$row->mambo);
      }
    } else { // no joomfish, so it has to be default language
      $langName = $shMosConfig_locale;
      $shIsoCodeCache[$shMosConfig_locale] = $shMosConfig_shortcode;
    }
  }
  return empty($shIsoCodeCache[$langName]) ? 'en' : $shIsoCodeCache[$langName];
}

// shumisha utility function to obtain language name from iso code
function shGetNameFromIsoCode($langCode) {
  global $shLangNameCache, $shMosConfig_lang, $shMosConfig_locale, $shLangNameCache;

  $database =& JFactory::getDBO();
  if (empty( $shLangNameCache)) {
    $type = shIsMultilingual();
    if ($type !== false) {
      if ($type == 'joomfish') {
        $select = 'iso, shortcode, code';
      }
      $query = 'SELECT '.($type == 'joomfish' ? $select:'mambo, name')
      .' FROM '.($type == 'joomfish' ? '#__languages':'#__nok_language').' WHERE 1';
      $database->setQuery($query);
      $rows = $database->loadObjectList();
      foreach ($rows as $row) {
        if ($type == 'joomfish')
        $jfIsoCode = empty($row->shortcode) ? $row->iso:$row->shortcode;
        $shLangNameCache[($type == 'joomfish' ? $jfIsoCode:$row->mambo)] = ($type == 'joomfish' ? $row->code:$row->name);
      }
      return empty($shLangNameCache[$langCode]) ? $shMosConfig_locale : $shLangNameCache[$langCode];
    } else { // no joomfish, so it has to be default language
      return $shMosConfig_locale;
    }
  } else return empty($shLangNameCache[$langCode]) ? $shMosConfig_locale : $shLangNameCache[$langCode];
}

/**
 * Get list of front-end available langauges
 *
 * @return unknown
 */
function shGetFrontEndActiveLanguages() {

  $shLangs = array();
  // Initialize some variables
  $mainframe = &JFactory::getApplication();
  $client =& JApplicationHelper::getClientInfo($mainframe->getClientId());

  //load folder filesystem class
  jimport('joomla.filesystem.folder');
  $path = JLanguage::getLanguagePath($client->path);
  $dirs = JFolder::folders( $path );

  foreach ($dirs as $dir) {
    //$files = JFolder::files( $path.DS.$dir, '^([-_A-Za-z]*)\.xml$' );
    $files = JFolder::files( $path.DS.$dir, '^([A-Za-z]{2}-[A-Za-z]{2})\.xml$' ); // some languages may add other xml files
    // Read the file to see if it's a valid component XML file
    $xml = & JFactory::getXMLParser('simple');

    foreach ($files as $file) {
      if (!$xml->loadFile($path.DS.$dir.DS.$file)) {
        unset($xml);
        continue;
      }
      if (is_object( $xml->document) && $xml->document->name() != 'metafile') {
        unset($xml);
        continue;
      }
      $shLang = new StdClass();
      $element = & $xml->document->metadata[0];
      $subElem = $element->tag[0];
      $shTemp = explode( '-', $subElem->data());
      $shLang->iso = $shTemp[0] ? $shTemp[0] : 'en';
      if (!empty($element->backwardLang)) {
        $subLang = $element->backwardLang[0];
      } else {
        $subLang = $element->backwardlang[0];  // some language files have backwardlang instead of backwardLang
      }
      $subLang = $element->tag[0];
      $shLang->code = $subLang->data();
      $shLangs[] = $shLang;
    }
  }
  return $shLangs;
}

// utility function to return list of available languages / isolate from JFish/Nokkaew compat issues
function shGetActiveLanguages() {

  global $mainframe;

  static $shActiveLanguages = null;  // cache this, to reduce DB queries
  if (!is_null($shActiveLanguages))
  return $shActiveLanguages;
   
  $shKind = shIsMultilingual();
  if ($shKind == 'joomfish') {
    $tempList = JoomFishManager::getActiveLanguages();
    if (!empty($tempList)) {
      foreach ($tempList as $language) {
        $shLang = null;
        $shLang->code = $language->code;
        $shLang->iso = $language->shortcode;
        $shActiveLanguages[] = $shLang;
      }
    } else $shKind = '';
  }
  if (empty($shKind)) {  // not multilingual
    $shActiveLanguages = shGetFrontEndActiveLanguages();
  }
  return $shActiveLanguages;
}

// returns prefix for $option component, as per user settings
function shGetComponentPrefix( $option) {

  if (empty($option)) return '';
  $sefConfig = shRouter::shGetConfig();
  $option = str_replace('com_', '', $option);
  $prefix = '';
  $prefix = empty($sefConfig->defaultComponentStringList[@$option]) ?
    '':$sefConfig->defaultComponentStringList[@$option];
  return $prefix;
}

function shRedirect( $url, $msg='', $redirKind = '301', $msgType='message' ) {

  global $mainframe;
  $sefConfig = & shRouter::shGetConfig();

  // specific filters
  if (class_exists('InputFilter')) {
    $iFilter = new InputFilter();
    $url = $iFilter->process( $url );
    if (!empty($msg)) {
      $msg = $iFilter->process( $msg );
    }

    if ($iFilter->badAttributeValue( array( 'href', $url ))) {
      $url = $GLOBALS['shConfigLiveSite'];
    }
  }

  // If the message exists, enqueue it
  if (JString::trim( $msg )) {
    $mainframe->enqueueMessage($msg, $msgType);
  }

  // Persist messages if they exist
  if (count($mainframe->_messageQueue))
  {
    $session =& JFactory::getSession();
    $session->set('application.queue', $mainframe->_messageQueue);
  }

  if (headers_sent()) {
    echo "<script>document.location.href='$url';</script>\n";
  } else {
    @ob_end_clean(); // clear output buffer
    switch ($redirKind) {
      case '302':
        $redirHeader ='HTTP/1.1 302 Moved Temporarily';
        break;
      case '303':
        $redirHeader ='HTTP/1.1 303 See Other';
        break;
      default:
        $redirHeader = 'HTTP/1.1 301 Moved Permanently';
        break;
    }
    header( $redirHeader );
    header( "Location: ". $url );
  }
  $mainframe->close();
}

function shCloseLogFile() {

  global $shLogger;
  if (!empty($shLogger)) {
    $shLogger->log('Closing log file at shutdown'."\n\n");
    if (!empty($shLogger->logFile))
    fClose( $shLogger->logFile);
  }
}

function _log($text, $data = '') {

  global $shLogger;
  $sefConfig = & shRouter::shGetConfig();
  static $shutdownRegistered = false;

  if (empty($sefConfig) || empty($sefConfig->debugToLogFile)) return;
  if (!empty($sefConfig->debugDuration) && (time()-$sefConfig->debugStartedAt) > $sefConfig->debugDuration)
  return;
  if (empty($shLogger)) {
    $shLogger = new shSimpleLogger( $GLOBALS['shConfigLiveSite'],
    sh404SEF_ADMIN_ABS_PATH.'logs/',
                    'sh404SEF_debug_log',
    $sefConfig->debugToLogFile);
  }
  if (!$shutdownRegistered) {
    register_shutdown_function('shCloseLogFile');
    $shutdownRegistered = true;
  }
  $shLogger->log($text, $data);
}

// J 1.5 : will put unused vars in uri query
function shRebuildVars( $appendString, &$uri) {
  if (empty( $uri)) return;
  $string = empty($appendString) ? '' : JString::ltrim($appendString, '?');
  $uri->setQuery($string);
}

function shFileExists( $fileName) {
  static $files = array();

  $fileMD5 = md5( $fileName);
  if (!isset($files[$fileMD5])) {
    $files[$fileMD5] = file_exists( $fileName);
  }
  return $files[$fileMD5];
}

function shSefRelToAbs($string, $shLanguageParam, &$uri, &$originalUri) {

  global $_SEF_SPACE, $shMosConfig_lang, $shMosConfig_locale, $mainframe,
  // shumisha 2007-03-13 added URL caching
  $shGETVars, $shRebuildNonSef,
  // V 1.2.4.m
  $shHomeLink,
  // V 1.2.4.q
  $shHttpsSave;
  _log('Entering shSefRelToAbs with '.$string.' | Lang = '.$shLanguageParam);

  $sefConfig = & shRouter::shGetConfig();

  // if superadmin, display non-sef URL, for testing/setting up purposes
  if (sh404SEF_NON_SEF_IF_SUPERADMIN) {
    $user = JFactory::getUser();
    if ($user->usertype == 'Super Administrator' ) {
      _log('Returning non-sef because superadmin said so.');
      return 'index.php';
    }
  }
  // return unmodified anchors
  if (JString::substr( $string, 0, 1) == '#') {  // V 1.2.4.t
    return $string;
  }
  // V 1.2.4.q quick fix for shared SSL server : if https, switch to non sef
  if (!empty($shHttpsSave) && $sefConfig->shForceNonSefIfHttps ) {
    _log('Returning shSefRelToAbs : Forced non sef if https');
    return shFinalizeURL($string);
  }

  $database =& JFactory::getDBO();

  $shOrigString = $string;
  $shMosMsg = shGetMosMsg($string); // V x 01/09/2007 22:45:52
  $string = shCleanUpMosMsg($string);// V x 01/09/2007 22:45:52

  // V x : removed shJoomfish module. Now we set $mosConfi_lang here
  $shOrigLang = $shMosConfig_locale; // save current language
  $shLanguage = shGetURLLang( $string);  // target language in URl is always first choice
  if (empty($shLanguage)) {
    $shLanguage = !empty($shLanguageParam) ? $shLanguageParam : $shMosConfig_locale;
  }

  // V 1.3.1 protect against those drop down lists
  if (strpos( $string, 'this.options[selectedIndex].value') !== false) {
    $string .= '&amp;lang='.shGetIsoCodeFromName($shLanguage);
    return $string;
  }
  $shMosConfig_locale = $shLanguage;
  _log('Language used : '.$shLanguage);

  // V 1.2.4.t workaround for old links like option=compName instead of option=com_compName
  if ( strpos(strtolower($string), 'option=login') === false && strpos(strtolower($string), 'option=logout') === false &&
  strpos(strtolower($string), 'option=&') === false && JString::substr(strtolower($string), -7) != 'option='
  && strpos(strtolower($string), 'option=cookiecheck') === false
  && strpos(strtolower($string), 'option=') !== false && strpos(strtolower($string), 'option=com_') === false) {
    $string = str_replace('option=', 'option=com_', $string);
  }
  // V 1.2.4.k added homepage check : needed in case homepage is not com_frontpage
  if (empty($shHomeLink)) {  // first, find out about homepage link, from DB. homepage is not always /index.php or similar
    // it can be a link to anything, a page, a component,...
    $menu = & shRouter::shGetMenu();
    $shHomePage = & $menu->getDefault();

    if ($shHomePage) {
      if ( (JString::substr( $shHomePage->link, 0, 9) == 'index.php')  // if link on homepage is a local page
      && (!preg_match( '/Itemid=[0-9]*/', $shHomePage->link))) {  // and it does not have an Itemid
        $shHomePage->link .= ($shHomePage->link == 'index.php' ? '?':'&').'Itemid='.$shHomePage->id;  // then add itemid
      }
      $shHomeLink = $shHomePage->link;
      if (!strpos($shHomeLink,'lang=')) {
        // V 1.2.4.q protect against not existing
        $shDefaultIso = shGetIsoCodeFromName(shGetDefaultLang());
        $shSepString = (JString::substr($shHomeLink, -9) == 'index.php' ? '?':'&');
        $shHomeLink .= $shSepString.'lang='.$shDefaultIso;
      }
      $shHomeLink = shSortUrl($shHomeLink);  // $shHomeLink has lang info, whereas $homepage->link may or may not
    }
    _log('HomeLink = '. $shHomeLink);
  }

  // V 1.2.4.j string to be appended to URL, but not saved to DB
  $shAppendString = '';
  $shRebuildNonSef = array();
  $shComponentType = '';  // V w initialize var to avoid notices

  if ($shHomeLink) {  // now check URL against our homepage, so as to always return / if homepage
    $v1 = JString::ltrim(str_replace($GLOBALS['shConfigLiveSite'], '', $string), '/');
    // V 1.2.4.m : remove anchor if any
    $v2 = explode( '#', $v1);
    $v1 = $v2[0];
    $shAnchor = isset($v2[1]) ? '#'.$v2[1] : '';
    $shSepString = (JString::substr($v1, -9) == 'index.php' ? '?':'&');
    $shLangString = $shSepString.'lang='.shGetIsoCodeFromName($shLanguage);
    if (!strpos($v1,'lang=')) {
      $v1 .= $shLangString;
    }
    $v1 = str_replace('&amp;', '&', shSortURL($v1));
    // V 1.2.4.t check also without pagination info
    if (strpos( $v1, 'limitstart=0') !== false) {  // the page has limitstart=0
      $stringNoPag = shCleanUpPag($v1);  // remove paging info to be sure this is not homepage
    } else $stringNoPag = null;
    if ($v1 == $shHomeLink || $v1 == 'index.php'.$shLangString
    || $stringNoPag == $shHomeLink)  { // V 1.2.4.t 24/08/2007 11:07:49
      $shTemp = ($v1 == $shHomeLink || shIsDefaultLang($shLanguage)?
          '' : shGetIsoCodeFromName($shLanguage).'/');  //10/08/2007 17:28:14
      if (!empty($shMosMsg) ) // V x 01/09/2007 22:48:01
      $shTemp .= '?'.$shMosMsg;
      if (!empty($sefConfig->shForcedHomePage)) { // V 1.2.4.t
        $shTmp = $shTemp.$shAnchor;
        $ret = shFinalizeURL($sefConfig->shForcedHomePage.(empty($shTmp) ? '' : '/'.$shTmp));
        if (empty($uri))  // if no URI, append remaining vars directly to the string
        $ret .= $shAppendString;
        else
        shRebuildVars( $shAppendString, $uri);
        $shMosConfig_locale = $shOrigLang;
        _log('Returning shSefRelToAbs 1 with '.$ret);
        return $ret;
      } else {
        $shRewriteBit = shIsDefaultLang($shLanguage)? '/': $sefConfig->shRewriteStrings[$sefConfig->shRewriteMode];
        $ret = shFinalizeURL($GLOBALS['shConfigLiveSite'].$shRewriteBit.$shTemp.$shAnchor);
        if (empty($uri))  // if no URI, append remaining vars directly to the string
        $ret .= $shAppendString;
        else
        shRebuildVars( $shAppendString, $uri);
        $shMosConfig_locale = $shOrigLang;
        _log('Returning shSefRelToAbs 2 with '.$ret);
        return $ret;
      }
    }
  }

  $newstring = str_replace($GLOBALS['shConfigLiveSite'].'/', '', $string);
  // check for url to same site, but with SSL : Joomla 1.5 does not allow it yet
  //$liveSiteSsl = str_replace('http://', 'https://', $GLOBALS['shConfigLiveSite']);
  //$newStringSsl = str_replace($liveSiteSsl.'/', '', $string);

  $letsGo = JString::substr($newstring,0,9) == 'index.php'
  && (strpos( $newstring, 'this.options[selectedIndex\].value' ) === false);
  $letsGoSsl = false;
  if ($letsGo || $letsGoSsl)
  {
    // Replace & character variations.
    $string = str_replace(array('&amp;', '&#38;'), array('&', '&'), $letsGo ? $newstring : $newStringSsl);
    $newstring = $string; // V 1.2.4.q
    $shSaveString = $string;
    // warning : must add &lang=xx (only if it does not exists already), so as to be able to recognize the SefURL in the db if it's there
    if (!strpos($string,'lang=')) {
      $shSepString = (JString::substr($string, -9) == 'index.php' ? '?':'&');
      $anchorTable = explode('#', $string); // V 1.2.4.m remove anchor before adding language
      $string = $anchorTable[0];
      $string .= $shSepString.'lang='.shGetIsoCodeFromName($shLanguage)
      .(!empty($anchorTable[1])? '#'.$anchorTable[1]:''); // V 1.2.4.m then stitch back anchor
    }
    $URI = new sh_Net_URL($string);
    // V 1.2.4.l need to save unsorted URL
    if (count($URI->querystring) > 0) {
      // Import new vars here.
      $option = null;
      $task = null;
      //$sid = null;  V 1.2.4.s
      // sort GET parameters to avoid some issues when same URL is produced with options not
      // in the same order, ie index.php?option=com_virtuemart&category_id=3&Itemid=2&lang=fr
      // Vs index.php?category_id=3&option=com_virtuemart&Itemid=2&lang=fr
      ksort($URI->querystring);  // sort URL array
      $string = shSortUrl($string);
      // now we are ready to extract vars
      $shGETVars = $URI->querystring;
      extract($URI->querystring, EXTR_REFS);
    }

    if (empty($option)) {// V 1.2.4.r protect against empty $option : we won't know what to do
      $shMosConfig_locale = $shOrigLang;
      _log('Returning shSefRelToAbs 3 with '.$shOrigString);
      return $shOrigString;
    }
    $shOption = str_replace('com_', '', $option);
    switch ($shOption) {
      case (in_array($shOption, $sefConfig->skip)):
        $shComponentType = 'skip';
        break;
      case (in_array($shOption, $sefConfig->nocache)):
        $shComponentType = 'noCache';
        break;
      default:
        $shComponentType = 'sh404SEF';
        break;
    }

    // V 1.2.4.s : fallback to to JoomlaSEF if no extension available
    // V 1.2.4.t : this is too early ; it prevents manual custom redirect to be checked agains the requested non-sef URL
    if (($shComponentType == 'sh404SEF')
    && !shFileExists(sh404SEF_ABS_PATH.'components/com_sh404sef/sef_ext/'.$option.'.php')
    && !shFileExists(sh404SEF_ABS_PATH.'components/'.$option.'/sef_ext.php')
    && !shFileExists(sh404SEF_ABS_PATH.'components/'.$option.'/sef_ext/'.$option.'.php')  // V 1.2.4.s native plugin can be in comp own /sef_ext/dir - allows deliv of plugin with comp
    && !shFileExists(sh404SEF_ABS_PATH.'components'.DS.$option.DS.'router.php')
    ) {
      $shComponentType = 'sh404SEFFallback';
    }
    _log('Component type = '.$shComponentType);
    // is there a named anchor attached to $string? If so, strip it off, we'll put it back later.
    if ($URI->anchor)
    $string = str_replace('#'.$URI->anchor, '', $string);  // V 1.2.4.m
    // shumisha special homepage processing (in other than default language)
    if  ((shIsHomePage($string)) || ($string == 'index.php')  // 10/08/2007 18:13:43
    ){
      $sefstring = '';
      $urlType = shGetSefURLFromCacheOrDB($string, $sefstring);
      // still use it so we need it both ways
      if (($urlType == sh404SEF_URLTYPE_NONE || $urlType == sh404SEF_URLTYPE_404) && empty($showall) && (!empty($limit) || (!isset($limit) && !empty($limitstart))) ) {
        $urlType = shGetSefURLFromCacheOrDB(shCleanUpPag($string), $sefstring); // V 1.2.4.t check also without page info
        //to be able to add pagination on custom
        //redirection or multi-page homepage
        if ($urlType != sh404SEF_URLTYPE_NONE && $urlType != sh404SEF_URLTYPE_404) {
          $sefstring = shAddPaginationInfo( @$limit, @$limitstart, @showall,1, $string, $sefstring, null);
          // a special case : com_content  does not calculate pagination right
          // for frontpage and blog, they include links shown at the bottom in the calculation of number of items
          // For instance, with joomla sample data, the frontpage has only 5 articles
          // but the view sets $limit to 9 !!!
          if (($option == 'com_content' && isset($layout) && $layout == 'blog')
          || ($option == 'com_content' && isset( $view) && $view == 'frontpage' )) {
            $listLimit = shGetDefaultDisplayNumFromURL($string, $includeBlogLinks = true);
            $string = shSetURLVar( $string, 'limit', $listLimit);
            $string = shSortUrl($string);
          }

          // that's a new URL, so let's add it to DB and cache
          shAddSefUrlToDBAndCache( $string, $sefstring, 0, $urlType);  // created url must be of same type as original
        }
        if ($urlType == sh404SEF_URLTYPE_NONE || $urlType == sh404SEF_URLTYPE_404) {
          require_once(sh404SEF_FRONT_ABS_PATH.'sef_ext.php');
          $sef_ext = new sef_404();
          // Rewrite the URL now.
          // a special case : com_content  does not calculate pagination right
          // for frontpage and blog, they include links shown at the bottom in the calculation of number of items
          // For instance, with joomla sample data, the frontpage has only 5 articles
          // but the view sets $limit to 9 !!!
          if (($option == 'com_content' && isset($layout) && $layout == 'blog')
          || ($option == 'com_content' && isset( $view) && $view == 'frontpage' )) {
            $listLimit = shGetDefaultDisplayNumFromURL($string, $includeBlogLinks = true);
            $string = shSetURLVar( $string, 'limit', $listLimit);
            $string = shSortUrl($string);
            //$URI->addQueryString( 'limit', $listLimit);
          }
          $sefstring = $sef_ext->create($string, $URI->querystring, $shAppendString, $shLanguage, $shOrigString, $originalUri); // V 1.2.4.s added original string
        }
      } else if (($urlType == sh404SEF_URLTYPE_NONE || $urlType == sh404SEF_URLTYPE_404)) {  // not found but no $limit or $limitstart
        $sefstring = shGetIsoCodeFromName($shLanguage).'/';
        shAddSefUrlToDBAndCache( $string, $sefstring, 0, sh404SEF_URLTYPE_AUTO); // create it
      }
      // V 1.2.4.j : added $shAppendString to pass non sef parameters. For use with parameters that won't be stored in DB
      $ret = $GLOBALS['shConfigLiveSite'].(empty( $sefstring) ? '' : $sefConfig->shRewriteStrings[$sefConfig->shRewriteMode].$sefstring);

      // not valid with 1.5 anymore                       ;
      //if (!empty($shMosMsg)) // V x 01/09/2007 22:48:01
      //  $ret .= (empty($shAppendString) || $sefConfig->shRewriteStrings[$sefConfig->shRewriteMode] == '/index.php?/' ? '?':'&').$shMosMsg;
      $ret = shFinalizeURL($ret);
      if (empty($uri))  // if no URI, append remaining vars directly to the string
      $ret .= $shAppendString;
      else
      shRebuildVars( $shAppendString, $uri);
      $shMosConfig_locale = $shOrigLang;
      _log('Returning shSefRelToAbs 4 with '.$ret);
      return $ret;
    }

    if (isset($option) && !($option=='com_content' && @$task == 'edit') && (strtolower($option) != 'com_sh404sef')) { // V x 29/08/2007 23:19:48
      // check also that option = com_content, otherwise, breaks some comp
      switch ($shComponentType) {
        case 'skip': {
          $sefstring = $shSaveString;  // V 1.2.4.q : restore untouched URL, except anchor
          // which will be added later
          break;
        }
        case 'noCache':
        case 'sh404SEFFallback': // v 1.2.4.t

          // check for custom urls
          $sefstring = '';
          $urlType = shGetSefURLFromCacheOrDB($string, $sefstring);
          // if no custom found, then build default url
          if ($urlType != sh404SEF_URLTYPE_CUSTOM) {
            // if not found then fall back to Joomla! SEF
            if (isset($URI)) {
              unset($URI);
            }
            $sefstring = 'component/';
            $URI = new sh_Net_URL(shSortUrl($shSaveString));
            if (count($URI->querystring) > 0) {
              foreach($URI->querystring as $key => $value) {
                $sefstring .= "$key,$value/";
              }
              $sefstring = str_replace( 'option/', '', $sefstring );
            }
          }
          break;
        default: {
          $sefstring='';
          $urlType = shGetSefURLFromCacheOrDB($string, $sefstring); // V 1.2.4.t
          if (($urlType == sh404SEF_URLTYPE_NONE || $urlType == sh404SEF_URLTYPE_404) && empty( $showall) && (!empty($limit) || (!isset($limit) && !empty($limitstart)))) {
            $urlType = shGetSefURLFromCacheOrDB(shCleanUpPag($string), $sefstring); // search without pagination info
            if ($urlType != sh404SEF_URLTYPE_NONE && $urlType != sh404SEF_URLTYPE_404) {
              $sefstring = shAddPaginationInfo( @$limit, @$limitstart, @showall, 1, $string, $sefstring, null);
              // a special case : com_content  does not calculate pagination right
              // for frontpage and blog, they include links shown at the bottom in the calculation of number of items
              // For instance, with joomla sample data, the frontpage has only 5 articles
              // but the view sets $limit to 9 !!!
              if (($option == 'com_content' && isset($layout) && $layout == 'blog')
              || ($option == 'com_content' && isset( $view) && $view == 'frontpage' )) {
                $listLimit = shGetDefaultDisplayNumFromURL($string, $includeBlogLinks = true);
                $string = shSetURLVar( $string, 'limit', $listLimit);
                $string = shSortUrl($string);
              }

              // that's a new URL, so let's add it to DB and cache
              shAddSefUrlToDBAndCache( $string, $sefstring, 0, $urlType);
            }
          }

          if ($urlType == sh404SEF_URLTYPE_NONE) {
            // If component has its own sef_ext plug-in included.
            $shDoNotOverride = in_array( $shOption, $sefConfig->shDoNotOverrideOwnSef);
            if (shFileExists(sh404SEF_ABS_PATH.'components/'.$option.'/sef_ext.php')
            && ($shDoNotOverride                   // and param said do not override
            || (!$shDoNotOverride              // or param said override, but we don't have a plugin either in sh404SEF dir or component sef_ext dir
            && (!shFileExists(sh404SEF_ABS_PATH
            .'components/com_sh404sef/sef_ext/'.$option.'.php')
            &&
            !shFileExists(sh404SEF_ABS_PATH
            .'components/'.$option.'/sef_ext/'.$option.'.php') )
            ))) {
              // Load the plug-in file. V 1.2.4.s changed require_once to include
              include_once(sh404SEF_ABS_PATH.'components/'.$option.'/sef_ext.php');
              $_SEF_SPACE = $sefConfig->replacement;
              $comp_name = str_replace('com_', '', $option);
              $className = 'sef_' . $comp_name;
              $sef_ext = new $className;
              // V x : added default string in params
              if (empty($sefConfig->defaultComponentStringList[$comp_name]))
              $title[] = getMenuTitle($option, null, isset($Itemid) ? @$Itemid : null, null, $shLanguage); // V 1.2.4.x
              else $title[] = $sefConfig->defaultComponentStringList[$comp_name];
              // V 1.2.4.r : clean up URL BEFORE sending it to sef_ext files, to have control on what they do
              // remove lang information, we'll put it back ourselves later
              //$shString = preg_replace( '/(&|\?)lang=[a-zA-Z]{2,3}/iU' ,'', $string);
              // V 1.2.4.t use original non-sef string. Some sef_ext files relies on order of params, which may
              // have been changed by sh404SEF
              $shString = preg_replace( '/(&|\?)lang=[a-zA-Z]{2,3}/iU' ,'', $shSaveString);
              $finalstrip = explode("|", $sefConfig->stripthese);
              $shString = str_replace('&', '&amp;', $shString);
              _log('Sending to own sef_ext.php plugin : '.$shString);
              $sefstring = $sef_ext->create($shString);
              _log('Created by sef_ext.php plugin : '.$sefstring);
              $sefstring = str_replace("%10", "%2F", $sefstring);
              $sefstring = str_replace("%11", $sefConfig->replacement, $sefstring);
              $sefstring = rawurldecode($sefstring);
              if ($sefstring == $string) {
                if (!empty($shMosMsg)) // V x 01/09/2007 22:48:01
                $string .= '?'.$shMosMsg;
                $ret = shFinalizeURL($string);
                $shMosConfig_locale = $shOrigLang;
                _log('Returning shSefRelToAbs 5 with '.$ret);
                return $ret;
              }
              else {
                // V 1.2.4.p : sef_ext extensions for opensef/SefAdvance do not always replace '
                $sefstring = str_replace( '\'', $sefConfig->replacement, $sefstring);
                // some ext. seem to html_special_chars URL ?
                $sefstring = str_replace( '&#039;', $sefConfig->replacement, $sefstring); // V w 27/08/2007 13:23:56
                $sefstring = str_replace(' ', $_SEF_SPACE, $sefstring);
                $sefstring = str_replace(' ', '',
                (shInsertIsoCodeInUrl($option, $shLanguage) ?   // V 1.2.4.q
                shGetIsoCodeFromName($shLanguage).'/' : '')
                .titleToLocation($title[0]).'/'.$sefstring.(($sefstring != '') ? $sefConfig->suffix : ''));
                if (!empty($sefConfig->suffix))
                $sefstring = str_replace('/'.$sefConfig->suffix, $sefConfig->suffix, $sefstring);

                //$finalstrip = explode("|", $sefConfig->stripthese);
                $sefstring = str_replace($finalstrip, $sefConfig->replacement, $sefstring);
                $sefstring = str_replace($sefConfig->replacement.$sefConfig->replacement.$sefConfig->replacement,
                $sefConfig->replacement, $sefstring);
                $sefstring = str_replace($sefConfig->replacement.$sefConfig->replacement,
                $sefConfig->replacement, $sefstring);
                $suffixthere = 0;
                if (!empty($sefConfig->suffix) && strpos($sefstring, $sefConfig->suffix ) !== false)  // V 1.2.4.s
                $suffixthere = strlen($sefConfig->suffix);
                $takethese = str_replace("|", "", $sefConfig->friendlytrim);
                $sefstring = JString::trim(JString::substr($sefstring,0,strlen($sefstring)-$suffixthere), $takethese);
                $sefstring .= $suffixthere == 0 ? '': $sefConfig->suffix;  // version u 26/08/2007 17:27:16
                // V 1.2.4.m store it in DB so as to be able to use sef_ext plugins really !
                $string = str_replace('&amp;', '&', $string);
                // V 1.2.4.r without mod_rewrite
                $shSefString = shAdjustToRewriteMode($sefstring);
                // V 1.2.4.p check for various URL for same content
                $dburl = ''; // V 1.2.4.t prevent notice error
                $urlType = sh404SEF_URLTYPE_NONE;
                if ($sefConfig->shUseURLCache)
                $urlType = shGetNonSefURLFromCache($shSefString, $dburl);
                $newMaxRank = 0; // V 1.2.4.s
                $shDuplicate = false;
                if ($sefConfig->shRecordDuplicates || $urlType == sh404SEF_URLTYPE_NONE) {  // V 1.2.4.q + V 1.2.4.s+t
                  $sql = "SELECT newurl, rank, dateadd FROM #__redirection WHERE oldurl = '"
                  .$shSefString."' ORDER BY rank ASC";
                  $database->setQuery($sql);
                  $dbUrlList = $database->loadObjectList();
                  if (count($dbUrlList) > 0) {
                    $dburl = $dbUrlList[0]->newurl;
                    $newMaxRank = $dbUrlList[count($dbUrlList)-1]->rank+1;
                    $urlType = $dbUrlList[0]->dateadd == '0000-00-00' ? sh404SEF_URLTYPE_AUTO : sh404SEF_URLTYPE_CUSTOM;
                  }
                }
                if ($urlType != sh404SEF_URLTYPE_NONE && ($dburl != $string)) $shDuplicate = true;
                $urlType = $urlType == sh404SEF_URLTYPE_NONE ? sh404SEF_URLTYPE_AUTO : $urlType;
                _log('Adding from sef_ext to DB : '.$shSefString.' | rank = '.($shDuplicate?$newMaxRank:0) );
                shAddSefUrlToDBAndCache( $string, $shSefString, ($shDuplicate?$newMaxRank:0), $urlType);
              }
            }
            // Component has no own sef extension.
            else {
              $string = JString::trim($string, "&?");

              // V 1.2.4.q a trial in better handling homepage articles
              if (shIsCurrentPageHome() && ($option == 'com_content')    // com_content component on homepage
              && (isset($task)) && ($task == 'view')
              && $sefConfig->guessItemidOnHomepage) {
                $string = preg_replace( '/(&|\?)Itemid=[^&]*/i', '', $string);  // we remove Itemid, as com_content plugin
                $Itemid = null;                                     // will hopefully do a better job at finding the right one
                unset($URI->querystring['Itemid']);
                unset($shGETVars['Itemid']);
              }

              require_once(sh404SEF_FRONT_ABS_PATH.'sef_ext.php');
              $sef_ext = new sef_404();
              // Rewrite the URL now. // V 1.2.4.s added original string
              // a special case : com_content  does not calculate pagination right
              // for frontpage and blog, they include links shown at the bottom in the calculation of number of items
              // For instance, with joomla sample data, the frontpage has only 5 articles
              // but the view sets $limit to 9 !!!
              if (($option == 'com_content' && isset($layout) && $layout == 'blog')
              || ($option == 'com_content' && isset( $view) && $view == 'frontpage' )) {
                $listLimit = shGetDefaultDisplayNumFromURL($string, $includeBlogLinks = true);
                $string = shSetURLVar( $string, 'limit', $listLimit);
                $string = shSortUrl($string);
                //$URI->addQueryString( 'limit', $listLimit);
              }
              $sefstring = $sef_ext->create($string, $URI->querystring, $shAppendString, $shLanguage, $shOrigString, $originalUri);
            }
          }
        }
      } // end of cache check shumisha
      if (isset($sef_ext)) unset($sef_ext);
      // V 1.2.4.j
      // V 1.2.4.r : checked for double //
      // V 1.2.4.r try sef without mod_rewrite
      $shRewriteBit = $shComponentType == 'skip' ? '/': $sefConfig->shRewriteStrings[$sefConfig->shRewriteMode];
      if (strpos($sefstring,'index.php') === 0 ) $shRewriteBit = '/';  // V 1.2.4.t bug #119
      $string =  $GLOBALS['shConfigLiveSite'].$shRewriteBit.JString::ltrim( $sefstring, '/')
      //.$shAppendString  // J 1.5 already do this
      //. (empty($shMosMsg) ? '' :
      //    (empty($shAppendString)
      //    || $sefConfig->shRewriteStrings[$sefConfig->shRewriteMode] == '/index.php?/' ? '?':'&').$shMosMsg)
      .(($URI->anchor)?"#".$URI->anchor:'');
    }
    else {  // V x 03/09/2007 13:47:37 editing content
      $shComponentType = 'skip';  // will prevent turning & into &amp;
    }
    $ret = $string;
    // $ret = str_replace('itemid', 'Itemid', $ret); // V 1.2.4.t bug #125
  }
  if (!isset($ret)) $ret = $string;
  //if (!empty($shMosMsg) && strpos($ret, $shMosMsg) === false) // V x 01/09/2007 23:02:00
  //   $ret .= (strpos( $ret, '?') === false  || $sefConfig->shRewriteStrings[$sefConfig->shRewriteMode] == '/index.php?/'? '?':'&').$shMosMsg;
  $ret = ($shComponentType == 'sh404SEF') ? shFinalizeURL($ret) : $ret;  // V w 27/08/2007 13:21:28
  if (empty($uri) || $shComponentType == 'skip') {  // we don't have a uri : we must be doing a redirect from non-sef to sef or similar
    $ret .= $shAppendString;  // append directly to url
  } else {
    if ( empty( $sefstring) || (!empty( $sefstring) && strpos( $sefstring, 'index.php') !== 0 )) {
      shRebuildVars( $shAppendString, $uri);  // instead, add to uri. Joomla will put everything together. Only do this if we have a sef url, and not if we have a non-sef
    }
  }
  $shMosConfig_locale = $shOrigLang;
  return $ret;
}

// V 1.2.4.t returns sef url with added pagination information
function shAddPaginationInfo( $limit, $limitstart, $showall, $iteration, $url, $location, $shSeparator = null){
  global $mainframe;
  /*  if (strpos( $url, 'option=com_myblog') !== false)
   echo 'Incoming pagination : ' . $url . ' | limit : ' . $limit . ' | start : ' . $limitstart . "\n";*/
  $sefConfig = & shRouter::shGetConfig();
  $database =& JFactory::getDBO();

  // get a default limit value, for urls where it's missing
  $listLimit = shGetDefaultDisplayNumFromURL($url, $includeBlogLinks = true);
  $defaultListLimit = shGetDefaultDisplayNumFromConfig( $url, $includeBlogLinks = false);
  /*  if (strpos( $url, 'option=com_myblog') !== false)
   echo 'Incoming pagination : $listLimit : ' . $listLimit . ' | $defaultListLimit : ' . $defaultListLimit . "\n";*/

  // clean suffix and index file before starting to add things to the url
  // clean suffix
  if (strpos($url, 'option=com_content') !== false && strpos($url, 'format=pdf') !== false) {
    $shSuffix = '.pdf';
  } else {
    $shSuffix = $sefConfig->suffix;
  }
  $suffixLength = JString::strLen( $shSuffix);
  if (!empty($shSuffix) && ($shSuffix != '/') && JString::substr( $location, -$suffixLength) == $shSuffix) {
    $location = JString::substr($location,0,JString::strlen($location) - $suffixLength);
  }

  // clean index file
  if ($sefConfig->addFile && (empty($shSuffix) || JString::subStr( $location, -$suffixLength) != $shSuffix)) {
    $indexFileLength = JString::strlen( $sefConfig->addFile);
    if (($sefConfig->addFile != '/') && JString::substr( $location, -$indexFileLength) == $sefConfig->addFile) {
      $location = JString::substr( $location, 0, JString::strlen($location) - $indexFileLength);
    }
  }

  // do we have a trailing slash ?
  if (empty($shSeparator)) {
    $shSeparator = (JString::substr($location, -1) == '/') ? '':'/';
  }
  if (!empty($limit) && is_numeric( $limit)) {
    $pagenum = intval($limitstart/$limit);
    $pagenum++;
  } else if (!isset($limit) && !empty($limitstart)) {  // only limitstart
    if (strpos( $url, 'option=com_content') !== false && strpos( $url, 'view=article') !== false) {
      $pagenum = intval($limitstart+1);   // multipage article
    }
    else {
      $pagenum = intval($limitstart/$listLimit)+1;  // blogs, tables, ...
    }
  } else {
    $pagenum = $iteration;
  }
  // Make sure we do not end in infite loop here.
  if ($pagenum < $iteration)
  $pagenum = $iteration;
  // shumisha added to handle table-category and table-section which may have variable number of items per page
  // There still will be a problem with filter, which may reduce the total number of items. Thus the item we are looking for
  if ( $sefConfig->alwaysAppendItemsPerPage || (strpos($url,'option=com_virtuemart') && $sefConfig->shVmUsingItemsPerPage)) {
    $shMultPageLength= $sefConfig->pagerep.(empty($limit) ? $listLimit : $limit);
  } else $shMultPageLength= '';
  // shumisha : modified to add # of items per page to URL, for table-category or section-category

  if (!empty($sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']])
  && (false !== strpos($sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']], '%s'))){
    $page = str_replace('%s', $pagenum, $sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']]).$shMultPageLength;
  } else {
    $page = $sefConfig->pagerep.$pagenum.$shMultPageLength;
  }

  // V 1.2.4.t special processing to replace page number by headings
  $shPageNumberWasReplaced = false;
  if (  strpos($url, 'option=com_content') !== false
  && strpos($url, 'view=article') !== false && !empty($limitstart) ) {  // this is multipage article - limitstart instead of limit in J1.5
    if ( $sefConfig->shMultipagesTitle ) {
      parse_str($url, $shParams);
      if (!empty($shParams['id'])) {
        $shPageTitle = '';
        $sql = 'SELECT c.id, c.fulltext, c.introtext  FROM #__content AS c WHERE id=\''.$shParams['id'].'\'';
        $database->setQuery($sql);
        $contentElement = $database->loadObject( );
        if ($database->getErrorNum()) {
          JError::RaiseError( 500, $database->stderr());
        }
        $contentText = $contentElement->introtext.$contentElement->fulltext;
        if (!empty($contentElement) && ( strpos( $contentText, 'class="system-pagebreak' ) !== false )) { // search for mospagebreak tags
          // copied over from pagebreak plugin
          // expression to search for
          $regex = '#<hr([^>]*)class=\"system-pagebreak\"([^>]*)\/>#iU';
          // find all instances of mambot and put in $matches
          $shMatches = array();
          preg_match_all( $regex, $contentText, $shMatches, PREG_SET_ORDER );
          // adds heading or title to <site> Title
          if (empty($limitstart)) {  // if first page use heading of first mospagebreak
            /* if ( $shMatches[0][2] ) {
             parse_str( html_entity_decode( $shMatches[0][2] ), $args );
             if ( @$args['heading'] ) {
             $shPageTitle = stripslashes( $args['heading'] );
             }
             }*/
          } else {  // for other pages use title of mospagebreak
            if ( $limitstart > 0 && $shMatches[$limitstart-1][1] ) {
              $args = JUtility::parseAttributes( $shMatches[$limitstart-1][1] );
              if ( @$args['title'] ) {
                $shPageTitle = $args['title'];
              } else if (@$args['alt']) {
                $shPageTitle = $args['alt'];
              } else {  // there is a page break, but no title. Use a page number
                $shPageTitle = str_replace('%s', $limitstart+1, $sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']]);
              }
            }
          }
        }
        if (!empty($shPageTitle)) { // found a heading, we should use that as a Title
          $location .= $shSeparator.titleToLocation($shPageTitle);
        }
        $shPageNumberWasReplaced = true;  // always set the flag, otherwise we'll a Page-1 added
      }
    } else {
      // mutiple pages article, but we don't want to use smart title.
      // directly use limitstart
      $page = str_replace('%s', $limitstart+1, $sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']]);
    }
  }
  // maybe this is a multipage with "showall=1"
  if ( strpos($url, 'option=com_content') !== false
  && strpos($url, 'view=article') !== false && strpos($url, 'showall=1') !== false ) {  // this is multipage article with showall
    $tempTitle = JText::_( 'All Pages' );
    $location .= $shSeparator. titleToLocation( $tempTitle);
    $shPageNumberWasReplaced = true;  // always set the flag, otherwise we'll a Page-1 added
  }

  // make sure we remove bad characters
  $takethese = str_replace('|', '', $sefConfig->friendlytrim);
  $location = JString::trim( $location, $takethese);

  // add page number
  if (!$shPageNumberWasReplaced
  && (
  (!isset($limitstart) && (isset($limit) && $limit != $listLimit && $limit != $defaultListLimit))
  ||
  ((isset($limitstart)
  && ($limitstart != 0                  // if not first page, add items per page
  || ($limitstart == 0                // if first page, we may add number of items per page if the
  && ((strpos($url,'option=com_virtuemart')     // requested number of items per page is not the default one
  && $sefConfig->shVmUsingItemsPerPage
  && (isset($limit) && $limit != $listLimit)  // // for Virtuemart, default is Joomla global default
  ) ) ) ) ) )
  )
  ) {
    $location .= $shSeparator.$page;
    /*echo 'adding ' . $page . "\n";*/
  }
  // add suffix
  if (!empty($shSuffix) && $location != '/' && JString::substr($location, -1) != '/') {
    $location = $shSuffix == '/' ?
    $location.$shSuffix
    : str_replace($shSuffix, '', $location).$shSuffix;
  }

  // add default index file
  if ($sefConfig->addFile){ // V 1.2.4.t
    if ((empty($shSuffix)
    || (!empty($shSuffix) && JString::subStr( $location, -$suffixLength) != $shSuffix) ) )
    $location .= (JString::substr($location, -1) == '/' ? '':'/').$sefConfig->addFile;
  }
  return JString::ltrim($location, '/');
}


// V 1.2.4.t check if this is a request for VM cookie check AND done by a search engine
// if so, this has to be an old link left over in search engine index, and  we must 301 redirectt to
// same URl without vmvhk/
function shCheckVMCookieRedirect() {

  global $shCurrentPageURL;

  if (shIsSearchEngine() && strpos($shCurrentPageURL, 'vmchk/') !== false) {
    shRedirect( str_replace('vmchk/', '', $shCurrentPageURL));
  }
}




/*
 * 404SEF SUPPORT FUNCTIONS
 */

// @TODO: deprecate this function, we don't need sef_ext.php file
// to perform decoding
function sef_ext_exists($this_name)
{

  /*  $sefConfig = & shRouter::shGetConfig();

  $database =& JFactory::getDBO();
  // check for sef_ext
  $this_name = str_replace($sefConfig->replacement, " ", $this_name);
  $this_name = str_replace('\'', '', $this_name);  // V 1.2.4.t 21/08/2007 20:45:58 bug #165
  $sql = "SELECT `id`,`link` FROM #__menu  WHERE ((`name` LIKE '%".$this_name."%') AND (`published` > 0))";
  $database->setQuery($sql);
  $rows = @$database->loadObjectList();

  if ($database->getErrorNum()) {
  JError::RaiseError( 500, $database->stderr());
  }

  if (@count($rows) > 0) {
  $option = str_replace("index.php?option=","",$rows[0]->link);
  if (shFileExists(sh404SEF_ABS_PATH."components/$option/sef_ext.php")){
  return @$rows[0];
  }
  else {
  unset($rows);
  }
  }*/

  return null;
}

function getExt($URL_ARRAY)
{

  $sefConfig = & shRouter::shGetConfig();

  $database =& JFactory::getDBO();
  $ext = array();
  $row = sef_ext_exists($URL_ARRAY[0]);
  $ext['path'] = sh404SEF_FRONT_ABS_PATH.'sef_ext.php';

  if (is_object($row)) {
    $option = str_replace("index.php?option=","",$row->link);
    $ext['path'] = sh404SEF_ABS_PATH."components/$option/sef_ext.php";
  }
  elseif ((strpos($URL_ARRAY[0], "com_") !== false) or ($URL_ARRAY[0] == "component")) {
    $option = "com_component";
  }
  elseif($URL_ARRAY[0] == 'content') {
    $option = "com_content";
  }
  else{
    $option = "404";
  }
  $ext['name'] = str_replace("com_","",$option);

  return $ext;
}

function is_valid($string)
{
  global $base, $index;
  if (empty($string))
  $state = false;
  elseif (($string == $index )|($string == $base.$index )) {
    $state = true ;
  }
  else {
    $state = false;
    require_once(sh404SEF_FRONT_ABS_PATH.'sef_ext.php');
    $sef_ext = new sef_404;
    $option = (isset($_GET['option'])) ? $_GET['option'] : (isset($_REQUEST['option'])) ? $_REQUEST['option'] : null;

    $vars = array();
    if (is_null($option)) {
      parse_str($string, $vars);
      if (isset($vars['option'])) {
        $option = $vars['option'];
      }
    }
    switch ($option) {
      case is_null($option):
        break;
      case "login":   /*Beat: makes this also compatible with CommunityBuilder login module*/
      case "logout": {
        $state = true;
        break;
      }
      default: {
        if (is_valid_component($option)){
          if ((!($option == "com_content"))|(!($option == "content"))) {
            $state = true;
          }
          else {
            $title=$sef_ext->getContentTitles($_REQUEST['view'],$_REQUEST['id'], empty($_REQUEST['layout']) ? '' : $_REQUEST['layout']);
            if (count($title) > 0) {
              $state = true;
            }
          }
        }
        // shumisha check if this is homepage+lang=xx
        else {
          if (JString::substr($string,0,5)=='lang=')
          $state = true;
        }
        // shumisha end of change
      }
    }
  }
  return $state;
}

function is_valid_component($this)
{
  $state = false;
  $path = sh404SEF_ABS_PATH .'components/';

  if (is_dir($path)) {
    if (($contents = opendir($path))) {
      while (($node = readdir($contents)) !== false) {
        if ($node != '.' && $node != '..') {
          if (is_dir($path.'/'.$node) && $this == $node) {
            $state = true;
            break;
          }
        }
      }
    }
  }
  return $state;
}

// V 1.2.4.q detect homepage, disregarding language and pagination
function shIsHomepage( $string) {

  static $pages = array();

  global $shHomeLink;

  $md5 = md5( $string);
  if( !isset( $pages[$md5])) {
    $shTempString = JString::rtrim(str_replace($GLOBALS['shConfigLiveSite'], '', $string), '/');
    $pages[$md5] = shSortUrl(shCleanUpLangAndPag($shTempString)) == shSortUrl(shCleanUpLangAndPag($shHomeLink)); // version t added sorting
  }
  return $pages[$md5];
}

function getMenuTitle($option, $task, $id = null, $string = null, $shLanguage = null)
{
  global $shHomeLink;

  $sefConfig = & shRouter::shGetConfig();

  $database =& JFactory::getDBO();
  $shLanguage = empty($shLanguage) ? $GLOBALS['shMosConfig_locale'] : $shLanguage;
  // V 1.2.4.q must also check if homepage, in any language. If homepage, must return $title[]='/'
  // language info and limit/limistart pagination will be added at final stage by sefGetLocation()
  // V 1.2.4.t must also check that menu item is published !!

  $nameField = $sefConfig->useMenuAlias ? 'alias' : 'name';

  if (!empty($string)) {  // V 1.2.4.q replaced isset by empty
    $sql = "SELECT " . $nameField . ", link,id FROM #__menu WHERE link = '$string' AND published = '1'";
  }
  elseif (!empty($id)) {
    $sql = "SELECT " . $nameField . ", link,id FROM #__menu WHERE id = '".$id."' AND published='1'";
  }
  elseif (!empty($option)) {
    $sql = 'SELECT ' . $nameField . ', link,id FROM #__menu WHERE published=\'1\' AND link LIKE \'index.php?option='.$option.'%\'';
  }else {
    return '/'; // don't know what else we could do, just go home
  }
  $database->setQuery($sql);
  if (isset($shLanguage) && shIsMultilingual()) {
    $rows = @$database->loadObjectList( '', true, $shLanguage);
  }
  else {
    $rows = @$database->loadObjectList( );
  }
  if ($database->getErrorNum()) {
    die( $database->stderr() );
  } elseif(@count($rows) > 0) {
    $shLink = shSortUrl($rows[0]->link.($rows[0]->link == 'index.php' ? '?':'&').'Itemid='.$rows[0]->id);
    if (!shIsHomepage( $shLink)) {  // V1.2.4.q homepage detection
      if(!empty($rows[0]->$nameField)) {
        $title = $rows[0]->$nameField;
      }
    } else $title = '/'; // this is homepage
  } else {
    $title = str_replace('com_', '', $option);
  }
  return $title;
}

function shIsSearchEngine() {  // return true if user agant is a search engine
  static $isSearchEngine = null;
  static $searchEnginesAgents = array(
     'B-l-i-t-z-B-O-T'
     ,'Baiduspider'
     ,'BlitzBot'
     ,'btbot'
     ,'DiamondBot'
     ,'Exabot'
     ,'FAST Enterprise Crawler'
     ,'FAST-WebCrawler/'
     ,'g2Crawler'
     ,'genieBot'
     ,'Gigabot'
     ,'Girafabot'
     ,'Googlebot'
     ,'ia_archiver'
     ,'ichiro'
     ,'Mediapartners-Google'
     ,'Mnogosearch'
     ,'msnbot'
     ,'MSRBOT'
     ,'Nusearch Spider'
     ,'SearchSight'
     ,'Seekbot'
     ,'sogou spider'
     ,'Speedy Spider'
     ,'Ask Jeeves/Teoma'
     ,'VoilaBot'
     ,'Yahoo!'
     ,'Slurp'
     ,'YahooSeeker'
     );
     //return true;
     if (!is_null ($isSearchEngine)) {
       return $isSearchEngine;
     }
     else {
       $isSearchEngine = false;
       $useragent = empty($_SERVER['HTTP_USER_AGENT']) ? '' : strtolower($_SERVER['HTTP_USER_AGENT']);
       if (!empty($useragent))
       foreach ($searchEnginesAgents as $searchEnginesAgent)
       if (strpos($useragent, strtolower($searchEnginesAgent)) !== false ) {
         $isSearchEngine = true;
         return true;
       }
       return $isSearchEngine;
     }
}

// J 1.5 specific functions

function shFetchLinkFromMenu($Itemid) {

}

function shRemoveSlugs( $vars, $removeWhat = true) {  // remove slugs from a J! 1.5 non-sef style vars array
  if (!empty($vars)) {
    foreach($vars as $k => $v) {
      $m = is_string( $v) ? explode(':', $v) : null; // tracker #14107, thanks 3dentech
      if (!empty( $m) && !empty($m[1]) && is_numeric($m[0])) { // an integer followed by : followed by something
        $vars[$k]= $removeWhat === 'removeId' ? $m[1] : $m[0];  // depending on params, either keep id or slug
      } else {
        // use the raw value, for arrays for instance
        $vars[$k] = $v;
      }
    }
    // fix some problems in incoming URLs
    if (!empty($vars['Itemid'])) {  // sometimes we get doubles : ?Itemid=xx?Itemid=xx
      $vars['Itemid'] = intval($vars['Itemid']);
    }
    if (!empty($vars['view'])) {    // some links have view=article;
      $vars['view'] = str_replace('article;', 'article', $vars['view']);
      // view is set but no option : use default controller (com_content)
      if (empty($vars['option']))
      $vars['option'] = 'com_content';
    }
    if (empty( $vars['option']) && !empty($vars['format']) && $vars['format']=='feed') {
      $vars['option'] = 'com_content';
    }
  }
  return $vars;
}

function shNormalizeNonSefUri( & $uri, $menu = null, $removeSlugs = true) {  // put back a J!1.5 non-sef url to J! 1.0.x format
  // Get the route
  $route = $uri->getPath();
  //Get the query vars
  $vars = $uri->getQuery(true);
  // fix some problems in incoming URLs
  if (!empty($vars['Itemid'])) {  // sometimes we get doubles : ?Itemid=xx?Itemid=xx
    $vars['Itemid'] = intval($vars['Itemid']);
    $uri->setQuery($vars);
  }

  // fix urls obtained through a single Itemid, in menus : url is option=com_xxx&Itemid=yy
  if (count($vars) == 2 && $uri->getVar('Itemid')) {
    if (empty($menu))
    $menu = & shRouter::shGetMenu();
    $shItem = $menu->getItem($vars['Itemid']);
    if (!empty($shItem)) {  // we found the menu item
      $url = $shItem->link.'&Itemid='.$shItem->id;
      $uri = new JURI($url);  // rebuild $uri based on this new url
      $uri->setPath($route);
      $vars = $uri->getQuery(true);
    }
  }

  if ($removeSlugs !== false) {
    $vars = shRemoveSlugs($vars, $removeSlugs);
  }
  $uri->setQuery($vars);
}

function shNormalizeNonSefUrl($url){  // returns non-sef url with slugs removed + a few fixes

  $uri = new JURI($url);
  shNormalizeNonSefUri($uri);
  return $uri->toString(array('path', 'query', 'fragment'));

}

function shSetJfLanguage( $requestlang) {

  if (empty($requestlang)) return;

  // get instance of JoomFishManager to obtain active language list and config values
  $jfm =&  JoomFishManager::getInstance();
  $activeLanguages = $jfm->getActiveLanguages();
  // get the name of the language file for joomla
  $jfLang = TableJFLanguage::createByShortcode( $requestlang, true);

  // set Joomfish stuff
  // Get the global configuration object
  global $mainframe;
  $registry =& JFactory::getConfig();
  $params = $registry->getValue("jfrouter.params");
  $enableCookie     = empty($params) ? 1 : $params->get( 'enableCookie', 1 );

  if ($enableCookie){
    setcookie( "lang", "", time() - 1800, "/" );
    setcookie( "jfcookie", "", time() - 1800, "/" );
    setcookie( "jfcookie[lang]", $jfLang->shortcode, time()+24*3600, '/' );
  }

  $GLOBALS['iso_client_lang'] = $jfLang->shortcode;
  $GLOBALS['mosConfig_lang'] = $jfLang->code;

  $mainframe->setUserState('application.lang',$jfLang->code);
  $registry->setValue("config.jflang", $jfLang->code);
  $registry->setValue("config.lang_site",$jfLang->code);
  $registry->setValue("config.language",$jfLang->code);
  $registry->setValue("joomfish.language",$jfLang);

  // Force factory static instance to be updated if necessary
  $lang =& JFactory::getLanguage();
  if ($jfLang->code != $lang->getTag()){
    $lang = JFactory::_createLanguage();
  }
  $lang16 =& shjlang16Helper::getLanguage();
  if ($jfLang->code != $lang16->getTag()){
    $lang16 = Jlanguage16::_createLanguage();
  }

  // overwrite with the valued from $jfLang
  $params = new JParameter($jfLang->params);
  $paramarray = $params->toArray();
  foreach ($paramarray as $key=>$val) {
    $registry->setValue("config.".$key,$val);

    if (defined("_JLEGACY")){
      $name = 'mosConfig_'.$key;
      $GLOBALS[$name] = $val;
    }
  }

  // set our own data
  $GLOBALS['shMosConfig_lang']   = $lang->get('backwardlang', 'english');
  $GLOBALS['shMosConfig_locale']   = $jfLang->code;
  $GLOBALS['shMosConfig_shortcode']   = $jfLang->shortcode;

}

function shCheckRedirect ($dest, $incomingUrl) {

  $sefConfig = & shRouter::shGetConfig();
  if (!empty($dest) && $dest != $incomingUrl) {  // redirect to alias
    if ($dest == sh404SEF_HOMEPAGE_CODE) {
      if (!empty($sefConfig->shForcedHomePage)) {
        $dest = shFinalizeURL($sefConfig->shForcedHomePage);
      } else {
        $dest = shFinalizeURL($GLOBALS['shConfigLiveSite']);
      }
    } else {
      $shUri = null;
      $shOriginalUri = null;
      $dest = shSefRelToAbs($dest, '', $shUri, $shOriginalUri);
    }
     
    if ($dest != $incomingUrl) {
      _log('Redirecting to '. $dest .' from alias '.$incomingUrl);
      shRedirect($dest);
    }
  }
}

function shUrlSafeDisplay( $url) {

  $url = urldecode( $url);
  return htmlentities( $url, ENT_QUOTES);
}

/**
 * Read config values from sobi2 config table
 *
 * @param $key
 * @param $section
 * @return string
 */
function shGetSobi2Config($key, $section ) {

  static $sobiConfig = null;

  if( empty( $sobiConfig[$section])) {
    // read from db
    $db = & JFactory::getDBO();
    $sql = 'select `configKey`,`configValue` from #__sobi2_config where `sobi2Section`=' . $db->Quote( $section) ;
    $db->setQuery( $sql);
    $sobiConfig[$section] = $db->loadAssocList( 'configKey');
  }

  $retValue = null;
  if (!empty($sobiConfig[$section]) && isset($sobiConfig[$section][$key])) {
    $retValue = $sobiConfig[$section][$key]['configValue'];
  }

  return $retValue;
}

/**
 * Insert an intro text into the content table
 *
 * @param strng $shIntroText
 * @return boolean, true if success
 */
function shInsertContent( $pageTitle, $shIntroText) {

  // get a db instance
  $db = & JFactory::getDBO();

  // result storage
  $status = false;

  // get current max id
  $sql = 'SELECT MAX(id)  FROM #__content';
  $db->setQuery( $sql );
  if ($max = $db->loadResult()){
    $max = intval( $max);
    $max++;
    $pageTitle = $db->Quote( $pageTitle);
    $sql = 'INSERT INTO #__content VALUES( "'.$max.'", '. $pageTitle .', '. $pageTitle .', '. $pageTitle .', '
    .$db->Quote($shIntroText).', "", "1", "0", "0", "0", "2009-01-09 12:00:00", "62", "", "'.date("Y-m-d H:i:s").'", "62", "0", "2009-01-09 12:00:00", "2009-01-09 12:00:00", '
    .'"0000-00-00 00:00:00", "", "", "menu_image=-1\nshow_title=0\nshow_section=0\nshow_category=0\show_vote=0\nshow_author=0\nshow_create_date=0\nshow_modify_date=0\nshow_pdf_icon=0\nshow_print_icon=0\nshow_email_icon=0\npageclass_sfx=",'
    .' "1", "0", "0", "", "", "0", "0", "");';
    $db->setQuery($sql);
    $db->query();
    $status = $db->getErrorNum() == 0;
  }

  return $status;
}

/**
 * This function based on Joomfish own method, but the
 * JF one only returns the current item translated
 * instead of the full menu set
 *
 * @param $lang
 * @param $getOriginals
 * @param $currentLangMenuItems
 * @return unknown_type
 */
function shGetJFMenu($lang, $getOriginals=true,  $currentLangMenuItems=false){

  static $instance;

  if (!isset($instance)){
    $instance = array();

    if (!$currentLangMenuItems){
      JError::raiseWarning('SOME_ERROR_CODE', "Error translating Menus - missing currentLangMenuItems");
      return false;
    }
    $db   = & JFactory::getDBO();

    $sql  = 'SELECT m.*, c.`option` as component' .
        ' FROM #__menu AS m' .
        ' LEFT JOIN #__components AS c ON m.componentid = c.id'.
        ' WHERE m.published = 1 '.
        ' ORDER BY m.sublevel, m.parent, m.ordering';
    $db->setQuery($sql);

    // get untranslated menus first
    // run through the translation code so that we get the correct reftablearray
    $registry =& JFactory::getConfig();
    $defLang = $registry->getValue("config.defaultlang");
    // done as array of one item so that joomla core menu code will work with it
    if (!($menu = $db->loadObjectList('id',true, $defLang))) {
      JError::raiseWarning('SOME_ERROR_CODE', "Error loading Menus: ".$db->getErrorMsg());
      return false;
    }

    $instance["raw"] = array("rows"=>$menu, "tableArray"=>$db->_getRefTables(),"originals"=>$currentLangMenuItems);
    shSetupMenuRoutes($instance["raw"]["rows"]);
    // This is really annoying in PHP5 - an array of stdclass objects is copied as an array of references
    // I tried doing this as a stdclass and cloning but it didn't seek to work.
    $instance["raw"] = serialize($instance["raw"]);

    $defLang = $registry->getValue("config.jflang");
    $instance[$defLang] = unserialize($instance["raw"]);

  }
  if (!isset($instance[$lang])){
    $instance[$lang] = unserialize($instance["raw"]);

    // Do not cache here since it can affect SEF components
    JLoader::import('helper', JPATH_ROOT.DS.'modules'.DS.'mod_jflanguageselection', 'jfmodule');
    JoomFish::translateList( $instance[$lang]["rows"], $lang, $instance[$lang]["tableArray"]);
    shSetupMenuRoutes($instance[$lang]["rows"]);
  }
  if ($getOriginals){
    return $instance[$lang]["originals"];
  }
  else {
    return $instance[$lang]["rows"];
  }
}

function shSetupMenuRoutes(&$menus) {

  if($menus) {
    foreach($menus as $key => $menu)
    {
      //Get parent information
      $parent_route = '';
      $parent_tree  = array();
      if(($parent = $menus[$key]->parent) && (isset($menus[$parent])) &&
      (is_object($menus[$parent])) && (isset($menus[$parent]->route)) && isset($menus[$parent]->tree)) {
        $parent_route = $menus[$parent]->route.'/';
        $parent_tree  = $menus[$parent]->tree;
      }

      //Create tree
      array_push($parent_tree, $menus[$key]->id);
      $menus[$key]->tree   = $parent_tree;

      //Create route
      $route = $parent_route.$menus[$key]->alias;
      $menus[$key]->route  = $route;

      //Create the query array
      $url = str_replace('index.php?', '', $menus[$key]->link);
      if(strpos($url, '&amp;') !== false)
      {
        $url = str_replace('&amp;','&',$url);
      }

      parse_str($url, $menus[$key]->query);
    }

    // $cache = &JFactory::getCache('_system', 'output');
    // $cache->store(serialize($menus), 'menu_items');
  }
}

/**
 * Returns a string with an article id, in accordance
 * with various settings
 * @param $id
 * @param $view
 * @param $option
 * @param $shLangName
 */
function shGetArticleIdString( $id, $view, $option, $shLangName) {

  $database = & JFactory::getDBO();
  $sefConfig = & shRouter::shGetConfig();

  // V 1.5.7 : article id, on some categories only
  $articleId= '';
  if ($sefConfig->ContentTitleInsertArticleId && isset($sefConfig->shInsertContentArticleIdCatList)
  && !empty($id) && ($view == 'article')) {

    $q = 'SELECT id, catid FROM #__content WHERE id = '.$id;
    $database->setQuery($q);
    if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m
    $contentElement = $database->loadObject( );
    else $contentElement = $database->loadObject( false);
    if ($contentElement) {
      $foundCat = array_search($contentElement->catid, $sefConfig->shInsertContentArticleIdCatList);
      if (($foundCat !== null && $foundCat !== false)
      || ($sefConfig->shInsertContentArticleIdCatList[0] == ''))  { // test both in case PHP < 4.2.0
        $articleId = $contentElement->id;
      }
    }
  }

  return $articleId;
}

/**
 * Reads an return the page title assigned to either
 * current or a specific menu item
 *
 * @param $Itemid itemid of the desired menu item
 */
function shGetJoomlaMenuItemPageTitle( $Itemid = 0) {

  // get the current menu item, or possibly the one asked for
  $menus = & shRouter::shGetMenu();
  $menuItem = empty( $Itemid) ? $menus->getActive() : $menus->getItem( $Itemid);

  // return value default
  $title = '';

  // now read the page_title, if any was set
  if (is_object( $menuItem )) {
    $menuParams = new JParameter( $menuItem->params );
    $title = $menuParams->get( 'page_title');
  }

  // return whatever we found
  return $title;
}

/**
 * check various conditions to decide if we
 * should redirect from non-sef url to its
 * sef equivalent
 */
function shShouldRedirectFromNonSef( $shPageInfo) {

  $sefConfig = & shRouter::shGetConfig();

  $method = JRequest::getMethod();
  $shouldRedirect = empty($shPageInfo->autoRedirectsDisabled) && $sefConfig->shRedirectNonSefToSef
  && (!empty($shPageInfo->URI->url))
  && strpos( $shPageInfo->URI->url, 'index2.php') === false
  && strpos( $shPageInfo->URI->url, 'tmpl=component') === false
  && strpos( $shPageInfo->URI->url, 'no_html=1') === false
  && ( empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'))
  && empty($_POST)
  && $method != 'POST';

  return $shouldRedirect;
}

function shCheckCustomRedirects( $path, $shPageInfo) {

  $sefConfig = & shRouter::shGetConfig();
  $db = &JFactory::getDBO();

  $incomingUrl = $path;
  $queryString = '';
  if (!empty($shPageInfo->URI->querystring)) {
    $tmp = array();
    foreach($shPageInfo->URI->querystring as $k => $v)
    $tmp[] = $k.'='.$v;
    $queryString = implode( '&', $tmp);
    $incomingUrl .= '?'. $queryString;
  }
  $query = 'SELECT newurl FROM #__sh404sef_aliases WHERE alias = ' . $db->Quote($incomingUrl);
  $query .= $path == $incomingUrl ? '' : ' or alias = ' . $db->Quote( $path) . ' order by ' . $db->nameQuote( 'alias') . ' DESC';
  $db->setQuery($query);
  $dest = $db->loadResult();
  if (!empty( $dest) && !empty( $queryString)) {
    $dest .= strpos( $dest, '?') !== false ? '&' . $queryString : '?' . $queryString;
  }
  shCheckRedirect( $dest, $incomingUrl );

  // now check pageids
  if ($sefConfig->enablePageId) {
    $query = 'SELECT newurl FROM #__sh404sef_pageids WHERE pageid = ' . $db->Quote($incomingUrl);
    $query .= $path == $incomingUrl ? '' : ' or pageid = ' . $db->Quote( $path) . ' order by ' . $db->nameQuote( 'pageid') . ' DESC';
    $db->setQuery($query);
    $dest = $db->loadResult();
    shCheckRedirect( $dest . $queryString, $incomingUrl );
  }

}

function shCheckAlias( $incomingUrl) {

  $sefConfig = & shRouter::shGetConfig();
  $db = &JFactory::getDBO();

  $query = 'SELECT newurl FROM #__sh404sef_aliases WHERE alias = ' . $db->Quote($incomingUrl);
  $db->setQuery($query);
  $dest = $db->loadResult();
  shCheckRedirect( $dest, $incomingUrl );

}
