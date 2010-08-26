<?php
/**
 *  $Id $
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
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Person.php';
require_once WEB_INF . '/beans/Artist.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/service/EventService.php';

require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A service class to serve both as data access facilitator and
 * API contract.  Note the convention that all pulic getters shall
 * return a bean or array of beans.   
 */
class PersonService
{ 
	public $eventService;

	/**
	 * Returns the Person bean for the given Person oid
	 * @param int oid of the target Person
	 * @return bean Person bean 
	 */
	public function getPersonById($personType, $oid)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getPersonById($personType, $oid)");
		
		if ($oid) {
			$pdo = $this->fetchPersonById($personType, $oid);
			$bean = $this->pdoToBean($pdo);
		}
		return $bean;
	}



	/** 
	 * Returns a list of Person beans.  If the optional
	 * scope attribute is specified, it will only return 
	 * person elements of the specified scope.
	 * 
	 * @param string An optional scope (e.g. Artist, Performer, Instructor)
	 * @param array An optional list of pubStates (e.g. Published, Unpublished, Archived)
	 * @return array List of category beans
	 */
	public function getPersons($personType, $pubStates = null)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getPersons($personType)");
		
		$beans = array();
		$pdos = array();
		$epm = epManager::instance();
		
		$find = "from Person as p";
		$criteria = array();
		
		if ( $pubStates == null || count($pubStates) == 0 ) {
			$find .= " where (p.pubState is null or p.pubState.value != '". PublicationState::ARCHIVED ."') ";
		} else {
			$find .= " where ";
			for( $i=0; $i<count($pubStates); $i++ )
			{
				$find .= '(p.pubState.value = "'. $pubStates[$i] .'" or ';		
			}
			$find .= 'p.pubState is null)';
		}		
		if 	($personType != null) {
			$find .= " and p.scope = ?";
			array_push($criteria, $personType);
		}
		$find .= " order by p.lastName";
		
		$logger->debug("Query: ". $find);
		$pdos = $epm->find($find,$criteria);
		
		$logger->debug("Number of identified Persons: ". count($pdos) );
		
		// convert to beans
		foreach ($pdos as $pdo) {
			$beans[] = $this->pdoToBean($pdo);	
		}
		
		return $beans;
	}







	/**
	 * Returns all Persons for the given publication status, or 
	 * all "non-archived" Persons if the pubStates array is null.
	 * @param array pubStates An array of status keys (e.g. Published, Unpublished, Archived, etc.)
	 * @return Event[] or empty array if not found
	 */
	function getPersonsByPubState($pubStates=null)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getPersonsByPubState($pubStates)");
		
		$pdo = epManager::instance();
	
		$result = array();
		$criteria = array();
		if ( $pubStates == null || count($pubStates) == 0 ) {
			$find = "from Person as p where p.pubState is null or p.pubState.value != ? ";
			array_push($criteria,PublicationState::ARCHIVED);
		} else {
			$find = "from $Person as p where (";
			for( $i=0; $i<count($pubStates); $i++ )
			{
				$find .= '(p.pubState.value = "'. $pubStates[$i] .'" or ';		
			}
			$find .= 'p.pubState is null))';
		}
		$find .=  " order by name";
		$logger->debug("DB Query: $find");
		$logger->debug("DB Criteria: ". implode(',',$criteria));
		$result = $pdo->find($find,$criteria);	

		// Convert PDOs to Beans
		$listOfBeans = array();
		foreach($result as $pdo) 	{
			$listOfBeans[] = $this->pdoToBean($pdo);
		}
		return $listOfBeans;		
	}
	

	/**
	 * Creates a new Person using the given bean. 
	 *  
	 * @param bean The inbound Person as a scoped bean 
	 * @return The new Person as a Person bean
	 */
	function setup($bean)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setup($bean)");	

		$pdo = $this->beanToPdo($bean);

		// Commit the populated PDO	
		$epm = epManager::instance();	
		if (!($epm->commit($pdo))) {
			$logger->error("Unable to commit created person.");
		}
		
		return $this->pdoToBean($pdo);
	}

	/**
	 * Updates a Person
	 *  
	 * @param bean The inbound Person as a bean
	 * @return bean The modified Person
	 */
	function update($bean)
	{
		global $logger;
		$logger->debug(get_class($this) . "::update($bean)");

		if ($bean->getOid() == null) {
			trigger_error('Invalid Person: oid is missing', E_USER_ERROR);
			return;
		}
		$pdo = $this->beanToPdo($bean);
		$logger->debug("person pdo scope, name: ". $pdo->getScope() .", ". $pdo->getLastName());
		   
        // Commit the populated PDO	
        $epm = epManager::instance();
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to update $oid", E_USER_ERROR);
		}
		return $this->pdoToBean($pdo);
	}

	/**
	 * Retrieves the person by the given id, then invokes the
	 * native delete method on the PDO object.
	 * @param int The oid for the target category
	 * @return void
	 */
	 function delete($type='Artist',$oid)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::delete($oid)");
		
		if ($oid == null) {
			trigger_error("Required oid is missing", E_USER_ERROR);	
		}
		$person = $this->fetchPersonById($type,$oid);
		$person->delete();		
	 }
	
	/**
	 * Converts the given Person PDO to a bean object.
	 * This includes the conversion from nested lists
	 * of PDO objects to usable lists of oids/names to be used
	 * by the page renderer.
	 * 
	 * @access private
	 * @param pdo $pdo Person
	 * @return bean Person
	 */
	 private function pdoToBean($pdo)
	 {
		global $logger;
	  	$logger->debug(get_class($this) . "::pdoToBean($pdo)");
	
		// if this is an artist, be sure to get the artist PDO not the person
		$scope = $pdo->getScope();
		$id = $pdo->getOid();
		if ($scope == 'Artist') {
			$epm = epManager::instance();
			$pdo = $epm->get('Artist', $id);	
		}
		$bean = new $scope($pdo->epGetVars());

	  	// pubState to a string
	  	$ps = '';
	  	if ($pdo->getPubState() != null) {
	  		$ps = $pdo->getPubState()->getValue();	
	  	}
	  	$bean->setPubState($ps);
  	
	  	// if it is an artist, convert the exhibitions  	
	  	if (get_class($bean) == 'Artist') {

		  	$exhibitions = $pdo->exhibitions;

			if ($exhibitions) {
				$related = array();
				foreach ($exhibitions as $event) {
					$related[] = new Exhibition($event->epGetVars());
				}
				$bean->setExhibitions($related);
			}
	  	}
		return $bean;	
	 } 

	/** 
	 * A convenience method to convert the incoming bean
	 * to the corresponding PDO.  This includes all translations
	 * such as the nested PublicationSate.
	 * If the bean has an oid, then it will fetch the person,
	 * if the person id is null, a new pdo object will be returned.
	 * 
	 * @access private
	 * @param bean Person bean
	 * @return pdo Person PDO
	 */
	 private function beanToPdo($bean)
	 {
	 	global $logger;
	 	$logger->debug(get_class($this) . "::beanToPdo($bean)");
	 	
	 	// Check to see if there is a valid OID 
	 	if ($bean->getOid() > 0) {
	 		$pdo = $this->fetchPersonById(get_class($bean),$bean->getOid());
	 	} else {
	 		// Get a new event PDO
			$epm = epManager::instance();
			$pdo = $epm->create(get_class($bean));
	 	} 	

		// Copy the bean values over the top of the PDO values
		BeanUtil::copyBean($bean, $pdo);
					
		// Translate the pubState from string to object instance;
		$pubState = $this->fetchPubState($bean->getPubState());
		$pdo->setPubState($pubState);
	
		// Get the Exhibitions if an Artist
		if (get_class($bean) == Person::ARTIST) {
			$es = $this->getEventService();
			$exhibitions = $bean->getExhibitions();
			if ($exhibitions != null) {
				$epdos = array();		
				foreach ($exhibitions as $event) {
					$epdos[] = $es->fetchEventById('Exhibition',$event->getOid());
				}		
				$pdo->getExhibitions()->removeAll();
				$pdo->setExhibitions($epdos);
			}
		}
		
		return $pdo;
	 }

	/**
	 * Returns a Person PDO for the given oid.
	 * 
	 * @param string the type of person subclass (Artist)
	 * @param int oid the oid for the target person
	 * @return Person or empty array if not found
	 */
	 function fetchPersonById($personType='Artist', $oid) 
	 {
		global $logger;
	  	$logger->debug(get_class($this) . "::fetchPersonById($personType, $oid)");
		
		$epm = epManager::instance();
		$person = $epm->get($personType, $oid);
		
		if ($person === FALSE) {
			trigger_error("Invalid $personType: $oid not found", E_USER_ERROR);
			return;
		}
		if (is_array($personType) > 1) {
			trigger_error("Invalid $personType: ambiguous results for $oid", E_USER_ERROR);
			return;
		}
		$logger->debug("Returning person: ". get_class($person));
		return $person;
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
	 
	private function getEventService() 
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}
}