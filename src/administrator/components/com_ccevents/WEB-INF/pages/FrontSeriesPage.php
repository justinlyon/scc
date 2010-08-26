<?php
/**
 *  $Id$: FrontSeriesPage.php, Dec 6, 2006 4:46:51 PM nchanda
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

class FrontSeriesPage extends MasterPage
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
	 * Displays the series summary
	 * @param bean $model The series summary model
	 */
	public function summary($model)
	{
		global $logger, $mainframe;
		$logger->debug(get_class($this) . "::summary($model)");

		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'series_summary.pat.tpl' );

		// page title + description
		$pg_title = "Series";
		if ($model->getSeries()) {
			$pg_title = $model->getSeries()->getName();
			$tmpl->addVar('series','description',$model->getSeries()->getDescription());
		}
		$mainframe->setPageTitle("Program Series | ". $pg_title);
		$tmpl->addVar('intro','title',$pg_title);
		
		// announcment
		if ($model->getAnnouncement() != null) {
			$tmpl->addVar('intro','announcement',$model->getAnnouncement());
		}
		

			
		
		$eventList = $model->getList();
		usort($eventList,array('FrontSeriesPage','sort_by_date'));		
		foreach($eventList as $event) {

			// simple attributes
			$tmpl->addVars('program', BeanUtil::beanToArray($event,true)); // scalars only

			// primary genre
			$pg = $event->getPrimaryGenre();
			if ($pg != null) {
				$tmpl->addVar('program', 'genre', $pg->getName() );
			}

			// activity level items
			$acts = $event->getChildren();
			$next_act = $this->getNextActivity($acts);
            $time_display = "";
					
			if ($next_act != null) {
				$schedule = $next_act->getSchedule();
				if ($schedule != null) {
//					$time_display = strftime("%A, %B %d, %I:%M %p ",$schedule->getStartTime());
                    $time_display = date("l, F j, g:i a",$schedule->getStartTime());
				}					
					
				if ($next_act->getActivityStatus() != null) {
					 // get the ticket code
					 $tc = null;
					 if ($next_act->getTicketCode() != null) {
					 	$tc = $next_act->getTicketCode();
					 } else {
					 	$tc = $event->getTicketUrl();
					 }
					 $ticket = $this->getStatusImage($next_act->getActivityStatus()->getValue(), $tc);	
				}
			}
			$tmpl->addVar('program','time',$time_display);
			$tmpl->addVar('program','status_img',$ticket);		

			// audience
			$tmpl->clearTemplate('show_audience');
			$tmpl->clearTemplate('audience');
			$family = false;
			$cats = $event->getCategories();
			if (isset($cats[Category::AUDIENCE])) {
				foreach( $cats[Category::AUDIENCE] as $aud) {
					if ($aud->getFamily()) {
						$family = true;
					}
					$tmpl->addVar('audience','name',$aud->getName());
					$tmpl->parseTemplate('audience','a');
					$tmpl->setAttribute( "show_audience", "visibility", "visible" );
				}
			}
			$tmpl->addVar('program','family',$family);

			// image
			if ($event->getGallery() != null) {
				$images = $event->getGallery()->getImages();
				$logger->debug('Number of images [1]: '. count($images));
				$img = $images[0];
				$logger->debug('Class of img [Image]: '. get_class($img));
				$tmpl->addVar('program','imageurl',$img->getUrl());
				$tmpl->addVar('program','imagecredit',$img->getAuthor());
			}


			$tmpl->parseTemplate('program',"a");
		}

		$tmpl->displayParsedTemplate( 'series' );
		
		// set the request for css ids and classes
		$_REQUEST['cce_scope'] = "programs"; // css file name / body id
		$_REQUEST['cce_page'] = ""; // body class
		$_REQUEST['cce_cols'] = "3"; // canvas div id
		$_REQUEST['cce_subtype'] = "general"; // canvas div class
	}	
	
} 
?>
