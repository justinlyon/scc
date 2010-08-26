<?php
/**
 *  $Id$: FrontVenueAction.php, Nov 2, 2006 11:31:58 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
require_once WEB_INF . '/beans/Venue.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/service/VenueService.php';
require_once WEB_INF . '/actions/MasterAction.php';

class FrontVenueAction extends MasterAction
{
	private $venueService;
	
	/**
	 * The default execute method.  
	 * @param Joomla mainframe object
	 * @return bean page model
	 */
	function execute($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::execute()');
		return $this->detail($mainframe);
	}	
	
	
	/**
	 * Process the incoming request for the detailed
	 * view of the given Program oid
	 */
	public function detail($mainframe)
	{	
		global $logger;
		$logger->debug(get_class($this) . "::detail()");
		
		$vs = $this->getVenueService();
		$model = new DetailPageModel();
		
		// get the Venue bean
		$vnue = $vs->getVenueById($_REQUEST['oid']);
			
		// Gallery
		$vnue = $this->setGallery($vnue); // in the MasterAction class

		$model->setDetail($vnue);
		
		return $model;
	}
	

	private function getVenueService()
	{
		if ($this->venueService == null) {
			$this->venueService = new VenueService();
		}
		return $this->venueService;	
	}
	
} 
?>

