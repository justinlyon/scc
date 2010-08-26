<?php
/**
 *  $Id$: SeriesPage.php, Oct 13, 2006 5:23:44 PM nchanda
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

require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/pages/MasterPage.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/web/AddressUtil.php');

class AudiencePage extends MasterPage
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
		
		$tmpl = $this->createPatTemplate();
		$tmpl->readTemplatesFromInput( 'audience_summary.pat.tpl' );
		
		
		$i=0;
		foreach( $model->getList() as $cat ) {
			
			$tmpl->addVars('audience', BeanUtil::beanToArray($cat,true)); // scalars only	
			
			$tmpl->addVar('audience','iter',$i);
			$tmpl->addVar('audience','index',$i+1);
			
			// publication state
			$pubwidget = $this->getPubControls($cat->getPubState());
			$logger->debug("Publication state of category ". $cat->getName() .": ". $cat->getPubState());
			$tmpl->addVars('audience',$pubwidget);
			
			// number of events
			$events = $cat->getEvents();
			$logger->debug("Number of events". count($events));
			$tmpl->addVar('audience','program',count($events));
			
			$tmpl->parseTemplate('audience','a');
			$i++;
		}
		
		$tmpl->displayParsedTemplate( 'audience_summary' );
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
		
		$cat = $model->getDetail();
		$options = $model->getOptions();
		$tmpl = $this->createPatTemplate();
		$tmpl->readTemplatesFromInput( 'audience_detail.pat.tpl' );
		
		// Render the primary form fields
		$tmpl->addVars('audience_detail', BeanUtil::beanToArray($cat,true)); // scalars only
		
		// Render the editor field
		$dconf = $this->getEditorConfig(Editor::MEDIUM, 'description', $cat->getDescription());
		$tmpl->addVar('audience_detail','desc_editor',$this->setEditor($dconf));
		
		// PubState Select
		foreach ($options['pubState'] as $ps) {
			$tmpl->addVar('pubState_options','value',$ps->value);
			$logger->debug("current: ". $ps->value ." | selected ". $cat->getPubState());
			
			if ($ps->value == $cat->getPubState()) {
				$tmpl->addVar('pubState_options','selected','selected');
			} else {
				$tmpl->addVar('pubState_options','selected','');
			}
			
			$tmpl->parseTemplate('pubState_options','a');
		}
		$tmpl->displayParsedTemplate( 'audience_detail' );
		
		// Render the tabs
		// TODO: Consider this later
		/*
		$tabs 	= new mosTabs(0); //1 = use cookies to remember selected tab
		$tabs->startPane("links");
		
		if( $cat->getOid() == null ) {
			$tabs->startTab("Notice","new-links");
			echo "<br/><br/>To assign a Programs, first save this new Series.<br/><br/>";
			$tabs->endTab();	
		} else {
			$tmpl->addVar('program_select','scope','Series');
			
			$tabs->startTab("Programs","prgm-links");
			foreach ($options['program'] as $prgm) {
				$tmpl->addVar('program_select','oid',$prgm->getOid());
				$tmpl->addVar('program_select','title',$prgm->getTitle());
				
				if ( isset($venues) && $this->bean_in_array($ven,$venues) ) {
					$tmpl->addVar('venue_options','selected','selected');
				} else {
					$tmpl->addVar('venue_options','selected','');	
				}
				$tmpl->parseTemplate('venue_options','a');
			}
			$tmpl->displayParsedTemplate('vnueTab');		
			$tabs->endTab();
		
		
		$tmpl->displayParsedTemplate( 'prgmTab' );
		*/
		
		// Close the form
		$tmpl->displayParsedTemplate( 'close_form' );
	 }	  
} 
?>
