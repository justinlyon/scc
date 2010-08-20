<?php
/**
 * J!Dump
 * @version      $Id: view.html.php 31 2008-04-28 14:46:40Z jenscski $
 * @package      mjaztools_dump
 * @copyright    Copyright (C) 2007 J!Dump Team. All rights reserved.
 * @license      GNU/GPL
 * @link         http://joomlacode.org/gf/project/jdump/
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class DumpViewAbout extends JView {
    function display($tpl = null) {
        global $mainframe;

        // Toolbar
        JToolBarHelper::title( 'J!Dump v' . DUMP_VERSION );
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Popup', 'default', 'Popup', "index.php?option=com_dump&view=tree&closebutton=0" );
        JToolBarHelper::preferences( 'com_dump', '300' );


/** Not needed here, DumpViewAbout is only used in the administrator
        // we need to add these paths so the component can work in both site and administrator
        $this->addTemplatePath( dirname(__FILE__) . DS . 'tmpl' );
*/


        $files = array( 'readme', 'changelog', 'installation' );
        foreach( $files as $file ) {
            $this->assignRef( $file, $this->get( $file ) );
        }

        parent::display($tpl);
    }
}
