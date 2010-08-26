<?php
/**
 *  $Id$: HomePageService.php, Sep 4, 2006 2:38:02 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/..');
}
require_once WEB_INF . '/base.include.php'; 
require_once WEB_INF . '/pdo/model.php'; 
require_once WEB_INF . '/beans/HomePage.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/Program.php';
require_once WEB_INF . '/beans/Course.php';
require_once WEB_INF . '/service/EventService.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A service class to serve both as data access facilitator and
 * API contract.  Note the convention that all pulic getters shall
 * return a bean or array of beans.   The private "fetch" methods
 * will return a PDO object or array of PDO objects.  Clients of 
 * the service should only call methods that will return bean objects.
 */
class HomePageService
{    
	/**
	 * Creates a new HomePage using the given home_page bean. 
	 *  
	 * @param bean The inbound HomePage as a bean
	 * @return The new home_page as a bean
	 */
	function setupHomePage($bean)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setupHomePage($bean)");
		
		$pdo = $this->beanToPdo($bean);

		// Commit the populated PDO	
		$epm = epManager::instance();	
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to commit created home_page.", E_USER_ERROR);
		}
		
		return $this->pdoToBean($pdo);
	}
	
	/**
	 * Updates a HomePage
	 *  
	 * @param bean The inbound HomePage as a bean
	 * @return bean The modified HomePage
	 */
	function update($bean)
	{
		global $logger;
		
		$logger->debug(get_class($this) . "::update($bean)");

		if ($bean->getOid() == null) {
			trigger_error('Invalid HomePage: oid is missing', E_USER_ERROR);
			return;
		}
		
		$pdo = $this->beanToPdo($bean);
		   
        // Commit the populated PDO	
        $epm = epManager::instance();
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to update $oid", E_USER_ERROR);
		}
		
		return $this->pdoToBean($pdo);
	}
	
	

	/**
	 * Retrieves the home_page by the given id, then invokes the
	 * native delete method on the PDO object.  If an address
	 * is associated with the home_page, it too will be deleted.
	 * @param int The oid for the target home_page
	 * @return void
	 */
	 function delete($oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::delete($oid)");
		
		if ($oid == null) {
			trigger_error("Required oid is missing", E_USER_ERROR);	
		}
		$home_page = $this->fetchHomePageById($oid);
		$home_page->delete();		
	 }

	/**
	 * Returns all home_pages for the given publication state, or 
	 * all "non-archived" home_pages if the pubStates array is null.
	 * @param array pubStates An array of status keys (e.g. Published, Unpublished, Archived, etc.)
	 * @return HomePage[] or empty array if not found
	 */
	function getHomePagesByPubState($pubStates=null)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getHomePagesByPubState($pubStates)");
		
		$epm = epManager::instance();

		$result = array();
		if ( $pubStates == null || count($pubStates) == 0 ) {
			$result = $epm->find("from HomePage where pubState is null or pubState.value != ? order by name",PublicationState::ARCHIVED);
		} else {
			$find = "from HomePage where ";
			for( $i=0; $i<count($pubStates); $i++ )
			{
				$find .= 'pubState.value = "'. $pubStates[$i] .'" or ';		
			}
			$find .= 'pubState is null order by name';
			$logger->debug("DB Query: $find");
			$result = $epm->find($find);
		}
		
		// Convert PDOs to Beans
		$listOfBeans = array();
		foreach($result as $pdo) 	{
			$listOfBeans[] = $this->pdoToBean($pdo);
		}
		return $listOfBeans;		
	}	
	

	/**
	 * Returns the home_page Bean for the given oid.
	 * This is a public wrapper for the fetchHomePageById
	 * method.
	 * 
	 * @param int oid
	 * @return bean a populated HomePage bean
	 */
	 function getHomePageById($oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::getHomePageById($oid)");
		
	 	if($oid == null) {
	 		trigger_error("Missing required OID", E_USER_ERROR);
	 		return;
	 	}	
	 	
	 	$pdo = $this->fetchHomePageById($oid);
	 	return $this->pdoToBean($pdo);	 
	 }
	 
	 /**
	  * Returns the most recently inserted HomePage (bean)
	  * as keyed by the max(id)
	  * 
	  * @return bean HomePage
	  */	 
	function getLastHomePage()
	{
		global $logger;
		$logger->debug(get_class($this) . "::getLastHomePage()");
		
		$epm = epManager::instance();
		$id = $epm->find("max(oid) from HomePage");
		
		return $this->getHomePageById($id);
	}

	

	/**
	  * A convenience method to get the most recent
	  * home page based on the publication state and
	  * timestamp comparison to now.
	  * 
	  * @return bean HomePage
	  */	 
	function getCurrentHomePage()
	{
		global $logger;
		$logger->debug(get_class($this) . "::getCurrentHomePage()");
		
		$epm = epManager::instance();
		$now = time();		
		$ids = $epm->find("from HomePage where pubState.value = ? and startTime < ? order by startTime desc",PublicationState::PUBLISHED,$now);
		$logger->debug("Number of found records: ". count($ids));
	
		return $this->getHomePageById($ids[0]->getOid());
	}



	/**
	 * Returns a HomePage PDO for the given oid.
	 * 
	 * @param int oid the oid for the target home_page
	 * @return HomePage or empty array if not found
	 */
	 function fetchHomePageById($oid)
	 {
		global $logger;
		$logger->debug(get_class($this) . "::fetchHomePageById($oid)");
		
		$epm = epManager::instance();
		$home_page = $epm->get('HomePage', $oid);
		
		if ($home_page === FALSE) {
			trigger_error("Invalid HomePage: $oid not found", E_USER_ERROR);
			return;
		}
		if (is_array($home_page)) {
			trigger_error("Invalid HomePage: ambiguous results for $oid", E_USER_ERROR);
			return;
		}
		$logger->debug("Name of home_page: ". $home_page->getName());
		return $home_page;
	 }
	
	/**
	  * A convenience method to copy attributes from the PDO
	  * to the Bean. Will automatically set the useTargetVars 
	  * attribute of the CopyBeanOption.
	  * 
	  * @access private
	  * @param pdo The HomePage PDO object (source)
	  * @return bean The HomePage bean
	  */
	  private function pdoToBean($pdo)
	  {
	  	global $logger;
	  	$logger->debug(get_class($this) . "::pdoToBean($pdo)");
	  	$copyOption = new CopyBeanOption();
		$copyOption->setUseTargetVars(true);
		$copyOption->setScalarsOnly(true);
	  	
	  	$bean = new HomePage();
	  	$bean = BeanUtil::copyBean($pdo, $bean, $copyOption);
	  	
	  	// Convert the pubState to a string
	  	$ps = '';
	  	if ($pdo->getPubState() != null) {
	  		$ps = $pdo->getPubState()->getValue();	
	  	}
	  	$bean->setPubState($ps);
		
	  	return $bean;
	  }

	/** 
	 * A convenience method to convert the incoming bean
	 * to the corresponding PDO.  This includes all translations
	 * such as the nested PublicationSate and Address objects.  
	 * If the bean has an oid, then it will fetch the home_page,
	 * if the home_page id is null, a new pdo object will be returned.
	 * 
	 * @access private
	 * @param bean HomePage bean
	 * @return pdo HomePage PDO
	 */
	 private function beanToPdo($bean)
	 {
	 	global $logger;
	 	$logger->debug(get_class($this) . "::beanToPdo($bean)");
	 	
	 	// Check to see if there is a valid HomePage OID 
	 	if ($bean->getOid() > 0) {
	 		$pdo = $this->fetchHomePageById($bean->getOid());
	 	} else {
	 		// Get a new event PDO
			$epm = epManager::instance();
			$pdo = $epm->create('HomePage');
	 	} 	
	 	
		// Copy the bean values over the top of the PDO values
		BeanUtil::copyBean($bean, $pdo);
		
		// Translate the pubState from string to object instance
		$pubState = $this->fetchPubState($bean->getPubState());
		$pdo->setPubState($pubState);
		
	 	return $pdo;
	 }
	 

	 /**
	  * Return the PublicationState PDO for the given value
	  * @access private
	  * @param string The PublicationSatte value
	  * @return PublicationState PDO
	  */
	  private function fetchPubState($value)
	  {
	  	global $logger;
		$logger->debug(get_class($this) . "::fetchPubState($value)");
		
	  	if ( is_string($value)) {
	  		$pdo = epManager::instance();
			$template = $pdo->create('PublicationState');
			$template->setValue($value);
			$pubStates = $pdo->find($template);
			if (count($pubStates) > 0) {
				return $pubStates[0]; 
			} else {
				$logger->debug("No PublicationStates matched value: $value");
				return false;
			}
					
		}
	  }
	  
	  /**
	   * Convenience method to return an associative array for the event 
	   * marker in the format array('scope'=>scope, 'id'=>id) where string 
	   * is like Exhibition.2
	   * @param String to split
	   * @param assoc array
	   */
	 function splitString($string) {
		$result = array();
	  	$split = preg_split("/\./", $string);
	  	if (count($split) == 2) {
	  		$result['scope'] = $split[0];
	  		$result['id'] = $split[1];	
	  	}
	  	return $result;
	 }
}
?>
