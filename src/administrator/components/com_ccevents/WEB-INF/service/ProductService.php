<?php
/**
 *  $Id$: ProductService.php, Feb 15, 2007 11:51:26 PM nchanda
 *  Copyright (c) 2007, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

require_once WEB_INF . '/beans/Product.php';

// Use VirtueMart as the integration point
global $mosConfig_absolute_path;
require_once ($mosConfig_absolute_path .'/components/com_virtuemart/virtuemart_parser.php');
require_once ($mosConfig_absolute_path .'/administrator/components/com_virtuemart/classes/ps_product.php');
require_once ($mosConfig_absolute_path .'/administrator/components/com_virtuemart/classes/ps_product_category.php');

/**
 * A service class to serve both as data access facilitator and
 * API contract.  Note the convention that all public getters shall
 * return a bean or array of beans.   The private "fetch" methods
 * will return a PDO object or array of PDO objects.  Clients of 
 * the service should only call methods that will return bean objects
 * unless there is valid reason to use the PDO directly.
 */
class ProductService
{
	function getProductBySku($sku) {
		global $database, $logger;
		$logger->debug(get_class($this) . "::getProductBySku($sku)");
			
		$prod = new Product();
		$ps_prod = new ps_product();
		$ps_cat = new ps_product_category();
		
		$query = "select product_id from #__vm_product where product_sku=". $sku;
		$database->loadQuery($query);
		$id = $db->loadResult();
		
		$prod->setOid($id);
		$prod->setName($ps_prod->get_field('product_name'));
		$prod->setFlypage($ps_prod->get_flypage($id));
		$prod->setCategoryId($ps_cat->get_cid($id));
		
		
		return $prod;
	}
}
?>

