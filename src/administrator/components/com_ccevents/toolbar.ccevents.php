<?php
/**
 *  $Id$: toolbar.ccevents.php, Jul 11, 2006 9:46:11 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

if ($_REQUEST['option'] == 'com_ccevents' && $_REQUEST['scope'] == 'annc') {
	TOOLBAR_ccevents::_Announcement();
}

else {
	switch ($task) {
		case "addGallery" :
		case "apply" :
		case "linkCategories" :
		case "linkCourses" :
		case "linkPrograms" :
		case "linkVenues" :
		case "read" :
		case "setup" :
			TOOLBAR_ccevents::_Detail();
			break;
		
		case "archive" :
		case "cancel" :
		case "publish" :
		case "readArchive" :
		case "save" :
		case "summary" :
		case "unpublish" :
			TOOLBAR_ccevents::_Summary();
			break;
		
		default:
			TOOLBAR_ccevents::_Summary();
			break;
	}

}
?>
 
