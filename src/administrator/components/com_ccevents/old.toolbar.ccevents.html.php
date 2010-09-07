<?php
/**
 *  $Id$: toolbar.ccevents.html.php, Jul 24, 2006 11:29:10 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

 
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );
 
/**
* @package ccevents
*/
class TOOLBAR_ccevents {
    /**
     * Displays the Joomla toolbar for unrecognized tasks
     */
    function _Default()
    {
    	//summary();   
    }
    
    /**
     * Renders the Joomla toolbar for all summary pages
     */
    function _Summary()
    {
		$code = JRequest::getVar('scope');
		$text = TOOLBAR_ccevents::getTitle($code);
		
		JToolBarHelper::title( $text .' Summary', 'addedit.png' );
		JToolBarHelper::customX( 'viewArchive', 'archive.png', 'archive_f2.png', 'View Archive', false );
		JToolBarHelper::archiveList();
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList('','delete');
		JToolBarHelper::addNew( 'setup' );
		JToolBarHelper::help( 'ccevents.help.html' );
    }
    
    /**
     * Renders the Joomla toolbar for all detail pages
     */
    function _Detail()
    {
    	$code = JRequest::getVar('scope');
		$text = TOOLBAR_ccevents::getTitle($code);
		
		JToolBarHelper::title( $text .' Details', 'addedit.png' );
        JToolBarHelper::save('save');
        JToolBarHelper::apply('apply');
        JToolBarHelper::cancel('cancel');
        JToolBarHelper::addNew('setup');
        JToolBarHelper::help( 'ccevents.help.html' );
    }
    
	/**
	 * Renders the toolbar for the announcment controller
	 */
	 function _Announcement()
	 {
	 	mosMenuBar::startTable();
	 	mosMenuBar::apply('apply');
	 	mosMenuBar::help( 'ccevents.help.html' );
        mosMenuBar::endTable();	 		
	 }
	 
	 /**
	  * Returns the proper scope name for the
	  * given scope code
	  * @param string code (annc, prgm, etc.)
	  * @return string name (Announcement, Program, etc.)
	  */
	 function getTitle($code)
	 {
	 	$name = "";
		switch ($code) {
			case 'vnue' : $name='Venue'; break;	
			case 'prgm' : $name='Program'; break;
			case 'exbt' : $name='Exhibition'; break;
			case 'crse' : $name='Course'; break;
			case 'gnre' : $name='Genre'; break;
			case 'annc' : $name='Audience'; break;
			case 'audc' : $name='Audience'; break;
			case 'home' : $name='Home Page'; break;
			case 'sers' : $name='Series'; break;
		}
		return $name;
	 }
}

?>
