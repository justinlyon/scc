<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: editalias.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelEditalias extends Sh404sefClassBaseeditmodel {

  protected $_context = 'sh404sef.editalias';
  protected $_defaultTable = 'aliases';

  protected $_alias = null;

  /**
   * Create or update a record to
   * DB from POST data
   *
   * Overriden from base model
   * to also save metas and aliases
   *
   * @param array $dataArray an array holding data to save. If empty, $_POST is used
   * @return integer id of created or updated record
   */
  public function save( $dataArray = null) {

    // use parent save method to save the url itself, from default values
    $this->_data = is_null( $dataArray) ? JRequest::get('post') : $dataArray;

    // save the non-sef/sef pair data
    $savedId = $this->_save();

    // return savedId of the url, will have
    // been set to 0 if something wrong happened
    // while saving either url, meta data or aliase
    return $savedId;
  }

  /**
   * Get a list of aliases from their ids,
   * passed as params
   *
   * @param array of integer $ids the list of aliases id to fetch
   * @return array of objects as read from db
   */
  public function getByIds( $ids = array()) {

    $aliases = array();

    if (empty($ids)) {
      return $aliases;
    }

    // select element where id is in list supplied
    $query = 'select * from ' . $this->_db->nameQuote( $this->_getTableName());
    $where[] = array();
    foreach( $ids as $id) {
      $where[] = $this->_db->Quote( intval($id));
    }
    $where = implode( ',', $ids);

    // aggregate query
    $query .= ' where ' . $this->_db->nameQuote( 'id') . ' in (' . $where . ')';

    // perform query
    $this->_db->setQuery( $query);
    $aliases = $this->_db->loadObjectList();

    // return result
    return $aliases;
  }

  /**
   * Delete a list of aliases from their ids,
   * passed as params
   *
   * @param array of integer $ids the list of aliases id to delete
   * @return boolean true if success
   */
  public function deleteByIds( $ids = array()) {

    $aliases = array();

    if (empty($ids)) {
      return $aliases;
    }

    // build a list of ids to read
    $where = array();
    foreach( $ids as $id) {
      $where[] = $this->_db->Quote( intval($id));
    }
    $whereIds = implode( ',', $where);

    // we can simply delete from db by ids
    $query = 'delete from ' . $this->_db->nameQuote( $this->_getTableName()) . ' where ' . $this->_db->nameQuote( 'id') . ' in (' . $whereIds . ')';
    $this->_db->setQuery( $query);
    $this->_db->query();

    // check errors
    $error = $this->_db->getErrorNum();
    if ($error) {
      $this->setError( 'Internal database error # ' . $error);
    }

  }

  /**
   * Save an alias to the database
   *
   * @param integer $type force url type, used when saving a custom url
   */
  private function _save( $type = Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS) {

    // check for bad data
    if (empty( $this->_data['newurl'])) {
      return 0;
    }

    // get required tools
    jimport( 'joomla.database.table');
    $row = & JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');

    // let table save record
    $row->save( $this->_data['newurl']);

    // collect errors
    $error = $row->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // return what should be a non-zero id
    return $row->id;

  }

  /**
   * Returns the default full table name on
   * which this model operates
   */
  protected function _getTableName() {

    return '#__sh404sef_aliases';

  }

}