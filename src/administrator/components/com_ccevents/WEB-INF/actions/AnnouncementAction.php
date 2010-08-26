<?php
/**
 *  $Id$: AnnouncementAction.php, Oct 23, 2006 12:55:31 PM nchanda
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
require_once WEB_INF . '/service/AnnouncementService.php';
require_once WEB_INF . '/actions/MasterAction.php';
require_once WEB_INF . '/beans/Announcement.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/beans/PublicationState.php';

require_once ('tachometry/web/BaseAction.php');
require_once ('tachometry/util/CopyBeanOption.php');

class AnnouncementAction extends MasterAction
{ 
	private $announcementService;
	
	/**
	 * The default method if no task is given. Will return an initialized 
	 * summary page model bean.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean summary page model bean
	 */
	function execute($mainframe)
	{
		global $logger;
        $logger->debug(get_class($this) . "::execute()");
		return $this->setSummary($mainframe);
	}
	
	function save($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::save()");
		$form = $this->getBeanFromRequest();
		$this->update($form);	
		return $this->setSummary($mainframe);
	}
	
	function apply($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::apply()");
		$form = $this->getBeanFromRequest();
		$this->update($form);
		return $this->setSummary($mainframe);
	}
	
	/**
	 * Gets a list of announcments.  
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the venues summary page model bean
	 */	
	private function setSummary($mainframe) {
		global $logger;
		$logger->debug(get_class($this) . "::setSummary()");
		
		$model = new SummaryPageModel();
		$scopeList = array('Global','Exhibition','Program','Course','Venue');
		$as = $this->getAnnouncementService();
		$notice = array();
		
		foreach($scopeList as $scope) {
			$notice[$scope] = $as->getAnnouncement($scope);	
		}
		$model->setList($notice);
		return $model;
	}
	 

	/**
	 * Updates the announcements in the incoming form.
	 * 
	 * @param array The array of Announcment beans from the form
	 * @return void
	 */
	private function update($beans) 
	{
		global $logger;
		$logger->debug(get_class($this) . "::update($beans)");
		
		$as = $this->getAnnouncementService();

		foreach($beans as $annc) {
			$as->update($annc);
		}			
	}

	 
	/**
	 * Gets the list of announcment beans from the request
	 * 
	 * @return array of announcment beans
	 */
	private function getBeanFromRequest() {
		$sections = array('Global','Exhibition','Program','Course','Venue');
		$beans = array();
		
		foreach($sections as $scope) {
			$bean = new Announcement();
			
			$pub_key = $scope ."_published";
			$oid_key = $scope ."_oid";
			$bean->setPublished($_REQUEST[$pub_key]);
			$bean->setOid($_REQUEST[$oid_key]);
			$bean->setScope($scope);	
			$bean->setContent($_REQUEST[$scope]);
			
			$beans[$scope] = $bean; 
		}
	
		return $beans;	
	}
	
	
	private function getAnnouncementService() 
	{
		if ($this->announcementService == null) {
			$this->announcementService = new AnnouncementService();
		}
		return $this->announcementService;
	}
	
	
	
	

} 
?>
