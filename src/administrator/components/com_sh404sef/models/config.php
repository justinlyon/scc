<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: config.php 1466 2010-06-12 18:54:47Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelConfig extends Sh404sefClassBaseeditmodel {

  protected $_context = 'sh404sef.config';

  protected $_defaultTable = '';

  /**
   * Layout value
   *
   * @var string
   */
  protected $_layout = 'default';


  /**
   * Save configuration to disk
   * from POST data or input array of data
   *
   * When config will be saved to db, most of the code in this
   * model will be removed and basemodel should handle everything
   *
   * @param array $dataArray an array holding data to save. If empty, $_POST is used
   * @return integer id of created or updated record
   */
  public function save( $dataArray = null) {

    // get current configuration object
    $sefConfig = & shRouter::shGetConfig();

    // call the appropriate method for each
    // configuration settings set
    $methodName = '_save' . ucfirst( $this->_layout);

    if (is_callable( array($this, $methodName))) {
      $status = true;
      $this->$methodName();
    } else {
      $status = false;
      $this->setError( 'Internal error : method not defined : _save' . ucfirst( $params['layout']));
    }

    if ($status && !empty($_POST)) {
      foreach($_POST as $key => $value) {
        $sefConfig->set($key, $value);
        $this->_advancedConfig($key, $value);
      }
    }

    // ask config class to save itself
    $status = $status && $sefConfig->saveConfig();

    // store any error
    if(!$status) {
      $this->setError( JText16::_('COM_SH404SEF_ERR_CONFIGURATION_NOT_SAVED'));

    }

    return $status;
  }

  /**
   * Prepare saving of basic configuration options set
   */
  private function _saveDefault() {

    // get current configuration object
    $sefConfig = & shRouter::shGetConfig();

    //clear config arrays, unless POST is empty, meaning this is first attempt to save config
    if (!empty($_POST)) {
      $sefConfig->skip = array();
      $sefConfig->nocache = array();
      $sefConfig->notTranslateURLList = array();
      $sefConfig->notInsertIsoCodeList = array();
      $sefConfig->shDoNotOverrideOwnSef = array();
      $sefConfig->shLangTranslateList = array();
      $sefConfig->shLangInsertCodeList = array();
      $sefConfig->compEnablePageId = array();
      $sefConfig->defaultComponentStringList = array();
    }
    if (empty($_POST['debugToLogFile'])) {
      $sefConfig->debugStartedAt = 0;
    } else {
      $sefConfig->debugStartedAt = empty($sefConfig->debugStartedAt) ? time() : $sefConfig->debugStartedAt;
    }

  }

  /**
   * Prepare saving of  extensions configuration options set
   */
  private function _saveExt() {

  }

  /**
   * Prepare saving of  S.E.O. and meta configuration options set
   */
  private function _saveSeo() {
    
    // get plugins details
    $plugin = &JPluginHelper::getPlugin( 'system', 'shmobile');
    $params = new JParameter( $plugin->params);
    
    // get current values
    $defaultEnabled = $params->get('mobile_switch_enabled');
    $defaultTemplate = $params->get('mobile_template');
    
    // save mobile template switcher params, stored in system plugin
    $mobile_switch_enabled = JRequest::getBool( 'mobile_switch_enabled', $defaultEnabled);
    $mobile_template = JRequest::getCmd( 'mobile_template', $defaultTemplate);
    
    // set params
    $params->set('mobile_switch_enabled', $mobile_switch_enabled);
    $params->set('mobile_template', $mobile_template);
    $textParams = $params->toString();
    
    // save params to database
    $db = &JFactory::getDBO();
    $query = 'update ' . $db->nameQuote( '#__plugins')
     . ' set ' . $db->nameQuote( 'params') . '=' . $db->Quote( $textParams)
     . ' where ' . $db->nameQuote( 'element') . '=' . $db->Quote( 'shmobile');
     
    $db->setQuery( $query);
    $db->query();
    
  }

  /**
   * Prepare saving of  security configuration options set
   */
  private function _saveSec() {

    // get current configuration object
    $sefConfig = & shRouter::shGetConfig();

    //set skip and nocache arrays, unless POST is empty, meaning this is first attempt to save config
    if (!empty($_POST)) {
      $sefConfig->shSecOnlyNumVars = array();
      $sefConfig->shSecAlphaNumVars = array();
      $sefConfig->shSecNoProtocolVars = array();
      $sefConfig->ipWhiteList = array();
      $sefConfig->ipBlackList = array();
      $sefConfig->uAgentWhiteList = array();
      $sefConfig->uAgentBlackList = array();
    }

  }

  /**
   * Prepare saving of  Error documents configuration options set
   */
  private function _saveErrordocs() {

    // update 404 error page
    $shIntroText = empty($_POST) ? '' : $_POST['introtext'];
    $sql='SELECT id  FROM #__content WHERE `title`="__404__"';
    $this->_db->setQuery( $sql );
    if ($id = $this->_db->loadResult()){
      $sql = 'UPDATE #__content SET introtext="'.$shIntroText.'",  modified ="'.date("Y-m-d H:i:s").'" WHERE `id` = "'.$id.'";';
    }else{
      $sql='SELECT MAX(id)  FROM #__content';
      $this->_db->setQuery( $sql );
      if ($max = $this->_db->loadResult()){
        $max++;
        $sql = 'INSERT INTO #__content VALUES( "'.$max.'", "__404__", "__404__", "__404__", "'.$shIntroText.'", "", "1", "0", "0", "0", "2004-11-11 12:44:38", "62", "", "'.date("Y-m-d H:i:s").'", "62", "0", "2004-11-11 12:45:09", "2004-10-17 00:00:00", "0000-00-00 00:00:00", "", "", "menu_image=-1\nshow_title=0\nshow_section=0\nshow_category=0\show_vote=0\nshow_author=0\nshow_create_date=0\nshow_modify_date=0\nshow_pdf_icon=0\nshow_print_icon=0\nshow_email_icon=0\npageclass_sfx=", "1", "0", "0", "", "", "0", "0", "");';
      }
    }
    $this->_db->setQuery( $sql );
    if (!$this->_db->query()) {
      $this->setError( $this->_db->getErrorMsg());
    }

    // prevent from being added later on to $sefConfig
    unset($_POST['introtext']);
  }

  /**
   * Prepare saving of quick control panel
   */
  private function _saveQcontrol() {

  }

  /**
   * Handle processing of some special parts of configuration
   * will be removed when moving to DB backed config
   *
   * @param string $key
   * @param string $value
   */
  private function _advancedConfig($key,$value){

    $sefConfig = & shRouter::shGetConfig();
    if ((strpos($key,"com_")) !== false) {
      // V 1.2.4.m
      $key = str_replace('com_','',$key);
      $param = explode('___',$key);
      switch ($param[1]) {
        case 'manageURL' :
          switch ($value) {
            case 1 :
              array_push($sefConfig->nocache,$param[0]);
              break;
            case 2 :
              array_push($sefConfig->skip,$param[0]);
              break;
          }
          break;
        case 'translateURL':
          if ($value == 1)
          array_push($sefConfig->notTranslateURLList,$param[0]);
          break;
        case 'insertIsoCode':
          if ($value == 1)
          array_push($sefConfig->notInsertIsoCodeList,$param[0]);
          break;
        case 'shDoNotOverrideOwnSef':
          if ($value == 1)
          array_push($sefConfig->shDoNotOverrideOwnSef,$param[0]);
          break;
        case 'compEnablePageId':
          if ($value == 1)
          array_push($sefConfig->compEnablePageId,$param[0]);
          break;
        case 'defaultComponentString':
          $cleanedUpValue = empty($value) ? '': titleToLocation($value);
          $cleanedUpValue = JString::trim( $cleanedUpValue, $sefConfig->friendlytrim);
          $sefConfig->defaultComponentStringList[$param[0]] = $cleanedUpValue;
          break;
      }
    } else {

      switch ($key){
        case 'shSecOnlyNumVars':
          $this->_shSetArrayParam($value, $sefConfig->shSecOnlyNumVars);
          break;
        case 'shSecAlphaNumVars':
          $this->_shSetArrayParam($value, $sefConfig->shSecAlphaNumVars);
          break;
        case 'shSecNoProtocolVars':
          $this->_shSetArrayParam($value, $sefConfig->shSecNoProtocolVars);
          break;
      }

      if (preg_match('/languages_([a-zA-Z]{2}-[a-zA-Z]{2})_translateURL/U', $key, $matches)) {
        $sefConfig->shLangTranslateList[$matches[1]] = $value;
      }
      if (preg_match('/languages_([a-zA-Z]{2}-[a-zA-Z]{2})_insertCode/U', $key, $matches)) {
        $sefConfig->shLangInsertCodeList[$matches[1]] = $value;
      }
      if (preg_match('/languages_([a-zA-Z]{2}-[a-zA-Z]{2})_pageText/U', $key, $matches)) {
        $sefConfig->pageTexts[$matches[1]] = $value;
      }
    }
  }

  private function _shSetArrayParam($value, &$param) {
    if (!empty($value)) {
      $param = explode("\n", $value);
      foreach ($param as $k=>$v) {
        $param[$k] = JString::trim($v);
      }
    } else
    $param = array();
    if (!empty($param))
    $param = array_filter($param);
  }

}