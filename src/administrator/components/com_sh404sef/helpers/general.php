<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: general.php 1478 2010-06-30 10:35:05Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperGeneral {

  const COM_SH404SEF_ALL_DUPLICATES = 0;
  const COM_SH404SEF_ONLY_DUPLICATES = 1;
  const COM_SH404SEF_NO_DUPLICATES = 2;

  const COM_SH404SEF_ALL_ALIASES = 0;
  const COM_SH404SEF_ONLY_ALIASES = 1;
  const COM_SH404SEF_NO_ALIASES = 2;

  const COM_SH404SEF_ALL_URL_TYPES = 0;
  const COM_SH404SEF_ONLY_CUSTOM = 1;
  const COM_SH404SEF_ONLY_AUTO = 2;

  const COM_sh404SEF_URLTYPE_404 = -2;
  const COM_sh404SEF_URLTYPE_NONE = -1;
  const COM_sh404SEF_URLTYPE_AUTO = 0;
  const COM_sh404SEF_URLTYPE_CUSTOM = 1;

  const COM_SH404SEF_URLTYPE_ALIAS = 0;
  const COM_SH404SEF_URLTYPE_PAGEID = 1;

  const COM_SH404SEF_ALL_TITLE = 0;
  const COM_SH404SEF_ONLY_TITLE = 1;
  const COM_SH404SEF_NO_TITLE = 2;

  const COM_SH404SEF_ALL_DESC = 0;
  const COM_SH404SEF_ONLY_DESC = 1;
  const COM_SH404SEF_NO_DESC = 2;


  /**
   * Load components
   *
   * @access  public
   * @param array exclude an array of component to exclude from result
   * @return  array
   */
  public function getComponentsList( $exclude = array()) {

    static $components = null;

    if (is_null($components)) {

      $db = &JFactory::getDBO();

      $query = 'select * from #__components'
      . ' where `parent` = 0 and `option` <> ""';

      // exclude some backend components + Joomfish and ourselves
      $exclude = array_merge( array( 'com_sh404sef', 'com_media', 'com_config', 'com_installer', 'com_languages', 'com_massmail'
      , 'com_menus', 'com_messages', 'com_modules', 'com_plugins', 'com_templates', 'com_users'
      , 'com_cache', 'com_cpanel', 'com_joomfish', 'com_joomsef'), $exclude);
      if (!empty( $exclude)) {
        $query .= ' and (`option` not in (\'' . implode('\',\'', $exclude) .'\'))';
      }

      // finish query
      $query .= ' order by `name`';

      // perform query
      $db->setQuery( $query );

      if (!($components = $db->loadObjectList( 'option' ))) {
        JError::raiseWarning( 'SOME_ERROR_CODE', "Error loading Components: " . $db->getErrorMsg());
        return false;
      }

    }

    return $components;

  }

  /**
   * Get installed front end language list
   *
   * @access  private
   * @return  array
   */
  public function getInstalledLanguagesList( $site = true) {

    static $languages = null;

    if (is_null($languages)) {

      $db = &JFactory::getDBO();

      // is there a languages table ?
      $languagesTableName = $db->getPrefix() . 'languages';
      $tablesList = $db->getTableList();
      if (in_array( $languagesTableName, $tablesList)) {

        $query = 'SELECT id, shortcode, name FROM #__languages WHERE active = "1" ORDER BY `ordering`';
        $db->setQuery( $query );

        if (!($languages = $db->loadObjectList())) {
          JError::raiseWarning( 'SOME_ERROR_CODE', "Error loading languages lists: " . $db->getErrorMsg());
          return false;
        }
      }
    }

    return $languages;

  }

  /**
   * Builds an internal urls
   *
   * @param <array> $elements an array of key,value pairs, should not have option=
   * @param string value of component, if not default
   * @return <string> the urls
   */
  public function buildUrl( $elements, $option = 'com_sh404sef') {

    $url = 'index.php?option=' . $option;

    if (is_array( $elements) && !empty( $elements)) {
      foreach( $elements as $key => $value) {
        $url .= '&' . $key . '=' . $value;
      }
    }

    return $url;
  }

  public function getComponentUrl( ) {

    return 'administrator/components/com_sh404sef';
  }

  /**
   * Create toolbar title for current view
   *
   * This one can ucstomize the class for styling
   * plus the output can be used to
   * simply display the title as opposed to
   * using $mainframe to set the component
   * title, which is not OK when used inside a modal box
   *
   * @param string $title text title
   * @param string $icon the name of an image, which is used to calculate aclass name
   * @param string $class the name of a wrapping class
   */
  public function makeToolbarTitle( $title, $icon = 'generic.png', $class = 'header') {

    //strip the extension
    $icon = preg_replace('#\.[^.]*$#', '', $icon);

    $html  = "<div class=\"$class icon-48-$icon\">\n";
    $html .= "$title\n";
    $html .= "</div>\n";

    return $html;

  }

  /**
   * Prepare an xml file content holding
   * a standard record for returning result
   * of an ajax request
   *
   * @param JView $view the view handling the request
   */
  public function prepareAjaxResponse( $view) {

    // use Joomla wml object
    jimport( 'joomla.utilities.simplexml');

    // create a root node
    $xml = new JSimpleXMLElement( 'item', array( 'id' => 'shajax-response'));

    // add children : status, message, message code, task
    $status = & $xml->addChild( 'status');
    $message = & $xml->addChild( 'message');
    $messagecode = & $xml->addChild( 'messagecode');
    $taskexecuted = & $xml->addChild( 'taskexecuted');

    // set default values
    $status->setData('_');
    $message->setData('_');
    $messagecode->setData( '_');
    $taskexecuted->setData('_');

    // set their respective values
    $vErrors = $this->getErrors();
    if (empty($vErrors)) {
      // retrieve messagecode and task
      if(empty($view->messagecode)) {
        $view->assign( 'messagecode', 'COM_SH404SEF_OPERATION_COMPLETED');
      }
      if(empty($view->taskexecuted)) {
        $view->assign( 'taskexecuted', '');
      }

      // either a success or a redirect
      if (empty($this->redirectTo)) {
        // no error
        $status->setData( 'success');
        $msg = empty( $this->message) ? JText16::_( 'COM_SH404SEF_OPERATION_COMPLETED') : $this->message;
        $message->setData('<ul>' . $msg . '</ul>');
        $messagecode->setData( $view->messagecode);
      } else {
        $status->setData( 'redirect');
        $glue = strpos( $this->redirectTo, '?') === false ? '?' : '&';
        $message->setData( $this->redirectTo . $glue . 'sh404sefMsg=' . $view->messagecode);
      }
      $taskexecuted->setData( $view->taskexecuted);
    } else {
      $status->setData( 'failure');
      $messageTxt =  '';
      foreach( $vErrors as $error) {
        $messageTxt .= '<li>' . $error . '</li>';
      }
      $message->setData( '<ul>' . $messageTxt . '</ul>');
    }

    // output resulting text, no need for a layout file I think
    $output = '<?xml version="1.0" encoding="UTF-8" ?>'. "\n";
    $output .= $xml->toString();

    return $output;
  }

  /**
   * Calculate MD5 of a set of data
   *
   * @param array $dataSet the data, as an array of objects or arrays
   * @param array $columns, hold the names of the object properties to be used in calculation
   * @param boolean $asObject if true, dataSet is an array of objects, else an array of array
   */
  public function getDataMD5( $dataSet, $columns, $asObject = true) {

    $md5 = null;
    $sum = '';

    if (!empty( $dataSet) && !empty( $columns)) {
      foreach( $dataSet as $record) {
        foreach( $columns as $column) {
          $sum .= $asObject ? $record->$column : $record[$column];
        }
      }
      $md5 = md5( $sum);
    }

    return $md5;
  }

  /**
   * Returns either the full set or just one
   * header line to be used in an export file
   * Also needed when importing, to recognize
   * import type
   *
   * @param string $type the data type being imported
   */
  public function getExportHeaders( $type = null) {

    static $_headers = array(
      'aliases' => '"Nbr","Alias","Sef url","Non sef url","Type","Hits"'
      , 'urls' => '"Nbr","Sef url","Non sef url","Hits","Rank","Date added","Page title","Page description","Page keywords","Page language","Robots tag"'
      , 'metas' => '"Nbr","Sef url","Non sef url","Hits","Rank","Date added","Page title","Page description","Page keywords","Page language","Robots tag"'
      , 'pageids' => '"Nbr","pageId","Sef url","Non sef url","Type","Hits"'
      , 'view404' => '"Nbr","Sef url","Non sef url","Hits","Rank","Date added","Page title","Page description","Page keywords","Page language","Robots tag"'
      
      // legacy files
      , 'sh404sefurls' => '"id","Count","Rank","SEF URL","non-SEF URL","Date added"'
      , 'sh404sefmetas' => '"id","newurl","metadesc","metakey","metatitle","metalang","metarobots"'
      
      );

      if (is_null( $type)) {
        return $_headers;
      }

      if (isset( $_headers[$type])) {
        return $_headers[$type];
      }

      return false;
  }
}