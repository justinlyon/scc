<?php
/*
 *  $Id: QueryUtil.php 1369 2008-10-02 01:52:20Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */
 
/**
 * Create and execute a dynamic SQL select command based on the
 * contents of the given ListBean. Includes support for pagination,
 * column sorting, and criteria-based filtering.
 */
class QueryUtil 
{
   /**
     * Returns a list of beans that matched the criteria 
     * given in the arguments
     *
     * @param db A database connection
     * @param namedBean A template bean identifiying the query table/columns
     * @param listBean Query parameters and results
     * @param where optional where clause element(s)
     * @param values optional values for prepared statement elements
     * @return boolean true if the query was successful, else false
     */
	public function select(&$db, $namedBean, &$listBean=null, $where=array(), $values=array())
    {
		Horde_Timer::singleton()->push();
    	if (empty($listBean)) { $listBean = new ListBean(); }
		$criteria = $listBean->get_criteria();
		$currentPage = $listBean->get_current_page();
		$pageSize = $listBean->get_page_size();
        $orderBy =  $listBean->get_order_by();
        $cols = $namedBean->get_bean_name() . '.*';

        // special handling to build timestamps from date columns
		// This is done to preserve naming convention for dates
		// while allowing the application to convert the value to a date OR
		// timestamp as needed.  
        foreach ($namedBean as $key => $value) {
        	if (strpos(strtolower($key),'timestamp') > 0) {
        		$cols .= ', TO_CHAR(' . str_replace('timestamp','date',$key) .
                         ', \'YYYY-MM-DD HH24:MI:SS\') AS ' . $key;
        	}
        }

        foreach($criteria as $property => $val) {
            $opcode = '=';
            $value = $val;
        	if (property_exists(get_class($namedBean), $property) && empty($value)) {
        	    Horde::logMessage( "NOTE: $property has empty value in _criteriaQuery", __FILE__, __LINE__, PEAR_LOG_WARNING);
        	}
          	if (property_exists(get_class($namedBean), $property)&& !empty($value)) {
            	if( is_object($value) && get_class($value) == 'Criterion' )
            	{
            		$value = $val->get_value();
            		$opcode = $val->get_operator();
            	}
        		if ( !is_numeric($value) && ($value == 'null' || $value == 'not null') ) {
        			$where[] = $property . ' is ' . $value;
        		} else if (is_array($value)) {
        			$tokens = $delim = '';
        			foreach ($value as $var) {
        				$tokens .= $delim . '?';
        				$delim = ',';
        				$values[] = $var;
        			}
        			if (empty($tokens)) {
        			    $where[] = '1=0';
        			} else if ($opcode == 'between' && count($value) == 2) {
        			    $where[] = "$property between ? and ?";
        			} else {
	            		$where[] = $property . ' in (' . $tokens . ')';
        			}
        		} else if (strpos(strtolower($property), 'timestamp') > 0) {
		            $where[] = $property . ' '.$opcode.' TO_DATE(?, \'YYYY-MM-DD HH24:MI:SS\')';
		            $values[] = date('Y-m-d H:i:s', strtotime($value));
        		} else if (strpos(strtolower($property), 'date') > 0) {
		            $where[] = 'trunc(' . $property . ') '.$opcode.' TO_DATE(?, \'YYYY-MM-DD\')';
		            $values[] = date('Y-m-d', strtotime($value));
        		} else if (is_string($value) && !(is_numeric($value)) && $opcode == '=') {
		            $where[] = $property . ' like ?';
		            $values[] = '%' . trim($value) . '%';
        		} else {
		            $where[] = $property . ' '.$opcode.' ?';
		            $values[] = $value;
        		}
        	}
        }
        $sql = 'SELECT ' . $cols . ' FROM ' . $namedBean->get_bean_name() .
               (count($where) ? ' WHERE ' . join(' AND ', $where) : '');
               
        $record_count = $listBean->get_record_count();
        if ($record_count == 0) {
        	$csql = str_replace($cols,'COUNT(*) AS count',$sql);
        	Horde::logMessage($csql . "\n" . print_r($values, true), __FILE__, __LINE__, PEAR_LOG_DEBUG);
        	$result = $db->query($csql, $values);
	        if (is_a($result, 'PEAR_Error')) {
	        	$listBean->setError($result);
		        QueryUtil::handleError($result, $csql, $values, __LINE__);
		    	return false;
	    	}
	        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	        if (is_a($row, 'PEAR_Error')) {
	        	$listBean->setError($row);
		        QueryUtil::handleError($row, $csql, $values, __LINE__);
		    	return false;
	    	}
	        $record_count = (int) $row['count'];
	        $listBean->set_record_count($record_count);
        }
        if ($pageSize < 0) { $pageSize = $record_count; }

		$firstRow = $currentPage * $pageSize + 1;
		if ($firstRow <= 0) {
			$firstRow = 1;
			$currentPage = 0;
		}
		$lastRow = ($currentPage+1) * $pageSize;
		if ($lastRow > $record_count) {
			$lastRow = $record_count;
			$currentPage = (int)(($record_count-1) / $pageSize );
			$firstRow = ($currentPage * $pageSize) + 1;
		}
		$listBean->set_current_page($currentPage);

		$list = array();
		if ($record_count > 0) {
			global $conf;
			if ($conf['data']['use_ci_sort']) {
				foreach ($orderBy as &$sort) {
					$parts = explode(' ', $sort);
					$sort = 'NLS_UPPER('. $parts[0] . ', \'NLS_SORT = GENERIC_BASELETTER\') ' . 
									(count($parts) > 1 ? $parts[1] : '');
				}
			}
			$psql = 'SELECT * FROM ( SELECT x.*, RowNum AS row_index FROM ( ' .
	        	    $sql . (count($orderBy) ? ' ORDER BY ' . join(', ', $orderBy) : '') .
	                ' ) x WHERE RowNum <= ' . $lastRow . ' ' .
	                ' ) WHERE row_index >= '. $firstRow;

	        Horde::logMessage($psql . "\n" . print_r($values, true), __FILE__, __LINE__, PEAR_LOG_DEBUG);

			$beanClass = get_class($namedBean);
			$beanKey = $namedBean->get_bean_key();
			$resultSet = $db->query($psql, $values);

	        if (is_a($resultSet, 'PEAR_Error')) {
	        	$listBean->setError($resultSet);
		        QueryUtil::handleError($resultSet, $psql, $values, __LINE__);
		    	return false;
	    	}

	    	$row = $resultSet->fetchRow(DB_FETCHMODE_ASSOC);

	        while (!empty($row)) {
		        if (is_a($row, 'PEAR_Error')) {
		        	$listBean->setError($row);
		        	QueryUtil::handleError($row, $psql, $values, __LINE__);
		        	return false;
		        }
		        if (is_array($beanKey)) {
		        	$keyVars = array();
		        	foreach($beanKey as $key) {
		        		$keyVars[] = $row[$key];
		        	}
		        	$listKey = join('|', $keyVars);
	            	$list[$listKey] = new $beanClass($row);
		        } else {
	            	$list[$row[$beanKey]] = new $beanClass($row);
		        }
	            $row = $resultSet->fetchRow(DB_FETCHMODE_ASSOC);
	        }
		} else {
	        Horde::logMessage('No matching rows: ' . $sql, __FILE__, __LINE__, PEAR_LOG_INFO);
		}
        $listBean->set_list($list);
        global $dispatcher;
		$dispatcher->timers[__CLASS__][__FUNCTION__][] = Horde_Timer::singleton()->pop();
        return true;
    }
	
	public function handleError($error, $sql, $values, $line)
	{
		$msg = 'SQL statement: ' . $sql . "\n";
		$msg .= print_r($values, true);
		$msg .= 'Error reported: ' . !empty($error) && is_a($error, 'PEAR_Error') ?
			$error->getMessage() . "\nDebug info: " . $error->getDebugInfo() :
			$error;
	    Horde::logMessage($msg , __FILE__, $line, PEAR_LOG_ERR);
	}
}

?>