<?php
/**
 *  $Id$: FrontCourseAction.php, Oct 5, 2006 10:12:04 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 *
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

require_once WEB_INF . '/actions/MasterAction.php';
require_once WEB_INF . '/beans/Course.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/service/ProductService.php';
require_once WEB_INF . '/pages/MasterPage.php';

require_once ('tachometry/web/BaseAction.php');


class FrontCourseAction extends MasterAction
{
	private $eventService;
	private $productService;

	/**
	 * The default execute method.
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
	 * There is no real detailed view for the course.
	 * Process the detail oid to find the genre, then call
	 * the summary method
	 */
	public function detail($mainframe)
	{
		$evs = $this->getEventService();
		$event = $evs->getEventById('Course',$_REQUEST['oid']);
		
		$_REQUEST['filter'] = 'Genre';
		$_REQUEST['fid'] = $event->getPrimaryGenre()->getOid();
		
		$this->summary($mainframe);		
	}

	/**
	 * Process the incoming request for the summary
	 * view of published courses.  If a filter is
	 * applied, the sub-set of published courses will
	 * be displayed.
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
		$ps = $this->getProductService();

		// check for a sort preference
		if (isset($_REQUEST['sort'])) {
			$_SESSION['summary_sort'] = $_REQUEST['sort'];
		}

		// check for a filter
		$model->setGenre("");
		if (isset($_REQUEST['filter']) && isset($_REQUEST['fid'])) {
			$logger->debug("Found a filter with id: ". $_REQUEST['fid'] );
			$list = $evs->getEventsByPubState('Course',array('Published'),$_REQUEST['fid']);
			
			// set the genre for the page title
			if (count($list) > 0 ) {
				$model->setGenre($list[0]->getPrimaryGenre());
			}
			
		} else {
			$list = $evs->getEventsByPubState('Course',array('Published'));
		}

		$current = array();
		foreach ($list as $event) {
			// Gallery
			$event = $this->setGallery($event,true); // in the MasterAction class
			$current[] = $event;
		}

		$model->setList($current);

		return $model;
	}

	/**
	 * Process the incoming request for the overview
	 * view of published primary genres.  
	 *
	 * @param object Joomla mainframe object
	 * @return bean SummaryPageModel
	 */
	public function overview($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::overview()');
		
		$model = new SummaryPageModel();
		$es = new EventService();
		$courses = array();
		$events = $es->getEventsByPubState('Course',array('Published'));
		
		foreach($events as $crse) {
			$pg = $crse->getPrimaryGenre();
						
			// Check to see if we are looking for school-related courses (not expected)
			$school = isset($_REQUEST['school']) ? $school : null;
			
			// add only the proper type (public or school) 
			if ($pg->getSchool() == $school) {
				$courses[] = $crse;				
			}
		}
		$model->setList($courses);
		
		// announcement
		$model->setAnnouncement($this->getPublishedAnnouncement('Course',false));

		return $model;
	}
	
	/**
	 * A sample detail bean for use in rendering the template.
	 * If a course is supplied, it will copy thevalues of the
	 * given bean over the top of the demo bean.
	 * @return
	 */
	private function getDemoCourseDetail($crse)
	{
		require_once WEB_INF . '/beans/Performance.php';
		require_once WEB_INF . '/beans/Schedule.php';
		require_once WEB_INF . '/beans/Venue.php';

		global $logger;
		$logger->debug(get_class($this) . "::getDemoCourseDetail($crse)");

		$bean = new Course();
		$bean->setTitle("Demo Course Detail Bean");

		$desc = "<p>This is a description of the course. Malian Grammy Award nominee Mamadou Diabate is a virtuoso kora player descended from a long line of Manding musician-storytellers. Dolor dignissim exerci feugiat. Lobortis ut, luptatum facilisis. Augue volutpat facilisis at, eum consequat adipiscing accumsan blandit molestie. </p>
				 <p>Lobortis eros at hendrerit luptatum consequat feugiat ut facilisi commodo esse autem consequat at ex ullamcorper hendrerit wisi, commodo nostrud nisl wisi eum autem eu esse eu iriure. Tation, magna ad nibh at eum, ea praesent eum lorem eu erat enim commodo dolore?</p>
 				 <p>Crisare enim sed ex eros hendrerit blandit illum qui sciurus autem nulla enim luptatum. Quis enim eum feugait elit blandit, hendrerit consequat, velit ut luptatum nostrud wisi ea. Dignissim consequat dolore aliquam eum volutpat, wisi dolore et exerci nisl veniam luptatum ut ullamcorper consequatvel nulla delenit.</p>
				";

		$bean->setDescription($desc);
		$bean->setPrimaryGenre("Music");

		// Performances
		$perf = new Performance();
		$schd = new Schedule();
		$schd->setStartTime(time());
		$perf->setSchedule($schd);
		$logger->debug("Performance time: ". $perf->getSchedule()->getStartTime());
		$perf->setTicketCode("21");
		$bean->setChildren(array($perf));
		$logger->debug("Number of set performaces: ". count($bean->getChildren()));

		// Venues
		$v1 = new Venue();
		$v1->setName('Hurd Gallery');
		$bean->setDefaultVenue($v1);


		if (get_class($crse) == 'Course') {
			$crse->setPerformances(null);
			$option = new CopyBeanOption();
			$option->setIgnoreNullValues(true);
			BeanUtil::copyBean($crse,$bean,$option);
		}

		return $bean;
	}

	private function getEventService()
	{
		if ($this->eventService == null) {
			$this->eventService = new EventService();
		}
		return $this->eventService;
	}

	private function getProductService()
	{
		if ($this->productService == null) {
			$this->productService = new ProductService();
		}
		return $this->productService;
	}
}
?>
