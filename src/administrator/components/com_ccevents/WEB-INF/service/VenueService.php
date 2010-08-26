<?php
/**
 *  $Id$: VenueService.php, Sep 4, 2006 2:38:02 PM nchanda
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
require_once WEB_INF . '/beans/Venue.php';
require_once WEB_INF . '/beans/Address.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/Program.php';
require_once WEB_INF . '/beans/Course.php';
require_once WEB_INF . '/dao/VenueDao.php';
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
class VenueService
{    

	public $dao;

	/**
	 * Creates a new Venue using the given venue bean. 
	 *  
	 * @param bean The inbound Venue as a bean
	 * @return The new venue as a bean
	 */
	function setupVenue($bean)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setupVenue($bean)");
		
		$pdo = $this->beanToPdo($bean);

		// Commit the populated PDO	
		$epm = epManager::instance();	
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to commit created venue.", E_USER_ERROR);
		}
		
		return $this->pdoToBean($pdo);
	}
	
	/**
	 * Updates a Venue
	 *  
	 * @param bean The inbound Venue as a bean
	 * @return bean The modified Venue
	 */
	function update($bean)
	{
		global $logger;
		
		$logger->debug(get_class($this) . "::update($bean)");

		if ($bean->getOid() == null) {
			trigger_error('Invalid Venue: oid is missing', E_USER_ERROR);
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
	 * Retrieves the venue by the given id, then invokes the
	 * native delete method on the PDO object.  If an address
	 * is associated with the venue, it too will be deleted.
	 * @param int The oid for the target venue
	 * @return void
	 */
	 function delete($oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::delete($oid)");
		
		if ($oid == null) {
			trigger_error("Required oid is missing", E_USER_ERROR);	
		}
		$venue = $this->fetchVenueById($oid);
		$address = $venue->getAddress();
		if ($address != null) {
			$address->delete();
		}
		$venue->delete();		
	 }

	/**
	 * Returns all venues for the given publication state, or 
	 * all "non-archived" venues if the pubStates array is null.
	 * @param array pubStates An array of status keys (e.g. Published, Unpublished, Archived, etc.)
	 * @return Venue[] or empty array if not found
	 */
	function getVenuesByPubState($pubStates=null)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getVenuesByPubState($pubStates)");
		
		$dao = $this->getDao();
		$venues = $dao->getVenueSummaries($pubStates);
/*
		$epm = epManager::instance();
	
		$result = array();
		if ( $pubStates == null || count($pubStates) == 0 ) {
			$result = $epm->find("from Venue where pubState is null or pubState.value != ? order by name",PublicationState::ARCHIVED);
		} else {
			$find = "from Venue where ";
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
		$listOfBeans = array();
		$logger->debug("listOfBeans has ". count($listOfBeans) ." records of class: ". get_class($listOfBeans[0]));
		return $listOfBeans;		
*/
		return $venues;
	}	
	

	/**
	 * Returns the venue Bean for the given oid.
	 * This is a public wrapper for the fetchVenueById
	 * method.
	 * 
	 * @param int oid
	 * @return bean a populated Venue bean
	 */
	 function getVenueById($oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::getVenueById($oid)");
		
	 	if($oid == null) {
	 		trigger_error("Missing required OID", E_USER_ERROR);
	 		return;
	 	}	
	 	
	 	$pdo = $this->fetchVenueById($oid);
	 	return $this->pdoToBean($pdo);	 
	 }
	 
	 /**
	  * Returns the most recently inserted Venue (bean)
	  * as keyed by the max(id)
	  * 
	  * @return bean Venue
	  */	 
	function getLastVenue()
	{
		global $logger;
		$logger->debug(get_class($this) . "::getLastVenue()");
		
		$epm = epManager::instance();
		$id = $epm->find("max(oid) from Venue");
		
		return $this->getVenueById($id);
	}

	/**
	 * Returns a Venue PDO for the given oid.
	 * 
	 * @param int oid the oid for the target venue
	 * @return Venue or empty array if not found
	 */
	 function fetchVenueById($oid)
	 {
		global $logger;
		$logger->debug(get_class($this) . "::fetchVenueById($oid)");
		
		$epm = epManager::instance();
		$venue = $epm->get('Venue', $oid);
		
		if ($venue === FALSE) {
			trigger_error("Invalid Venue: $oid not found", E_USER_ERROR);
			return;
		}
		if (is_array($venue)) {
			trigger_error("Invalid Venue: ambiguous results for $oid", E_USER_ERROR);
			return;
		}
		$logger->debug("Name of venue: ". $venue->getName());
		return $venue;
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
	  	
	  	$bean = new Venue();
	  	$bean = BeanUtil::copyBean($pdo, $bean, $copyOption);
	  	
	  	// Convert the pubState to a string
	  	$ps = '';
	  	if ($pdo->getPubState() != null) {
	  		$ps = $pdo->getPubState()->getValue();	
	  	}
	  	$bean->setPubState($ps);
	  	$logger->debug("pubstate: ". $bean->getPubState());
	  	
	  	// Convert the Address to bean
	  	$addrBean = new Address();
	  	if ($pdo->getAddress() != null) {
	  		$addrBean = BeanUtil::copyBean($pdo->getAddress(), $addrBean, $copyOption);	
	  	}
	  	$bean->setAddress($addrBean);
	  	$logger->debug("address: ". $bean->getAddress());
	  	
	  	// related events from array of pdos to keyed array of oids 
	  	$events = $pdo->getEvents();
	  	$logger->debug("events: ". count($events));
		if (!empty($events) && '' != get_class($events[0])) {
			$es = new EventService();
			$related = array();
			foreach ($events as $event) {
				$logger->debug("event: ". $event);
				$related[] = $es->getEventById($event->getScope(), $event->getOid());
			}
			$bean->setEvents($related);
		}
	  	
	  	return $bean;
	  }

	/** 
	 * A convenience method to convert the incoming bean
	 * to the corresponding PDO.  This includes all translations
	 * such as the nested PublicationSate and Address objects.  
	 * If the bean has an oid, then it will fetch the venue,
	 * if the venue id is null, a new pdo object will be returned.
	 * 
	 * @access private
	 * @param bean Venue bean
	 * @return pdo Venue PDO
	 */
	 private function beanToPdo($bean)
	 {
	 	global $logger;
	 	$logger->debug(get_class($this) . "::beanToPdo($bean)");
	 	
	 	// Check to see if there is a valid Venue OID 
	 	if ($bean->getOid() > 0) {
	 		$pdo = $this->fetchVenueById($bean->getOid());
	 	} else {
	 		// Get a new event PDO
			$epm = epManager::instance();
			$pdo = $epm->create('Venue');
	 	} 	
	 	
		// Copy the bean values over the top of the PDO values
		BeanUtil::copyBean($bean, $pdo);
		
		// Translate the pubState from string to object instance
		$pubState = $this->fetchPubState($bean->getPubState());
		$pdo->setPubState($pubState);
		
		// Translate the address from bean to object instance
		$addrBean = $bean->getAddress();
		if ($addrBean != null) {
			if ($addrBean->getOid() > 0 || trim($addrBean->getStreet()) != "") {
				$addrPdo= $this->fetchAddressById($addrBean->getOid());
				BeanUtil::copyBean($addrBean,$addrPdo);
				$pdo->setAddress($addrPdo); 
			}
		}
		
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
	  * Return the Address PDO for the given Address bean.
	  * If no OID is available in the bean, then a new
	  * address instance is created. If the bean has a
	  * value for the street attribite, the values of 
	  * the bean will be coppied to the pdo object.  
	  * Otherwise the empty pdo will be returned. (This 
	  * will protect against a new entry being created for
	  * an invalid address)
	  * 
	  * @access private
	  * @param int The oid of the Address
	  * @return pdo Address PDO
	  */
	  private function fetchAddressById($oid = null)
	  {
	  	global $logger;
		$logger->debug(get_class($this) . "::fetchAddressByOid($oid)");
		
	  	$epm = epManager::instance();
						
		if ($oid == null || $oid == 0) {	
			$result = $epm->create('Address');
		} else {
			$result = $epm->get('Address', $oid);
		} 
		return $result;		
	  }	
	  
	/**
	* Copies the updated values of the bean to the pdo
	* object, then commits the pdo object to update the 
	* address.
	* 
	* @access private
	* @param bean Address Bean
	* @return pdo updated Address PDO
	*/
	private function updateAddress($bean)
	{
		global $logger;
		$logger->debug(get_class($this) . "::updateAddress($bean)");
		
		$logger->debug("Address is of class: ". get_class($bean));
		$logger->debug("Before update the address id: ". $bean->getOid());
		
		$epm = epManager::instance();
		
		$pdo = null;
		if ($bean->getOid() > 0) {
			$pdo = $this->fetchAddressById($bean->getOid());
			$logger->debug("Oid > 0: ". $pdo->getOid());
		} else if (trim($bean->getStreet()) != NULL) {
			$pdo = $epm->create('Address');
			$logger->debug("No oid, but valid street: ". $bean->getStreet());
		} else {
			return null; // This is not a valid address	
		}
		$pdo = BeanUtil::copyBean($bean,$pdo);
		$pdo = $epm->commit($pdo);	
		$logger->debug("After update the address id: ". $pdo->getOid());
		return $pdo;
	}

	private function getDao()
	{
		if ($this->dao == null) {
			$this->dao = new VenueDao();
		}
		return $this->dao;
	}

}
?>
