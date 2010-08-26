<?php
/**
 *  $Id$: 
 *  Copyright (c) 2008, Tachometry Corporation
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
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Category.php';
require_once WEB_INF . '/dao/CategoryDao.php';
require_once WEB_INF . '/service/EventService.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A service class to serve both as data access facilitator and
 * API contract.  Note the convention that all public getters shall
 * return a bean or array of beans.   The private "fetch" methods
 * will return a PDO object or array of PDO objects.  Clients of 
 * the service should only call methods that will return bean objects
 * unless there is valid reason to use the PDO directly.
 */
class CategoryService
{ 

	public $dao;

	/**
	 * Creates a new Category using the given bean. 
	 *  
	 * @param bean The inbound Category as a scoped bean 
	 * @return The new Category as a Category bean
	 */
	function setup($bean)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setup($bean)");
		
		$pdo = $this->beanToPdo($bean);

		// Commit the populated PDO	
		$epm = epManager::instance();	
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to commit created venue.", E_USER_ERROR);
		}
		
		return $this->pdoToBean($pdo);
	}



	/** 
	 * Returns a list of Category beans.  If the optional
	 * scope attribute is specified, it will only return 
	 * category elements of the specified scope.
	 * 
	 * @param string An optional scope (e.g. Audience, Genre, Series)
	 * @param array An optional list of pubStates (e.g. Published, Unpublished, Archived)
	 * @return array List of category beans
	 */
	public function getCategories($scope = null, $pubStates = null)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getCategories($scope)");
		
		$beans = array();

		$dao = $this->getDao();
		$beans = $dao->getCategorySummaries($scope, $pubStates);
/* OLD
		$pdos = array();
		$epm = epManager::instance();
		
		$find = "from Category as c";
		$criteria = array();
		
		if ( $pubStates == null || count($pubStates) == 0 ) {
			$find .= " where (c.pubState is null or c.pubState.value != '". PublicationState::ARCHIVED ."') ";
		} else {
			$find .= " where ";
			for( $i=0; $i<count($pubStates); $i++ )
			{
				$find .= '(c.pubState.value = "'. $pubStates[$i] .'" or ';		
			}
			$find .= 'c.pubState is null)';
		}		
		if 	($scope != null) {
			$find .= " and c.scope = ?";
			array_push($criteria, $scope);
		}
		$find .= " order by c.name";
		
		$logger->debug("Query: ". $find);
		$pdos = $epm->find($find,$criteria);
		$logger->debug("Number of identified Categories: ". count($pdos) );
		
		// convert to beans
		foreach ($pdos as $pdo) {
			$beans[] = $this->pdoToBean($pdo);	
		}
*/
		
		return $beans;
	}
	
	
	/**
	 * Returns the category bean for the given category oid
	 * @param int oid of the target category
	 * @return bean scoped Category bean (e.g Series, Audience, Genre)
	 */
	public function getCategoryById($oid)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getCategoryById($oid)");
		
		if ($oid) {
			$pdo = $this->fetchCategoryById($oid);
			$beanType = $pdo->scope;
			$logger->debug("Bean type:". $beanType);
			$bean = $this->pdoToBean($pdo);
		}
		return $bean;
	}

	/**
	 * Updates a Category
	 *  
	 * @param bean The inbound Category as a bean
	 * @return bean The modified Category
	 */
	function update($bean)
	{
		global $logger;
		$logger->debug(get_class($this) . "::update($bean)");

		if ($bean->getOid() == null) {
			trigger_error('Invalid Category: oid is missing', E_USER_ERROR);
			return;
		}
		$logger->debug("update bean name: ". $bean->getName());
			
		$pdo = $this->beanToPdo($bean);
		
		$logger->debug("update pdo name: ". $pdo->getName());
		   
        // Commit the populated PDO	
        $epm = epManager::instance();
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to update $oid", E_USER_ERROR);
		}
	
		return $this->pdoToBean($pdo);
	}

	/**
	  * A convenience method to copy attributes from the PDO
	  * to the Bean. Will automatically set the useTargetVars 
	  * attribute of the CopyBeanOption.
	  * 
	  * @access private
	  * @param pdo The Venue PDO object (source)
	  * @return bean The Venue bean
	  */
	  private function pdoToBean($pdo)
	  {
	  	global $logger;
	  	$logger->debug(get_class($this) . "::pdoToBean($pdo)");
	  	$copyOption = new CopyBeanOption();
		$copyOption->setUseTargetVars(true);
		$copyOption->setScalarsOnly(true);
	  	
	  	$bean = new $pdo->scope();
	  	$bean = BeanUtil::copyBean($pdo, $bean, $copyOption);
	  	
	  	// pubState to a string
	  	$ps = '';
	  	if ($pdo->getPubState() != null) {
	  		$ps = $pdo->getPubState()->getValue();	
	  	}
	  	$bean->setPubState($ps);
	  	
	  	// related events from array of pdos to keyed array of oids 
	  	$events = $pdo->getEvents();
		if (!empty($events)) {
			$es = new EventService();
			$related = array();
			foreach ($events as $event) {
				$related[] = $es->getEventById($event->getScope(), $event->getOid());
			}
			$bean->setEvents($related);
		}
	  	
	  	return $bean;
	}


	/**
	 * Returns a Category PDO for the given oid.
	 * 
	 * @param int oid the oid for the target venue
	 * @return Category or empty array if not found
	 */
	 function fetchCategoryById($oid) 
	 {
		global $logger;
	  	$logger->debug(get_class($this) . "::fetchCategoryById($oid)");
		
		$epm = epManager::instance();
		$pdos = $epm->find("from Category where oid = ?",$oid);
		
		$logger->debug("Number of returned categories [1]: ". count($pdos));
		if (count($pdos) == 0) {
			trigger_error("No category found for oid $oid", E_USER_ERROR);
			return false;
		} elseif (count($pdos) > 1){
			trigger_error("Ambiguous result found for oid $oid", E_USER_ERROR);
			return false;
		}
		
		return $pdos[0];
	 }

	/** 
	 * A convenience method to convert the incoming bean
	 * to the corresponding PDO.  This includes all translations
	 * such as the nested PublicationSate.
	 * If the bean has an oid, then it will fetch the category,
	 * if the category id is null, a new pdo object will be returned.
	 * 
	 * @access private
	 * @param bean Category bean
	 * @return pdo Category PDO
	 */
	 private function beanToPdo($bean)
	 {
	 	global $logger;
	 	$logger->debug(get_class($this) . "::beanToPdo($bean)");
	 	
	 	// Check to see if there is a valid OID 
	 	if ($bean->getOid() > 0) {
	 		$pdo = $this->fetchCategoryById($bean->getOid());
	 	} else {
	 		// Get a new event PDO
			$epm = epManager::instance();
			$pdo = $epm->create('Category');
	 	} 	
	 	
		// Copy the bean values over the top of the PDO values
		BeanUtil::copyBean($bean, $pdo);
				
		// Set the scope
		$pdo->setScope(get_class($bean));		
				
		// Translate the pubState from string to object instance
		$pubState = $this->fetchPubState($bean->getPubState());
		$pdo->setPubState($pubState);
			
		// Translate the events from array of oids to array of PDOs
		$eventAssoc = $bean->getEvents();
		if($eventAssoc != null) {
			$es = new EventService();
			$eventPdo = array();
			
			foreach ($eventAssoc as $key => $value) {
				$type = ucfirst($key);
				$logger->debug("The event type is: ". $type);
				
				foreach ($value as $evoid) {
					$eventPdo[] = $es->fetchEventById($type,$evoid);
				}
			}
			$pdo->setEvents($eventPdo);
	 	}
				
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
	 * Retrieves the category by the given id, then invokes the
	 * native delete method on the PDO object.
	 * @param int The oid for the target category
	 * @return void
	 */
	 function delete($oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::delete($oid)");
		
		if ($oid == null) {
			trigger_error("Required oid is missing", E_USER_ERROR);	
		}
		$category = $this->fetchCategoryById($oid);
		$category->delete();		
	 }

	private function getDao()
	{
		if ($this->dao == null) {
			$this->dao = new CategoryDao();
		}
		return $this->dao;
	}


}
?>

