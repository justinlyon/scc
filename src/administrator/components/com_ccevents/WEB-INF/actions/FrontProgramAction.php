<?php
/**
 *  $Id$: FrontProgramAction.php, Oct 5, 2006 10:12:04 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 *
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

require_once WEB_INF . '/actions/MasterAction.php';
require_once WEB_INF . '/beans/Program.php';
require_once WEB_INF . '/beans/Event.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/service/GalleryService.php';
require_once WEB_INF . '/service/EventService.php';
require_once WEB_INF . '/service/CategoryService.php';
require_once WEB_INF . '/service/JoomlaContentService.php';
require_once WEB_INF . '/service/ScheduleService.php';
require_once WEB_INF . '/pages/MasterPage.php'; // for the getNextActivity method

require_once ('tachometry/web/BaseAction.php');


class FrontProgramAction extends MasterAction
{
	private $eventService;
	private $categoryService;
	private $scheduleService;
	private $joomlaContentService;
	private $enumeratedValueService;

	/**
	 * The default execute method.
	 * @param Joomla mainframe object
	 * @return bean page model
	 */
	function execute($mainframe=null)
	{
		global $logger;
		$logger->debug(get_class($this) . '::execute()');
		return $this->summary($mainframe);
	}

	/**
	 * Process the incoming request for the detailed
	 * view of the given Program oid
	 */
	public function detail($mainframe=null)
	{
		// If there is not an oid in the request, redirect to the summary
		if (!isset($_REQUEST['oid'])) {
			$this->summary();
		}

		$es = $this->getEventService();
		$jcs = $this->getJoomlaContentService();
		$model = new DetailPageModel();

		// get the Program bean
		$prgm = $es->getEventById('Program',$_REQUEST['oid']);

		// get the gallery
		$prgm = $this->setGallery($prgm, false, false); // in the MasterAction class
		
		// get the related content
		$articles = array();
		if ($prgm->getRelatedArticles()) {
			$articles = $jcs->getArticlesByCategory($prgm->getRelatedArticles());
			$prgm->setRelatedArticles($articles);
		}

		// get the comments
		$comments = array();
		if ($prgm->getCommentArticle()) {
			$comments = $jcs->getFeaturedComments($prgm->getCommentArticle());
			$prgm->setCommentArticle($comments);
		}

		$model->setDetail($prgm);

		return $model;
	}

	/**
	 * Process the incoming request for the summary
	 * view of published programs.  If a filter is
	 * applied, the sub-set of published programs will
	 * be displayed.
	 *
	 * @param object Joomla mainframe object
	 * @return bean SummaryPageModel
	 */
	public function summary($mainframe=null)
	{
		global $logger;
		$logger->debug(get_class($this) . '::summary()');
		$model = new SummaryPageModel();

		$evs = $this->getEventService();
		$cs = $this->getCategoryService();

		// check for a sort preference
		if (isset($_REQUEST['sort'])) {
			$_SESSION['summary_sort'] = $_REQUEST['sort'];
		}

		// check for a filter
		$model->setGenre("");
		if (isset($_REQUEST['filter']) && isset($_REQUEST['fid'])) {
			$logger->debug("Found a filter with id: ". $_REQUEST['fid'] );
			$list = $evs->getEventsByPubState('Program',array('Published'),$_REQUEST['fid']);
			
			// set the genre for the page title
			if (count($list) > 0 ) {
				$model->setGenre($cs->getCategoryById($_REQUEST['fid']));
			}
			
		} else {
			$list = $evs->getEventsByPubState('Program',array('Published'));
			// set the genre for the page title
			if (count($list) > 0 ) {
				$model->setGenre($list[0]->getPrimaryGenre());
			}
		}

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
	public function overview($mainframe=null)
	{
		global $logger;
		$logger->debug(get_class($this) . '::overview()');
		
		$model = new SummaryPageModel();
		$es = new EventService();
		$genres = array();
		$events = $es->getEventsByPubState('Program',array('Published'));
	
		foreach($events as $prgm) {
			$pg = $prgm->getPrimaryGenre();
				
			// Check to see if we are looking for school-related programs (not expected)
			$school = isset($_REQUEST['school']) ? $school : null;
			
			// add only the proper type (public or school)
			if ($pg && $pg->getSchool() == $school) {
				// only add it to the list once
				if (isset($genres[$pg->getOid()])) {
					continue;
				} else {
					$genres[$pg->getOid()] = $pg;
				}
			}
		}
		$model->setList($genres);
		
		// announcement
		$model->setAnnouncement($this->getPublishedAnnouncement('Program'));

		return $model;
	}


	/**
	 * Returns the model for the featured programs  
	 *
	 * @param object Joomla mainframe object
	 * @return bean SummaryPageModel
	 */
	public function featured($mainframe=null)
	{
		global $logger;
		$logger->debug(get_class($this) . '::featured()');
		$model = new SummaryPageModel();
		
		$evs = $this->getEventService();
		$events = $evs->getFeatured(Event::PROGRAM, true);
		
		$ss = $this->getScheduleService();
		$results = array();
		foreach($events as $event) {
			// get the gallery
			$event = $this->setGallery($event, true, true); // in the MasterAction class
			
			// get the performaces
			$performances = $ss->getActivities(Event::PROGRAM, $event->getOid());
			$event->setChildren($performances);	
		}		
		$model->setList($events);
		$model->setAnnouncement($this->getPublishedAnnouncement(Event::PROGRAM));
		
		return $model;
	}




	
	/**
	 * A sample detail bean for use in rendering the template.
	 * If a program is supplied, it will copy thevalues of the
	 * given bean over the top of the demo bean.
	 * @return
	 */
	private function getDemoProgramDetail($prgm)
	{
		require_once WEB_INF . '/beans/Performance.php';
		require_once WEB_INF . '/beans/Schedule.php';
		require_once WEB_INF . '/beans/Venue.php';

		global $logger;
		$logger->debug(get_class($this) . "::getDemoProgramDetail($prgm)");

		$bean = new Program();
		$bean->setTitle("Demo Program Detail Bean");

		$desc = "<p>This is a description of the program. Malian Grammy Award nominee Mamadou Diabate is a virtuoso kora player descended from a long line of Manding musician-storytellers. Dolor dignissim exerci feugiat. Lobortis ut, luptatum facilisis. Augue volutpat facilisis at, eum consequat adipiscing accumsan blandit molestie. </p>
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


		if (get_class($prgm) == 'Program') {
			$prgm->setPerformances(null);
			$option = new CopyBeanOption();
			$option->setIgnoreNullValues(true);
			BeanUtil::copyBean($prgm,$bean,$option);
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

	private function getCategoryService()
	{
		if ($this->categoryService == null) {
			$this->categoryService = new CategoryService();
		}
		return $this->categoryService;
	}
	
	private function getEnumeratedValueService()
	{
		if ($this->enumeratedValueService == null) {
			$this->enumeratedValueService = new EnumeratedValueService();
		}
		return $this->enumeratedValueService;
	}
	
	private function getJoomlaContentService()
	{
		if ($this->joomlaContentService == null) {
			$this->joomlaContentService = new JoomlaContentService();
		}
		return $this->joomlaContentService;
	}
	
	private function getScheduleService()
	{
		if ($this->scheduleService == null) {
			$this->scheduleService = new ScheduleService();
		}
		return $this->scheduleService;
	}
}
?>

