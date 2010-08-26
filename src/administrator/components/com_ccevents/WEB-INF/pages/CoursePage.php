<?php
/**
 *  $Id $
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
require_once WEB_INF . '/beans/PublicationState.php';


class CoursePage extends MasterPage
{	
	/**
	 * The default render method.  Acts as a micro-dispatcher
	 * forwarding to the proper render method based on the class 
	 * of given model bean.  
	 * 
	 * Note: This is a reference inplementation for a possible 
	 * PageDispatcher utility class.
	 * 
	 * @param bean $model A PageModel bean
	 * @return void
	 */
	function render($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::render()');
		
		$target = "render". get_class($model);
		$this->$target($model);	
	}
	
	
	/**
	 * Renders the course summary template
	 * 
	 * @param bean $model a SummaryPageModel bean
	 * @return void
	 */
	 private function renderSummaryPageModel($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::renderSummaryPageModel($model)");
	 	
	 	$list = $model->getList();
	 	$tmpl = $this->createPatTemplate(); //in the MasterPage class
	 	$tmpl->readTemplatesFromInput( 'course_summary.pat.tpl' );
	 	
	 	$tmpl->addVar('course_summary','total',count($list));
	 	
	 	// Add the objects to the nested templates
		for ($i=0; $i<count($list); $i++) {
			$crse = $list[$i];
			$logger->debug("Class of course [Course]: ". get_class($crse));
			
			$tmpl->addVar('course','iter',$i);
			$tmpl->addVar('course','index',$i+1);		
			$tmpl->addVars('course', BeanUtil::beanToArray($crse,true)); // scalars only
			$courseType = $crse->getPrimaryGenre();
			if (isset($courseType)) {
				$tmpl->addVar('course', 'coursetype', $courseType->getName());
			}
			$pubwidget = array();
			if($crse->getPubState() == PublicationState::PUBLISHED) {
				$pubwidget['pubimg'] = 'publish_g.png';
				$pubwidget['pubalt'] = PublicationState::PUBLISHED;
				$pubwidget['pubtask'] = 'unpublish';
				$pubwidget['pubtoggle'] = PublicationState::UNPUBLISHED;
			} else if ($crse->getPubState() == PublicationState::UNPUBLISHED) {
				$pubwidget['pubimg'] = 'publish_x.png';
				$pubwidget['pubalt'] = PublicationState::UNPUBLISHED;
				$pubwidget['pubtask'] = 'publish';
				$pubwidget['pubtoggle'] = PublicationState::PUBLISHED;	
			}
			$tmpl->addVars('course',$pubwidget);
			
			$cats = $crse->getCategories();
			$ecount = (isset($cats['Series'])) ? count($cats['Series']) : 0;
			$tmpl->addVar('course','series',$ecount);
			$ecount = (isset($cats['Genre'])) ? count($cats['Genre']) : 0;
			$tmpl->addVar('course','genre',$ecount);
			$ecount = (isset($cats['Audience'])) ? count($cats['Audience']) : 0;
			$tmpl->addVar('course','audience',$ecount);

			$exhibitions = $crse->getExhibitions();
			$ecount = count($exhibitions);
			$programs = $crse->getPrograms();
			$ccount = count($programs);
			$activities = $crse->getChildren();
			$scount = count($activities);

			if (!empty($activities)) {
				$startTime =
				$endTime = 0;
				foreach ($activities as $activity) {
					$schedule = $activity->getSchedule();
					$startTime = empty($startTime) ? $schedule->getStartTime() :
									min($startTime, $schedule->getStartTime());
					$endTime = empty($schedule->endTime) ? max($endTime, $schedule->getStartTime()) :
									max($endTime, $schedule->getEndTime());
				}
				$tmpl->addVar('course','starttime',$startTime);
				$tmpl->addVar('course','endtime',$endTime);
			}
			
			$tmpl->addVar('course','seminar',$scount);
			$tmpl->addVar('course','exhibition',$ecount);
			$tmpl->addVar('course','program',$ccount);

			$tmpl->parseTemplate('course',"a");	
		}
	 	$tmpl->displayParsedTemplate( 'course_summary' );
	 }
	 
	 
	/**
	 * Renders the course detail template
	 * 
	 * @param bean $model a DetailPageModel bean
	 * @return void
	 */
	 private function renderDetailPageModel($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::renderDetailPageModel($model)");
		
		$course = $model->getDetail();
		$options = $model->getOptions();
		$exhibitions = $course->getExhibitions();
		$programs = $course->getPrograms();
		$categories = $course->getCategories();
		
		$tmpl = $this->createPatTemplate(); //in the MasterPage class
		$tmpl->readTemplatesFromInput( 'course_detail.pat.tpl' );
		$tmpl->addGlobalVar('scope','Course');
		
		// Render the primary form fields
		$tmpl->addVars('course_form', BeanUtil::beanToArray($course,true)); // scalars only
		
		// Renders the editor fields
		$iconf = $this->getEditorConfig(Editor::MEDIUM, 'instructorbio', $course->getInstructorBio());
		$tmpl->addVar('course_form','instructor_editor',$this->setEditor($iconf));
		
		$sconf = $this->getEditorConfig(Editor::SMALL, 'summary', $course->getSummary());
		$tmpl->addVar('course_form','summary_editor',$this->setEditor($sconf));
		
		$dconf = $this->getEditorConfig(Editor::MEDIUM, 'description', $course->getDescription());
		$tmpl->addVar('course_form','description_editor',$this->setEditor($dconf));
		
		// PubState Select
		foreach ($options['pubState'] as $ps) {
			$tmpl->addVar('pubState_options','value',$ps->value);
			$logger->debug("current: ". $ps->value ." | selected ". $course->getPubState());
			
			if ($ps->value == $course->getPubState()) {
				$tmpl->addVar('pubState_options','selected','selected');
			} else {
				$tmpl->addVar('pubState_options','selected','');
			}
			
			$tmpl->parseTemplate('pubState_options','a');
		}
		
		// Primary Genre Select
		$genre = $course->getPrimaryGenre();
		foreach ($options['genre'] as $gc) {
			$tmpl->addVar('primaryGenre_options','oid',$gc->getOid());
			$tmpl->addVar('primaryGenre_options','name',$gc->getName());
			
			if (!empty($genre) && $gc->getOid() == $genre->getOid()) {
				$tmpl->addVar('primaryGenre_options','selected','selected');
			} else {
				$tmpl->addVar('primaryGenre_options','selected','');
			}
			
			$tmpl->parseTemplate('primaryGenre_options','a');
		}
		
		// DefaultVenue Select
		$venues = $course->getVenues();
		$venue = isset($venues[0]) ? $venues [0] : null;
		foreach ($options['venue'] as $dv) {
			$tmpl->addVar('defaultVenue_options','oid',$dv->getOid());
			$tmpl->addVar('defaultVenue_options','name',$dv->getName());
			
			if (!empty($venue) && $dv->getOid() == $venue->getOid()) {
				$tmpl->addVar('defaultVenue_options','selected','selected');
			} else {
				$tmpl->addVar('defaultVenue_options','selected','');
			}
			
			$tmpl->parseTemplate('defaultVenue_options','a');
		}
		$tmpl->displayParsedTemplate('course_form');
		
		// Render the Tabs 	
		$tabs 	= new mosTabs(1); //1 = use cookies to remember selected tab
		$tabs->startPane("links");
		
		if( $course->getOid() == null ) {
			$tabs->startTab("Notice","new-links");
			echo "<br/><br/>To assign a class, first save this new course.<br/><br/>";
			$tabs->endTab();	
		} else {
			$tabs->startTab("Classes","seminar-links");
			$tmpl->addVar('activity_tab','scope','Performance');
			
			// Date Selects
			$logger->debug("Size of months in page: ". count($options['month']));
	
			foreach ($options['month'] as $key=>$value) {
				$tmpl->addVar('start_month_options','value',$key);
				$tmpl->addVar('start_month_options','text',$value);	
				$tmpl->parseTemplate('start_month_options','a');
				
				$tmpl->addVar('end_month_options','value',$key);
				$tmpl->addVar('end_month_options','text',$value);	
				$tmpl->parseTemplate('end_month_options','a');
			}
			foreach ($options['day'] as $value) {
				$tmpl->addVar('start_day_options','value',$value);
				$tmpl->parseTemplate('start_day_options','a');
				
				$tmpl->addVar('end_day_options','value',$value);
				$tmpl->parseTemplate('end_day_options','a');
			}
			foreach ($options['year'] as $value) {
				$tmpl->addVar('start_year_options','value',$value);
				$tmpl->parseTemplate('start_year_options','a');
				
				$tmpl->addVar('end_year_options','value',$value);
				$tmpl->parseTemplate('end_year_options','a');
			}
			
			foreach ($options['hour'] as $value) {
				$tmpl->addVar('start_hour_options','value',$value);
				$tmpl->parseTemplate('start_hour_options','a');
				
				$tmpl->addVar('end_hour_options','value',$value);
				$tmpl->parseTemplate('end_hour_options','a');
			}
			
			foreach ($options['minute'] as $value) {
				$tmpl->addVar('start_minute_options','value',$value);
				$tmpl->parseTemplate('start_minute_options','a');
				
				$tmpl->addVar('end_minute_options','value',$value);
				$tmpl->parseTemplate('end_minute_options','a');
			}
			
			foreach ($options['ampm'] as $value) {
				$tmpl->addVar('start_ampm_options','value',$value);
				$tmpl->parseTemplate('start_ampm_options','a');
				
				$tmpl->addVar('end_ampm_options','value',$value);
				$tmpl->parseTemplate('end_ampm_options','a');
			}
			
			foreach ($options['venue'] as $av) {
				$tmpl->addVar('activityVenue_options','oid',$av->getOid());
				$tmpl->addVar('activityVenue_options','name',$av->getName());
				
				if (!empty($venue) && $av->getOid() == $venue->getOid()) {
					$tmpl->addVar('activityVenue_options','selected','selected');
				} else {
					$tmpl->addVar('activityVenue_options','selected','');
				}	
				$tmpl->parseTemplate('activityVenue_options','a');
			}
			
			foreach ($options['eventStatus'] as $es) {
				$tmpl->addVar('activityStatus_options','value',$es->value);
				$tmpl->parseTemplate('activityStatus_options','a');
			}
			
			$activities = $course->getChildren();
			if (!empty($activities)) {
				$delim = 
				$activityStartTime =
				$activityEndTime =
				$activityVenueId =
				$activityVenueName =
				$activityStatus =
				$activityTicketCode = '';
				foreach ($activities as $activity) {
					$schedule = $activity->getSchedule();
					$ststr = date("Y-n-j H:i:s",$schedule->getStartTime());
					$etstr = date("Y-n-j H:i:s",$schedule->getEndTime());
					$activityStartTime .= $delim . $ststr;
					$activityEndTime .= $delim . $etstr;
					$activityVenueId .= $delim . $activity->getVenue()->getOid();
					$activityVenueName .= $delim . $activity->getVenue()->getName();
					$activityStatus .= $delim . $activity->getActivityStatus()->getValue();
					$activityTicketCode .= $delim . $activity->getTicketCode();
					$delim = '|';
				}
				$tmpl->addVar('activity_tab','start_time',$activityStartTime);
				$tmpl->addVar('activity_tab','end_time',$activityEndTime);
				$tmpl->addVar('activity_tab','venue_id',$activityVenueId);
				$tmpl->addVar('activity_tab','venue_name',$activityVenueName);
				$tmpl->addVar('activity_tab','activity_status',$activityStatus);
				$tmpl->addVar('activity_tab','activity_ticket',$activityTicketCode);
			}
			
			$tmpl->displayParsedTemplate('seminarTab');
			$tabs->endTab();
			
			$tabs->startTab("Genres","cat-links");
			foreach ($options['audience'] as $aud) {
				$tmpl->addVar('audience_options','oid',$aud->getOid());
				$tmpl->addVar('audience_options','name',$aud->getName());
				
				if ( isset($categories['Audience']) && $this->bean_in_array($aud,$categories['Audience']) ) {
					$tmpl->addVar('audience_options','selected','selected');
				} else {
					$tmpl->addVar('audience_options','selected','');	
				}
				$tmpl->parseTemplate('audience_options','a');
			}
			foreach ($options['genre'] as $gen) {
				$tmpl->addVar('genre_options','oid',$gen->getOid());
				$tmpl->addVar('genre_options','name',$gen->getName());
				
				if ( isset($categories['Genre']) && $this->bean_in_array($gen,$categories['Genre']) ) {
					$tmpl->addVar('genre_options','selected','selected');
				} else {
					$tmpl->addVar('genre_options','selected','');	
				}
				$tmpl->parseTemplate('genre_options','a');
			}		
			$tmpl->displayParsedTemplate('catsTab');		
			$tabs->endTab();
			
			$tabs->startTab("Series","series-links");
			foreach ($options['series'] as $ser) {
				$tmpl->addVar('series_options','oid',$ser->getOid());
				$tmpl->addVar('series_options','name',$ser->getName());
				
				if ( isset($categories['Series']) && $this->bean_in_array($ser,$categories['Series']) ) {
					$tmpl->addVar('series_options','selected','selected');
				} else {
					$tmpl->addVar('series_options','selected','');	
				}
				$tmpl->parseTemplate('series_options','a');
			}		
			$tmpl->displayParsedTemplate('sersTab');
			$tabs->endTab();
			
			$tabs->startTab("Exhibits","exbt-links");
			foreach ($options['exhibition'] as $exbt) {
				$tmpl->addVar('exhibition_options','oid',$exbt->getOid());
				$tmpl->addVar('exhibition_options','title',$exbt->getTitle());
				
				if ( isset($exhibitions) && $this->bean_in_array($exbt,$exhibitions) ) {
					$tmpl->addVar('exhibition_options','selected','selected');
				} else {
					$tmpl->addVar('exhibition_options','selected','');	
				}
				$tmpl->parseTemplate('exhibition_options','a');
			}
			$tmpl->displayParsedTemplate('exbtTab');
			$tabs->endTab();
				
			$tabs->startTab("Programs","prgm-links");
			foreach ($options['program'] as $prgm) {
				$tmpl->addVar('program_options','oid',$prgm->getOid());
				$tmpl->addVar('program_options','title',$prgm->getTitle());
				
				if ( isset($programs) && $this->bean_in_array($prgm,$programs) ) {
					$tmpl->addVar('program_options','selected','selected');
				} else {
					$tmpl->addVar('program_options','selected','');	
				}
				$tmpl->parseTemplate('program_options','a');
			}
			$tmpl->displayParsedTemplate('prgmTab');
			$tabs->endTab();
			
			$tabs->startTab("Gallery","glry-links");
			foreach ($options['gallery'] as $glry) {
				$tmpl->addVar('gallery_options','gid',$glry['id']);
				$tmpl->addVar('gallery_options','name',$glry['name']);
				if ( $glry['id'] == $course->getGallery() ) {
					$tmpl->addVar('gallery_options','selected','selected');
				} else {
					$tmpl->addVar('gallery_options','selected','');	
				}
				
				$tmpl->parseTemplate('gallery_options','a');
			}
			$tmpl->displayParsedTemplate('glryTab');
			$tabs->endTab();
			
		}
		
		$tmpl->displayParsedTemplate('close_form');	
	 }
	
}
?>

