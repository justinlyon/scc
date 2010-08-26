<?php
/**
 *  $Id: base.include.php 1025 2007-04-10 17:50:15Z nchanda $: base.php, Jun 24, 2006 9:11:15 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 *
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

// Local deployment configuration settings
include_once 'local.include.php';

/**
 * File locations and application-level constants.
 */
if (!defined('SERVER_BASE_DIR')) {
   define('SERVER_BASE_DIR','/var/www/htdocs');
}
if (!defined('WEBAPP_NAME')) {
   define('WEBAPP_NAME', 'com_ccevents');
}
if (!defined('WEBAPP_BASE_DIR')) {
   define('WEBAPP_BASE_DIR', SERVER_BASE_DIR . '/administrator/components/' . WEBAPP_NAME);
}
if (!defined('WEB_INF')) {
   define('WEB_INF', dirname(__FILE__));
}
// Set the include path for shared libraries (local by default)
if (!defined('SERVER_LIB_DIR')) {
   define('SERVER_LIB_DIR', WEB_INF . '/lib');
}

if (!defined('HORDE_BASE')) {
    define('HORDE_BASE', WEB_INF . '/lib/Horde');
}
// update the path if necessary
if (SERVER_LIB_DIR != '') {
   set_include_path(get_include_path() . PATH_SEPARATOR . SERVER_LIB_DIR);
}

// Set the number of seconds in the grace period for which to show expired prorams
if (!defined('GRACE_PERIOD')) {
   define('GRACE_PERIOD', '86400');
}

// Set the number of years in the future that should be available to choose
if (!defined('GRACE_YEAR_FORWARD')) {
	define('GRACE_YEAR_FORWARD', '4');
}


/**
 * TEMPLATE CONSTANTS
 */
if (!defined('TEMPLATE_DIR')) {
   define('TEMPLATE_DIR', WEB_INF . '/templates');
}
if (!defined('FRONT_TEMPLATE_DIR')) {
   define('FRONT_TEMPLATE_DIR', SERVER_BASE_DIR . '/components/com_ccevents/themes/default/templates');
}
if (!defined('SMARTY_CACHE_DIR')) {
   define('SMARTY_CACHE_DIR', WEBAPP_BASE_DIR . '/work/smarty/cache');
}
if (!defined('SMARTY_COMPILE_DIR')) {
   define('SMARTY_COMPILE_DIR', WEBAPP_BASE_DIR . '/work/smarty/compiled');
}

/**
 * LOGGING CONSTANTS
 */

if (!defined('WEBAPP_LOG_DIR')) {
   define('WEBAPP_LOG_DIR', WEB_INF . DS.'logs');
}
if (!defined('WEBAPP_LOG_FILE')) {
   define('WEBAPP_LOG_FILE', WEBAPP_LOG_DIR . DS.'webapp.log');
}
if (!defined('WEBAPP_LOG_IDENT')) {
   define('WEBAPP_LOG_IDENT', WEBAPP_NAME);
}

require_once('Log.php');
if (!defined('WEBAPP_LOG_LEVEL')) {
   define('WEBAPP_LOG_LEVEL', PEAR_LOG_DEBUG);
}

require_once(HORDE_BASE .DS.'Horde.php');
$logger = &Log::singleton('file', WEBAPP_LOG_FILE, WEBAPP_LOG_IDENT, array(), WEBAPP_LOG_LEVEL);
$GLOBALS['logger'] = $logger;

/**
 * Shared (global) variables
 */

if (!defined('DEFAULT_SCOPE_KEY')) {
   define('DEFAULT_SCOPE_KEY', 'exbt');
}

if (!defined('DEFAULT_POSTAL_STATE_KEY')) {
   define('DEFAULT_POSTAL_STATE_KEY', 'CA');
}

if (!defined('DEFAULT_GALLERY_ROOT')) {
	define('DEFAULT_GALLERY_ROOT', '/images/gallery/albums');	
}

if (!defined('DEFAULT_EXBT_IMAGE_URL')) {
	define('DEFAULT_EXBT_IMAGE_URL', DEFAULT_GALLERY_ROOT .'/systemimages/default/exhibition_default_details.jpg');
}

if (!defined('DEFAULT_PRGM_IMAGE_URL')) {
	define('DEFAULT_PRGM_IMAGE_URL', DEFAULT_GALLERY_ROOT .'/templates/autry/images/blank.jpg');
}

if (!defined('DEFAULT_CRSE_IMAGE_URL')) {
	define('DEFAULT_CRSE_IMAGE_URL', DEFAULT_GALLERY_ROOT .'/systemimages/default/course_default_details.jpg');
}

if (!defined('DEFAULT_EXBT_THUMBNAIL_URL')) {
	define('DEFAULT_EXBT_THUMBNAIL_URL', DEFAULT_GALLERY_ROOT .'/systemimages/default/exhibition_default_overview.jpg');
}

if (!defined('DEFAULT_PRGM_THUMBNAIL_URL')) {
	define('DEFAULT_PRGM_THUMBNAIL_URL', DEFAULT_GALLERY_ROOT .'/systemimages/default/program_default_overview.jpg');
}

if (!defined('DEFAULT_GENRE_IMAGE_URL')) {
	define('DEFAULT_GENRE_IMAGE_URL', DEFAULT_GALLERY_ROOT. '/systemimages/default/program_default_listing.jpg');
}

// This has been moved to Program's view.html.php
if (!defined('TICKET_VENDOR_URL')) {
	define('TICKET_VENDOR_URL', 'http://www.ticketweb.com');
}

if (!defined('TICKET_BUTTON_IMAGE')) {
	define('TICKET_BUTTON_IMAGE', '/templates/autry/images/button_tickets.gif');
}

if (!defined('CANCELLED_BUTTON_IMAGE')) {
	define('CANCELLED_BUTTON_IMAGE', '/templates/autry/images/button_cancelled.gif');
}

if (!defined('SOLDOUT_BUTTON_IMAGE')) {
	define('SOLDOUT_BUTTON_IMAGE', '/templates/autry/images/button_soldout.gif');
}

if (!defined('HOMEPAGE_TITLE')) {
	define('HOMEPAGE_TITLE', "");
}

if (!defined('MINUTE_INTERVAL')) {
	define('MINUTE_INTERVAL', '5');
}

if (!defined('PRGM_OVERVIEW_TITLE')) {
	define('PRGM_OVERVIEW_TITLE', 'Overview');
}

if (!defined('PRGM_CONTENT_SECTION_ID')) {
	define('PRGM_CONTENT_SECTION_ID', '1');
}

if (!defined('EXBT_CONTENT_SECTION_ID')) {
	define('EXBT_CONTENT_SECTION_ID', '2');
}

if (!defined('PRESS_CONTENT_SECTION_ID')) {
	define('PRESS_CONTENT_SECTION_ID', '3');
}

if (!defined('COMMENT_ARTICLE_CATEGORY_ID')) {
	define('COMMENT_ARTICLE_CATEGORY_ID', '66');
}

if (!defined('PRESS_ACTIVE_CATEGORY_ID')) {
	define('PRESS_ACTIVE_CATEGORY_ID', '51');
}

// start (or continue) the session
session_start();
?>
