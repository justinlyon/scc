<?php

/**
 * $Id: epDbPeardb.php 838 2006-03-11 04:42:09Z nauhygon $
 * 
 * Copyright(c) 2005 by Oak Nauhygon. All rights reserved.
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2006-03-10 23:42:09 -0500 (Fri, 10 Mar 2006) $
 * @package ezpdo
 * @subpackage ezpdo.db
 */

/**
 * need epOverload
 */
include_once(EP_SRC_DB.'/epDb.php');

/**
 * Exception class for {@link epDbPeardb}
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2006-03-10 23:42:09 -0500 (Fri, 10 Mar 2006) $
 * @package ezpdo
 * @subpackage ezpdo.base 
 */
class epExceptionDbPeardb extends epExceptionDb {
}

/**
 * A wrapper class for the PEAR DB. See 
 * {@link http://pear.php.net/manual/en/package.database.db.php}.
 * 
 * The class implements the abstract methods defined in the
 * superclass, {@link epDb}. 
 * 
 * One note about the method, {@link lastInsertId()}. We have to implement 
 * something equivalent to Insert_ID() in ADODB. Unlike ADODB, 
 * PEAR DB does not have an intrinsic method like it that's tied 
 * to the auto-incremental col of a row. Although the PEAR DB has 
 * the sequence methods, createSequence(), nextId(), dropSequence(), 
 * it does not provide a natural way to bind the sequence to the 
 * auto-incremental column. 
 * 
 * The implementation of {@link lastInsertId()} might not be optimal 
 * because every time the method is called we do a "SELECT MAX(oid) 
 * FROM table" query to figure out the max oid in table, which may 
 * introduce undesired overhead. 
 * 
 * Our tests have shown that using PEAR DB for ezpdo is slower than
 * ADODB with the current implementation. We will do some investigation
 * to see how to improve the performance for both DB libs. 
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2006-03-10 23:42:09 -0500 (Fri, 10 Mar 2006) $
 * @package ezpdo
 * @subpackage ezpdo.db
 */
class epDbPeardb extends epDb {
    
    /**
     * Array of tables exist
     */
    protected $tables_exist = array();
    
    /**
     * The last record set
     * @var mixed
     */
    protected $last_rs = false;
    
    /**
     * The last row fetched in record set
     * @var record
     */
    protected $last_row = false;
    
    /**
     * Constructor
     * @param string $dsn the DSN to access the database
     * @param bool $is_persistent whether connection is persistent or not
     * @param string $fetch_mode the fetch mode
     * @throws epExceptionOverload
     */
    public function __construct($dsn) {
        parent::__construct($dsn);
    }
    
    /**
     * Establishes a DB connection
     * @access public
     * @return bool
     */
    public function open() {
        
        // check if connected already
        if ($this->db) {
            return true;
        }
        
        // make db connection
        include_once('DB.php');
        $this->db = & DB::connect($this->dsn);
        if (PEAR::isError($this->db)) {
            throw new epExceptionDbPeardb('Cannot connect db (error: ' . $this->db->getMessage() . ')');
            return false;
        }
        
        // default to auto commit
        $this->db->autoCommit(true);

        return true;
    }

    /**
     * Implements {@link epDb::_beginTransaction()}
     * @return bool
     */
    public function _beginTransaction() {
        
        // open connection if not already 
        if (!$this->open()) {
            return false;
        }

        // call peardb to start a transaction
        return $this->db->autoCommit(false);
    }

    /**
     * Implements {@link epDb::_commit()}
     * @return bool
     */
    public function _commit() {

        // call peardb to commit
        $status = $this->db->commit(); 
        
        // revert to auto commit
        $this->db->autoCommit(true);
        
        return $status;
    }

    /**
     * Implements {@link epDb::_rollback()}
     * @return bool
     */
    public function _rollback() {

        // call peardb to roll back
        $status = $this->db->rollback();
        
        // revert to auto commit
        $this->db->autoCommit(true);
        
        return $status;
    }

    /**
     * Executes SQL command
     * @param string query string
     * @access public
     * @return mixed
     */
    protected function _execute($query) {
        
        // check if connection okay
        if (!$this->open()) {
            return false;
        }

        // execute query
        $this->last_rs = $this->db->query($query);
        
        // check if any error
        if (DB::isError($this->last_rs)) {
            throw new epExceptionDbPeardb($this->last_rs->getMessage() . ", query: $query" );
            return false;
        }
        
        return $this->last_rs;
    }

    /**
     * Closes the DB connection
     * @return void
     */
    public function close() {
        if ($this->db instanceof DB) {
            $this->db->disconnect();
        }
    }
    
    /**
     * Check if a table exists
     * @param string $table
     * @return bool
     */
    public function tableExists($table) {
        
        if (!$table) {
            return false;
        }
        
        // check db connection
        if (!$this->db) {
            if (!$this->open()) {
                return false;
            }
        }
        
        // test if table exists 
        try {
            // execute a select statement on the table 
            $rs = $this->db->query('SELECT COUNT(*) FROM ' . $this->quoteId($table) . ' WHERE 1=1'); 
        }
        catch (Exception $e) {
            // table does not exist if exception 
            return false;
        }

        // fix: rs can also be DB Error
        if (PEAR::isError($rs)) {
            return false;
        }

        // cache to tables_exist if exists
        $this->tables_exist[] = $table;

        return true;
    }
    
    /**
     * Override {@link epDb::lastInsertId()}
     * Returns the last insert id
     * @param string $oid the oid column
     * @return integer
     * @access public
     */
    public function lastInsertId($table, $oid = 'oid') {
        // return the last insert id
        return $this->_getMaxId($table, $oid);
    }

    /**
     * Returns the number of records in last result set
     * @return integer
     */
    public function rsRows() {
        
        if (!$this->last_rs) {
            return 0;
        }
        
        return $this->last_rs->numRows();
    }
    
    /**
     * Rewinds to the first row in the last result
     * @return null|mixed
     */
    public function rsRestart() {
        
        if (!$this->last_rs) {
            return false;
        }
        
        return $this->last_rs->fetchInto($this->last_row, DB_FETCHMODE_ASSOC, 0);
    }
    
    /**
     * Moves to the next row in the last result set
     * @return null|mixed
     */
    public function rsNext() {
        
        if (!$this->last_rs) {
            return false;
        }
        
        return $this->last_rs->fetchInto($this->last_row, DB_FETCHMODE_ASSOC);
    }
    
    /**
     * Get the value for a column in the current row in the last result set
     * @param string the name of the column 
     * @return false|mixed
     */
    public function rsGetCol($col, $col_alt = false) {
        
        if (!$this->last_rs || !$this->last_row) {
            throw new epExceptionDbPeardb('No last query result found');
            return false;
        }
        
        // try $col first
        if (array_key_exists($col, $this->last_row)) {
            return $this->last_row[$col];
        } 
        
        // try alternative
        if ($col_alt && array_key_exists($col_alt, $this->last_row)) {
            return $this->last_row[$col_alt];
        }
        
        // last resort: partial match
        foreach($this->last_row as $col_ => $value) {
            $pieces = explode('.', $col_);
            $field = (count($pieces) == 1) ? $pieces[0] : $pieces[1];
            $field = strtolower($field);
            if ($field == strtolower($col) || $field == strtolower($col_alt)) {
                return $value;
            }
        }
        
        throw new epExceptionDbPeardb('Column [' . $col . '] not found');
        return false;
    }

    /**
     * Formats input so it can be safely used as a literal
     * @param mixed $input
     * @return mixed
     */
    public function quote($input) {
        // open connection if not already 
        if (!$this->open()) {
            return false;
        }
        return $this->db->quoteSmart($input);
    }
    
    /**
     * Get the largest oid inserted with the values specified in an 
     * example object ($o). 
     * @param string table name
     * @return false|integer
     */
    private function _getMaxId($table, $oid = 'oid') {
        
        // preapre sql statement
        $sql = 'SELECT MAX(' . $this->quoteId($oid) . ') FROM ' . $this->quoteId($table) . ' WHERE 1=1;';

        // execute sql
        if (!$this->execute($sql)) {
            return false;
        }
        
        // prepare to read result
        $this->rsRestart();

        // check either MAX["oid"] (mysql/sqlite) or 'max' (pgsql)
        return $this->rsGetCol('MAX(' . $this->quoteId($oid) . ')', 'max');
    }
    
}

?>
