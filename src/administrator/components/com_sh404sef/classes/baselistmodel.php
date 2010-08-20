<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: baselistmodel.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


class Sh404sefClassBaselistmodel extends Sh404sefClassBasemodel {

  /**
   * Data array
   *
   * @var array
   */
  protected $_data = null;

  /**
   * Data total
   *
   * @var integer
   */
  protected $_total = null;

  /**
   * Pagination object
   *
   * @var object
   */
  protected $_pagination = null;

  /**
   * Holds current context, ie : controller/model/view/layout hierarchy
   *
   * @var string
   */
  protected $_context = null;

  /**
   * Method to get lists item data
   *
   * @access public
   * @param object holding options
   * @param boolea $returnZeroElement . If true, and the list returned is empty, a null object will be returned (as an array)
   * @return array
   */
  public function getList( $options = null, $returnZeroElement = false, $forcedLimitstart = null, $forcedLimit = null) {

    // make sure we use latest user state
    $this->_updateContextData();

    // Lets load the content if it doesn't already exist
    if (is_null($this->_data)) {

      // get pagination values, and check them
      $total = $this->getTotal($options);
      $limitstart = is_null( $forcedLimitstart) ? $this->_getState( 'limitstart') : $forcedLimitstart;
      if( !is_null( $forcedLimitstart) && $limitstart >= $total) {
        $limitstart = 0;
        $this->_setState( 'limitstart', 0);
      }
      $limit = is_null( $forcedLimit) ? $this->_getState( 'limit') : $forcedLimit;

      // build the actual query
      $query = $this->_buildListQuery( $options);
      //echo '<br />data query : '; print_r($query);echo '<br />';

      $this->_data = $this->_getList( $query, $limitstart, $limit);
      //echo $this->_db->getErrorMsg() . '<br />';
      //echo '<br />Data : '; print_r($this->_data);echo '<br />';
      //echo 'limit = ' . $this->_getState( 'limit') . ' limit start = ' . $this->_getState( 'limitstart') . '<br />';
      if ($returnZeroElement && empty( $this->_data)) {
        // create an empty record and return it
        $zeroObject = JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');
        return array( $zeroObject);
      }
    }

    return $this->_data;
  }

  /**
   * Method to get the total number of categories
   *
   * @access public
   * @return integer
   */
  public function getTotal( $options = null) {

    // make sure we use latest user state
    $this->_updateContextData();

    // Lets load the content if it doesn't already exist
    if (is_null($this->_total)) {
      $query = $this->_buildListQuery( $options);
      //echo '<br />count query : '; print_r($query);echo '<br />';
      $this->_total = $this->_getListCount( $query);
      //echo '<br />Counted : '; print_r($this->_total);echo '<br />';

    }

    return $this->_total;
  }

  /**
   * Method to get a pagination object for the lists
   *
   * @access public
   * @return integer
   */
  public function getPagination( $options = null) {

    // make sure we use latest user state
    $this->_updateContextData();

    // Lets load the content if it doesn't already exist
    if (empty($this->_pagination)) {
      // get pagination values, and check them
      $total = $this->getTotal($options);
      $limitstart = $this->_getState( 'limitstart');
      $limit = $this->_getState( 'limit');

      // create a pagination object
      jimport('joomla.html.pagination');
      $this->_pagination = new JPagination( $total, $limitstart, $limit);
    }

    return $this->_pagination;
  }

  /**
   * Gets alist of current filters and sort options which have
   * been applied when building up the data
   *
   * @return object the list ov values as object properties
   */
  public function getDisplayOptions() {

    $options = new stdClass();

    // search string applied to either sef or non sef
    $options->search_all = $this->_getState( 'search_all');
    // ordering column
    $options->filter_order = $this->_getState( 'filter_order');
    // show all/only custom/only automatic
    $options->filter_order_Dir = $this->_getState( 'filter_order_Dir');

    // return cached instance
    return $options;
  }


  protected function _buildListQuery( $options) {

    // Collect the various parts of the query
    $select = $this->_buildListSelect( $options);
    $join = $this->_buildListJoin( $options);
    $where = $this->_buildListWhere( $options);
    $orderBy = $this->_buildListOrderBy( $options);
    $groupBy = $this->_buildListGroupBy( $options);

    // complete query
    $query = $select . $join . $where . $groupBy;

    // wrap if combined queries
    $query = $this->_buildListCombinedQuery( $query, $options);

    // finally add sorting
    $query .= $orderBy;

    return $query;
  }


  protected function _buildListSelect( $options) {

    // array to hold select clause parts
    $select = array();

    // get options
    $select[] = ' select *';

    // add from  clause
    $select[] = 'from ' . $this->_getTableName();
     
    // aggregate clauses
    $select    = ( count( $select ) ? implode( ' ', $select ) : '' );

    return $select;
  }

  protected function _buildListJoin( $options) {

    // array to hold join clause parts
    $join = array();

    // aggregate clauses
    $join = ( count( $join ) ? ' ' . implode( ' ', $join ) : '' );

    return $join;

  }

  protected function _buildListWhere( $options) {

    // array to hold where clause parts
    $where = array();

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    return $where;
  }

  protected function _buildListGroupBy( $options) {

    // build query fragment
    $groupBy = '';

    return $groupBy;
  }

  protected function _buildListOrderBy( $options) {

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // build query fragment
    $orderBy  = ' order by ' . $this->_db->nameQuote( $filters->filter_order);
    $orderBy .=  ' ' . $filters->filter_order_Dir;

    return $orderBy;
  }

  protected function _buildListCombinedQuery( $query, $options) {

    return $query;
  }


  /**
   * Count rows included in query, with ability to force values
   * for limit and limit start instead of using that stored in session
   * @param $query
   * @param $forcedLimitstart
   * @param $forcedLimit
   */
  function _getListCountWithForcedLimits( $query, $forcedLimitstart = 0, $forcedLimit = 0 ) {

    $this->_db->setQuery( $query, $forcedLimitstart, $forcedLimit );
    $this->_db->query();

    return $this->_db->getNumRows();
  }

  /**
   * Provides context data definition, to be used by context handler
   * Should be overriden by descendant
   */
  protected function _getContextDataDef() {

    $application = JFactory::getApplication();

    // define context data to be retrieved. Cannot be done at class level,
    // as some default values are dynamic
    $contextData = array(

    array( 'name' => 'limit', 'html_name' => 'limit', 'default' => $application->getCfg('list_limit'), 'type' => 'int')
    , array( 'name' => 'limitstart', 'html_name' => 'limitstart', 'default' => 0, 'type' => 'int')
    // search string applied to either sef or non sef
    , array( 'name' => 'search_all', 'html_name' => 'search_all', 'default' => '', 'type' => 'string')
    // ordering column
    , array( 'name' => 'filter_order', 'html_name' => 'filter_order', 'default' => 'oldurl', 'type' => 'string')
    // ordering direction
    , array( 'name' => 'filter_order_Dir', 'html_name' => 'filter_order_Dir', 'default' => 'ASC', 'type' => 'string')

    );

    return $contextData;
  }

  /**
   * Reset model internal cached data
   * used after changing context for instance
   */
  protected function _resetData() {

    // clean data, total and pagination, as we need them rebuilt
    $this->_data = null;
    $this->_total = null;
    $this->_pagination = null;
  }

  /**
   * Read application user state stored by
   * Joomla application object for the current context
   * context represents current controller/model/view hierarchy
   * and has been set by each of those elements
   */
  protected function _updateContextData() {

    // if not been there before, or context has changed since last visit
    if (is_null($this->_context) || $this->_context != $this->getState( 'context')) {

      // read context name and store inclass variabel, easier to access later on
      $this->_context = $this->getState( 'context');

      // get an application instance
      $application = & JFactory::getApplication();

      // define context data to be retrieved. Cannot be done at class level,
      // as some default values are dynamic
      $contextData = $this->_getContextDataDef();

      // get the values from session and store them for future reuse
      foreach( $contextData as $contextDataItem) {
        // get value
        $value = $application->getUserStateFromRequest( $this->_context . '.' . $contextDataItem['name'], $contextDataItem['html_name'], $contextDataItem['default'], $contextDataItem['type'] );

        // and store
        $this->setState( $this->_context . '.' . $contextDataItem['name'], $value);
      }
    }
  }

  protected function _getOption( $name, $options, $default = null) {

    if (!is_object( $options)) {
      return $default;
    }

    $value = isset( $options->$name) ? $options->$name : $default;

    return $value;

  }

  /**
   * Short cut to get current state of value
   * @param string $key
   */
  protected function _getState( $key) {

    return $this->getState( $this->_context . '.' . $key);

  }

  /**
   * short cut to set the state of a value
   *
   * @param string $key
   * @param mixed $value
   */
  protected function _setState( $key, $value) {

    return $this->setState( $this->_context . '.' . $key, $value);

  }


  protected function _cleanForQuery( $string) {

    return $this->_db->getEscaped( JString::trim( JString::strtolower( $string )));

  }

}