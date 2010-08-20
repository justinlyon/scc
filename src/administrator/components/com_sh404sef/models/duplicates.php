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

class Sh404sefModelDuplicates extends Sh404sefClassBaselistmodel {

  protected $_defaultTable = 'urls';

  /**
   * Layout value
   *
   * @var string
   */
  private $_layout = 'default';

  /**
   * Object holding the url record
   * for which we are handling duplicates
   *
   * @var object
   */
  private $_sefUrl = null;

  /**
   * Method to get lists item data
   * Make sure we load the url data for the url
   * we are handling duplicates for
   *
   * WARNING : this is not necesarily the MAIN url
   *
   * @access public
   * @param object holding options
   * @param boolea $returnZeroElement . If true, and the list returned is empty, a null object will be returned (as an array)
   * @return array
   */
  public function getList( $options = null, $returnZeroElement = false) {

    // make sure we use latest user state
    $this->_updateContextData();

    // Lets load the content if it doesn't already exist
    if (is_null($this->_data)) {

      // do we have a cid ? if not, nothing we can do
      $sefId = intval( $this->getState( 'sefId'));
      if (!empty( $sefId)) {
        $this->_sefUrl = $this->getById( $sefId);
        if (!empty( $this->_sefUrl)) {
          $query = $this->_buildListQuery( $options);
          //echo '<br />data query : '; print_r($query);echo '<br />';
          $this->_data = $this->_getList( $query, $this->_getState( 'limitstart'), $this->_getState( 'limit'));
          //echo '<br />Data : '; print_r($this->_data);echo '<br />';
          //echo 'limit = ' . $this->_getState( 'limit') . ' limit start = ' . $this->_getState( 'limitstart') . '<br />';
        }
      }
    }

    if ($returnZeroElement && empty( $this->_data)) {
      // create an empty record and return it
      $zeroObject = JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');
      return array( $zeroObject);
    }

    return $this->_data;
  }

  /**
   * Get details of the currently registered
   * main url for which we handle duplicates
   */
  public function getMainUrl() {
    return $this->_sefUrl;
  }

  /**
   * Make the url with id = $cid the main url
   * in case of duplicates. Also set the previous
   * main url as secondary, swapping their rank
   *
   * @param integer $cid
   */
  public function makeMainUrl($cid) {

    // get this url record
    $newMain = $this->getById( $cid);
    $error = $this->getError();
    if (!empty( $error)) {
      return;
    }

    // is this already the main url ?
    if ($newMain->rank == 0) {
      return;
    }

    // now get the current main url
    $options = array( 'rank' => 0, 'oldurl' => $newMain->oldurl);
    $previousMains = $this->getByAttr( $options);

    // if we got it, do the swapping
    if (!empty( $previousMains)) {
      foreach( $previousMains as $previousMain) {
        $query = 'update ' . $this->_db->nameQuote( $this->_getTableName())
        . ' set ' . $this->_db->nameQuote('rank') . '=' . $this->_db->Quote( $newMain->rank)
        . ' where ' . $this->_db->nameQuote('id') . '=' . $this->_db->Quote( $previousMain->id);
        $this->_db->setQuery( $query);
        $this->_db->query();
        // check errors
        $error = $this->_db->getErrorNum();
        if ($error) {
          $this->setError( 'Internal database error # ' . $error);
        }

        // another thing we have to do is attach any meta data to the new
        // main url, so that they keep showing. Meta data are attached to
        // a NON-sef url, which has the benefit of keeping the attachement
        // whenever sef url creations are modified and sef urls recreated
        // but require a bit more work in that case
        $query = 'update ' . $this->_db->nameQuote( '#__sh404SEF_meta')
        . ' set ' . $this->_db->nameQuote('newurl') . '=' . $this->_db->Quote( $newMain->newurl)
        . ' where ' . $this->_db->nameQuote('newurl') . '=' . $this->_db->Quote( $previousMain->newurl);
        $this->_db->setQuery( $query);
        $this->_db->query();
        // check errors
        $error = $this->_db->getErrorNum();
        if ($error) {
          $this->setError( 'Internal database error # ' . $error);
        }
      }
    }

    // finally make it the main url
    if (!empty( $previousMains) && empty($error)) {
      $query = 'update ' . $this->_db->nameQuote( $this->_getTableName())
      . ' set ' . $this->_db->nameQuote('rank') . '=' . $this->_db->Quote( 0)
      . ' where ' . $this->_db->nameQuote('id') . '=' . $this->_db->Quote( $newMain->id);
      $this->_db->setQuery( $query);
      $this->_db->query();
      // collect error from db
      $error = $this->_db->getError();
      if (!empty( $error)) {
        $this->setError( $error);
      }
    }

  }


  /**
   * Gets alist of current filters and sort options which have
   * been applied when building up the data
   * @override
   * @return object the list ov values as object properties
   */
  public function getDisplayOptions() {

    $options = parent::getDisplayOptions();

    // get additional options vs base class

    // component used in url
    $options->filter_component = $this->_getState( 'filter_component');
    // show all/only with aliases/only w/o aliases
    $options->filter_alias = $this->_getState( 'filter_alias');
    // show all/only custom/only automatic
    $options->filter_url_type = $this->_getState( 'filter_url_type');
    // show all/only one language
    $options->filter_language = $this->_getState( 'filter_language');

    // return cached instance
    return $options;
  }

  protected function _buildListSelect( $options) {

    // array to hold select clause parts
    $select = array();

    // get the layout option from params
    $layout = $this->_getOption( 'layout', $options);
    switch ($layout) {
      default:
        $select[] = ' select u1.*, pg.pageid as pageid, count(a.`alias`) as aliases';
        break;
    }

    // add from  clause
    $select[] = 'from ' . $this->_getTableName() . ' as u1';
     
    // aggregate clauses
    $select    = ( count( $select ) ? implode( ' ', $select ) : '' );

    return $select;
  }

  protected function _buildListJoin( $options) {

    // array to hold join clause parts
    $join = array();

    // count aliases
    $join[] = 'left join ' . $this->_db->nameQuote( '#__sh404sef_aliases') . ' as a';
    $join[] = 'on a.' . $this->_db->nameQuote('newurl') . ' = u1.' . $this->_db->nameQuote('newurl');
    
    // get page ids
    $join[] = 'left join ' . $this->_db->nameQuote( '#__sh404sef_pageids') . ' as pg';
    $join[] = 'on pg.' . $this->_db->nameQuote('newurl') . ' = u1.' . $this->_db->nameQuote('newurl');

    // aggregate clauses
    $join = ( count( $join ) ? ' ' . implode( ' ', $join ) : '' );

    return $join;

  }

  protected function _buildListWhere( $options) {

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // array to hold where clause parts
    $where = array();

    // get the layout options from param
    $layout = $this->_getOption( 'layout', $options);

    // various cases of layouts
    switch ($layout) {
      default:
        if (!empty( $this->_sefUrl->oldurl)) {
          $where[] = 'u1.' . $this->_db->nameQuote('oldurl') . ' = '
          . $this->_db->Quote( $this->_sefUrl->oldurl);
        }
        break;
    }

    // add search all urls term if any
    if ( !empty($filters->search_all) ) {  // V 1.2.4.q added search URL feature
      jimport( 'joomla.utilities.string');
      $searchTerm = $this->_cleanForQuery( JString::strtolower($filters->search_all));
      $where[] = "LOWER(u1.newurl)  LIKE '%" . $searchTerm  . "%'";
    }

    // components check
    if (!empty( $filters->filter_component)) {
      $where[] = "LOWER(u1.newurl)  LIKE '%option=" . $this->_cleanForQuery( $filters->filter_component ) . "%'";
    }

    // language check
    if (!empty( $filters->filter_language)) {
      $where[] = "LOWER(u1.newurl)  LIKE '%lang=" . $this->_cleanForQuery( $filters->filter_language ) . "%'";
    }

    // custom or automatic ?
    if (!empty( $filters->filter_url_type)) {
      switch ($filters->filter_url_type) {
        case Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM:
          $where[] = 'u1.dateadd <> ' . $this->_db->Quote( '0000-00-00');
          break;
        case Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO:
          $where[] = 'u1.dateadd = ' . $this->_db->Quote( '0000-00-00');
          break;
      }
    }

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    return $where;
  }

  protected function _buildListGroupBy( $options) {

    // build query fragment
    $groupBy = ' group by u1.' . $this->_db->nameQuote( 'newurl');

    return $groupBy;
  }

  protected function _buildListOrderBy( $options) {

    $orderBy = parent::_buildListOrderBy( $options);

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // always add a secondary sort by SEF urls, unless it is already the primary
    if ($filters->filter_order != 'oldurl') {
      // build query fragment
      $orderBy .= ', ' . $this->_db->nameQuote( 'oldurl');
    }

    return $orderBy;
  }

  protected function _getTableName() {

    return '#__redirection';

  }

  /**
   * Provides context data definition, to be used by context handler
   * Should be overriden by descendant
   */
  protected function _getContextDataDef() {

    $contextData = parent::_getContextDataDef();

    // define context data to be retrieved. Cannot be done at class level,
    // as some default values are dynamic
    $addedContextData = array(

    // redefined default sort order
    array( 'name' => 'filter_order', 'html_name' => 'filter_order', 'default' => 'rank', 'type' => 'string')

    // component used in url
    , array( 'name' => 'filter_component', 'html_name' => 'filter_component', 'default' => '', 'type' => 'string')
    // show all/only with aliases/only w/o aliases
    , array( 'name' => 'filter_alias', 'html_name' => 'filter_alias', 'default' => 0, 'type' => 'int')
    // show all/only custom/only automatic
    , array( 'name' => 'filter_url_type', 'html_name' => 'filter_url_type', 'default' => 0, 'type' => 'int')
    // show all/only one language
    , array( 'name' => 'filter_language', 'html_name' => 'filter_language', 'default' => '', 'type' => 'string')

    );

    return array_merge( $contextData, $addedContextData);
  }

}