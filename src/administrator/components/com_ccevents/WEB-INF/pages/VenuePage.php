<?php
/**
 *  $Id$: VenuePage.php, Sep 4, 2006 11:55:27 PM nchanda
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

require_once WEB_INF . '/beans/Venue.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/pages/MasterPage.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/web/AddressUtil.php');

class VenuePage extends MasterPage
{	
	/**
	 * The default render method.  Displays the summary list
	 * @param bean $model The venue summary model
	 */
	public function render($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::render()');
		$this->renderSummary($model);	
	} 
	
	/**
	 * Displays the details for page for the given venue
	 * @param bean DetailPageModel
	 */
	 public function read($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::read()');
		$this->renderDetail($model);		
	 }

	/**
	 * Displays the details for page for a new venue
	 * @param bean DetailPageModel
	 */
	public function setup($model)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::setup()');
		$this->renderDetail($model);		
	 }

	/**
	 * Displays the details for page for the given venue
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
	 * @param bean $model The venue summary model
	 */
	public function delete($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::delete()');
		$this->renderSummary($model);	
	} 
	
	/**
	 * Renders the summary of given venues
	 * @param bean $model The venues summary model
	 */
	private function renderSummary($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::summary()');
		
		$data = $model->getVenues();	
		
		$tmpl = $this->createPatTemplate();
		$tmpl->readTemplatesFromInput( 'venue_summary.pat.tpl' );
		
		$tmpl->addVar('venue_summary','total',count($data));
		
		// Add the objects to the nested templates
		for ($i=0; $i<count($data); $i++) {
			$venue = $data[$i];
			$logger->debug("Class of venue: ". get_class($venue));
			$tmpl->addVar('venue','iter',$i);
			$tmpl->addVar('venue','index',$i+1);		
			// Render the primary form fields
			$tmpl->addVars('venue', BeanUtil::beanToArray($venue,true)); // scalars only
			
			$ab = $venue->getAddress();
			if ($ab->getStreet() == null) {
				$addr = "n/a";
			} else {
				
				$addr = $ab->getStreet() .",". $ab->getCity() .",". $ab->getState();	
			}
			$tmpl->addVar('venue','address',$addr);
			
			$pubwidget = $this->getPubControls($venue->getPubState());
			$tmpl->addVars('venue',$pubwidget);
			
			$ecount = 0;
			$pcount = 0;
			$ccount = 0;
			$events = $venue->getEvents();
			foreach ($events as $event) {
				switch ($event->getScope()) {
					case 'Exhibition': $ecount += 1; break;
					case 'Program': $pcount += 1; break;
					case 'Course': $ccount += 1; break;
				}
			}
			$tmpl->addVar('venue','exhibition',$ecount);
			$tmpl->addVar('venue','program',$pcount);
			$tmpl->addVar('venue','course',$ccount);
			
			$tmpl->parseTemplate('venue',"a");
		}
		$tmpl->displayParsedTemplate( 'venue_summary' );
	}
	
	/**
	 * Renders the detail page for the given venue
	 * @param bean DetailPageModel 
	 */
	private function renderDetail($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::detail()');
		
		$venue = $model->getDetail();
		$events = $venue->getEvents();
		$options = $model->getOptions();
		
		$tmpl = $this->createPatTemplate();
		$tmpl->readTemplatesFromInput( 'venue_detail.pat.tpl' );
		$tmpl->addGlobalVar('scope','Venue');
		
		// Render the primary form fields
		$tmpl->addVars('venue_form', BeanUtil::beanToArray($venue,true)); // scalars only
		
		// Renders the editor field
		$dconf = $this->getEditorConfig(Editor::MEDIUM, 'description', $venue->getDescription());
		$tmpl->addVar('venue_form','description_editor',$this->setEditor($dconf));
		
		// PubState Select
		foreach ($options['pubState'] as $ps) {
			$tmpl->addVar('pubState_options','value',$ps->value);
			$logger->debug("current: ". $ps->value ." | selected ". $venue->getPubState());
			
			if ($ps->value == $venue->getPubState()) {
				$tmpl->addVar('pubState_options','selected','selected');
			} else {
				$tmpl->addVar('pubState_options','selected','');
			}
			
			$tmpl->parseTemplate('pubState_options','a');
		}
				
		/// Address Elements
		$addr = $venue->getAddress();	
		$tmpl->addVar('address','oid',$addr->getOid());
		$tmpl->addVar('address','street',$addr->getStreet());
		$tmpl->addVar('address','unit',$addr->getUnit());
		$tmpl->addVar('address','city',$addr->getCity());
		$tmpl->addVar('address','state',$addr->getState());
		$tmpl->addVar('address','postalCode',$addr->getPostalCode());
		$tmpl->addVar('address','phone',$addr->getPhone());
			
		// State Select 
		$selectedState = DEFAULT_POSTAL_STATE_KEY;
		if ($venue->getAddress() != null && $venue->getAddress()->getState() != null) {
			$selectedState = $venue->getAddress()->getState();	
		}
		$logger->debug("Selected state: ". $selectedState);
		
		foreach(AddressUtil::getUsStates() as $key=>$value) {
			$tmpl->addVar('state_options','code',$key);
			$tmpl->addVar('state_options','name',$value);
			if ($key == $selectedState) {
				$tmpl->addVar('state_options','selected','selected');
				$logger->debug("Found matching state to select: ". $key);
			} else {
				$tmpl->addVar('state_options','selected','');
			}
			
			$tmpl->parseTemplate('state_options','a');	
		}
				
		$tmpl->displayParsedTemplate('venue_form');
		
		// Render the Tabs 	
		$tabs 	= new mosTabs(1); //1 = use cookies to remember selected tab
		$tabs->startPane("links");
		
		if( $venue->getOid() == null ) {
			$tabs->startTab("Notice","new-links");
			echo "<br/><br/>To assign events, first save this new venue.<br/><br/>";
			$tabs->endTab();	
		} else {
			$tabs->startTab("Exhibitions","exbt-links");
			foreach ($options['exhibition'] as $exbt) {
				$tmpl->addVar('exhibition_options','oid',$exbt->getOid());
				$tmpl->addVar('exhibition_options','title',$exbt->getTitle());
				
				if ( isset($events) && $this->bean_in_array($exbt,$events) ) {
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
				
				if ( isset($events) && $this->bean_in_array($prgm,$events) ) {
					$tmpl->addVar('program_options','selected','selected');
				} else {
					$tmpl->addVar('program_options','selected','');	
				}
				$tmpl->parseTemplate('program_options','a');
			}
			$tmpl->displayParsedTemplate('prgmTab');
			$tabs->endTab();
				
			$tabs->startTab("Courses","crse-links");
			foreach ($options['course'] as $crse) {
				$tmpl->addVar('course_options','oid',$crse->getOid());
				$tmpl->addVar('course_options','title',$crse->getTitle());
				
				if ( isset($events) && $this->bean_in_array($crse,$events) ) {
					$tmpl->addVar('course_options','selected','selected');
				} else {
					$tmpl->addVar('course_options','selected','');	
				}
				$tmpl->parseTemplate('course_options','a');
			}
			$tmpl->displayParsedTemplate('crseTab');
			$tabs->endTab();
			
			/*
			$tabs->startTab("Gallery","glry-links");
			foreach ($options['gallery'] as $glry) {
				$tmpl->addVar('gallery_options','gid',$glry['id']);
				$tmpl->addVar('gallery_options','name',$glry['name']);
				if ( $glry['id'] == $venue->getGallery() ) {
					$tmpl->addVar('gallery_options','selected','selected');
				} else {
					$tmpl->addVar('gallery_options','selected','');	
				}
				
				$tmpl->parseTemplate('gallery_options','a');
			}
			$tmpl->displayParsedTemplate('glryTab');
			$tabs->endTab();
			*/
		}
		
		$tmpl->displayParsedTemplate('close_form');	
	}
} 
?>
