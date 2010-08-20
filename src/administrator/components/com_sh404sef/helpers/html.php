<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: html.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperHtml {


  /**
   * Method to create a select list of the installed components
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  function buildComponentsSelectList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '') {

    // load components from DB
    $components = Sh404sefHelperGeneral::getComponentsList();

    // adjust to require format
    $data = array();
    if (!empty( $components)) {
      foreach( $components as $component) {
        $data[] = array( 'id' => $component->option, 'title' => $component->name);
      }
    }

    // use helper to build html
    $list = self::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle);

    // return list
    return $list;

  }

  /**
   * Method to create a select list of the installed components
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  function buildLanguagesSelectList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '') {

    // load languages from DB
    $languages = Sh404sefHelperGeneral::getInstalledLanguagesList();

    // adjust to require format
    $data = array();
    if (!empty( $languages)) {
      foreach( $languages as $languages) {
        $data[] = array( 'id' => $languages->shortcode, 'title' => $languages->name);
      }
    }

    // use helper to build html
    $list = self::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle);

    // return list
    return $list;

  }

  /**
   * Method to create a select list
   *
   * @access  public
   * @param array $data elements of the select list. An array of (id, title) arrays
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  function buildSelectList( $data, $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '' ) {

    // should we autosubmit ?
    $extra = $autoSubmit ? ' onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"' : '';

    // add select all option
    if ($addSelectAll) {
      array_unshift( $data, JHTML::_('select.option', 0, $selectAllTitle, 'id', 'title' ));
    }
    // use joomla lib to build the list
    return JHTML::_('select.genericlist', $data, $name, $extra, 'id', 'title', $current );

  }


  /**
   * A copy of Joomla own modal helper function,
   * giving access to more params
   *
   * @param $selector selector class to stitch modal javascript on
   * @param $params an array of key/values pairs to be passed as options to SqueezeBox
   */
  function modal( $selector='a.modal', $params = array()) {

    static $modals;
    static $included;

    $document =& JFactory::getDocument();

    // Load the necessary files if they haven't yet been loaded
    if (!isset($included)) {

      // Load the javascript and css
      JHTML::script('modal.js');
      JHTML::stylesheet('modal.css');

      // our flag to block opening several Squeezboxes
      $document = & JFactory::getDocument();
      $document->addScriptDeclaration( 'var shAlreadySqueezed = false;');
      $document->addScriptDeclaration( 'var shReloadModal = true;');

      $included = true;
    }

    if (!isset($modals)) {
      $modals = array();
    }

    $sig = md5(serialize(array($selector,$params)));
    if (isset($modals[$sig]) && ($modals[$sig])) {
      return;
    }

    // Setup options object
    $options = Sh404sefHelperHtml::makeSqueezeboxOptions( $params);

    // Attach modal behavior to document
    $document->addScriptDeclaration("
    window.addEvent('domready', function() {

      SqueezeBox.initialize({".$options."});

      $$('".$selector."').each(function(el) {
        el.addEvent('click', function(e) {
          new Event(e).stop();
          if (!shAlreadySqueezed) {
            shAlreadySqueezed = true;
            SqueezeBox.fromElement(el);
          }
        });
      });
    });");

    // Set static array
    $modals[$sig] = true;
    return;
  }

  public function makeSqueezeboxOptions( $params = array()) {

    // Setup options object
    $opt = array();

    $opt['ajaxOptions'] = (isset($params['ajaxOptions']) && (is_array($params['ajaxOptions']))) ? $params['ajaxOptions'] : null;
    $opt['size']    = (isset($params['size']) && (is_array($params['size']))) ? $params['size'] : null;
    $opt['sizeLoading']    = (isset($params['sizeLoading']) && (is_array($params['sizeLoading']))) ? $params['sizeLoading'] : null;
    $opt['marginInner']    = (isset($params['marginInner']) && (is_array($params['marginInner']))) ? $params['marginInner'] : null;
    $opt['marginImage']    = (isset($params['marginImage']) && (is_array($params['marginImage']))) ? $params['marginImage'] : null;

    $opt['overlayOpacity']    = (isset($params['overlayOpacity'])) ? $params['overlayOpacity'] : null;
    $opt['classWindow']    = (isset($params['classWindow'])) ? $params['classWindow'] : null;
    $opt['classOverlay']    = (isset($params['classOverlay'])) ? $params['classOverlay'] : null;
    $opt['disableFx']    = (isset($params['disableFx'])) ? $params['disableFx'] : null;

    $opt['onOpen']    = (isset($params['onOpen'])) ? $params['onOpen'] : null;
    $opt['onClose']   = (isset($params['onClose'])) ? $params['onClose'] : null;
    $opt['onUpdate']  = (isset($params['onUpdate'])) ? $params['onUpdate'] : null;
    $opt['onResize']  = (isset($params['onResize'])) ? $params['onResize'] : null;
    $opt['onMove']    = (isset($params['onMove'])) ? $params['onMove'] : null;
    $opt['onShow']    = (isset($params['onShow'])) ? $params['onShow'] : null;
    $opt['onHide']    = (isset($params['onHide'])) ? $params['onHide']  : null;

    $opt['fxOverlayDuration']    = (isset($params['fxOverlayDuration'])) ? $params['fxOverlayDuration'] : null;
    $opt['fxResizeDuration']    = (isset($params['fxResizeDuration'])) ? $params['fxResizeDuration'] : null;
    $opt['fxContentDuration']    = (isset($params['fxContentDuration'])) ? $params['fxContentDuration'] : null;

    $options = self::JGetJSObject($opt);

    $options = substr($options, 0, 1) == '{' ? substr( $options, 1) : $options;
    $options = substr($options, -1) == '}' ? substr( $options, 0, -1) : $options;

    return $options;
  }

  /**
   * Internal method to get a JavaScript object notation string from an array
   * Copied over from Joomla lib, for access reasons
   *
   * @param array $array  The array to convert to JavaScript object notation
   * @return  string  JavaScript object notation representation of the array
   * @since 1.5
   */
  public function JGetJSObject($array=array())
  {
    // Initialize variables
    $object = '{';

    // Iterate over array to build objects
    foreach ((array)$array as $k => $v)
    {
      if (is_null($v)) {
        continue;
      }
      if (!is_array($v) && !is_object($v)) {
        $object .= ' '.$k.': ';
        $object .= (is_numeric($v) || strpos($v, '\\') === 0) ? (is_numeric($v)) ? $v : substr($v, 1) : "'".$v."'";
        $object .= ',';
      } else {
        $object .= ' '.$k.': '.self::JGetJSObject($v).',';
      }
    }
    if (substr($object, -1) == ',') {
      $object = substr($object, 0, -1);
    }
    $object .= '}';

    return $object;
  }

  /**
   * Builds up an html link using the various parts supplied
   *
   * @param $view a JView object, to be able to escape output text
   * @param $linkData an array of key/value pairs to build up the target links
   * @param $elementData an array holding element data : title, class, rel
   * @param $modal boolean, if true, required stuff to make the link open in modal box is added
   * @param $hasTip boolean, if true, required stuff to turn elementData['title'] into a tooltip is added
   * @param $extra an array holding key/value pairs, will be added as raw attributes to the link
   */
  public function makeLink( $view, $linkData, $elementData, $modal = false, $modalOptions = array(), $hasTip = false, $extra = array()) {

    // calculate target link
    if ($modal) {
      $linkData['tmpl'] = 'component';
    }
    $url = Sh404sefHelperGeneral::buildUrl( $linkData);
    $url = JRoute::_( $url);

    // calculate title
    $title = empty( $elementData['title']) ? '' : $elementData['title'];
    $title = is_null( $view) ? $title : $view->escape( $title);

    $attribs = array();

    // calculate class
    $class = empty( $elementData['class']) ? '' : $elementData['class'];
    if ($hasTip) {
      $class .= ' ' . $hasTip;
    }

    // store title in attributes array
    if (!empty( $title)) {
      $attribs['title'] = $title;
    }


    // store in attributes array
    if (!empty( $class)) {
      $attribs['class'] = $class;
    }

    // calculate modal information
    $rel = empty( $elementData['rel']) || is_null($view) ? '' : $view->escape($elementData['rel']);
    if ($modal) {
      $modalOptionsString = Sh404sefHelperHtml::makeSqueezeboxOptions( $modalOptions);
      $rel .= ' {handler: \'iframe\'' . (empty($modalOptionsString) ? '' : ', ' . $modalOptionsString) . '}';
    }

    // store in attributes array
    if (!empty( $rel)) {
      $attribs['rel'] = $rel;
    }

    // any custom attibutes ?
    if (!empty($extra)) {
      foreach($extra as $key => $value) {
        $attribs[$key] = $value;
      }
    }

    // finish link
    $anchor = empty( $elementData['anchor']) ? $title : $elementData['anchor'];

    return JHTML::link( $url, $anchor, $attribs);

  }

  public function gridMainUrl(&$url, $i) {

    $isMain = $url->rank == 0;

    $imgPrefix = $isMain ? '' : '-non';
    $img = 'components/com_sh404sef/assets/images/icon-16' . $imgPrefix . '-default.png';

    if ($isMain){
      $alt = JText16::_('COM_SH404SEF_DUPLICATE_IS_MAIN');
      $href = '<img src="' . $img .'" border="0" alt="'. $alt .'" title="' . $alt . '" />';
    } else {
      $alt  = JText16::sprintf('COM_SH404SEF_DUPLICATE_MAKE_MAIN', $url->oldurl);
      $href = '
    <a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\'makemainurl\')" title="'. $alt .'">
    <img src="' . $img .'" border="0" alt="'. $alt .'" /></a>'
    ;
    }
    return $href;
  }

  /**
   * Returns html to display a main control panel icon
   *
   * @param string $function name of function performed by icon
   */
  public function getCPImage( $function) {

    switch ($function) {
      case 'config_base':
        $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-cpanel.png\'/>';
        $linkData = array( 'c' => 'config', 'tmpl' => 'component');
        $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_DESC'), 'class' => 'modalediturl','anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG') . '</span>');
        $modalOptions = array( 'size' => array('x' => '\\window.getSize().scrollSize.x*.9', 'y' => '\\window.getSize().size.y*.9'));
        $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
        break;
      case 'config_ext':
        $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-ext.png\'/>';
        $linkData = array( 'c' => 'config', 'layout' => 'ext', 'tmpl' => 'component');
        $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_EXT_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_EXT') . '</span>');
        $modalOptions = array( 'size' => array('x' => '\\window.getSize().scrollSize.x*.9', 'y' => '\\window.getSize().size.y*.9'));
        $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
        break;
      case 'config_error_page':
        $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-errorpage.png\'/>';
        $linkData = array( 'c' => 'config', 'layout' => 'errordocs', 'tmpl' => 'component');
        $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_ERROR_PAGE_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_ERROR_PAGE') . '</span>');
        $modalOptions = array( 'size' => array('x' => '\\window.getSize().scrollSize.x*.9', 'y' => '\\window.getSize().size.y*.9'));
        $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
        break;
      case 'config_seo':
        $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-seo.png\'/>';
        $linkData = array( 'c' => 'config', 'layout' => 'seo', 'tmpl' => 'component');
        $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_SEO_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_SEO') . '</span>');
        $modalOptions = array( 'size' => array('x' =>700, 'y' => '\\window.getSize().size.y*.7'));
        $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
        break;
      case 'config_sec':
        $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-sec.png\'/>';
        $linkData = array( 'c' => 'config', 'layout' => 'sec', 'tmpl' => 'component');
        $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_SEC_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_SEC') . '</span>');
        $modalOptions = array( 'size' => array('x' =>700, 'y' => '\\window.getSize().size.y*.9'));
        $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
        break;  
        
      case 'urlmanager':
        $img = 'icon-48-sefmanager.png';
        $title = JText16::_( 'COM_SH404SEF_VIEWURLDESC');
        $anchor = JText16::_( 'COM_SH404SEF_VIEWURL');
        $link = 'index.php?option=com_sh404sef&c=urls&layout=default&view=urls';
        $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
        break;
      case '404manager':
        $img = 'icon-48-404log.png';
        $title = JText16::_( 'COM_SH404SEF_VIEW404DESC');
        $anchor = JText16::_( 'COM_SH404SEF_404_MANAGER');
        $link = 'index.php?option=com_sh404sef&c=urls&layout=view404&view=urls';
        $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
        break;
      case 'aliasesmanager':
        $img = 'icon-48-aliases.png';
        $title = JText16::_( 'COM_SH404SEF_ALIASES_HELP');
        $anchor = JText16::_( 'COM_SH404SEF_ALIASES_MANAGER');
        $link = 'index.php?option=com_sh404sef&c=aliases&layout=default&view=aliases';
        $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
        break;
      case 'pageidmanager':
        $img = 'icon-48-pageid.png';
        $title = JText16::_( 'COM_SH404SEF_PAGEID_HELP');
        $anchor = JText16::_( 'COM_SH404SEF_PAGEID_MANAGER');
        $link = 'index.php?option=com_sh404sef&c=pageids&layout=default&view=pageids';
        $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
        break;  
      case 'metamanager':
        $img = 'icon-48-metas.png';
        $title = JText16::_( 'COM_SH404SEF_META_TAGS_DESC');
        $anchor = JText16::_( 'COM_SH404SEF_META_TAGS');
        $link = 'index.php?option=com_sh404sef&c=metas&layout=default&view=metas';
        $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
        break;
      case 'doc':
        $img = 'icon-48-doc.png';
        $title = JText16::_( 'COM_SH404SEF_INFODESC');
        $anchor = JText16::_( 'COM_SH404SEF_INFO');
        $link = 'index.php?option=com_sh404sef&layout=info&view=default&task=info';
        $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
        break;
    }

    return $link;

  }

  private function _doLinkCPImage( $img, $title, $anchor, $link) {

    $link  = '<a href="' . $link . '" style="text-decoration: none;" title="' . $title . '">';
    $link .= ' <img src="components/com_sh404sef/assets/images/' . $img . '"/>';
    $link .= '<span>' . $anchor . '</span></a>';

    return $link;
  }
}