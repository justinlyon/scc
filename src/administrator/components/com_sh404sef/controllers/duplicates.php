<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: duplicates.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefControllerDuplicates extends Sh404sefClassBasecontroller {

  protected $_context = 'com_sh404sef.duplicates';
  protected $_defaultModel = 'duplicates';
  protected $_defaultView = 'duplicates';
  protected $_defaultController = 'duplicates';
  protected $_defaultTask = '';
  protected $_defaultLayout = 'default';

  protected $_returnController = 'urls';
  protected $_returnTask = '';
  protected $_returnView = 'urls';
  protected $_returnLayout = 'default';

  /**
   * Redirect to a confirmation page showing in
   * a popup window
   */
  public function display($cachable = false) {

    // find and store edited item id
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');

    // Set the view name and create the view object
    $viewName = 'duplicates';
    $document =& JFactory::getDocument();
    $viewType = $document->getType();
    $viewLayout = JRequest::getCmd( 'layout', $this->_defaultLayout );

    $view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));

    // Get/Create the model
    if ($model = & $this->getModel( 'duplicates', 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( $this->_context);

      // store the sef url id
      $model->setState( 'sefId', $cid[0]);

      // Push the model into the view (as default)
      $view->setModel($model, true);

    }

    // Set the layout
    $view->setLayout($viewLayout);

    // Display the view
    $view->display();

  }

  public function makemainurl() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    // find and store edited item id
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');

    // check invalid data
    if (!is_array( $cid ) || count( $cid ) != 1 || intval($cid[0]) == 0) {
      $redirect = array( 'c'=>"duplicates", 'tmpl' => 'component', 'cid[]' => JRequest::getInt('mainurl_id'));
      $this->setRedirect( $this->_getDefaultRedirect( $redirect), JText16::_( 'COM_SH404SEF_SELECT_ONE_URL'), 'error');
      
      // send back response through default view
      $this->display();
    }

    // now make that url the main url
    // while also setting the previous
    // with this url current rank
    // get the model to do it, actually
    // Get/Create the model
    if ($model = & $this->getModel( $this->_defaultModel, 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( $this->_context);

      // call the delete method on our list
      $model->makeMainUrl( intval($cid[0]));

      // check errors and enqueue them for display if any
      $errors = $model->getErrors();
      if (!empty($errors)) {
        $this>enqueuemessages( $errors, 'error');

      }

    }

    // send back response through default view
    $this->display();

  }

}