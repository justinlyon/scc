<?php
/**
 *  $Id$: FrontProgramPage.php, Oct 5, 2006 10:11:14 AM nchanda
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
require_once WEB_INF . '/beans/Program.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/web/BasePage.php');

class FrontProgramPage extends MasterPage
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
	 * Displays the program detail
	 * @param bean $model The program detail model
	 */
	public function detail($model)
	{
		global $logger, $mainframe;
		$logger->debug(get_class($this) . "::detail($model)");

		$event = $model->getDetail();
		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'program_detail.pat.tpl' );

		if ($model->getAnnouncement() != null) {
			$tmpl->addVar('intro','announcement',$model->getAnnouncement());
		}

		// simple attributes
		$tmpl->addVars('program', BeanUtil::beanToArray($event,true)); // scalars only
        
		// page title
		$pt = "";
		if ( $event->getPrimaryGenre() ) {
			$genre = $event->getPrimaryGenre();
			$tmpl->addVar('program','genre',$genre->getName());
			$pt .= $genre->getName() ." | ";
		}
		$mainframe->setPageTitle($pt . $event->getTitle());

		// gallery images
		if ($event->getGallery() != null) {
			$images = $event->getGallery()->getImages();
			$logger->debug('Number of images: '. count($images));
			foreach($images as $img) {
				$tmpl->addVar('photo','imageurl',$img->getUrl());
				$tmpl->addVar('photo','caption',$img->getAuthor());
				$tmpl->parseTemplate('photo','a');
			}
		}

                // Determine if there should be an column for images or media links...
                  if ($event->audioClip || $event->videoClip || (count($images)>0))  {
                   $tmpl->addVar('mediacolumn','display',true);
                } 

		// venues
		$logger->debug("Number of venues for event ID ". $event->getOid() .": ". count($event->getVenues()));
		if ($event->getVenues() != null) {
			$tmpl->clearTemplate('venues');
			$logger->debug("type of venue collection [array]: ". gettype($event->getVenues()));

			foreach ( $event->getVenues() as $venue ) {
				$logger->debug("Venue is of class [Venue]: ". get_class($venue));
				$vlink = $this->getVenueTitleLink($venue);
				$tmpl->addVar('venues','venue_link',$vlink);
				$tmpl->parseTemplate('venues',"a");
			}
		}

		// performances (load in array, then sort by start time)
		$logger->debug("Number of performances: ". count($event->getChildren()));
		$perfs = array();
		$sts = array();
        // Track whether a performance has a ticket code, sold out, cancelled, etc.
        $show_dates = false;
		foreach($event->getChildren() as $perf) {
			$logger->debug("Performance is of class: ". get_class($perf));
			//tickets
			if ($perf->getActivityStatus() != null) {
				 // get the ticket code
				 $tc = null;
				 if ($perf->getTicketCode() != null) {
				 	$tc = $perf->getTicketCode();
				 } else {
				 	$tc = $event->getTicketUrl();
				 }
				 $ticket = $this->getStatusImage($perf->getActivityStatus()->getValue(), $tc);	
			}
            if(!empty($ticket))   {
                $show_dates = true;
            }
                 

			$perfs[] = array('starttime'=>$perf->getSchedule()->getStartTime(),'status_image'=>$ticket);
			$sts[] = $perf->getSchedule()->getStartTime();
		}
		array_multisort($sts, SORT_ASC, $perfs);
		
		foreach($perfs as $perf) {
					
			$time_display = date("l, F j, g:i a",$perf['starttime']);
			$tmpl->addVar('performance','time',$time_display);
			$tmpl->addVar('performance','status_image',$perf['status_image']);
			$tmpl->parseTemplate( 'performance','a' );
		}
        // If any performance has a ticket code or a note, show all performances.
        // If there is a date override and there are NO perfs with notes, etc. show date override
        if($show_dates || $event->getScheduleNote() == '')  {
            $tmpl->addVar('program','show_dates',true);
        }   else    {
            $tmpl->addVar('program','time_display', $event->getScheduleNote());
        }
            
		// audience
		$tmpl->clearTemplate('show_audience');
		$tmpl->setAttribute('show_audience','visibility','hidden');
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
		
		// series
		$tmpl->clearTemplate('series');
		if (isset($cats[Category::SERIES])) {
			foreach( $cats[Category::SERIES] as $ser) {
				$slink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=sers&task=summary&oid=". $ser->getOid() );
				$tmpl->addVar('series','series_link', $slink);
				$tmpl->addVar('series','name',$ser->getName());
				$tmpl->parseTemplate('series','a');
				$tmpl->setAttribute( "series", "visibility", "visible" );
				
				// related events
				$tmpl->setAttribute( "series_related", "visibility", "hidden" );
				$revents = $ser->getEvents();
				
				if (isset($revents) && count($revents) > 0) {
					foreach ($revents as $sprg) {
						$plink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=prgm&task=detail&oid=". $sprg->getOid() );
						$tmpl->addVar('related','prgm_link', $plink);
						$tmpl->addVar('related','title', $sprg->getTitle());
						$tmpl->addVar('related','starttime',time());
						$tmpl->parseTemplate('related','a');
						$tmpl->setAttribute( "series_related", "visibility", "visible" );	
					}
				}
			}
		}
		
		// exhibitions
		$tmpl->setAttribute( "exhibition", "visibility", "hidden" );
		$rexbt= $event->getExhibitions();
		if (isset($rexbt) && count($rexbt) > 0) {
			foreach ($rexbt as $exbt) {
				$elink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=exbt&task=detail&oid=". $exbt->getOid() );
				$tmpl->addVar('exhibit','exbt_link', $elink);
				$tmpl->addVar('exhibit','title',$exbt->getTitle());
				$tmpl->parseTemplate('exhibit','a');
				$tmpl->setAttribute( "exhibition", "visibility", "visible" );		
			}	
		}
		
		$tmpl->displayParsedTemplate( 'program' );
		
		// set the request for css ids and classes
		$_REQUEST['cce_scope'] = "programs"; // css file name / body id
		$_REQUEST['cce_page'] = strtolower($genre->getName()); // body class
		$_REQUEST['cce_cols'] = "3"; // canvas div id
		$_REQUEST['cce_subtype'] = "details"; // canvas div class
		$_REQUEST['ccmenu'] = isset($_REQUEST['ccmenu']) ? $_REQUEST['ccmenu'] : '';
	}

	/**
	 * Displays the program summary
	 * @param bean $model The program summary model
	 */
	public function summary($model)
	{
		global $logger, $mainframe;
		$logger->debug(get_class($this) . "::summary($model)");

		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'program_summary.pat.tpl' );

		// page title
		$pg_title = "Program Summary";
		if ($model->getGenre()) {
			$pg_title = $model->getGenre()->getName();
			
			if ($model->getGenre()->getIntroduction() != null) {
				$tmpl->addVar('intro','introduction',$model->getGenre()->getIntroduction());
			}
		}
		$mainframe->setPageTitle($pg_title);
		$tmpl->addVar('intro','title',$pg_title);
		
		if ($model->getAnnouncement() != null) {
			$tmpl->addVar('intro','announcement',$model->getAnnouncement());
		}
				
		$eventList = $model->getList();
		// check for a sort preference
		if (isset($_SESSION['summary_sort'])) {
			usort($eventList,array('FrontProgramPage','sort_by_' . $_SESSION['summary_sort']));
//			$tmpl->addVar('prgm_summary','sort_' . $_SESSION['summary_sort'],'class="sel"');
            $tmpl->addVar('sort_links','sortby',$_SESSION['summary_sort']);
		} else {
			usort($eventList,array('FrontProgramPage','sort_by_date'));
//			$tmpl->addVar('prgm_summary','sort_date','class="sel"');
            $tmpl->addVar('sort_links','sortby','date');
		}
		
		// sort links
		$base_link = "index.php?option=com_ccevents&scope=prgm&task=summary";
//		$sort_link = array();
   		$sort_info = array(
                        array("text"=>"View by Date","type"=>"date"),
                        array("text"=>"View Alphabetically","type"=>"title"),
                        array("text"=>"View by Series","type"=>"series"),
                        array("text"=>"View by Age Group","type"=>"age")
                        );
		$filter = "";
		if ($_REQUEST['fid']) {
			$filter	= "&filter=Genre&fid=". $_REQUEST['fid'];
		}
		if (isset($_REQUEST['school'])) {
			$filter	.= "&school=true";
		}
//		$sort_link['sort_date_link'] = $this->cceventSefUrl($base_link . $filter . "&sort=date");
        $sort_info[0]["link"] = $this->cceventSefUrl($base_link . $filter . "&sort=date");
//		$sort_link['sort_title_link'] = $this->cceventSefUrl($base_link . $filter . "&sort=title");
        $sort_info[1]["link"] = $this->cceventSefUrl($base_link . $filter . "&sort=title");
//		$sort_link['sort_series_link'] = $this->cceventSefUrl($base_link . $filter . "&sort=series");
        $sort_info[2]["link"] = $this->cceventSefUrl($base_link . $filter . "&sort=series");
//		$sort_link['sort_age_link'] = $this->cceventSefUrl($base_link . $filter . "&sort=age");
        $sort_info[3]["link"] = $this->cceventSefUrl($base_link . $filter . "&sort=age");
//		$tmpl->addVars('prgm_summary',$sort_link);
        $tmpl->addRows('sort_links',$sort_info);
		
		// a temporary place to hold a comparison operator for group headings
		$prev_category_name = "";
		
		$iter = 0;
		foreach($eventList as $event) {		
			// check group order for series and audience groupings
			$tmpl->setAttribute('group','visibility','hidden');
			$sort_name = $this->getSortName($event,$_SESSION['summary_sort']);
			if ($sort_name != $prev_category_name) {
				$tmpl->addVar('group','group_heading',$sort_name);
				$tmpl->setAttribute('group','visibility','visible');
				$prev_category_name = $sort_name;
				$iter = 0;
			}	
			
			$event_class =  ($iter == 0) ? "event first" : "event";
			$tmpl->addVar('program','event_class',$event_class);
			$iter++;	
			
			// simple attributes
			$tmpl->addVars('program', BeanUtil::beanToArray($event,true)); // scalars only

			// detail link
			$school = '';
			if (isset($_REQUEST['school']) || $event->getPrimaryGenre()->getSchool()) {
				$school = "&school=true";	
			}
			$dlink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=prgm&task=detail&oid=". $event->getOid() . $school);
			$tmpl->addVar('program','detail_link',$dlink);			
			
			// primary genre
			$pg = $event->getPrimaryGenre();
			if ($pg != null) {
				$tmpl->addVar('program', 'genre', $pg->getName() );
			}

			// activity level items
			$time_display = "";
			if ($event->getScheduleNote() != '') {
				$time_display = $event->getScheduleNote();
                $ticket = '';	
			}  else {
				$acts = $event->getChildren();
				$next_act = $this->getNextActivity($acts);
				$ticket = '';
				if ($next_act != null) {
					$schedule = $next_act->getSchedule();
					if ($schedule != null) {
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
			}
			$tmpl->addVar('program','time',$time_display);
			$tmpl->addVar('program','status_img',$ticket);		

			// audience
			$tmpl->clearTemplate('show_audience');
			$tmpl->setAttribute('show_audience','visibility','hidden');
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

			// series
			$tmpl->clearTemplate('series');
			if (isset($cats[Category::SERIES])) {
				foreach( $cats[Category::SERIES] as $ser) {
					$slink = $this->cceventSefUrl("index.php?option=com_ccevents&scope=sers&task=summary&oid=". $ser->getOid() );
					$tmpl->addVar('series','series_link',$slink);
					$tmpl->addVar('series','series_title',$ser->getName());
					$tmpl->parseTemplate('series','a');
				}
			}

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

		$tmpl->displayParsedTemplate( 'prgm_summary' );
		
		// set the request for css ids and classes
		$_REQUEST['cce_scope'] = "programs"; // css file name / body id
		$_REQUEST['cce_page'] = ""; // body class
		$_REQUEST['cce_cols'] = "3"; // canvas div id
		$_REQUEST['cce_subtype'] = "general"; // canvas div class
		$_REQUEST['ccmenu'] = isset($_REQUEST['ccmenu']) ? $_REQUEST['ccmenu'] : ''; // menu
	}


	/**
	 * Displays the what's on overview (list of published genres)
	 * @param bean $model The program summary model
	 */
	public function overview($model)
	{
		global $logger, $mainframe;
		$logger->debug(get_class($this) . "::summary($model)");

		$list = $model->getList();
		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'program_overview.pat.tpl' );

		// page title
		$pg_title = PRGM_OVERVIEW_TITLE;
		$mainframe->setPageTitle($pg_title);
		$tmpl->addVar('intro','title',$pg_title);
		
		// announcement
		if ($model->getAnnouncement() != null) {
			$tmpl->addVar('intro','announcement',$model->getAnnouncement());
		}
		
		// order the genres alphabetically
		$name = array();
		foreach ($list as $key => $row) {
		    $name[$key]  = $row->getName();
		}
		array_multisort($name, SORT_ASC, $list);
		
		
		// load the genre information
		foreach ($list as $genre) {
			
			if ($genre->getName() != '') { // protects against empty categories
				// simple attributes
				$tmpl->addVars('genre', BeanUtil::beanToArray($genre,true)); // scalars only
				
				// image
				$photo_url = ($genre->getImage() != '') ? $genre->getImage() : DEFAULT_GENRE_IMAGE_URL;
				$tmpl->addVar('genre','photo_url',$photo_url);
				
				// link
				$link_url = "index.php?option=com_ccevents&scope=prgm&task=summary&filter=Genre&fid=". $genre->getOid() ."&ccmenu=". $_REQUEST['ccmenu'];
				$tmpl->addVar('genre','link_url',$this->cceventSefUrl($link_url));
				
				$tmpl->parseTemplate('genre',"a");
			}
		}
				
		$tmpl->displayParsedTemplate( 'program_overview' );
		
		// set the request for css ids and classes
		$_REQUEST['cce_scope'] = "whats_on"; // css file name / body id
		$_REQUEST['cce_page'] = "whats_on_at_the_skirball"; // body class
		$_REQUEST['cce_cols'] = "2"; // canvas div id
		$_REQUEST['cce_subtype'] = "overview"; // canvas div class
		$_REQUEST['ccmenu'] = isset($_REQUEST['ccmenu']) ? $_REQUEST['ccmenu'] : ''; // menu
		
		
	}
}
?>

