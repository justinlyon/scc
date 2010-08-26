<?php
/*
 *  $Id: ListBean.php 1290 2008-09-17 00:12:23Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */
 
require_once 'tachometry/util/BaseBean.php';
require_once 'tachometry/web/Criterion.php';

/**
 * Defines a query and the list results. Passed by reference
 * into the Driver (sub)classes to fetch list data from the
 * corresponding data source.
 */
class ListBean extends BaseBean
{
	// input attributes
	
	public $criteria;		// where clause array(attribute => value ...)
	public $order_by;		// order clause array(attribute ['ASC'|'DESC'])
	public $current_page;	// int
	public $page_size;		// int

	// output attributes
	
	public $error;			// query error (PEAR_Error)
	public $list;			// result beans array(key => value ...)
	public $record_count;	// int
		
	public function __construct($source=null) {

		$this->set_current_page(0);
		$this->set_page_size(0);
		$this->set_record_count(0);
		$this->set_criteria(array());
		$this->set_order_by(array());
		$this->set_list(array());

		parent::__construct($source);
	}
	
	public function add_order_by($attribute) {
		$orderBy = $this->get_order_by();
		$orderBy[] = $attribute . ' ASC';
		$this->set_order_by($orderBy);
	}
	
	public function add_order_by_desc($attribute) {
		$orderBy = $this->get_order_by();
		$orderBy[] = $attribute . ' DESC';
		$this->set_order_by($orderBy);
	}
	
	public function get_num_pages() {
		if ($this->get_page_size() == 0) { return 0; }
		return (int) (($this->get_record_count()-1) / $this->get_page_size())+1;
	}
}

 
?>
