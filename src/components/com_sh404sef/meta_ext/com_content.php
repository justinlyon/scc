<?php
/**
 * shCustomTags support for com_content
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_content.php 1491 2010-07-09 18:28:04Z silianacom-svn $
 *
 *  This module must set $shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag,$shCustomLangTag, $shCustomRobotsTag according to specific component output
 *
 * if you set a variable to '', this will ERASE the corresponding meta tag
 * if you set a variable to null, this will leave the corresponding meta tag UNCHANGED
 *
 *
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $Itemid;

global $shMosConfig_locale, $sh_LANG, $mainframe;

$sefConfig = & shRouter::shGetConfig();

$database =& JFactory::getDBO();

$view = JREQUEST::getVar('view', null);
$catid = JREQUEST::getVar('catid', null);
$id = JREQUEST::getVar('id', null);
$limit = JREQUEST::getVar('limit', null);
$limitstart = JREQUEST::getVar('limitstart', null);
$layout = JREQUEST::getVar('layout', null);
$showall = JREQUEST::getVar('showall', null);
$format = JREQUEST::getVar('format', null);
$print = JREQUEST::getVar('print', null);
$tmpl = JREQUEST::getVar('tmpl', null);
$lang = JREQUEST::getVar('lang', null);

$shLangName = empty($lang) ? $shMosConfig_locale : shGetNameFromIsoCode( $lang);
$shLangIso = isset($lang) ? $lang : shGetIsoCodeFromName( $shMosConfig_locale);
$shLangIso = shLoadPluginLanguage( 'com_content', $shLangIso, 'COM_SH404SEF_CREATE_NEW');
//-------------------------------------------------------------

global 	$shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag,
$shCustomLangTag, $shCustomRobotsTag;

// add no follow to print pages
$shCustomRobotsTag = ($tmpl == 'component' && !empty( $print) ) ? 'noindex, nofollow' : $shCustomRobotsTag;

// calculate page title
$title= array();
switch ($view) {
  case 'archivecategory':
  case 'archivesection' :
    $shCustomTitleTag = $sh_LANG[$shLangIso]['COM_SH404SEF_ARCHIVE']
    . ' '.$sefConfig->replacement.' '. $GLOBALS['shConfigLiveSite'];
    break;
  case 'edit':
    break;
  case 'frontpage':
    $shCustomDescriptionTag = $mainframe->getCfg('MetaDesc');
    $shCustomKeywordsTag = $mainframe->getCfg('MetaKeys');
    // TODO fix this, does not belong in J! 1.5
    /*$query = 'SELECT id, name FROM #__menu WHERE `link` LIKE \'%option=com_content&view=frontpage%\'';
    $database->setQuery($query);
    $shTitle = $database->loadObject();*/
    $shTitle = shGetJoomlaMenuItemPageTitle();
    if (empty($shTitle)) {
      $config =& JFactory::getConfig();
      $title[] = $config->getValue('config.sitename');
    }	else {
      $title[] = $shTitle;
    }

    // handle second, third,... pages on home page
    // TODO same code used in function shAddPaginationInfo, should regroup
    if (!empty( $limitstart)) {
      $shPageInfo = & shRouter::shPageInfo();
      $shLimit = shGetDefaultDisplayNumFromConfig( $shPageInfo->shCurrentPageNonSef, $includeBlogLinks = false);
      $pagenum = empty( $shLimit) ? (int) $limitstart : (int) ($limitstart / $shLimit) + 1;
      if ( $sefConfig->alwaysAppendItemsPerPage) {
        $shMultPageLength= $sefConfig->pagerep . $shLimit;
      } else $shMultPageLength= '';

      if (!empty($sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']])
      && (false !== strpos($sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']], '%s'))){
        $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']]);
        $title[] = str_replace('%s', $pagenum, $pattern).$shMultPageLength;
      } else {
        $title[] = ' ' . $pagenum.$shMultPageLength;
      }
    }

    $shCustomTitleTag = JString::ltrim(implode( ' | ', $title), '/ | ');

    break;

  default:
    if ($view=='article' && !empty($layout) && $layout == 'form') { // submit new article
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_CREATE_NEW'];
      if (!empty($sectionid)) {
        $q = 'SELECT id, title FROM #__sections WHERE id = '.$sectionid;
        $database->setQuery($q);
        if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m
        $sectionTitle = $database->loadObject( );
        else $sectionTitle = $database->loadObject( false);
        if ($sectionTitle) {
          $title[] = $sectionTitle->title;
        }
      }
    }
    // use regular function to get content titles, as per out specific settings
    $customConfig = clone( $sefConfig);

    $customConfig->ShowSection = $sefConfig->ContentTitleShowSection;
    $customConfig->ShowCat = $sefConfig->ContentTitleShowCat;
    $customConfig->UseAlias = $sefConfig->ContentTitleUseAlias;
    $customConfig->useCatAlias = $sefConfig->ContentTitleUseCatAlias;
    $customConfig->useSecAlias = $sefConfig->ContentTitleUseSecAlias;
    $customConfig->LowerCase = false;
    // V 1.2.4.t protect against sef_ext.php not being included
    if (!class_exists('sef_404'))
    require_once(sh404SEF_ABS_PATH.'components/com_sh404sef/sef_ext.php');
    $layout = isset($layout) ? $layout : null;
    $articleId = shGetArticleIdString( $id, $view, $option, $shLangName);
    $title = sef_404::getContentTitles($view, $id, $layout, $Itemid, $shLangName, $customConfig);
    if (!empty( $articleId)) {
      $lastBit = array_pop( $title);
      $lastBit .= ' [' . $articleId . ']';
      array_push( $title, $lastBit);
    }
    $pageNumber = '';
    // V 1.2.4.t try better handling of multipages article (use of mospagebreak)
    if ($view == 'article' && !empty($limitstart) ) {  // this is multipage article
      $shPageTitle = '';
      $sql = 'SELECT c.id, c.fulltext, c.introtext  FROM #__content AS c WHERE id=\''.$id.'\'';
      $database->setQuery($sql);
      $contentElement = $database->loadObject( );
      if ($database->getErrorNum()) {
        JError::raiseError(500, $database->stderr() );
      }
      $contentText = $contentElement->introtext.$contentElement->fulltext;

      if (!empty($contentElement) && empty($showall) && ( strpos( $contentText, 'class="system-pagebreak' ) !== false )) { // search for mospagebreak tags
        // copied over from pagebreak plugin
        // expression to search for
        //$regex = '/{(mospagebreak)\s*(.*?)}/i';
        $regex = '#<hr([^>]*)class=\"system-pagebreak\"([^>]*)\/>#iU';
        // find all instances of mambot and put in $matches
        $shMatches = array();
        preg_match_all( $regex, $contentText, $shMatches, PREG_SET_ORDER );
        // adds heading or title to <site> Title
        if (empty($limitstart)) {  // if first page use heading of first mospagebreak
        } else {  // for other pages use title of mospagebreak
          if ( $limitstart > 0 && $shMatches[$limitstart-1][1] ) {
            $args = JUtility::parseAttributes( $shMatches[$limitstart-1][1] );
            if ( @$args['title'] ) {
              $shPageTitle = $args['title'];
            } else if (@$args['alt']) {
              $shPageTitle = $args['alt'];
            } else {  // there is a page break, but no title. Use a page number
              $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']]);
              $shPageTitle = str_replace('%s', $limitstart+1, $pattern);
            }
          }
        }
      }

      if (!empty($shPageTitle))  // found a heading, we should use that as a Title
      $title[] = shCleanUpTitle($shPageTitle);
    } else {
      if (!empty( $limit) && !empty( $limitstart)) {
        $shPageInfo = & shRouter::shPageInfo();
        $shLimit = $layout == 'blog' ? shGetDefaultDisplayNumFromConfig( $shPageInfo->shCurrentPageNonSef, $includeBlogLinks = false) : $limit;
        $pagenum = empty( $limit) ? (int) $limitstart : (int) ($limitstart / $shLimit) + 1;
        if ( $sefConfig->alwaysAppendItemsPerPage) {
          $shMultPageLength= $sefConfig->pagerep . $shLimit;
        } else $shMultPageLength= '';
        $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']]);
        $pageNumber = str_replace('%s', $pagenum, $pattern).$shMultPageLength;
      } else {
        if (!empty($limitstart)) {  // this may be a blog category view, with more than one page
          if ($title[count($title)-1] == '/') { // need to remove trailing slash added by getContentTitle
            unset($title[count($title)-1]);
          }
          if ($view == 'article') {
            $pagenum = intval($limitstart+1);   // multipage article
          }
          $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']]);
          $pageNumber = str_replace('%s', $pagenum, $pattern)/*.$shMultPageLength*/;
        } else {
          if (!empty($showall)) {
            $pageNumber = titleToLocation(JText::_( 'All Pages' ));
          }
        }
      }
    }
    // V 1.2.4.j 2007/04/11 : numerical ID, on some categories only
    if ($sefConfig->shInsertNumericalId && isset($sefConfig->shInsertNumericalIdCatList)
    && !empty($id) && ($view == 'view')) {

      $q = 'SELECT id, catid, created FROM #__content WHERE id = '.$id;
      $database->setQuery($q);
      if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m
      $contentElement = $database->loadObject( );
      else $contentElement = $database->loadObject( false);
      if (!empty($contentElement)) { // V 1.2.4.t
        $foundCat = array_search(@$contentElement->catid, $sefConfig->shInsertNumericalIdCatList);
        if (($foundCat !== null && $foundCat !== false)
        || ($sefConfig->shInsertNumericalIdCatList[0] == ''))  { // test both in case PHP < 4.2.0
          $shTemp = explode(' ', $contentElement->created);
          $title[] = str_replace('-','', $shTemp[0]).$contentElement->id;
        }
      }
    }

    // V 1.2.4.k 2007/04/25 : if activated, insert edition id and name from iJoomla magazine
    if (!empty($ed) && $sefConfig->shActivateIJoomlaMagInContent && $id && ($view == 'view')) {
      $q = 'SELECT id, title FROM #__magazine_categories WHERE id = '.$ed;
      $database->setQuery($q);
      if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m
      $issueName = $database->loadObject(false);
      else $issueName = $database->loadObject( );
      if ($issueName) {
        $title[] = ($sefConfig->shInsertIJoomlaMagIssueId ? $ed.$sefConfig->replacement:'')
        .$issueName->title;
      }
    }
    // end of edition id insertion
    $title = array_reverse( $title);
    if (!empty($pageNumber)) {  // better add page number at end rather than beg
      $title[] = $pageNumber;
    }
    $shCustomTitleTag = JString::ltrim(implode( $sefConfig->pageTitleSeparator, $title), '/' . $sefConfig->pageTitleSeparator);
}

?>
