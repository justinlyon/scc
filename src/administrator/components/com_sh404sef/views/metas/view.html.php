<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php 1478 2010-06-30 10:35:05Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.application.component.view');

class Sh404sefViewMetas extends JView {

  // we are in 'urls' view
  protected $_context = 'metas';

  public function display( $tpl = null) {

    // get model and update context with current
    $model = &JModel::getInstance( 'urls', 'Sh404sefModel');
    $context = $model->setContext( $this->_context . '.' . $this->getLayout());

    // store it
    $model = &$this->setModel( $model, true);

    // read data from model
    $list = &$model->getList( (object) array('layout' => $this->getLayout(), 'getMetaData' => true));

    // and push it into the view for display
    $this->assign( 'items', $list);
    $this->assign( 'itemCount', count( $this->items));
    $this->assign( 'contentcs', Sh404sefHelperGeneral::getDataMD5( $this->items, array( 'metatitle', 'metadesc')));
    $this->assign( 'pagination', $model->getPagination( (object) array('layout' => $this->getLayout())));
    $options = $model->getDisplayOptions();
    $this->assign( 'options', $options);
    $this->assign( 'optionsSelect', $this->_makeOptionsSelect( $options));
    $this->assign( 'helpMessage', JText16::_('COM_SH404SEF_META_HELP'));

    // add behaviors and styles as needed
    $modalSelector = 'a.modalediturl';
    $js= '\\function(){shAlreadySqueezed = false;if(parent.shReloadModal) {parent.window.location=\''. $this->defaultRedirectUrl .'\';parent.shReloadModal=true}}';
    $params = array( 'overlayOpacity' => 0, 'classWindow' => 'sh404sef-popup', 'classOverlay' => 'sh404sef-popup', 'onClose' => $js);
    Sh404sefHelperHtml::modal( $modalSelector, $params);

    // build the toolbar
    $toolbarMethod = '_makeToolbar' . ucfirst( $this->getLayout());
    if (is_callable( array( $this, $toolbarMethod))) {
      $this->$toolbarMethod( $params);
    }

    // add our own css
    JHtml::styleSheet( 'list.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');

    // link to  custom javascript
    JHtml::script( 'list.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');
    JHtml::script( 'metas.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');

    // now display normally
    parent::display($tpl);

  }

  /**
   * Create toolbar for default layout view
   *
   * @param midxed $params
   */
  private function _makeToolbarDefault( $params = null) {

    global $mainframe;

    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // add title
    $title = Sh404sefHelperGeneral::makeToolbarTitle( JText16::_( 'COM_SH404SEF_META_TAGS'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
    $mainframe->set('JComponentTitle', $title);

    // get toolbar object
    $bar = & JToolBar::getInstance('toolbar');
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 400);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=import&opsubject=urls';  // importing metas is same as importing urls, as export format is same
    $bar->appendButton( 'Shpopuptoolbarbutton', 'import', $url, JText::_( 'Import'), $msg='', $task='import', $list = false, $hidemenu=true, $params);
    
    // add export button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=metas';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'export', $url, JText::_( 'Export'), $msg='', $task='export', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // edit home page button
    $params['class'] = 'modalediturl';
    $params['size'] =array('x' =>700, 'y' => 500);
    $js= '\\function(){shAlreadySqueezed = false;if(parent.shReloadModal) parent.window.location=\''. $this->defaultRedirectUrl .'\';parent.shReloadModal=true}';
    $params['onClose'] = $js;
    $bar->appendButton( 'Shpopupbutton', 'home', JText16::_( 'COM_SH404SEF_HOME_PAGE_ICON'), "index.php?option=com_sh404sef&c=editurl&task=edit&home=1&tmpl=component", $params);

    // separator
    JToolBarHelper::divider();

    // add save button as an ajax call
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');
    $params['class'] = 'savemeta';
    $params['id'] = 'savemeta';
    $params['closewindow'] = 0;
    $bar->appendButton( 'Shajaxbutton', 'save', 'Save', "index.php?option=com_sh404sef&c=metas&task=save&shajax=1&tmpl=component", $params);

    // separator
    JToolBarHelper::divider();

  }


  private function _makeOptionsSelect( $options) {

    $selects = new StdClass();

    // component list
    $current = $options->filter_component;
    $name = 'filter_component';
    $selectAllTitle = JText16::_('COM_SH404SEF_ALL_COMPONENTS');
    $selects->components = Sh404sefHelperHtml::buildComponentsSelectList( $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // language list
    $current = $options->filter_language;
    $name = 'filter_language';
    $selectAllTitle = JText16::_('COM_SH404SEF_ALL_LANGUAGES');
    $selects->languages = Sh404sefHelperHtml::buildLanguagesSelectList( $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // select custom
    $current = $options->filter_url_type;
    $name = 'filter_url_type';
    $selectAllTitle = JText16::_('COM_SH404SEF_ALL_URL_TYPES');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM, 'title' => JText16::_('COM_SH404SEF_ONLY_CUSTOM'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO, 'title' => JText16::_('COM_SH404SEF_ONLY_AUTO'))
    );
    $selects->filter_url_type = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);
    
    // select title
    $current = $options->filter_title;
    $name = 'filter_title';
    $selectAllTitle = JText16::_('COM_SH404SEF_ALL_TITLE');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_TITLE, 'title' => JText16::_('COM_SH404SEF_ONLY_TITLE'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_TITLE, 'title' =>JText16::_('COM_SH404SEF_NO_TITLE'))
    );
    $selects->filter_title = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // select description
    $current = $options->filter_desc;
    $name = 'filter_desc';
    $selectAllTitle = JText16::_('COM_SH404SEF_ALL_DESC');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_DESC, 'title' => JText16::_('COM_SH404SEF_ONLY_DESC'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_DESC, 'title' =>JText16::_('COM_SH404SEF_NO_DESC'))
    );
    $selects->filter_desc = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // return set of select lists
    return $selects;
  }

}