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
require_once WEB_INF . '/beans/Editor.php';
require_once WEB_INF . '/pages/MasterPage.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Schedule.php';

class ExhibitionPage extends MasterPage
{
	/**
	 * The default render method.  Acts as a micro-dispatcher
	 * forwarding to the proper render method based on the class
	 * of given model bean.
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
	 * Renders the exhibition summary template
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
	 	$tmpl->readTemplatesFromInput( 'exhibition_summary.pat.tpl' );

	 	$tmpl->addVar('exhibition_summary','total',count($list));

	 	// Add the objects to the nested templates
		for ($i=0; $i<count($list); $i++) {
			$exbt = $list[$i];
			$logger->debug("Class of exhibition [Exhibition]: ". get_class($exbt));

			$tmpl->addVar('exhibition','iter',$i);
			$tmpl->addVar('exhibition','index',$i+1);
			$tmpl->addVars('exhibition', BeanUtil::beanToArray($exbt,true)); // scalars only

			// set the schedule values
			$tmpl->addVar('exhibition', 'start_display', $this->formatDate($exbt->getSchedule()->getStartTime(),'fulldate'));
			if ($exbt->getSchedule() && $exbt->getSchedule()->getEndTime() > 0) {
				$tmpl->addVar('exhibition', 'end_display', $this->formatDate($exbt->getSchedule()->getEndTime(),'fulldate'));
			} else {
				$tmpl->addVar('exhibition', 'end_display', 'Ongoing');
			}

			$first = ($i==0) ? "yes" : "no";
			$last = ($i==(count($list))-1) ? "yes" : "no";
			$tmpl->addVar('move_up','FIRST',$first);
			$tmpl->addVar('move_down','LAST',$last);

			$pubwidget = array();
			if($exbt->getPubState() == PublicationState::PUBLISHED) {
				$pubwidget['pubimg'] = 'publish_g.png';
				$pubwidget['pubalt'] = PublicationState::PUBLISHED;
				$pubwidget['pubtask'] = 'unpublish';
				$pubwidget['pubtoggle'] = PublicationState::UNPUBLISHED;
			} else if ($exbt->getPubState() == PublicationState::UNPUBLISHED) {
				$pubwidget['pubimg'] = 'publish_x.png';
				$pubwidget['pubalt'] = PublicationState::UNPUBLISHED;
				$pubwidget['pubtask'] = 'publish';
				$pubwidget['pubtoggle'] = PublicationState::PUBLISHED;
			}
			$tmpl->addVars('exhibition',$pubwidget);

			$eventwidget = array();
			if($exbt->getEventStatus() == EventStatus::ACTIVE) {
				$eventwidget['statusimg'] = 'publish_g.png';
				$eventwidget['statusalt'] = EventStatus::ACTIVE;
				$eventwidget['statustoggle'] = EventStatus::SOLDOUT;
			} else if ($exbt->getEventStatus() == EventStatus::SOLDOUT) {
				$eventwidget['statusimg'] = 'publish_y.png';
				$eventwidget['statusalt'] = EventStatus::SOLDOUT;
				$eventwidget['statustoggle'] = EventStatus::CANCELLED;
			} else if ($exbt->getEventStatus() == EventStatus::CANCELLED) {
				$eventwidget['statusimg'] = 'publish_x.png';
				$eventwidget['statusalt'] = EventStatus::CANCELLED;
				$eventwidget['statustoggle'] = EventStatus::ACTIVE;
			}
			$tmpl->addVars('exhibition',$eventwidget);

			$programs = $exbt->getPrograms();
			$ecount = count($programs);
			$courses = $exbt->getCourses();
			$ccount = count($courses);
			$tmpl->addVar('exhibition','program',$ecount);
			$tmpl->addVar('exhibition','course',$ccount);

			$rv = $exbt->getVenues();
			$vcount = (isset($rv)) ? count($rv) : 0;
			$tmpl->addVar('exhibition','venue',$vcount);

			$tmpl->parseTemplate('exhibition',"a");
		}
	 	$tmpl->displayParsedTemplate( 'exhibition_summary' );
	 }


	/**
	 * Renders the exhibition detail template
	 *
	 * @param bean $model a DetailPageModel bean
	 * @return void
	 */
	 private function renderDetailPageModel($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::renderDetailPageModel($model)");

		$exbt = $model->getDetail();
		$options = $model->getOptions();
		$programs = $exbt->getPrograms();
		$courses = $exbt->getCourses();
		$artists = $exbt->getArtists();
		$categories = $exbt->getCategories();
		$venues = $exbt->getVenues();
		$artifacts = explode(",",$exbt->getArtifacts());


		$logger->debug("Number of artists for exhibition in page: ". count($artists));

		$tmpl = $this->createPatTemplate(); //in the MasterPage class
		$tmpl->readTemplatesFromInput( 'exhibition_detail.pat.tpl' );
		$tmpl->addGlobalVar('scope','Exhibition');

		// Render the primary form fields
		$tmpl->addVars('exhibition_form', BeanUtil::beanToArray($exbt,true)); // scalars only




		// Renders the editor fields
		$sconf = $this->getEditorConfig(Editor::SMALL, 'summary', $exbt->getSummary());
		$tmpl->addVar('exhibition_form','summary_editor',$this->setEditor($sconf));

		$dconf = $this->getEditorConfig(Editor::MEDIUM, 'description', $exbt->getDescription());
		$tmpl->addVar('exhibition_form','description_editor',$this->setEditor($dconf));

		$cconf = $this->getEditorConfig(Editor::SMALL, 'credit', $exbt->getCredit());
		$tmpl->addVar('exhibition_form','credit_editor',$this->setEditor($cconf));

		$aconf = $this->getEditorConfig(Editor::SMALL, 'addinfo', $exbt->getAddinfo());
		$tmpl->addVar('exhibition_form','addinfo_editor',$this->setEditor($aconf));

		$a2conf = $this->getEditorConfig(Editor::SMALL, 'addinfo2', $exbt->getAddinfo2());
		$tmpl->addVar('exhibition_form','addinfo2_editor',$this->setEditor($a2conf));

		// PubState Select
		foreach ($options['pubState'] as $ps) {
			$tmpl->addVar('pubState_options','value',$ps->value);
			$logger->debug("current: ". $ps->value ." | selected ". $exbt->getPubState());

			if ($ps->value == $exbt->getPubState()) {
				$tmpl->addVar('pubState_options','selected','selected');
			} else {
				$tmpl->addVar('pubState_options','selected','');
			}

			$tmpl->parseTemplate('pubState_options','a');
		}

		// Event Status Select
		foreach ($options['eventStatus'] as $es) {
			$tmpl->addVar('eventStatus_options','value',$es->value);

			if ($es->value == $exbt->getEventStatus()) {
				$tmpl->addVar('eventStatus_options','selected','selected');
			} else {
				$tmpl->addVar('eventStatus_options','selected','');
			}
			$tmpl->parseTemplate('eventStatus_options','a');
		}
		// Date Selects
		$logger->debug("Size of months in page: ". count($options['month']));
		$schedule = $exbt->getSchedule();
		if (empty($schedule)) { $schedule = new Schedule(); }
		$tmpl->addVar('exhibition_form','scheduleOid',$schedule->getOid());
		$startTime = ($schedule->getStartTime() > 0) ? $schedule->getStartTime() : time();

		// set the end time functionality
		if ($schedule->getEndTime() > 0) {
			$endTime = $schedule->getEndTime();
			$tmpl->addVar('close_form','show_closing','1');
		} else {
			$endTime = time();
			$tmpl->addVar('close_form','show_closing','0');
		}

		foreach ($options['month'] as $key=>$value) {
			$tmpl->addVar('start_month_options','value',$key);
			$tmpl->addVar('start_month_options','text',$value);
			if ($key == date("n",$startTime)) {
				$tmpl->addVar('start_month_options','selected','selected');
			} else {
				$tmpl->addVar('start_month_options','selected','');
			}
			$tmpl->parseTemplate('start_month_options','a');

			$tmpl->addVar('end_month_options','value',$key);
			$tmpl->addVar('end_month_options','text',$value);
			if ($key == date("n",$endTime)) {
				$tmpl->addVar('end_month_options','selected','selected');
			} else {
				$tmpl->addVar('end_month_options','selected','');
			}
			$tmpl->parseTemplate('end_month_options','a');
		}
		foreach ($options['day'] as $value) {
			$tmpl->addVar('start_day_options','value',$value);
			if (intval($value) == date("j",$startTime)) {
				$tmpl->addVar('start_day_options','selected','selected');
			} else {
				$tmpl->addVar('start_day_options','selected','');
			}
			$tmpl->parseTemplate('start_day_options','a');

			$tmpl->addVar('end_day_options','value',$value);
			if (intval($value) == date("j",$endTime)) {
				$tmpl->addVar('end_day_options','selected','selected');
			} else {
				$tmpl->addVar('end_day_options','selected','');
			}
			$tmpl->parseTemplate('end_day_options','a');
		}
		foreach ($options['year'] as $value) {
			$tmpl->addVar('start_year_options','value',$value);
			if (intval($value) == date("Y",$startTime)) {
				$tmpl->addVar('start_year_options','selected','selected');
			} else {
				$tmpl->addVar('start_year_options','selected','');
			}
			$tmpl->parseTemplate('start_year_options','a');

			$tmpl->addVar('end_year_options','value',$value);
			if (intval($value) == date("Y",$endTime)) {
				$tmpl->addVar('end_year_options','selected','selected');
			} else {
				$tmpl->addVar('end_year_options','selected','');
			}
			$tmpl->parseTemplate('end_year_options','a');
		}

		// Press Release Article Select
		$proptions = $options['pressrelease'];
		foreach ($proptions as $pra) {
			$tmpl->addVar('pressrelease_options','value',$pra->getId());
			$tmpl->addVar('pressrelease_options','title',substr($pra->getTitle(),0,60));
			if ($pra->getId() == $exbt->getPressRelease()) {
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
			if ($ca->getId() == $exbt->getCommentArticle()) {
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
			if ($rca->getId() == $exbt->getRelatedArticles()) {
				$tmpl->addVar('relatedcategory_options','selected','selected');
			} else {
				$tmpl->addVar('relatedcategory_options','selected','');
			}
			$tmpl->parseTemplate('relatedcategory_options','a');
		}

		// Render the Main Template
		$tmpl->displayParsedTemplate('exhibition_form');


		// Render the Tabs
		$tabs 	= new mosTabs(1); //1 = use cookies to remember selected tab
		$tabs->startPane("links");

		if( $exbt->getOid() == null ) {
			$tabs->startTab("Notice","new-links");
			echo "<br/><br/>To assign a Venue, first save this new Exhibition.<br/><br/>";
			$tabs->endTab();
		} else {
			$tabs->startTab("Venues","vnue-links");
			foreach ($options['venue'] as $ven) {
				$tmpl->addVar('venue_options','oid',$ven->getOid());
				$tmpl->addVar('venue_options','name',$ven->getName());

				if ( isset($venues) && $this->bean_in_array($ven,$venues) ) {
					$tmpl->addVar('venue_options','selected','selected');
				} else {
					$tmpl->addVar('venue_options','selected','');
				}
				$tmpl->parseTemplate('venue_options','a');
			}
			$tmpl->displayParsedTemplate('vnueTab');
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
				if ( $glry->id == $exbt->getGallery() ) {
					$tmpl->addVar('gallery_options','selected','selected');
				} else {
					$tmpl->addVar('gallery_options','selected','');
				}

				$tmpl->parseTemplate('gallery_options','a');
			}
			$tmpl->displayParsedTemplate('glryTab');
			$tabs->endTab();

			$tabs->startTab("Artists","pers-links");
			foreach ($options['person'] as $pers) {
				$artistName = ($pers->getLastName()) ? $pers->getLastName() .", ". $pers->getFirstName() : $pers->getFriendlyName();
				$tmpl->addVar('person_options','oid',$pers->getOid());
				$tmpl->addVar('person_options','title',$artistName);

				if ( isset($artists) && $this->bean_in_array($pers,$artists) ) {
					$tmpl->addVar('person_options','selected','selected');
				} else {
					$tmpl->addVar('person_options','selected','');
				}
				$tmpl->parseTemplate('person_options','a');
			}

			foreach ($options['artifact'] as $album) {
				
				foreach ($album->getImages() as $image) {	
					
					$large = $image->getLarge();

					if ($large) {						
						
						$tmpl->addVar('object_options','oid',$large->getId());
						$tmpl->addVar('object_options','name',$image->getTitle());

					if ( isset($artifacts) && in_array($large->getId(),$artifacts) ) {
						$tmpl->addVar('object_options','selected','selected');
					} else {
						$tmpl->addVar('object_options','selected','');
					}

						$tmpl->parseTemplate('object_options','a');
					}

				}
			}
			$tmpl->displayParsedTemplate('persTab');
			$tabs->endTab();



		}
		$tmpl->displayParsedTemplate('close_form');

	 }
}

?>
