<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: pageids.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelPageids extends Sh404sefClassBaselistModel {

  protected $_context = 'sh404sef.pageids';
  protected $_defaultTable = 'pageids';

  protected static $_mustCreate = false;

  /**
   * Returns true if current sef url being created can have a pageId
   * Can be set from within a plugin, otherwise default to false
   * Reset to false upon each creation of a new sef url in shInitializePlugin()
   *
   * @param unknown_type $action
   * @param unknown_type $value
   * @return unknown
   */
  public function mustCreatePageId( $action = 'get', $value = false) {

    if ($action == 'set') {
      self::$_mustCreate = (boolean) $value;
    }

    return self::$_mustCreate;
  }

  public function createPageId( $sefUrl, $nonSefUrl) {

    if (!$this->_mustCreatePageid( $nonSefUrl)) {
      return;
    }

    $sefUrl = ltrim( $sefUrl, '/');
    $nonSefForDB = addslashes(urldecode($nonSefUrl));

    // check that we don't already have a pageId for the same SEF url, even if non-sef differ
    $query = 'SELECT count(id) FROM #__redirection where oldurl=\''.$sefUrl.'\' AND newurl <> \'\';';
    $this->_db->setQuery($query);
    $result = (int) $this->_db->loadResult();
    if (!empty($result) && $result > 1) {
      // we already have a SEF URL, so we must already have a pageId as well
      return;
    }

    // check this nonsef url does not already have a pageId
    $query = "SELECT pageid FROM #__sh404sef_pageids WHERE newurl = '".$nonSefForDB."'";
    $this->_db->setQuery($query);
    $existingPageId = $this->_db->loadResult();
    // we have a valid pageId, write it to DB
    if (!empty( $existingPageId)) {
      return;
    }

    // if we don't already have a pageId, create the new one
    $pageId = $this->_buildPageId();
    if (!empty( $pageId)) {

      // insert in db
      $query = 'insert into #__sh404sef_pageids (newurl, pageid, type, hits) values ('
      . $this->_db->Quote($nonSefForDB)
      . ','
      . $this->_db->Quote($pageId)
      . ','
      . $this->_db->Quote(Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID)
      . ','
      . $this->_db->Quote(0)
      . ')';
      $this->_db->setQuery( $query);
      $this->_db->query();
    }

    // don't need to add the pageid to cache, won't be needed when building up the page,
    //only when decoding incoming url
  }

  /**
   * Count pageids records
   * either all of them or the currently selected set
   * as per user filter settings in meta manager
   *
   * @param string $type either 'all' or 'selected'
   */
  public function getPageIdsCount( $type) {

    switch (strtolower( $type)) {

      // we want to read all automatic urls (include duplicates)
      case 'all':
        $query = 'select count(*) from ' . $this->_db->nameQuote( $this->_getTableName());
        $this->_db->setQuery( $query);
        $numberOfPageids = $this->_db->loadResult();
        break;

        // we want to read urls as per current selection input fields
        // ie : component, language, custom, ...
      case 'selected':
        // get model and update context with current
        $model = &JModel::getInstance( 'urls', 'Sh404sefModel');

        // use current filters for default layout of metas manager
        $context = $model->setContext( $this->_context . '.' . 'default');

        // read url data from model
        $list = &$model->getList( (object) array('layout' => 'default', 'getPageId' => true));

        $numberOfPageids = 0;
        // just count urls with some pageids
        if (!empty($list)) {
          foreach ($list as $urlRecord) {
            if (!empty( $urlRecord->pageid)) {
              $numberOfPageids++;
            }
          }
        }
        break;

      default:
        $numberOfPageids = 0;
        break;
    }

    return intval( $numberOfPageids);
  }

  /**
   * Delete a list of pagesids from their ids,
   * passed as params
   *
   * @param array of integer $ids the list of pageId id to delete
   */
  public function deleteByIds( $ids = array()) {

    if (empty($ids)) {
      return;
    }

    // build a list of ids to read
    $where = array();
    foreach( $ids as $id) {
      $where[] = $this->_db->Quote( intval($id));
    }
    $whereIds = implode( ',', $where);

    // perform deletion
    $query  = 'delete from ' . $this->_db->nameQuote( $this->_getTableName());
    $query .= ' where ' . $this->_db->nameQuote( 'id') . ' in (' . $whereIds . ')';

    // perform query
    $this->_db->setQuery( $query);
    $this->_db->query();

    // check errors
    $error = $this->_db->getErrorNum();
    if ($error) {
      $this->setError( 'Internal database error # ' . $error);
    }

  }

  /**
   * Purge pageId records from the database
   * either all of them or the currently selected set
   * as per user filter settings in meta manager
   *
   * @param string $type either 'all' or 'selected'
   */
  public function purgePageids( $type) {

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
    if (!empty( $deleteQuery)) {
      $this->_db->setQuery( $deleteQuery);
      $this->_db->query();
      // set error
      $error = $this->_db->getErrorNum();
      if (!empty($error)) {
        $this->setError( 'Internal database error # ' . $error . ' ' . $deleteQuery);
      }
    } else {
      $this->setError( JText16::_('COM_SH404SEF_NORECORDS'));
    }

  }

  /**
   * Delete all automatically generated url records
   * from database and cache
   */
  private function _getPurgeQueryAll() {

    // delete from database
    $query = 'truncate ' . $this->_db->nameQuote( $this->_getTableName());

    return $query;
  }

  private function _getPurgeQuerySelected() {

    // get model and update context with current
    $model = &JModel::getInstance( 'urls', 'Sh404sefModel');

    // use current filters for default layout of pageIds manager
    $context = $model->updateContext( $this->_context . '.' . 'default');

    // read url data from model
    $list = &$model->getList( (object) array('layout' => 'default', 'getPageId' => true));

    $pageIds = array();
    // store meta data records ids for urls with some metat data
    if (!empty($list)) {
      foreach ($list as $urlRecord) {
        $pageIds[] = $this->_db->Quote($urlRecord->pageid);
      }
    }

    // if no urls with pageId data, return empty query
    if (empty( $pageIds)) {
      return '';
    }

    // start delete query
    $query = 'delete from ' . $this->_db->nameQuote( $this->_getTableName());

    // call method to build where clause in accordance to current settings and user selection
    $where = implode( ', ', $pageIds);

    // stitch where clause
    $query = $query . ' where pageid in (' . $where . ')';

    return $query;
  }


  protected function _buildListWhere( $options) {

    // array to hold where clause parts
    $where = array();

    // are we reading pageids for one specific url ?
    $newurl = $this->_getOption( 'newurl', $options);
    if (!is_null( $newurl)) {
      $where[] = 'newurl = ' . $this->_db->Quote( $newurl);
      $where[] = 'type = ' . $this->_db->Quote( Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID);
    }

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    return $where;
  }

  protected function _buildListOrderBy( $options) {

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // build query fragment
    $orderBy  = ' order by ' . $this->_db->nameQuote( 'newurl');
    $orderBy .=  ' ' . $filters->filter_order_Dir;

    return $orderBy;
  }
  protected function _getTableName() {

    return '#__sh404sef_pageids';

  }

  private function _buildPageId() {

    $pageId = '';

    $nextId = $this->_getNextDBId( '#__sh404sef_pageids');
    if ($nextId !== false) {
      // get pattern
      $pattern = $this->_getPageIdPattern();

      // convert to desired base
      $targetBase = 18;
      $nextId = base_convert( 18+$nextId, 10, $targetBase);

      // insert next id in it
      $pageId = sprintf( $pattern, $nextId);
    }

    return strtolower( $pageId);
  }

  private function _getPageIdPattern( $p = '') {
    static $next = null;
    static $initial = 'abcdgkpqrsuwxyz';

    if (is_null( $next)) {
      $next = rand( 0, strlen( $initial));
    }

    $pattern = empty( $p) || (strpos( $p, '%s') === false) ? (substr( $initial, $next, 1) . '%s' ) : $p;

    // increment initial
    $next++;
    if ($next > strlen( $initial)-1) {
      $next = 0;
    }

    return $pattern;
  }


  private function _getNextDBId( $table) {
    if (empty( $table)) {
      return false;
    }
    $this->_db = & JFactory::getDBO();
    // need to force replace prefix
    $table = $this->_db->replacePrefix(  $table);
    $query = 'show table status like \'' . $table . '\';';
    $this->_db->setQuery( $query);
    $this->_db->query();
    $status = $this->_db->loadAssoc();
    if (empty( $status) || empty( $status['Auto_increment'])) {
      return false;
    } else {
      return (int) $status['Auto_increment'];
    }
  }

  private function _mustCreatePageid( $nonSefUrl) {

    // currently disabled by sef url plugin
    if (!self::$_mustCreate) {
      return false;
    }

    // if enabled at sef url plugin level, check configuration
    $sefConfig = &shRouter::shGetConfig();

    // check global flag
    if (!$sefConfig->enablePageId) {
      return false;
    }

    // last check at component level
    $option = shGetURLVar( $nonSefUrl, 'option');
    $option = str_replace( 'com_', '', $option);
    $enable = !empty( $option) && in_array( $option, $sefConfig->compEnablePageId);

    return $enable;
  }

}