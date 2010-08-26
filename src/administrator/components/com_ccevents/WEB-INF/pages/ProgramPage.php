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


class ProgramPage extends MasterPage
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
	 * Renders the program summary template
	 * 
	 * @param bean $model a SummaryPageModel bean
	 * @return void
	 */
	 private function renderSummaryPageModel($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::renderSummaryPageModel($model)");
	 	
	 	$list = $model->getList();
        usort($list,array('ProgramPage','sort_by_title'));
	 	$tmpl = $this->createPatTemplate(); //in the MasterPage class
	 	$tmpl->readTemplatesFromInput( 'program_summary.pat.tpl' );
	 	
	 	$tmpl->addVar('program_summary','total',count($list));
	 	
	 	// Add the objects to the nested templates
		for ($i=0; $i<count($list); $i++) {
			$prgm = $list[$i];
			$logger->debug("Class of program [Program]: ". get_class($prgm));
			
			$tmpl->addVar('program','iter',$i);
			$tmpl->addVar('program','index',$i+1);		
			$tmpl->addVars('program', BeanUtil::beanToArray($prgm,true)); // scalars only
			$programType = $prgm->getPrimaryGenre();
			if (isset($programType)) {
				$tmpl->addVar('program', 'programtype', $programType->getName());
			}
			$pubwidget = array();
			if($prgm->getPubState() == PublicationState::PUBLISHED) {
				$pubwidget['pubimg'] = 'publish_g.png';
				$pubwidget['pubalt'] = PublicationState::PUBLISHED;
				$pubwidget['pubtask'] = 'unpublish';
				$pubwidget['pubtoggle'] = PublicationState::UNPUBLISHED;
			} else if ($prgm->getPubState() == PublicationState::UNPUBLISHED) {
				$pubwidget['pubimg'] = 'publish_x.png';
				$pubwidget['pubalt'] = PublicationState::UNPUBLISHED;
				$pubwidget['pubtask'] = 'publish';
				$pubwidget['pubtoggle'] = PublicationState::PUBLISHED;	
			}
			$tmpl->addVars('program',$pubwidget);
			
			$cats = $prgm->getCategories();
			$ecount = (isset($cats['Series'])) ? count($cats['Series']) : 0;
			$tmpl->addVar('program','series',$ecount);
			$ecount = (isset($cats['Genre'])) ? count($cats['Genre']) : 0;
			$tmpl->addVar('program','genre',$ecount);
			$ecount = (isset($cats['Audience'])) ? count($cats['Audience']) : 0;
			$tmpl->addVar('program','audience',$ecount);

			$exhibitions = $prgm->getExhibitions();
			$ecount = count($exhibitions);
			$courses = $prgm->getCourses();
			$ccount = count($courses);
			$activities = $prgm->getChildren();
			$pcount = count($activities);

			if (!empty($activities)) {
				$startTime = 0;
				$endTime = 0;
				foreach ($activities as $activity) {
					$schedule = $activity->getSchedule();
					$startTime = empty($startTime) ? $schedule->getStartTime() :
									min($startTime, $schedule->getStartTime());
					$endTime = empty($schedule->endTime) ? max($endTime, $schedule->getStartTime()) :
									max($endTime, $schedule->getEndTime());
				}
				$tmpl->addVar('program','starttime',$startTime);
				$tmpl->addVar('program','endtime',$endTime);
			}
			
			$tmpl->addVar('program','exhibition',$ecount);
			$tmpl->addVar('program','course',$ccount);
			$tmpl->addVar('program','performance',$pcount);

			$tmpl->parseTemplate('program',"a");	
		}
	 	$tmpl->displayParsedTemplate( 'program_summary' );
	 }
	 
	 
	/**
	 * Renders the program detail template
	 * 
	 * @param bean $model a DetailPageModel bean
	 * @return void
	 */
	 private function renderDetailPageModel($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::renderDetailPageModel($model)");
		
		$program = $model->getDetail();
		$options = $model->getOptions();
		$exhibitions = $program->getExhibitions();
		$courses = $program->getCourses();
		$categories = $program->getCategories();
		
		$tmpl = $this->createPatTemplate(); //in the MasterPage class
		
		$tmpl->readTemplatesFromInput( 'program_detail.pat.tpl' );
		$tmpl->addGlobalVar('scope','Program');

		// Render the primary form fields
		$tmpl->addVars('program_form', BeanUtil::beanToArray($program,true)); // scalars only

		// Renders the editor fields
		$sconf = $this->getEditorConfig(Editor::SMALL, 'summary', $program->getSummary());
		$tmpl->addVar('program_form','summary_editor',$this->setEditor($sconf));
		
		$dconf = $this->getEditorConfig(Editor::MEDIUM, 'description', $program->getDescription());
		$tmpl->addVar('program_form','description_editor',$this->setEditor($dconf));
		
		$cconf = $this->getEditorConfig(Editor::SMALL, 'credit', $program->getCredit());
		$tmpl->addVar('program_form','credit_editor',$this->setEditor($cconf));
		
		$aconf = $this->getEditorConfig(Editor::SMALL, 'addinfo', $program->getAddinfo());
		$tmpl->addVar('program_form','addinfo_editor',$this->setEditor($aconf));
		
		$a2conf = $this->getEditorConfig(Editor::SMALL, 'addinfo2', $program->getAddinfo2());
		$tmpl->addVar('program_form','addinfo2_editor',$this->setEditor($a2conf));
		
		// PubState Select
		foreach ($options['pubState'] as $ps) {
			$tmpl->addVar('pubState_options','value',$ps->value);
			$logger->debug("current: ". $ps->value ." | selected ". $program->getPubState());
			
			if ($ps->value == $program->getPubState()) {
				$tmpl->addVar('pubState_options','selected','selected');
			} else {
				$tmpl->addVar('pubState_options','selected','');
			}
			
			$tmpl->parseTemplate('pubState_options','a');
		}
		
		// Primary Genre Select
		$genre = $program->getPrimaryGenre();
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
		$venues = $program->getVenues();
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
		
		// Press Release Article Select
		$proptions = $options['pressrelease'];
		foreach ($proptions as $pra) {
			$tmpl->addVar('pressrelease_options','value',$pra->getId());
			$tmpl->addVar('pressrelease_options','title',$pra->getTitle());
			if ($pra->getId() == $program->getPressRelease()) {
				$tmpl->addVar('pressrelease_options','selected','selected');
			} else {
				$tmpl->addVar('pressrelease_options','selected','');
			}
			$tmpl->parseTemplate('pressrelease_options','a');
		}		
		
		// Comment Article Select
		$caoptions = $options['commentarticle'];
		foreach ($caoptions as $ca) {
			$tmpl->addVar('commentarticle_options','value',$ca->getId());
			$tmpl->addVar('commentarticle_options','title',$ca->getTitle());
			if ($ca->getId() == $program->getCommentArticle()) {
				$tmpl->addVar('commentarticle_options','selected','selected');
			} else {
				$tmpl->addVar('commentarticle_options','selected','');
			}
			$tmpl->parseTemplate('commentarticle_options','a');
		}	
		
		// Related Content Category
		$relatedoptions = $options['relatedcategory'];
		foreach ($relatedoptions as $rca) {
			$tmpl->addVar('relatedcategory_options','value',$rca->getId());
			$tmpl->addVar('relatedcategory_options','title',$rca->getTitle());
			if ($rca->getId() == $program->getRelatedArticles()) {
				$tmpl->addVar('relatedcategory_options','selected','selected');
			} else {
				$tmpl->addVar('relatedcategory_options','selected','');
			}
			$tmpl->parseTemplate('relatedcategory_options','a');
		}
		
		// Render the Main Template
		$tmpl->displayParsedTemplate('program_form');
		
		$logger->debug("program form template parsed");
		
		// Render the Tabs 	
		$tabs 	= new mosTabs(1); //1 = use cookies to remember selected tab
		$tabs->startPane("links");
		
		if( $program->getOid() == null ) {
			$tabs->startTab("Notice","new-links");
			echo "<br/><br/>To assign a performance, first save this new program.<br/><br/>";
			$tabs->endTab();	
		} else {
			$tabs->startTab("Performances","perf-links");
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
			
			$activities = $program->getChildren();
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
					$activityStartTime .= $delim .  $ststr;
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
			
			$tmpl->displayParsedTemplate('perfTab');
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
				
			$tabs->startTab("Courses","crse-links");
			foreach ($options['course'] as $prgm) {
				$tmpl->addVar('course_options','oid',$prgm->getOid());
				$tmpl->addVar('course_options','title',$prgm->getTitle());
				
				if ( isset($courses) && $this->bean_in_array($prgm,$courses) ) {
					$tmpl->addVar('course_options','selected','selected');
				} else {
					$tmpl->addVar('course_options','selected','');	
				}
				$tmpl->parseTemplate('course_options','a');
			}
			$tmpl->displayParsedTemplate('crseTab');
			$tabs->endTab();
			
			$tabs->startTab("Gallery","glry-links");
			foreach ($options['gallery'] as $glry) {
				$tmpl->addVar('gallery_options','gid',$glry->id);
				$tmpl->addVar('gallery_options','name',$glry->title);
				if ( $glry->id == $program->getGallery() ) {
					$tmpl->addVar('gallery_options','selected','selected');
				} else {
					$tmpl->addVar('gallery_options','selected','');	
				}
				
				$tmpl->parseTemplate('gallery_options','a');
			}
			$tmpl->displayParsedTemplate('glryTab');
			$tabs->endTab();
		}
		$logger->debug("parsing template");
		$tmpl->displayParsedTemplate('close_form');	
	 }
	
}
?>

