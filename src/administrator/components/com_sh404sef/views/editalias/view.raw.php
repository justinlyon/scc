<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.raw.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.application.component.view');

class Sh404sefViewEditalias extends JView {

  public function display( $tpl = null) {

    // declare docoument mime type
    $document = &JFactory::getDocument();
    $document->setMimeEncoding( 'text/xml');

    // call helper to prepare response xml file content
    $response = Sh404sefHelperGeneral::prepareAjaxResponse( $this);

    // echo it
    echo $response;

  }
}
