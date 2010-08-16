<?php

/*------------------------------------------------------------------------
# Copyright (C) 2005-2010 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 

jckimport('ckeditor.htmlwriter.htmlwriter');
jckimport('ckeditor.htmlwriter.javascript');

class JCKHtmlwriterHelper
{

	function EditorTextArea($name,$content,$buttons)
    {
 
		$html =  JCKHtmlwriter::textarea($name,$content);
		
		//load CKEditor script
		$javascript = new JCKJavascript();
		$javascript->addScriptDeclaration(
		'window.addEvent("domready",function()
				{	
					CKEDITOR.config.expandedToolbar = true;
					Replace'.$name.'TextContainer("'.  $name .'"); 
				});');
		
		 $html .= $javascript->toString();
				 
		 //Get buttons
		if(!empty($buttons))
		{
			
			// Load modal popup behavior
			JHTML::_('behavior.modal', 'a.modal-button');
			
			$editor =& JFactory::getEditor('jckeditor');
			
			//set event handlers
			$args['name'] = $name;
			$args['event'] = 'onGetInsertMethod';
	
			$results[] = $this->update($args);
			foreach ($results as $result) {
				if (is_string($result) && trim($result)) {
					$html .= $result;
				}
			}
			
		 	$plugins = $editor->getButtons($name,$buttons);
			$buttons = '';
			
			foreach($plugins as $plugin)
			{
				$className	=	($plugin->get('modal')) ? "modal-button" : '';
				$url		= 	($plugin->get('link')) ? $plugin->get('link') : '';
				$click		= 	($plugin->get('onclick')) ? $plugin->get('onclick') : '';
				$options 	=  	$plugin->get('options');
				$content	=	$plugin->get('text'); 
				$buttonName = 	$plugin->get('name'); 
				$buttons 	.=  JCKHtmlwriter::buttonModalLink($url,$content,$options,$buttonName,$className,$click,array("class"=>"button2-left"));
			}
			$container	= JCKHtmlwriter::DivContainer($buttons,'editor-xtd-buttons');
			$html .= $container; 
		}
		
		return $html;

	}

}

?>