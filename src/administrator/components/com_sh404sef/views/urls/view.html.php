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

class Sh404sefViewUrls extends JView {

  // we are in 'urls' view
  protected $_context = 'urls';

  public function display( $tpl = null) {

    // get model and update context with current
    $model = &$this->getModel();
    $context = $model->setContext( $this->_context . '.' . $this->getLayout());

    // read data from model
    $list = &$model->getList( (object) array('layout' => $this->getLayout()));

    // and push it into the view for display
    $this->assign( 'items', $list);
    $this->assign( 'itemCount', count( $this->items));
    $this->assign( 'pagination', $model->getPagination( (object) array('layout' => $this->getLayout())));
    $options = $model->getDisplayOptions();
    $this->assign( 'options', $options);
    $this->assign( 'optionsSelect', $this->_makeOptionsSelect( $options));

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
    JHtml::styleSheet( 'urls.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');

    // link to  custom javascript
    JHtml::script( 'list.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');

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
    $title = Sh404sefHelperGeneral::makeToolbarTitle( JText16::_( 'COM_SH404SEF_SEF_URL_LIST'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
    $mainframe->set('JComponentTitle', $title);

    // add "New url" button
    $bar = & JToolBar::getInstance('toolbar');
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');
    $params['class'] = 'modalediturl';
    $params['size'] =array('x' =>700, 'y' => 500);
    $js= '\\function(){shAlreadySqueezed = false;if(parent.shReloadModal) parent.window.location=\''. $this->defaultRedirectUrl .'\';parent.shReloadModal=true}';
    $params['onClose'] = $js;
    $bar->appendButton( 'Shpopupbutton', 'new', JText::_('New'), "index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component", $params);

    // add edit button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>700, 'y' => 500);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'edit', $url, JText::_( 'Edit'), $msg='', $task='edit', $list = true, $hidemenu=true, $params);

    // add delete button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdelete&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'delete', $url, JText::_( 'Delete'), $msg=JText::_('VALIDDELETEITEMS', true), $task='delete', $list = true, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 400);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=import&opsubject=urls';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'import', $url, JText::_( 'Import'), $msg='', $task='import', $list = false, $hidemenu=true, $params);

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=urls';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'export', $url, JText::_( 'Export'), $msg='', $task='export', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // add purge and purge selected  buttons
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=urls&task=confirmpurge&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'purge', $url, JText16::_( 'COM_SH404SEF_PURGE'), $msg=JText::_('VALIDDELETEITEMS', true), $task='purge', $list = false, $hidemenu=true, $params);

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

  }


  /**
   * Create toolbar for 404 pages template
   *
   * @param midxed $params
   */
  private function _makeToolbarView404( $params = null) {

    global $mainframe;

    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // and connect to our buttons
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');

    // add title
    $title = Sh404sefHelperGeneral::makeToolbarTitle( JText16::_( 'COM_SH404SEF_404_MANAGER'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
    $mainframe->set('JComponentTitle', $title);

    // add edit button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>700, 'y' => 500);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'edit', $url, JText::_( 'Edit'), $msg='', $task='edit', $list = true, $hidemenu=true, $params);

    // add delete button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdelete404&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'delete', $url, JText::_( 'Delete'), $msg=JText::_('VALIDDELETEITEMS', true), $task='delete', $list = true, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=view404';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'export', $url, JText::_( 'Export'), $msg='', $task='export', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();
    
    // add purge and purge selected  buttons
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=urls&task=confirmpurge404&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'purge', $url, JText16::_( 'COM_SH404SEF_PURGE'), $msg=JText::_('VALIDDELETEITEMS', true), $task='purge', $list = false, $hidemenu=true, $params);

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

    // select duplicates
    $current = $options->filter_duplicate;
    $name = 'filter_duplicate';
    $selectAllTitle = JText16::_('COM_SH404SEF_ALL_DUPLICATES');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_DUPLICATES, 'title' => JText16::_('COM_SH404SEF_ONLY_DUPLICATES'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_DUPLICATES, 'title' =>JText16::_('COM_SH404SEF_ONLY_NO_DUPLICATES'))
    );
    $selects->filter_duplicate = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // select aliases
    $current = $options->filter_alias;
    $name = 'filter_alias';
    $selectAllTitle = JText16::_('COM_SH404SEF_ALL_ALIASES');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_ALIASES, 'title' => JText16::_('COM_SH404SEF_ONLY_ALIASES'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_ALIASES, 'title' =>JText16::_('COM_SH404SEF_ONLY_NO_ALIASES'))
    );
    $selects->filter_alias = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // select custom
    $current = $options->filter_url_type;
    $name = 'filter_url_type';
    $selectAllTitle = JText16::_('COM_SH404SEF_ALL_URL_TYPES');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM, 'title' => JText16::_('COM_SH404SEF_ONLY_CUSTOM'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO, 'title' => JText16::_('COM_SH404SEF_ONLY_AUTO'))
    );
    $selects->filter_url_type = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // return set of select lists
    return $selects;
  }

}