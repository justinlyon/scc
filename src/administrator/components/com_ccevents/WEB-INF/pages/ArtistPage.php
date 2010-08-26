<?php
/**
 *  $Id$: 
 *  Copyright (c) 2008, Tachometry Corporation
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

require_once WEB_INF . '/beans/Person.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/pages/MasterPage.php';
require_once ('tachometry/util/BeanUtil.php');

class ArtistPage extends MasterPage
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
	 * Renders the person summary template
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
	 	$tmpl->readTemplatesFromInput( 'person_summary.pat.tpl' );
	 	
	 	$tmpl->addVar('person_summary','total',count($list));
	 	
	 	// Add the objects to the nested templates
		for ($i=0; $i<count($list); $i++) {
			$person = $list[$i];
			$logger->debug("Class of person [Person]: ". get_class($person));

			$tmpl->addVar('person','iter',$i);
			$tmpl->addVar('person','index',$i+1);
			$tmpl->addVars('person', BeanUtil::beanToArray($person,true)); // scalars only
			
			// Set the publication value			
			$pubwidget = array();
			if($person->getPubState() == PublicationState::PUBLISHED) {
				$pubwidget['pubimg'] = 'publish_g.png';
				$pubwidget['pubalt'] = PublicationState::PUBLISHED;
				$pubwidget['pubtask'] = 'unpublish';
				$pubwidget['pubtoggle'] = PublicationState::UNPUBLISHED;
			} else if ($person->getPubState() == PublicationState::UNPUBLISHED) {
				$pubwidget['pubimg'] = 'publish_x.png';
				$pubwidget['pubalt'] = PublicationState::UNPUBLISHED;
				$pubwidget['pubtask'] = 'publish';
				$pubwidget['pubtoggle'] = PublicationState::PUBLISHED;	
			}
			$tmpl->addVars('person',$pubwidget);
									
			$tmpl->parseTemplate('person',"a");	
		}
	 	$tmpl->displayParsedTemplate( 'person_summary' );
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
		
		$person = $model->getDetail();
		$options = $model->getOptions();
		$exhibitions = $person->getExhibitions();
		$tmpl = $this->createPatTemplate();
		$tmpl->readTemplatesFromInput( 'person_detail.pat.tpl' );

		// Render the primary form fields
		$tmpl->addVars('person_detail', BeanUtil::beanToArray($person,true)); // scalars only
		
		// Render the editor fields
		$sconf = $this->getEditorConfig(Editor::SMALL, 'summary', $person->getSummary());
		$tmpl->addVar('person_detail','summary_editor',$this->setEditor($sconf));
		
		// PubState Select
		foreach ($options['pubState'] as $ps) {
			$tmpl->addVar('pubState_options','value',$ps->value);
			$logger->debug("current: ". $ps->value ." | selected ". $person->getPubState());
			
			if ($ps->value == $person->getPubState()) {
				$tmpl->addVar('pubState_options','selected','selected');
			} else {
				$tmpl->addVar('pubState_options','selected','');
			}
			
			$tmpl->parseTemplate('pubState_options','a');
		}
		$tmpl->displayParsedTemplate( 'person_detail' );

		// Render the Tabs 	
		$tabs 	= new mosTabs(1); //1 = use cookies to remember selected tab
		$tabs->startPane("links");
		
		if( $person->getOid() == null ) {
			$tabs->startTab("Notice","new-links");
			echo "<br/><br/>To assign a gallery, first save this new person.<br/><br/>";
			$tabs->endTab();	
		} else {
			$tabs->startTab("Gallery","glry-links");
			foreach ($options['gallery'] as $glry) {
				$tmpl->addVar('gallery_options','gid',$glry->id);
				$tmpl->addVar('gallery_options','name',$glry->title);
				if ( $glry->id == $person->getGallery() ) {
					$tmpl->addVar('gallery_options','selected','selected');
				} else {
					$tmpl->addVar('gallery_options','selected','');	
				}
				
				$tmpl->parseTemplate('gallery_options','a');
			}
			$tmpl->displayParsedTemplate('glryTab');
			$tabs->endTab();
		
			$tabs->startTab("Exhibitions","exbt-links");
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
		}
		
		// Close the form
		$tmpl->displayParsedTemplate( 'close_form' );
	 }	


} 
?>
