<?php
/**
 * shCustomTags support for VirtueMart component.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_virtuemart.php 1491 2010-07-09 18:28:04Z silianacom-svn $
 *
 * This module must set $shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag, $shCustomRobotsTag according to specific component output
 *
 * if you set a variable to '', this will ERASE the corresponding meta tag
 * if you set a variable to null, this will leave the corresponding meta tag UNCHANGED
 *
 * Some parts from:
 * 404SEFx support for VirtueMart component.
 * Mark Fabrizio, Joomlicious
 * fabrizim@owlwatch.com
 * http://www.joomlicious.com
 *
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $VM_LANG;

// init languages system : we could use Virtuemart languages files, but I want to use the same system as sh404SEF, to have the exact same translations
global $shMosConfig_locale, $sh_LANG, $mainframe;

// get DB
$database =& JFactory::getDBO();

// V 1.2.4.q must comply with translation restrictions
$shLangName = empty($lang) ? $shMosConfig_locale : shGetNameFromIsoCode( $lang);
$shLangIso = isset($lang) ? $lang : shGetIsoCodeFromName( $shMosConfig_locale);
$shLangIso = shLoadPluginLanguage( 'com_virtuemart', $shLangIso, '_PHPSHOP_LIST_ALL_PRODUCTS');
//-------------------------------------------------------------

$page = JRequest::getVar('page', null);
$func = JRequest::getVar('func', null);
$task = JRequest::getVar( 'task', null);
$category_id = JRequest::getVar( 'category_id', null);
$product_id = JRequest::getVar( 'product_id', null);

global $shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag, $shCustomLangTag, $shCustomRobotsTag;

$q = 'SELECT vendor_id, vendor_name, vendor_store_name, vendor_store_desc FROM #__vm_vendor';
$database->setQuery( $q );
$row = $database->loadObjectList();

if (!empty($row) && !empty($row[0]->vendor_name) ){
  $shShopName = $row[0]->vendor_name;
  $shStoreName = $GLOBALS['shConfigLiveSite'];
  $shStoreDesc = $row[0]->vendor_store_desc;
} else {
  $shShopName = $mainframe->getCfg('sitename');
  $shStoreName = $GLOBALS['shConfigLiveSite'];
  $shStoreDesc = $mainframe->getCfg('MetaDesc');
}

function vm_sef_get_category_title( &$db, &$catDesc, $category_id, $option, $shLangName ){

  global $shMosConfig_locale;

  $sefConfig = & shRouter::shGetConfig();

  if (empty($category_id)) return '';
  $q  = "SELECT c.category_name, c.category_id, c.category_description, x.category_parent_id FROM #__vm_category AS c" ;
  $q .= "\n LEFT JOIN #__vm_category_xref AS x ON c.category_id = x.category_child_id;";
  //$q .= "\n WHERE c.category_publish = 'Y';";  // V x
  $db->setQuery( $q );
  if (!shTranslateUrl($option, $shLangName))  // V 1.2.4.m
  $tree = $db->loadObjectList( 'category_id', false);
  else
  $tree = $db->loadObjectList( 'category_id' );
  $catDesc = $tree[ $category_id ]->category_description;
  $title='';
  $securityCounter = 0;
  do {               // all categories and subcategories
    $securityCounter++;
    $title .= ($sefConfig->shInsertCategoryId ?
    $tree[ $category_id ]->category_id.$sefConfig->replacement : '')
    .$tree[ $category_id ]->category_name. ' | ';
    $category_id = $tree [ $category_id ]->category_parent_id;
  } while( $category_id != 0 && $securityCounter < 10);
  if ($securityCounter >= 10) {
    JError::raiseError( 500, 'Unable to create SEF url for Virtuemart: could not find category with id : ' . $category_id);
  }
  return JString::rtrim( $title, ' | ');
}

switch ($page)
{
  case 'shop.browse':
    $catDesc = '';
    $catList = vm_sef_get_category_title( $database, $catDesc, $category_id, $option, $shLangName );
    $shCustomTitleTag = $catList ? $catList.' | ':'';
    // pagination
    $limit = JRequest::getInt( 'limit');
    $limitstart = JRequest::getInt( 'limitstart');
    $pageNumber = empty( $limit) ? $limitstart : (floor( $limitstart/$limit) + 1);
    if (!empty( $pageNumber)) {
      $sefConfig = & shRouter::shGetConfig();
      if ( $sefConfig->alwaysAppendItemsPerPage || $sefConfig->shVmUsingItemsPerPage) {
        $shMultPageLength= $sefConfig->pagerep .(empty($limit) ? '' : $limit);
      } else $shMultPageLength= '';
      // shumisha : modified to add # of items per page to URL, for table-category or section-category

      if (!empty($sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']])
      && (false !== strpos($sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']], '%s'))){
        $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$GLOBALS['shMosConfig_locale']]);
        $pageString = str_replace('%s', $pageNumber, $pattern).$shMultPageLength;
      } else {
        $pageString = ' ' .$pageNumber.$shMultPageLength;
      }
    } else {
      $pageString = '';
    }
    $shCustomTitleTag .= empty($pageString) ? '' : $pageString .' | ';
    // shop name
    $shCustomTitleTag .= $shShopName;
    $shCustomDescriptionTag = $catDesc;
    $shCustomKeywordsTag = ($catList ? str_replace('|', ',', $catList).',':'')
    .$shShopName. ','.$shStoreName;
    $shCustomRobotsTag = 'index, follow';
    break;
  case 'shop.product_details':
    $q = "SELECT product_id, product_name, product_s_desc FROM #__vm_product";
    $q .= "\n WHERE product_id = %s";
    $database->setQuery( sprintf( $q, $product_id ) );
    $row = null;
    $row = $database->loadObject();
    $catDesc = '';
    $catList = vm_sef_get_category_title( $database, $catDesc, $category_id, $option, $shLangName );
    if ($row) {
      $shCustomTitleTag = $row->product_name.' | '.($catList ? $catList.' | ':'').$shShopName;
      $shCustomDescriptionTag = $row->product_s_desc;
      $shCustomKeywordsTag = $row->product_name.', '.($catList ? str_replace('|', ',', $catList).',':'')
      .$shShopName. ','.$shStoreName;
      $shCustomRobotsTag = 'index, follow';
    }
    break;
    // shumisha 2007-03-16 let's try to do something for more pages
  case 'checkout.index':
    $shCustomTitleTag = $VM_LANG->_('PHPSHOP_CHECKOUT_TITLE').' | '.$shShopName;
    $shCustomDescriptionTag = $shCustomTitleTag;
    $shCustomKeywordsTag = $VM_LANG->_('PHPSHOP_CHECKOUT_TITLE').', '.$shShopName;
    $shCustomRobotsTag = 'noindex, follow';
    break;
  case 'shop.index':
  case '':  // this is main menu link, let's fetch store name, etc
    $shCustomTitleTag = $shShopName;
    $shCustomDescriptionTag = $shStoreDesc;
    $shCustomKeywordsTag = '';
    $q  = 'SELECT category_name, category_id FROM #__vm_category';
    $database->setQuery( $q );
    $catRows = $database->loadObjectList();
    if (!empty($catRows)) {
      forEach ($catRows as $cat)
      $shCustomKeywordsTag .= $cat->category_name.',';
    }
    $shCustomKeywordsTag = $shCustomKeywordsTag.$shShopName. ','.$shStoreName;
    $shCustomRobotsTag = 'index, follow';
    break;
  default:
    break;
}

?>
