<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: urls.php 1440 2010-05-27 18:37:42Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelUrls extends Sh404sefClassBaselistmodel {

  /**
   * Layout value
   *
   * @var string
   */
  private $_layout = 'default';


  /**
   * Purge urls from database (and cache)
   * either all automatic, or according to current
   * sef url list page select options as stored in
   * in session
   * @param unknown_type $type
   */
  public function purge( $type = 'auto') {

    // make sure we use latest user state
    $this->_updateContextData();

    // call the appropriate sub-method to get the db query
    $methodName = '_getPurgeQuery' . ucfirst($type);
    if (is_callable( array( $this, $methodName))) {
      $deleteQuery = $this->$methodName();
    } else {
      $this->setError( 'Invalid method call _purge' . $type);
      return;
    }

    // then run the query
    $this->_db->setQuery( $deleteQuery);
    $this->_db->query();

    // delete from cache : we delete the whole cache anyway, except for 404 pages
    // which are not in the cache
    if ($type != '404') {
      $this->deleteCache();
    }

    // set error
    $error = $this->_db->getErrorNum();
    if (!empty($error)) {
      $this->setError( 'Internal database error # ' . $error);
    }

  }

  public function getUrlsCount( $which = 'auto') {

    switch (strtolower( $which)) {

      // we want to read all automatic urls (include duplicates)
      case 'auto':
        $query = 'select count(*) from ' . $this->_db->nameQuote( $this->_getTableName())
        . ' where ' . $this->_db->nameQuote( 'dateadd') . '=' . $this->_db->Quote( '0000-00-00');
        $this->_db->setQuery( $query);
        $numberOfUrls = $this->_db->loadResult();
        break;

        // we want to read urls as per current selection input fields
        // ie : component, language, custom, ...
      case 'selected':
        $numberOfUrls = $this->getTotal();
        break;

      case '404':
        $query = 'select count(*) from ' . $this->_db->nameQuote( $this->_getTableName())
        . ' where ' . $this->_db->nameQuote( 'dateadd') . '!=' . $this->_db->Quote( '0000-00-00')
        . ' and ' . $this->_db->nameQuote( 'newurl') . '=' . $this->_db->Quote( '');
        $this->_db->setQuery( $query);
        $numberOfUrls = $this->_db->loadResult();
        break;

      default:
        $numberOfUrls = 0;
        break;
    }

    return intval( $numberOfUrls);
  }

  /**
   * Delete the url disk cache
   *
   */
  public function deleteCache() {
    // delete from cache : we delete the whole cache anyway, except for 404 pages
    // which are not in the cache
    jimport('joomla.filesystem.file');
    if (JFile::exists( JPATH_ROOT.'/components/com_sh404sef/cache/shCacheContent.php')) {
      JFile::delete( JPATH_ROOT.'/components/com_sh404sef/cache/shCacheContent.php');
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

    // search string applied to pageid
    $options->search_pageid = $this->_getState( 'search_pageid');
    // component used in url
    $options->filter_component = $this->_getState( 'filter_component');
    // show all/only with duplicates/only w/o duplicates
    $options->filter_duplicate = $this->_getState( 'filter_duplicate');
    // show all/only with aliases/only w/o aliases
    $options->filter_alias = $this->_getState( 'filter_alias');
    // show all/only custom/only automatic
    $options->filter_url_type = $this->_getState( 'filter_url_type');
    // show all/only one language
    $options->filter_language = $this->_getState( 'filter_language');

    // record has a title
    $options->filter_title = $this->_getState( 'filter_title');
    // record has a description
    $options->filter_desc = $this->_getState( 'filter_desc');

    // return cached instance
    return $options;
  }

  protected function _buildListSelect( $options) {

    // array to hold select clause parts
    $select = array();

    // get the layout option from params
    $layout = $this->_getOption( 'layout', $options);
    $getMetaData = $this->_getOption( 'getMetaData', $options, false);

    switch ($layout) {
      case 'export' :
        $s = ' select distinct u1.*';
        $s .= $getMetaData ? ', m.id as metaid, m.metatitle as metatitle, m.metadesc as metadesc, m.metakey as metakey, m.metalang as metalang, m.metarobots as metarobots' : '';
        $select[] = $s;
        break;
      case 'view404':
      default:
        $s = ' select distinct u1.*, count(d.`id`)-1 as duplicates, count(m.`id`) as metas';
        $s .= $getMetaData ? ', m.id as metaid, m.metatitle as metatitle, m.metadesc as metadesc, m.metakey as metakey, m.metalang as metalang, m.metarobots as metarobots' : '';
        $select[] = $s;
        break;
    }

    // add from  clause
    $select[] = 'from ' . $this->_getTableName() . ' as d, '. $this->_getTableName() . ' as u1 ';
     
    // aggregate clauses
    $select    = ( count( $select ) ? implode( ' ', $select ) : '' );

    return $select;
  }

  protected function _buildListJoin( $options) {

    // array to hold join clause parts
    $join = array();

    $join[] = 'left join ' . $this->_db->nameQuote('#__sh404SEF_meta') . ' as m on m.newurl=u1.newurl';

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
      case 'view404':
        $where[] = 'u1.newurl = ""';
        break;
      default:
        $where[] = 'u1.newurl <> ""';
        break;
    }

    // required to count correctly duplicates if any
    $where[] = 'd.oldurl=u1.oldurl';

    //we only show the main url, not its duplicates, except when exporting
    switch ($layout) {
      case 'export':
        break;
      default:
        $where[] = 'u1.rank = 0';
        break;
    }


    // add search all urls term if any
    if ( !empty($filters->search_all) ) {  // V 1.2.4.q added search URL feature
      jimport( 'joomla.utilities.string');
      $searchTerm = $this->_cleanForQuery( JString::strtolower($filters->search_all));
      $where[] = " (LOWER(u1.oldurl)  LIKE '%" . $searchTerm  . "%' OR "
      . "LOWER(u1.newurl)  LIKE '%" . $searchTerm  . "%')";
    }

    // components check
    if (!empty( $filters->filter_component)) {
      $where[] = "LOWER(u1.newurl)  LIKE '%option=" . $this->_cleanForQuery( $filters->filter_component ) . "%'";
    }

    // language check
    if (!empty( $filters->filter_language)) {
      $where[] = "LOWER(u1.newurl)  LIKE '%lang=" . $this->_cleanForQuery( $filters->filter_language ) . "%'";
    }

    // only those with some meta data
    // get the option from param
    $onlyWithMetaData = $this->_getOption( 'onlyWithMetaData', $options);
    if (!empty( $onlyWithMetaData)) {
      $where[] = '('
      . 'm.metatitle <> ' . $this->_db->Quote( '')
      . ' or m.metadesc <> ' . $this->_db->Quote( '')
      . ' or m.metakey <> ' . $this->_db->Quote( '')
      . ' or m.metalang <> ' . $this->_db->Quote( '')
      . ' or m.metarobots <> ' . $this->_db->Quote( '')
      . ')';
    }

    // meta-title check
    if (!empty( $filters->filter_title)) {
      switch ($filters->filter_title) {
        case Sh404sefHelperGeneral::COM_SH404SEF_ONLY_TITLE:
          $where[] = 'm.metatitle <> ' . $this->_db->Quote( '');
          break;
        case Sh404sefHelperGeneral::COM_SH404SEF_NO_TITLE:
          $where[] = '(m.metatitle is null or m.metatitle = ' . $this->_db->Quote( '') . ')';
          break;
      }
    }

    // meta-description check
    if (!empty( $filters->filter_desc)) {
      switch ($filters->filter_desc) {
        case Sh404sefHelperGeneral::COM_SH404SEF_ONLY_DESC:
          $where[] = 'm.metadesc <> ' . $this->_db->Quote( '');
          break;
        case Sh404sefHelperGeneral::COM_SH404SEF_NO_DESC:
          $where[] = '(m.metadesc is null or m.metadesc = ' . $this->_db->Quote( '') . ')';
          break;
      }
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

    // get the layout options from param
    $layout = $this->_getOption( 'layout', $options);

    // various cases of layouts
    switch ($layout) {
      case 'export':
        $groupBy = '';
        return;
      default:
        // build query fragment
        $groupBy = ' group by u1.' . $this->_db->nameQuote( 'id');
        break;
    }

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


  protected function _buildListCombinedQuery( $query, $options) {

    // get the layout options from param
    $layout = $this->_getOption( 'layout', $options);

    // various cases of layouts
    switch ($layout) {
      case 'export':
      case 'view404':
        return $query;
        break;
    }

    // make the first combination
    $baseQuery  = 'select u.*, pg.pageid as pageid, pg.id as pageidid, pg.type as pageidtype, pg.hits as pageidhits, count(a.alias) as aliases from (' . $query . ') as u';
    $baseQuery .= ' left join `#__sh404sef_aliases` as a on a.newurl = u.newurl';
    $baseQuery .= ' left join `#__sh404sef_pageids` as pg on pg.newurl = u.newurl';
    $baseQuery .= ' group by u.newurl';

    // then add another layer of subqueries if there are some
    // view filters (like show only duplicates, or show only with aliases
    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // array to hold where clause parts
    $where = array();

    // add pageId search
    if ( !empty($filters->search_pageid) ) {  // V 1.2.4.q added search URL feature
      $searchId = $this->_cleanForQuery( $filters->search_pageid);
      $where[] = '(LOWER(pageid)  LIKE \'%' . $searchId  . '%\' AND pageidtype=' . $this->_db->Quote(Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID) . ')';
    }

    // with or without duplicates ?
    if (!empty( $filters->filter_duplicate)) {
      switch ($filters->filter_duplicate) {
        case Sh404sefHelperGeneral::COM_SH404SEF_ONLY_DUPLICATES:
          $where[] = 'duplicates > 0';
          break;
        case Sh404sefHelperGeneral::COM_SH404SEF_NO_DUPLICATES:
          $where[] = 'duplicates = 0';
          break;
      }
    }

    // with or without aliases
    if (!empty( $filters->filter_alias)) {
      switch ($filters->filter_alias) {
        case Sh404sefHelperGeneral::COM_SH404SEF_ONLY_ALIASES:
          $where[] = 'aliases > 0';
          break;
        case Sh404sefHelperGeneral::COM_SH404SEF_NO_ALIASES:
          $where[] = 'aliases = 0';
          break;
      }
    }

    // do we require a pageid ?
    $getPageId = $this->_getOption( 'getPageId', $options, false);
    if ($getPageId) {
      $where[] = 'pageid <> \'\'';
    }

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    // combine queries
    $finalQuery = $baseQuery;
    if (!empty( $where)) {
      $finalQuery = 'select combine2.* from (' . $baseQuery . ') as combine2 ' . $where;
    }

    return $finalQuery;
  }

  /**
   * Delete all automatically generated url records
   * from database and cache
   */
  private function _getPurgeQueryAuto() {

    // delete from database
    $query = 'delete from ' . $this->_db->nameQuote( $this->_getTableName())
    . ' where ' . $this->_db->nameQuote( 'dateadd') . '=' . $this->_db->Quote( '0000-00-00');

    return $query;
  }

  private function _getPurgeQuerySelected() {

    // start delete query
    $query = 'delete from ' . $this->_db->nameQuote( $this->_getTableName());

    // call method to build where clause in accordance to current settings and user selection
    $where = $this->_buildListWhere( (object) array( 'layout' => 'default'));

    // remove a bit that's only used when selecting aliases and duplicates together
    // with the main data. As we are deleting, we don't care about the actuall data
    $where = str_replace( ' AND d.oldurl=u1.oldurl', '', $where);

    // also remove possible rank limitations. This means that
    // dplicates will also go away with their parent.
    // Need a big warning!
    $where = str_replace( ' AND u1.rank = 0', '', $where);

    // finally remove any u1. left
    $where = str_replace( 'u1.', '', $where);

    // stitch where clause
    $query = $query . $where;

    return $query;
  }

  /**
   * Delete all records of 404 pages requests
   *
   */
  private function _getPurgeQuery404() {

    // delete from database
    $query = 'delete from ' . $this->_db->nameQuote( $this->_getTableName())
    . ' where ' . $this->_db->nameQuote( 'dateadd') . '!=' . $this->_db->Quote( '0000-00-00')
    . ' and '. $this->_db->nameQuote( 'newurl') . '=' . $this->_db->Quote( '');

    return $query;
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

    // search string applied to either sef or non sef
    array( 'name' => 'search_pageid', 'html_name' => 'search_pageid', 'default' => '', 'type' => 'string')
    // component used in url
    , array( 'name' => 'filter_component', 'html_name' => 'filter_component', 'default' => '', 'type' => 'string')
    // show all/only with duplicates/only w/o duplicates
    , array( 'name' => 'filter_duplicate', 'html_name' => 'filter_duplicate', 'default' => 0, 'type' => 'int')
    // show all/only with aliases/only w/o aliases
    , array( 'name' => 'filter_alias', 'html_name' => 'filter_alias', 'default' => 0, 'type' => 'int')
    // show all/only custom/only automatic
    , array( 'name' => 'filter_url_type', 'html_name' => 'filter_url_type', 'default' => 0, 'type' => 'int')
    // show all/only one language
    , array( 'name' => 'filter_language', 'html_name' => 'filter_language', 'default' => '', 'type' => 'string')

    // show all/only with duplicates/only w/o duplicates
    , array( 'name' => 'filter_title', 'html_name' => 'filter_title', 'default' => 0, 'type' => 'int')
    // show all/only with aliases/only w/o aliases
    , array( 'name' => 'filter_desc', 'html_name' => 'filter_desc', 'default' => 0, 'type' => 'int')

    );

    return array_merge( $contextData, $addedContextData);
  }

}