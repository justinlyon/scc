<?php
/*
 *  $Id: NamedBean.php 685 2008-04-05 21:01:56Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

require_once 'BaseBean.php';

/**
 * A class for a named bean instance. In a web application,
 * the bean name is expected to match the table name. The
 * bean key attribute should name the primary key column.
 *
 * @author Tom Evans <tevans@tachometry.com>
 * @version $Revision: 512 $
 */
class NamedBean extends BaseBean
{
	public $row_index;

	public $bean_name;
	public $bean_key;

	public function get_bean_name() {
		if (is_null($this->bean_name)) {
			return strtolower(get_class($this));
		} else {
			return $this->bean_name;
		}
	}

	public function getBeanName() {
		return $this->get_bean_name();
	}

	public function get_bean_key() {
		if (is_null($this->bean_key)) {
			return 'oid';
		} else {
			return $this->bean_key;
		}
	}

	public function getBeanKey() {
		return $this->get_bean_key();
	}

	public function __construct($source=null) {
		parent::__construct($source);
	}
}
?>
