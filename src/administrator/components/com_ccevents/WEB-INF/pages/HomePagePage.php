<?php
/**
 *  $Id$: HomePagePage.php, Sep 4, 2006 11:55:27 PM nchanda
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

require_once WEB_INF . '/beans/HomePage.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/pages/MasterPage.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/web/AddressUtil.php');

class HomePagePage extends MasterPage
{	
	/**
	 * The default render method.  Displays the summary list
	 * @param bean $model The home_page summary model
	 */
	public function render($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::render()');
		$this->renderSummary($model);	
	} 
	
	/**
	 * Displays the details for page for the given home_page
	 * @param bean DetailPageModel
	 */
	 public function read($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::read()');
		$this->renderDetail($model);		
	 }

	/**
	 * Displays the details for page for a new home_page
	 * @param bean DetailPageModel
	 */
	public function setup($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::setup()');
		$this->renderDetail($model);		
	 }

	/**
	 * Displays the details for page for the given home_page
	 * @param bean DetailPageModel
	 */
	public function apply($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::setup()');
		$this->renderDetail($model);		
	 }
	
	
	/**
	 * Displays the summary list
	 * @param bean $model The home_page summary model
	 */
	public function delete($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::delete()');
		$this->renderSummary($model);	
	} 
	
	/**
	 * Renders the summary of given home_pages
	 * @param bean $model The home_pages summary model
	 */
	private function renderSummary($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::summary()');
		
		$data = $model->getHomePages();	
		
		$tmpl = $this->createPatTemplate();
		$tmpl->readTemplatesFromInput( 'home_page_summary.pat.tpl' );
		
		$tmpl->addVar('home_page_summary','total',count($data));
		
		// Add the objects to the nested templates
		for ($i=0; $i<count($data); $i++) {
			$home_page = $data[$i];
			$logger->debug("Class of home_page: ". get_class($home_page));
			$tmpl->addVar('home_page','iter',$i);
			$tmpl->addVar('home_page','index',$i+1);		
			// Render the primary form fields
			$tmpl->addVars('home_page', BeanUtil::beanToArray($home_page,true)); // scalars only
			
			$pubwidget = $this->getPubControls($home_page->getPubState());
			$tmpl->addVars('home_page',$pubwidget);
			
			$tmpl->parseTemplate('home_page',"a");
		}
		$tmpl->displayParsedTemplate( 'home_page_summary' );
	}
	
	/**
	 * Renders the detail page for the given home_page
	 * @param bean DetailPageModel 
	 */
	private function renderDetail($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::detail()');
		
		$home_page = $model->getDetail();
		$options = $model->getOptions();
		
		$tmpl = $this->createPatTemplate();
		$tmpl->readTemplatesFromInput( 'home_page_detail.pat.tpl' );
		$tmpl->addGlobalVar('scope','HomePage');
		
		// Render the primary form fields
		$tmpl->addVars('home_page_form', BeanUtil::beanToArray($home_page,true)); 
		
		// PubState Select
		foreach ($options['pubState'] as $ps) {
			$tmpl->addVar('pubState_options','value',$ps->value);
			$logger->debug("current: ". $ps->value ." | selected ". $home_page->getPubState());
			
			if ($ps->value == $home_page->getPubState()) {
				$tmpl->addVar('pubState_options','selected','selected');
			} else {
				$tmpl->addVar('pubState_options','selected','');
			}
			
			$tmpl->parseTemplate('pubState_options','a');
		}
				
		// Date Selects
		$logger->debug("Size of months in page: ". count($options['month']));
		$startTime = ($home_page->getStartTime() > 0) ? $home_page->getStartTime() : time();

		foreach ($options['month'] as $key=>$value) {
			$tmpl->addVar('start_month_options','value',$key);
			$tmpl->addVar('start_month_options','text',$value);	
			if ($key == date("n",$startTime)) {
				$tmpl->addVar('start_month_options','selected','selected');
			} else {
				$tmpl->addVar('start_month_options','selected','');
			}
			$tmpl->parseTemplate('start_month_options','a');
		}
		foreach ($options['day'] as $value) {
			$tmpl->addVar('start_day_options','value',$value);
			if (intval($value) == date("j",$startTime)) {
				$tmpl->addVar('start_day_options','selected','selected');
			} else {
				$tmpl->addVar('start_day_options','selected','');
			}
			$tmpl->parseTemplate('start_day_options','a');
		}
		foreach ($options['year'] as $value) {
			$tmpl->addVar('start_year_options','value',$value);
			if (intval($value) == date("Y",$startTime)) {
				$tmpl->addVar('start_year_options','selected','selected');
			} else {
				$tmpl->addVar('start_year_options','selected','');
			}
			$tmpl->parseTemplate('start_year_options','a');
		}
		$tmpl->displayParsedTemplate('home_page_form');
		
		// Render the Tabs 	
		$tabs 	= new mosTabs(1); //1 = use cookies to remember selected tab
		$tabs->startPane("links");
		
		if( $home_page->getOid() == null ) {
			$tabs->startTab("Notice","new-links");
			echo "<br/><br/>To assign events, first save this new home page.<br/><br/>";
			$tabs->endTab();	
		} else {
			$tabs->startTab("Exhibitions","home_page_exhibitions");
			for ($index=1; $index<=3; $index++) {
				$getter = 'getEvent' . $index;
				$eventIndex = $this->getPromoObject( $home_page->$getter() );
				foreach ($options['exhibition'] as $event) {
					$tmpl->addVar('published_exhibition_options','type',$event->getScope());
					$tmpl->addVar('published_exhibition_options','oid',$event->getOid());
					$tmpl->addVar('published_exhibition_options','title',$event->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Exhibition' && 
							$event->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_exhibition_options','selected','selected');
					} else {
						$tmpl->addVar('published_exhibition_options','selected','');	
					}
					$tmpl->parseTemplate('published_exhibition_options','a');
				}
				$tmpl->addVar('published_exhibitions','index',$index);
				$tmpl->parseTemplate('published_exhibitions','a');
				$tmpl->clearTemplate('published_exhibition_options');
			}
			$tmpl->displayParsedTemplate('exhibitions');
			$tabs->endTab();
			
			$tabs->startTab("Programs","home_page_programs");
			for ($index=4; $index<=9; $index++) {
				$getter = 'getEvent' . $index;
				$eventIndex = $this->getPromoObject( $home_page->$getter() );
				foreach ($options['program'] as $event) {
					$tmpl->addVar('published_program_options','type',$event->getScope());
					$tmpl->addVar('published_program_options','oid',$event->getOid());
					$tmpl->addVar('published_program_options','title',$event->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Program' && 
							$event->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_program_options','selected','selected');
					} else {
						$tmpl->addVar('published_program_options','selected','');	
					}
					$tmpl->parseTemplate('published_program_options','a');
				}
				foreach ($options['genre'] as $cat) {
					$tmpl->addVar('published_genre_options','type',$cat->getScope());
					$tmpl->addVar('published_genre_options','oid',$cat->getOid());
					$tmpl->addVar('published_genre_options','title',$cat->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Genre' && 
							$cat->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_genre_options','selected','selected');
					} else {
						$tmpl->addVar('published_genre_options','selected','');	
					}
					$tmpl->parseTemplate('published_genre_options','a');
				}
				foreach ($options['audience'] as $cat) {
					$tmpl->addVar('published_audience_options','type',$cat->getScope());
					$tmpl->addVar('published_audience_options','oid',$cat->getOid());
					$tmpl->addVar('published_audience_options','title',$cat->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Audience' && 
							$cat->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_audience_options','selected','selected');
					} else {
						$tmpl->addVar('published_audience_options','selected','');	
					}
					$tmpl->parseTemplate('published_audience_options','a');
				}
				foreach ($options['series'] as $cat) {
					$tmpl->addVar('published_series_options','type',$cat->getScope());
					$tmpl->addVar('published_series_options','oid',$cat->getOid());
					$tmpl->addVar('published_series_options','title',$cat->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Genre' && 
							$cat->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_series_options','selected','selected');
					} else {
						$tmpl->addVar('published_series_options','selected','');	
					}
					$tmpl->parseTemplate('published_series_options','a');
				}
/*				
				foreach ($options['course'] as $event) {
					$tmpl->addVar('published_course_options','type',$event->getScope());
					$tmpl->addVar('published_course_options','oid',$event->getOid());
					$tmpl->addVar('published_course_options','title',$event->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Course' && 
							$event->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_course_options','selected','selected');
					} else {
						$tmpl->addVar('published_course_options','selected','');	
					}
					$tmpl->parseTemplate('published_course_options','a');
				}
*/
				$count = $index - 3;
				$tmpl->addVar('published_events','index',$index);
				$tmpl->addVar('published_events','count',$count);
				$tmpl->parseTemplate('published_events','a');

				$tmpl->clearTemplate('published_program_options');
				$tmpl->clearTemplate('published_genre_options');
				$tmpl->clearTemplate('published_audience_options');
				$tmpl->clearTemplate('published_series_options');
//				$tmpl->clearTemplate('published_course_options');
			}
			$tmpl->displayParsedTemplate('programs');
			$tabs->endTab();
			
			$tabs->startTab("Calendar","calendar_promo");
			for ($index=10; $index<=13; $index++) {
				$getter = 'getEvent' . $index;
				$eventIndex = $this->getPromoObject( $home_page->$getter() );
				foreach ($options['exhibition'] as $event) {
					$tmpl->addVar('published_cal_exhibition_options','type',$event->getScope());
					$tmpl->addVar('published_cal_exhibition_options','oid',$event->getOid());
					$tmpl->addVar('published_cal_exhibition_options','title',$event->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Exhibition' && 
							$event->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_cal_exhibition_options','selected','selected');
					} else {
						$tmpl->addVar('published_cal_exhibition_options','selected','');	
					}
					$tmpl->parseTemplate('published_cal_exhibition_options','a');
				}
				foreach ($options['program'] as $event) {
					$tmpl->addVar('published_cal_program_options','type',$event->getScope());
					$tmpl->addVar('published_cal_program_options','oid',$event->getOid());
					$tmpl->addVar('published_cal_program_options','title',$event->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Program' && 
							$event->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_cal_program_options','selected','selected');
					} else {
						$tmpl->addVar('published_cal_program_options','selected','');	
					}
					$tmpl->parseTemplate('published_cal_program_options','a');
				}

/*				
				foreach ($options['course'] as $event) {
					$tmpl->addVar('published_course_options','type',$event->getScope());
					$tmpl->addVar('published_course_options','oid',$event->getOid());
					$tmpl->addVar('published_course_options','title',$event->getTitle());
					
					if ( !empty($eventIndex) && $eventIndex->scope == 'Course' && 
							$event->getOid() == $eventIndex->id) {
						$tmpl->addVar('published_course_options','selected','selected');
					} else {
						$tmpl->addVar('published_course_options','selected','');	
					}
					$tmpl->parseTemplate('published_course_options','a');
				}
*/
				$count = $index - 9;
				$tmpl->addVar('published_calendar','index',$index);
				$tmpl->addVar('published_calendar','count',$count);
				$tmpl->parseTemplate('published_calendar','a');

				$tmpl->clearTemplate('published_cal_program_options');
				$tmpl->clearTemplate('published_cal_exhibition_options');
//				$tmpl->clearTemplate('published_cal_course_options');
			}
			$tmpl->displayParsedTemplate('calendar');
			$tabs->endTab();
		}
		
		$tmpl->displayParsedTemplate('close_form');	
	}
	
	/** 
	 * A method to separate the class and id and return them as 
	 * a standard class.
	 * @param string in the form Class.ID
	 * @return stdClass [id,scope]
	 */
	function getPromoObject($promo)
	{
		$object = new stdClass();
		$pa = preg_split("/\./",$promo);
		$object->scope = $pa[0];
		$object->id = $pa[1];
		return $object;
	}
} 
?>
