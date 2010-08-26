<?php
/**
 *  $Id$: FrontHomePageAction.php, Dec 5, 2006 9:12:40 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
require_once WEB_INF . '/base.include.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/Category.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/actions/MasterAction.php';
require_once WEB_INF . '/service/HomePageService.php';
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/service/AnnouncementService.php';

require_once ('tachometry/web/BaseAction.php');

class FrontHomePageAction extends MasterAction
{
	private $homepageService;
	private $eventService;
	private $enumeratedValueService;
	private $announcementService; 

	/**
	 * The default execute method.  
	 * @param Joomla mainframe object
	 * @return bean page model
	 */
	function execute($mainframe)
	{
echo "FRONT HOMEPAGE ACTION";
		global $logger;
		$logger->debug(get_class($this) . '::execute()');
		
		$model = new DetailPageModel();
		
		$hps = $this->getHomepageService();
		$hp = $hps->getCurrentHomePage();
		
		// load the galleries
		for($i=1;$i<10;$i++) {
			
			$getter = "getEvent". $i;
			$event = $hp->$getter();
			
			if ($event != null) {
				$setter = "setEvent". $i;
				$event = $this->setGallery($event,true); // in the MasterAction class
				
				$hp->$setter($event);
			}
		}		
		
		$model->setDetail($hp);
		
		// announcment
		$ans = $this->getAnnouncementService();
		$annc = $ans->getAnnouncement('Exhibition',true,true); // get any old announcment object, then pull the global
		$model->setAnnouncement($annc->getGlobal());
		
		return $model;		
	}
	
	
	
	private function getHomepageService() 
	{
		if ($this->homepageService == null) {
			$this->homepageService = new HomePageService();
		}
		return $this->homepageService;
	}
	
	private function getEventService() 
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}

	private function getEnumeratedValueService()
	{
		if ($this->enumeratedValueService == null) {
			$this->enumeratedValueService = new EnumeratedValueService();
		}
		return $this->enumeratedValueService;	
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
