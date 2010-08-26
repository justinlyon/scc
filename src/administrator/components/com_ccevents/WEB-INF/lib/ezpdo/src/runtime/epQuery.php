<?php

/**
 * $Id: epQuery.php 734 2005-12-15 03:48:54Z nauhygon $
 * 
 * Copyright(c) 2005 by Oak Nauhygon. All rights reserved.
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2005-12-14 22:48:54 -0500 (Wed, 14 Dec 2005) $
 * @package ezpdo
 * @subpackage ezpdo.runtime
 */

/**
 * need query builder
 */
include_once(EP_SRC_QUERY.'/epQueryBuilder.php');

/**
 * Exception class for {@link epQuery}
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2005-12-14 22:48:54 -0500 (Wed, 14 Dec 2005) $
 * @package ezpdo
 * @subpackage ezpdo.runtime
 */
class epExceptionQuery extends epException {
}

/**
 * The EZPDO query class
 * 
 * This class interprets EZOQL (the EZPDO Object Query Language) query 
 * strings and outputs SQL statement. EZOQL is a simple object query 
 * lanaguage, a variant of standard SQL. 
 * 
 * The syntax EZOQL in the BNF (Backus Normal Form) can be found in 
 * src/query/bnf.txt. You can safely skip it if you know enough about 
 * the SQL SELECT statement. The syntax is very similar.  
 * 
 * During a query, both in-memory objects and those in database tables 
 * should be searched. The presence of in-memory objects actually presents 
 * a problem for us. We can safely pass the query string to the 
 * database to do the query if there is no loaded objects. When there are 
 * objects loaded and their variables have been altered, the database 
 * query won't be aware of the inconsistency and the results can be invalid. 
 * 
 * Two solutions to this:
 * <ol>
 * <li>
 * It would be ideal to do the same query on the in-memory objects, but
 * this apparently requires the "deep" parsing of the query string and 
 * applying the where clause on all objects. Potentially a lot of 
 * work on the parser. Plus, whether in-memory query can always outperform 
 * an all-database query is also very questionable in PHP.
 * </li>
 * <li>
 * A simple solution. Before the query, we <b>commit</b> all in-memory 
 * objects that are related to the database query. The overhead is the 
 * commiting before query. So it is important to commit only the objects 
 * of the <b>related</b> classes.
 * </li>
 * </ol>
 * 
 * Currently we implement the second option, for which we can simply 
 * process the string with class/table name replacement and pass it
 * to the database layer to execute the query. This is by any means a 
 * rudimentary implementation. 
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2005-12-14 22:48:54 -0500 (Wed, 14 Dec 2005) $
 * @package ezpdo
 * @subpackage ezpdo.runtime
 */
class epQuery {

    /**
     * The class map of the root class in the query
     * @var array of epClassMap
     */
    protected $root_cms = false;

    /**
     * The last parsed EZOQL query
     * @var string
     */
    protected $oql_stmt = false;

    /**
     * The arguments for the EZOQL query
     * @var string
     */
    protected $args = array();

    /**
     * The aggregation function involved in the query
     * @var false|string
     */
    protected $aggr_func = false;
    
    /**
     * Order by in the query
     * @var false|string
     */
    protected $orderby = false;
    
    /**
     * Limit in the query
     * @var false|string
     */
    protected $limit = false;

    /**
     * Constructor
     * @param string $q (the EZOQL query string)
     * @param array $args arguments for the query
     */
    public function __construct($oql_stmt = '', $args = array()) {
        if ($oql_stmt) {
            $this->parse($oql_stmt, $args);
        }
    }
    
    /**
     * Return the EZOQL statement 
     * @return string
     */
    public function getOqlStatement() {
        return $this->oql_stmt;
    }

    /**
     * Return the equivalent SQL statement (the parsing result)
     * @return string
     */
    public function getSqlStatement() {
        return $this->sql_stmt;
    }

    /**
     * Returns the class maps involved in the query
     * @return array
     */
    public function &getClassMaps() {
        return $this->root_cms;
    }

    /**
     * Returns whether the query has aggregate function
     * @return boolean
     */
    public function getAggregateFunction() {
        return $this->aggr_func;
    }

    /**
     * Returns whether the query has a limit
     * @return boolean|string
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * Returns whether the query has an order by
     * @return boolean|string
     */
    public function getOrderBy() {
        return $this->orderby;
    }

    /**
     * Parse the EZOQL statement and translate it into equivalent 
     * SQL statement
     * 
     * @param string $q (the EZOQL query string)
     * @param array $args arguments for the query
     * @return false|string
     * @throws epExceptionQuery, epQueryExceptionBuilder
     */
    public function parse($oql_stmt, $args = array()) {
        
        // reset aggregation function
        $this->aggr_func = false;

        // get oql statement (query)
        if ($oql_stmt) {
            $this->oq_stmt = $oql_stmt;
        }

        // check if query empty
        if (!$this->oq_stmt) {
            throw new epExceptionQuery('Empty EZOQL query'); 
            return false;
        }

        // get oql statement (query)
        if ($args) {
            $this->args = $args;
        }

        // instantiate a query parser
        if (!($p = new epQueryParser($oql_stmt))) {
            return false;
        }

        // parse query and get syntax tree
        $root = $p->parse();

        // check if there is any errors
        if (!$root || $errors = $p->errors()) {
            $emsg = 'EZOQL parsing error';
            if ($errors) {
                $emsg .= ":\n";
                foreach($errors as $error) {
                    $emsg .= $error->__toString() . "\n";
                }
            } else {
                $emsg .= " (unknown)";
            }
            throw new epExceptionQuery($emsg); 
            return false;
        }

        // instantiate builder to build the SQL query
        if (!($b = new epQueryBuilder($root, $this->oq_stmt, $this->args))) {
            return false;
        }

        // build the SQL query from syntax tree
        $this->sql_stmt = $b->build();

        // get the aggregate function in the query
        $this->aggr_func = $b->getAggregateFunction();

        // get the limit
        $this->limit = $b->getLimit();
        
        // get the order
        $this->orderby = $b->getOrderBy();
        
        // get the root classes of this query
        $this->root_cms = & $b->getRootClassMaps();
        
        return $this->sql_stmt;
    }

}

?>