<?php
/**
 *  $Id$: FrontSeriesAction.php, Dec 6, 2006 4:26:08 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

require_once WEB_INF . '/actions/MasterAction.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/pages/MasterPage.php';


class FrontSeriesAction extends MasterAction
{
 	private $eventService;
	
	/**
	 * The default execute method. 
	 * 
	 * @param Joomla mainframe object
	 * @return bean page model
	 */
	function execute($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::execute()');
		return $this->summary($mainframe);
	}
	
	/**
	 * Process the incoming request for the summary
	 * view of published programs in the series.  
	 *
	 * @param object Joomla mainframe object
	 * @return bean SummaryPageModel
	 */
	public function summary($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::summary()');
		$model = new SummaryPageModel();

		$evs = $this->getEventService();

		// check for a sort preference
		if (isset($_REQUEST['sort'])) {
			$_SESSION['summary_sort'] = $_REQUEST['sort'];
		}
        
		// filter by series
		$model->setSeries("");
		$series_id = $_REQUEST['oid'];
		
		$logger->debug("Found a series filter with id: ". $series_id );
		
		$list = $evs->getEventsByPubState('Program',array('Published'),$series_id);

		// clean the list
		$mp = new MasterPage();
		$current = array();
		
		foreach ($list as $event) {

			$last = $mp->getLastActivity($event->getChildren());
			if ($last == NULL || $mp->isCurrent($last)) {
				// Gallery
				$event = $this->setGallery($event,true); // in the MasterAction class
				$current[] = $event;
			} 
		}
		
		// set the series name for the page title
		$cat = $evs->getCategoryById('Series',$series_id);
		$model->setSeries($cat);

		// announcement
		$model->setAnnouncement($this->getPublishedAnnouncement('Program',true));

		$model->setList($current);

		return $model;
	}
	
	private function getEventService()
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}

} 
?>

