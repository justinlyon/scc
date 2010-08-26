<?php
/**
 *  $Id$: Product.php, Feb 15, 2007 11:44:47 PM nchanda
 *  Copyright (c) 2007, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
require_once('tachometry/util/BaseBean.php');

class Product extends BaseBean
{
	/**
	 * The name of the product
	 * @var string
	 */
	public $name;
	
	/**
	 * The sku of the product
	 * @var string
	 */
	public $sku;

	/**
	 * The database id of the product
	 * @var int
	 */
	public $oid;

	/**
	 * The virtuemart flypage
	 * @var string
	 */
	public $flypage;

	/**
	 * The parent category for the product
	 * @var int
	 */
	public $categoryId;
	
}

?>


