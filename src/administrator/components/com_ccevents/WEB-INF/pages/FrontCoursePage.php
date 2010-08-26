<?php
/**
 *  $Id$: FrontCoursePage.php, Oct 5, 2006 10:11:14 AM nchanda
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

require_once WEB_INF . '/pages/MasterPage.php';
require_once WEB_INF . '/beans/Course.php';

require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/web/BasePage.php');

class FrontCoursePage extends MasterPage
{
	/**
	 * The default render method.  Displays the summary list
	 * @param bean $model The exhibition summary model
	 */
	public function render($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::render()');
		$this->summary($model);
	}

	/**
	 * Displays the course summary
	 * @param bean $model The course summary model
	 */
	public function summary($model)
	{
		global $logger, $mainframe, $mosConfig_livesite;
		$logger->debug(get_class($this) . "::summary($model)");

		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'course_summary.pat.tpl' );
		$tmpl->addGlobalVar('live_site', $mosConfig_livesite);
		$tmpl->addGlobalVar('shop_menu', strtolower(base64_encode('shop')));

		// page title
		$pg_title = "Course Summary";
		if ($model->getGenre()) {
			$pg_title = $model->getGenre()->getName();
			
			if ($model->getGenre()->getIntroduction() != null) {
				$tmpl->addVar('intro','introduction',$model->getGenre()->getIntroduction());
			}
		}
		$mainframe->setPageTitle($pg_title);
		$tmpl->addVar('intro','title',$pg_title);
				
		$eventList = $model->getList();
		usort($eventList,array('FrontCoursePage','sort_by_date'));
		
		$first = true;		
		foreach($eventList as $event) {
		
			$tmpl->clearVar('course','venue');
			$tmpl->clearVar('course','sessions');
			$tmpl->clearVar('course','pricing');
		
		
			// simple attributes
			$tmpl->addVars('course', BeanUtil::beanToArray($event,true)); // scalars only
			
			$first_class = $first ? ' first' : '';
			$tmpl->addVar('course', 'first_class', $first_class);
			$first = false;


			// image
			if ($event->getGallery() != null) {
				$images = $event->getGallery()->getImages();
				if ($images != null && $images[0] != null) {
					$img = $images[0];
					$logger->debug('Class of img [Image]: '. get_class($img));
					$tmpl->addVar('course','imageurl',$img->getUrl());
					$tmpl->addVar('course','imagecredit',$img->getAuthor());
				}
			}
			
			// venue
			$venues = $event->getVenues();
			$dv = isset($venues[0]) ? $venues [0] : null;
			if ($dv != null) {
				$dv_link = $this->getVenueTitleLink($dv); // in the MasterPage
				$tmpl->addVar('course','venue',$dv_link);
			}
		
			// date description (Use scheduleNote or next activity time
			$date_desc = '';
			if ($event->getScheduleNote() != null) {
				$date_desc = $event->getScheduleNote();	
			} else {
				$next = $this->getNextActivity($event->getChildren());
				if ($next != null && $next->getSchedule() != null) {
					$date_desc = $this->formatDate($next->getSchedule()->getStartTime());	// in the master page class
				}
			}
			$tmpl->addVar('course','date_desc',$date_desc);
			
			// sessions
			if ($event->getChildren() != null) {
				$sessions = count($event->getChildren());
				$ss = ' session';
				if ($sessions > 1) {
					$ss = ' sessions';
				}
				$tmpl->addVar('course','sessions', $sessions . $ss);	
			}
			
			// registration link
			if ($event->getProduct() != null && $event->getProduct()->getOid() != null) {
				$prod = $event->getProd();
				$reg_link = cceventSefUrl("index.php?option=com_virtuemart&page=shop.product_details&category_id=". $prod->getCategoryId() ."&flypage=". $prod->getFlypage() ."&product_id=". $prod->getOid());
				$tmpl->addVar('course','register_link',$reg_link);	
			}
			
			$tmpl->parseTemplate('course',"a");
		}

		$tmpl->displayParsedTemplate( 'course_summary' );
		
		// set the request for css ids and classes
		$_REQUEST['cce_cols'] = "2"; // canvas div id
		$_REQUEST['cce_subtype'] = "general"; // canvas div class
		$_REQUEST['ccmenu'] = isset($_REQUEST['ccmenu']) ? $_REQUEST['ccmenu'] : ''; // menu
	}


	/**
	 * Displays the what's on overview (list of published genres)
	 * @param bean $model The course summary model
	 */
	public function overview($model)
	{
		global $logger, $mainframe;
		$logger->debug(get_class($this) . "::overview($model)");

		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'course_overview.pat.tpl' );


		// page title
		$pg_title = "Learning For Life Overview";
		$mainframe->setPageTitle($pg_title);
		$tmpl->addVar('intro','title',$pg_title);
		
		if ($model->getAnnouncement() != null) {
			$tmpl->addVar('intro','announcement',$model->getAnnouncement());
		}
				
		$eventList = $model->getList();
		
		// TODO: sort by primary genre\
		$pgs = array();
		foreach($eventList as $event) {
			$pgs[] = $event->getPrimaryGenre();	
		}
		array_multisort($pgs,$eventList);
				
		// a temporary place to hold a comparison operator for group headings
		$prev_category_name = "";
		$first = true;
		foreach($eventList as $event) {

			// check group order for series and audience groupings
			$tmpl->setAttribute('group','visibility','hidden');
			$sort_name = $event->getPrimaryGenre()->getName();
			if ($sort_name != $prev_category_name) {
				$tmpl->addVar('group','group_heading',$sort_name);
				$tmpl->setAttribute('group','visibility','visible');
				$prev_category_name = $sort_name;
				$first = true;
			}		

			// simple attributes
			$tmpl->addVars('course', BeanUtil::beanToArray($event,true)); // scalars only
			$first_class = $first ? ' first' : '';
			$tmpl->addVar('course', 'first_class', $first_class);
			$first = false;

			// detail link
			$dlink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=crse&task=summary&filter=Genre&fid=". $event->getPrimaryGenre()->getOid(), $event->getOid());
			$tmpl->addVar('course','detail_link',$dlink);			
			
			// venue
			$venues = $event->getVenues();
			$dv = isset($venues[0]) ? $venues [0] : null;
			if ($dv != null) {
				$dv_link = $this->getVenueTitleLink($dv); // in the MasterPage
				$tmpl->addVar('course','venue',$dv_link);
			}
		
			// date description (Use scheduleNote or next activity time
			$date_desc = '';
			if ($event->getScheduleNote() != null) {
				$date_desc = $event->getScheduleNote();	
			} else {
				$next = $this->getNextActivity($event->getChildren());
				if ($next != null && $next->getSchedule() != null) {
					$date_desc = $this->formatDate($next->getSchedule()->getStartTime());	// in the master page class
				}
			}
			$tmpl->addVar('course','date_desc',$date_desc);
			
			// sessions
			if ($event->getChildren() != null) {
				$sessions = count($event->getChildren());
				$ss = ' session';
				if ($sessions > 1) {
					$ss = ' sessions';
				}
				$tmpl->addVar('course','sessions', $sessions . $ss);	
			}


			$tmpl->parseTemplate('course',"a");
		}

		$tmpl->displayParsedTemplate( 'course_overview' );
		
		// set the request for css ids and classes
		$_REQUEST['cce_cols'] = "2"; // canvas div id
		$_REQUEST['cce_subtype'] = "general"; // canvas div class
		$_REQUEST['ccmenu'] = isset($_REQUEST['ccmenu']) ? $_REQUEST['ccmenu'] : ''; // menu
	}
}
?>

