<?php
/**
 * sh404SEF support for JomSocial component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_community.php 1517 2010-08-08 14:53:19Z silianacom-svn $
 * 
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & shRouter::shGetConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin($lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// do something about that Itemid thing
if (!preg_match( '/Itemid=[0-9]+/i', $string)) { // if no Itemid in non-sef URL
  if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid)) {
    $string .= '&Itemid='.$shCurrentItemid;  // append current Itemid
    $Itemid = $shCurrentItemid;
    shAddToGETVarsList('Itemid', $Itemid);
  }
  if ($sefConfig->shInsertTitleIfNoItemid) {
    $title[] = $sefConfig->shDefaultMenuItemName ?
    $sefConfig->shDefaultMenuItemName : getMenuTitle($option, null, $shCurrentItemid );
  }
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
  COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$shCurrentItemid
  : '';
} else {  // if Itemid in non-sef URL
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
  COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$Itemid
  : '';
}

// load JS language strings. If we are creating urls on the
// fly, after an automatic redirection, they may not be loaded yet
$lang =& JFactory::getLanguage();
$lang->load('com_community');

// real start
$Itemid = isset($Itemid) ? $Itemid : null;
$limit = isset($limit) ? $limit : null;
$limitstart = isset($limitstart) ? $limitstart : null;

if (!function_exists( 'shGetJSUsernameSlug')) {
  function shGetJSUsernameSlug( $id, $option, $shLangName) {
    $sefConfig = & shRouter::shGetConfig();

    $slug = '';

    if (empty($id)) {
      return $slug;
    }

    $database =& JFactory::getDBO();
    $query = 'SELECT id, username, name FROM #__users WHERE id ='. $id;
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    // just in case
    if (empty($result)) {
      return 'user' . $sefConfig->replacement . $id;
    }

    // what prefix ?
    $prefix = $sefConfig->shJSInsertUserId ? $id : '';

    // what should be use as name ?
    $name = $sefConfig->shJSInsertUserFullName ? $result->name : '';
    if (empty( $name)) {
      $name = $sefConfig->shJSInsertUsername ? $result->username : '';
    }
    if (!empty($name)) {
      $slug = (empty($prefix) ? '' : $prefix . $sefConfig->replacement) . $name;
    }

    // if we added the user name or full name to sef url
    // remove it from query string
    if (!empty($name) && ($sefConfig->shJSInsertUsername || $sefConfig->shJSInsertUserFullName)) {
      shRemoveFromGETVarsList('userid');
    }

    return $slug;
  }
}

if(!function_exists( 'shGetJSGroupCategoryTitle')) {
  function shGetJSGroupCategoryTitle( $id, $option, $shLangName) {

    static $cats = null;

    $sefConfig = & shRouter::shGetConfig();
    if (is_null( $cats)) {
      $database =& JFactory::getDBO();
      $query = 'SELECT id, name FROM #__community_groups_category';
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $cats = $database->loadObjectList( 'id', false);
      } else {
        $cats = $database->loadObjectList( 'id');
      }
    }
    $slug = empty( $cats[$id]) ? '' : $cats[$id]->name;
    $prefix = empty( $slug) || $sefConfig->shJSInsertGroupCategoryId ? $id : '';
    $slug = $prefix . (empty($slug) ? '' : $sefConfig->replacement)  . $slug;

    return $slug;
  }
}

if(!function_exists( 'shGetJSEventsCategoryTitle')) {
  function shGetJSEventsCategoryTitle( $id, $option, $shLangName) {

    static $cats = null;

    $sefConfig = & shRouter::shGetConfig();
    if (is_null( $cats)) {
      $database =& JFactory::getDBO();
      $query = 'SELECT id, name FROM #__community_events_category';
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $cats = $database->loadObjectList( 'id', false);
      } else {
        $cats = $database->loadObjectList( 'id');
      }
    }
    $slug = empty( $cats[$id]) ? '' : $cats[$id]->name;
    $prefix = empty( $slug) || $sefConfig->shJSInsertGroupCategoryId ? $id : '';
    $slug = $prefix . (empty($slug) ? '' : $sefConfig->replacement)  . $slug;

    return $slug;
  }
}

if (!function_exists( 'shGetJSGroupTitleArray')) {
  function shGetJSGroupTitleArray( $id, $option, $shLangName) {
    $sefConfig = & shRouter::shGetConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, name, categoryid FROM #__community_groups WHERE id = ' . $id;
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->name) || $sefConfig->shJSInsertGroupId ? $id : '';
    $groupName =  !is_object( $result) || empty( $result->name) ? '' : $result->name;
    $groupName = $prefix . (empty( $groupName) ? '' : $sefConfig->replacement) . $groupName;

    // optionnally insert group category
    if($sefConfig->shJSInsertGroupCategory) {
      $title = array( shGetJSGroupCategoryTitle( $result->categoryid, $option, $shLangName), $groupName);
    } else {
      $title = array( $groupName);
    }

    return $title;
  }
}

if (!function_exists( 'shGetJSGroupBulletinTitle')) {
  function shGetJSGroupBulletinTitle( $id, $option, $shLangName) {
    $sefConfig = & shRouter::shGetConfig();

    $database =& JFactory::getDBO();
    $query = 'SELECT id, title FROM #__community_groups_bulletins WHERE id = ' . $id;
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->title) || $sefConfig->shJSInsertGroupBulletinId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->title) ? '' : $result->title;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if (!function_exists( 'shGetJSGroupDiscussionTitle')) {
  function shGetJSGroupDiscussionTitle( $id, $option, $shLangName) {
    $sefConfig = & shRouter::shGetConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, title FROM #__community_groups_discuss WHERE id = ' . $id;
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->title) || $sefConfig->shJSInsertDiscussionId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->title) ? '' : $result->title;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if(!function_exists( 'shGetJSMessageTitle')) {
  function shGetJSMessageTitle( $id, $option, $shLangName) {
    $sefConfig = & shRouter::shGetConfig();

    $database =& JFactory::getDBO();
    $query = 'SELECT id, subject FROM #__community_msg WHERE id =' . $id;
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->subject) || $sefConfig->shJSInsertMessageId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->subject) ? '' : $result->subject;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if(!function_exists( 'shGetJSPhotoAlbumDetails')) {
  function shGetJSPhotoAlbumDetails( $id, $option, $shLangName) {
    $sefConfig = & shRouter::shGetConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, name FROM #__community_photos_albums WHERE id =' . $id;
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->name) || $sefConfig->shJSInsertPhotoAlbumId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->name) ? '' : $result->name;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if (!function_exists( 'shGetJSPhotoTitle')) {
  function shGetJSPhotoTitle( $id, $option, $shLangName) {
    $sefConfig = & shRouter::shGetConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, caption FROM #__community_photos WHERE id = ' . $id;
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }
     
    // this photo name
    $prefix = !is_object( $result) || empty( $result->caption) || $sefConfig->shJSInsertPhotoId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->caption) ? '' : $result->caption;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if(!function_exists( 'shGetJSVideoCategoryTitle')) {
  function shGetJSVideoCategoryTitle( $id, $option, $shLangName) {

    static $cats = null;
    $sefConfig = & shRouter::shGetConfig();

    if (is_null($cats)) {
      $database =& JFactory::getDBO();
      $query = 'SELECT id, name FROM #__community_videos_category';
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $cats = $database->loadObjectList( 'id', false);
      } else {
        $cats = $database->loadObjectList( 'id');
      }
    }

    $prefix = empty( $cats[$id]) || $sefConfig->shJSInsertVideoCatId ? $id : '';
    $slug =  empty( $cats[$id]) ? '' : $cats[$id]->name;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if (!function_exists( 'shGetJSVideoTitle')) {
  function shGetJSVideoTitle( $id, $option, $shLangName) {
    $sefConfig = & shRouter::shGetConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, title, category_id FROM #__community_videos WHERE id = ' . $id;
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $videoName = ($sefConfig->shJSInsertVideoId ? $id . $sefConfig->replacement : '') . $result->title;
     
    // optionnally insert video category
    if($sefConfig->shJSInsertVideoCat) {
      $title = array( shGetJSVideoCategoryTitle( $result->category_id, $option, $shLangName), $videoName);
    } else {
      $title = array( $videoName);
    }

    return $title;

  }
}

if (!function_exists( 'shMustInsertJSName')) {
  function shMustInsertJSName($shJSName, $userid,$view) {
    $sefConfig = & shRouter::shGetConfig();

    // nothing to insert
    if (empty( $shJSName)) {
      return false;
    }

    if(!$sefConfig->shJSInsertJSName) {
      // if set to not insert, return false
      // except if we are on user profile, and short urls to profile is on
      $insert = $sefConfig->shJSShortURLToUserProfile && $view == 'profile' && !empty($userid)
      // and poor configuration made that we don't insert username or user full name
      // in such case, we should still insert the name
      && !$sefConfig->shJSInsertUsername && !$sefConfig->shJSInsertUserFullName;

      // or we are on user profile, and short url is off but user has set
      // to not insert user name or user full name
      if (!$insert && !$sefConfig->shJSShortURLToUserProfile && !$sefConfig->shJSInsertUsername && !$sefConfig->shJSInsertUserFullName) {
        $insert = true;
      }
      return $insert;
    }

    // params say to insert name. we should do it, unless on
    // user profile page, and we are set to have short urls to profile
    $insert = !($sefConfig->shJSShortURLToUserProfile && $view == 'profile' && !empty($userid));

    // however if set to not insert either username or fullname, there will be a problem as
    // user id is passed a query string. In such case, revert the decision and still insert
    if (!$sefConfig->shJSInsertUsername && !$sefConfig->shJSInsertUserFullName) {
      $insert = true;
    }

    return $insert;
  }
}

// main vars
$view = isset($view) ? $view : null;
$task = isset($task) ? $task : null;
$userid = isset($userid) ? $userid : null;

// insert component name from menu
$shJSName = shGetComponentPrefix($option);
$shJSName = empty($shJSName) ?  getMenuTitle($option, null, $Itemid, null, $shLangName ) : $shJSName;
$shJSName = (empty($shJSName) || $shJSName == '/') ? 'JS':$shJSName;

// do this only if not set to create direct links to user profile like mysite.com/john
if (shMustInsertJSName($shJSName, $userid,$view)) {
  $title[] = $shJSName;
  // if direct url to user profile, prevent adding suffix ('.html')
  if (($sefConfig->shJSShortURLToUserProfile ||
  (!$sefConfig->shJSShortURLToUserProfile && !$sefConfig->shJSInsertUsername && !$sefConfig->shJSInsertUserFullName))
  && $view == 'profile' && !empty($userid)) {
    $title[] = '/';
  }
}

// build url first based on view, but make use of other vars ($task,..) as needed
switch($view){
  case 'frontpage':
    if (empty( $task) && empty( $userid) && empty( $title)) {
      $title[] = $shJSName;
    }
    break;
  case 'profile':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
      $title[] = '/';
    }
    break;
  case 'groups':
    if (empty($task)) {
      $title[] = JText::_('CC GROUP');
    }
    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
    } else if (!empty($categoryid)) {
      $title[] = shGetJSGroupCategoryTitle( $categoryid, $option, $shLangName);
    } else if (!empty($topicid)) {
      $title[] = shGetJSGroupDiscussionTitle( $topicid, $option, $shLangName);
    }else if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'photos':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
    }
    if (empty($task) || $task=='myphotos' || $task=='search') {
      $title[] = JText::_('CC PHOTOS');
    }
    if(!empty( $albumid) && $sefConfig->shJSInsertPhotoAlbum) {
      $title[] = shGetJSPhotoAlbumDetails( $albumid, $option, $shLangName);
    }
    if(!empty($photoid)) {
      $title[] = shGetJSPhotoTitle( $photoid, $option, $shLangName);
    }
    if(empty($task) && empty( $albumid) && empty($photoid)) {
      $title[] = '/';
    }
    break;
  case 'videos':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
    }
    if (empty( $task) || $task=='myvideos' || $task=='search') {
      $title[] = JText::_('CC VIDEOS');
    }
    if(!empty($catid)) {
      $title[] = shGetJSVideoCategoryTitle( $catid, $option, $shLangName);
    } else if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'search':
    if ($task != 'browse' && $task != 'advancesearch') {
      $title[] = JText::_('CC SEARCH');
    }
    if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'inbox':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = JText::_('CC INBOX');
    break;
  case 'register':
    $title[] = JText::_('CC REGISTER');
    break;
  case 'friends':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = JText::_('CC FRIENDS');
    if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'apps':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = JText::_('CC APPLICATIONS');
    if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'events':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    if (empty($task) || $task=='myevents' || $task=='myinvites' || $task == 'expiredevents' || $task== 'search') {
      $title[] = JText::_('CC EVENTS');
    }

    if (!empty( $categoryid)) {
      $slug = shGetJSEventsCategoryTitle($categoryid, $option, $shLangName);
      if(!empty($slug)) {
        $title[] = $slug;
      }
    }
    if(empty($task)) {
      $title[] = '/';
    }
    break;
  default:
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
    }
    $title[] = $view;
}

// add more details based on $task
switch($task){

  // groups
  case 'mygroups':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = JText::_('CC MY GROUPS TITLE');
    $title[] = '/';
    break;
  case 'create':
    $title[] = JText::_('CC CREATE GROUP');
    break;
  case 'joingroup':
    $title[] = JText::_('CC JOIN GROUP TITLE');
    break;
  case 'leavegroup':
    $title[] = JText::_('CC LEAVE GROUP TITLE');
    break;
  case 'viewgroup':
    break;
  case 'created':
    break;
  case 'invitefriends':
    $title[] = JText::_('CC INVITE FRIENDS');
    break;
  case 'viewmembers':
    $title[] = JText::_('CC GROUP MEMBERS');
    $title[] = '/';
    break;
  case 'viewbulletin':
    if(!empty($bulletinid)) {
      $title[] = shGetJSGroupBulletinTitle( $bulletinid, $option, $shLangName);
    }
    break;
  case 'viewbulletins':
    $title[] = JText::_('CC SHOW ALL BULLETINS');
    break;
  case 'addnews':
    $title[] = JText::_('CC ADD BULLETIN');
    break;
  case 'viewdiscussion':
    if(!empty($topicid)) {
      $title[] = shGetJSGroupDiscussionTitle( $topicid, $option, $shLangName);
    }
    break;
  case 'viewdiscussions':
    $title[] = JText::_('CC SHOW ALL DISCUSSIONS');
    $title[] = '/';
    break;
  case 'adddiscussion':
    $title[] = JText::_('CC ADD DISCUSSION');
    break;
  case 'uploadAvatar':
    $title[] = JText::_('CC EDIT GROUP AVATAR');
    break;
  case 'uploadavatar':
    $title[] = JText::_('CC UPLOAD GROUP AVATAR TITLE');
    break;
  case 'avatar':
    $title[] = JText::_('AVATAR');
    break;
  case 'edit':
    $title[] = $view == 'groups' ? JText::_('CC EDIT') : JText::_('CC EDIT PROFILE');
    break;
  case 'editDetails':
    $title[] = JText::_('CC EDIT DETAILS');
    break;
  case 'privacy':
    $title[] = JText::_('CC EDIT PRIVACY');
    break;

    // photos
  case 'myphotos':
    $title[] = '/';
    break;
  case 'newalbum':
    $title[] = JText::_('CC ADD ALBUM');
    break;
  case 'uploader':
    $title[] = JText::_('CC UPLOAD PHOTOS');
    break;
  case 'album':
    break;
  case 'editAlbum':
    $title[] = JText::_('CC EDIT');
    break;
  case 'photo':
    $title[] = JText::_('CC PHOTOS');
    break;
  case 'jsonupload':
    $dosef = false;
    break;

    // videos
  case 'myvideos':
    $title[] = '/';
    break;
  case 'removevideo':
    $title[] = JText::_('CC REMOVE');
    break;
  case 'video':
    if(!empty($videoid)) {
      $title = array_merge( $title, shGetJSVideoTitle( $videoid, $option, $shLangName));
    }
    break;

    // messages
  case 'read':
    if(!empty($msgid)) {
      $title[] = shGetJSMessageTitle( $msgid, $option, $shLangName);
    }
    break;
  case 'sent':
    $title[] = JText::_('CC SENT');
    break;
  case 'write':
    $title[] = JText::_('CC WRITE');
    break;

    // applications
  case 'app':
    $title[] = JText::_('CC APPLICATIONS');
    break;
  case 'invite':
    $title[] = JText::_('CC INVITE FRIENDS');
    break;
  case 'sent':
    $title[] = JText::_('CC REQUEST SENT');
    break;
  case 'pending':
    $title[] = JText::_('CC PENDING APPROVAL');
    break;
  case 'remove':
    $slug = shGetJSUsernameSlug($fid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = JText::_('CC REMOVE');
    break;
  case 'field':
    $title[] = JText::_('CC FIELD');
    break;

  // events
  case 'myevents':
    break;
  case 'myinvites':
    $title[] = JText::_('CC INVITE');
    break;
  case 'expiredevents':
    $title[] = $task;
    break;  
    
  // searching
  case 'advancesearch':
    $title[] = JText::_('CC CUSTOM SEARCH');
    $title[] = '/';
    break;
  case 'browse':
    if ($view == 'search') {
      $title[] = JText::_('CC MEMBERS');
      $title[] = '/';
    } else {
      $title[] = JText::_('CC BROWSE APPS');
      $title[] = '/';
    }
    break;
  case 'search':
    $title[] = JText::_('CC SEARCH');
    break;

    // others
  case 'removepicture':
    $title[] = JText::_('REMOVE PROFILE PICTURE');
    break;
  case 'link':
    $title[] = JText::_('CC LINK VIDEO');
    break;
  case 'registerProfile':
    $title[] = JText::_('CC PROFILE');
    break;
  case 'registerAvatar':
    $title[] = JText::_('GET AVATAR');
    break;
  case 'registerSucess':
    $title[] = JText::_('REGISTERED SUCCESSFULLY');
    break;
  default:
    if( !empty( $task)) {
      $title[] = $task;
    }
}

if(!empty($app)) {
  $title[] = $app;
  shRemoveFromGETVarsList( 'app');
}

shRemoveFromGETVarsList('view');
shRemoveFromGETVarsList('task');
shRemoveFromGETVarsList('msgid');
shRemoveFromGETVarsList('categoryid');
shRemoveFromGETVarsList('bulletinid');
shRemoveFromGETVarsList('topicid');
shRemoveFromGETVarsList('albumid');
shRemoveFromGETVarsList('photoid');
shRemoveFromGETVarsList('groupid');
shRemoveFromGETVarsList('catid');
shRemoveFromGETVarsList('videoid');
shRemoveFromGETVarsList('fid');

shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');
if(!empty($Itemid)) {
  shRemoveFromGETVarsList('Itemid');
}
if(!empty($limit)) {
  shRemoveFromGETVarsList('limit');
}
if(isset($limitstart)) {
  shRemoveFromGETVarsList('limitstart');
}

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
  $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

?>