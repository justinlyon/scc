<?php
/**
 *  $Id$: FrontHomePagePage.php, Dec 5, 2006 9:18:41 AM nchanda
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
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Category.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/web/BasePage.php');

class FrontHomePagePage extends MasterPage
{	
	/**
	 * The default render method.  Displays the summary list
	 * @param bean $model The exhibition summary model
	 */
	public function render($model)
	{
		global $logger, $mainframe;
		$logger->debug(get_class($this) . '::render()');	
		
		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'homepage_events.pat.tpl' );	
		
		$title = HOMEPAGE_TITLE;		
		$mainframe->setPageTitle($title);
		
		$tmpl->addVar('intro','title',$title);
		if ($model->getAnnouncement() != null) {
			$tmpl->addVar('intro','announcement',$model->getAnnouncement());
		}
		
		$hp = $model->getDetail();
		// cycle through the 9 slots
		for ($i=1; $i<10; $i++) {
			
			$getter = "getEvent". $i;
			$event = $hp->$getter();
			
			// if there is a published event in the slot, render it
			$time_display = null;
			$genre = null;
			$ticket = null;
					
			if ($event != null && $event->getPubState() == PublicationState::PUBLISHED) {
					
				// load the image
				$gallery = $event->getGallery();
				$images = $gallery->getImages();
				$image = $images[0];
				$img_src = "";
				$img_alt = $event->getTitle();
				if ($image != null) {
					$img_src = $image->getUrl();
					$img_alt = ($image->getTitle() != null ) ? $images[0]->getTitle() : $event->getTitle();
				}
				
				// set the differences between event types
				if (get_class($event) == Event::EXHIBITION) {
					
					// set the genre
					$genre = Event::EXHIBITION;
					
					// figure the proper link url
					$elink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=exbt&task=detail&ccmenu=v2hhdcdzie9u&oid=". $event->getOid());
				
					// get the time 
					if ($event->getScheduleNote()) {
						$time_display = $event->getScheduleNote();
					} else {
						$schedule = $event->getSchedule();
						if ($schedule != null) {
							$time_display = $this->formatDate($schedule->getStartTime());
							if ($schedule->getEndTime() > 0) {
								$time_display .= $this->formatDate($schedule->getEndTime());	
							}
						}
					}
					
					// get the status/tickets image
					$ticket = $this->getStatusImage($event->getEventStatus(), $event->getTicketUrl());					
					
				} else {
					
					// genre
					if ($event->getPrimaryGenre() != null) {
						$genre = $event->getPrimaryGenre()->getName();
					}
					
					// figure the proper link url
					if (get_class($event) == Event::PROGRAM) {
						$elink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=prgm&task=detail&ccmenu=v2hhdcdzie9u&oid=". $event->getOid());
					} else if (get_class($event) == Event::COURSE) {
						$elink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=crse&task=summary&filter=Genre&fid=". $event->getPrimaryGenre()->getOid(),  $event->getOid());	
					}

					// actvity level items
					if ($event->getScheduleNote()) {
						$time_display = $event->getScheduleNote();
					} else {
						$acts = $event->getChildren();
						$next_act = $this->getNextActivity($acts);
						
						if ($next_act != null) {
							$schedule = $next_act->getSchedule();
							if ($schedule != null) {
								$time_display = $this->formatDate($schedule->getStartTime());
							}					
						
							if ($next_act->getActivityStatus() != null) {
								// get the ticket code
						 		$tc = null;
						 		if ($next_act->getTicketCode() != null) {
						 			$tc = $next_act->getTicketCode();
						 		} else {
						 			$tc = $event->getTicketUrl();
						 		}
								
								$ticket = $this->getStatusImage($next_act->getActivityStatus()->getValue(), $next_act->getTicketCode());	
							}
						}
					}
				}
				
				
				// load the template
				$tmpl->addVar('event','title',$event->getTitle());
				$tmpl->addVar('event','img_src',$img_src);
				$tmpl->addVar('event','img_alt',$img_alt);
				$tmpl->addVar('event','genre',$genre);
				$tmpl->addVar('event','event_link', $this->cceventSefUrl($elink));
				$tmpl->addVar('event','time',$time_display);
				$tmpl->addVar('event','status_img',$ticket);
				$tmpl->parseTemplate('event',"a");
				
			}
		}
				
		$tmpl->displayParsedTemplate( 'homepage' );
		
		// set the request for css ids and classes
		$_REQUEST['cce_scope'] = "home"; // css file name / body id
		$_REQUEST['cce_page'] = "welcome"; // body class
		$_REQUEST['cce_cols'] = "3"; // canvas div id
		$_REQUEST['cce_subtype'] = "home"; // canvas div class
	}
} 
?>

