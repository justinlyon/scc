<?php
/*
 *  $Id: Criterion.php 1391 2008-10-03 15:38:01Z phale $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */
 
/**
 * Defines an operator and value used to construct the
 * corresponding elements of a custom SQL where clause
 */
class Criterion extends BaseBean 
{
    public $operator;
    public $value;
    
	public function __construct($source=null) {
		parent::__construct($source);
	}

    public function get_operator()
    {
    	return $this->map_operator($this->operator);
	}
	
    public function set_operator($arg)
    {
    	$this->operator = $this->map_operator($arg);
	}
	
    public function map_operator($arg)
    {
    	$opcodes = array(
    		'lt' => '<',
    		'le' => '<=',
    	    'gt' => '>',
    	    'ge' => '>=',
    	    'ne' => '<>',
    	    'eq' => '='
    	);
    	if (array_key_exists($arg, $opcodes)) {
    		return $opcodes[$arg];
    	} else {
    		return ($arg);
    	}
    }
}

?>