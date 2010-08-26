<?php
/**
 *  $Id$: AnnouncementPage.php, Oct 23, 2006 2:56:43 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
require_once WEB_INF . '/beans/Announcement.php';
require_once WEB_INF . '/beans/Editor.php';
require_once WEB_INF . '/pages/MasterPage.php';
require_once ('tachometry/util/BeanUtil.php');

class AnnouncementPage extends MasterPage
{	
	/**
	 * The default render method.  Displays the editor tabs
	 * @param bean $model The summary model
	 */
	public function render($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::render()');
		$notice = $model->getList();
		
		$tmpl = $this->createPatTemplate();
		$tmpl->readTemplatesFromInput( 'announcement.pat.tpl' );
		$tmpl->displayParsedTemplate('announcement_open');
		
				
		// Render the Tabs 	
		$tabs 	= new mosTabs(0); //1 = use cookies to remember selected tab
		$tabs->startPane("links");
		
		foreach($notice as $note) {
			$logger->debug("Notice published: ". $note->getPublished());
			
			$tabs->startTab($note->getScope(), $note->getScope()."_tab");	
			
				echo "<div style='padding: 20px;'>";
				echo $this->getPublished($note->getScope(), $note->getPublished());
				$conf = $this->getEditorConfig(Editor::SMALL,$note->getScope(),$note->getContent());
				echo $this->setEditor($conf);
				echo "<input type='hidden' name='". $note->getScope() ."_oid' value='". $note->getOid() ."'/>";
				echo "</div>";			
			
			$tabs->endTab();
		}
		
		$tabs->endPane();
						
		$tmpl->displayParsedTemplate('announcement_close');
	}  
	
	
	/**
	 * Returns the string representation of the publication
	 * select box.
	 * 
	 * @param string scope The scope of the given element for namespace
	 * @param int current boolean value of the publication state
	 * @return string the in-memory rendering of the select box
	 */
	private function getPublished($scope, $published) {
		$select_name = $scope ."_published";
		$result = "Published: ";
		$result .= "<select name='". $select_name ."'>";
		$result .= "<option value='0'";
		if ($published == 0) {
			$result .= " selected";
		}
		$result .= ">Unpublished</option><option value='1'";
		if ($published == 1) {
			$result .= " selected";
		}
		$result .= ">Published</option></select><br/><br/>";

		return $result;	
	}
}
?>
