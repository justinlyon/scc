<?php 

/*------------------------------------------------------------------------
# Copyright (C) 2005-2010 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 

jckimport('ckeditor.htmlwriter.javascript');
jckimport('ckeditor.stylesheet');


class JCKJavascriptHelper
{
	function getHeadJavascript(&$params,&$errors,&$excludeEventHandlers)
	{
	  		
		global $option;	
			
		//lets get JS object
		$javascript =& JCKJavascript::getInstance();
		//now Add intialisation scripts
		
		$mainframe =& JFactory::getApplication();
		
		$path_root = '../';
		
		if($mainframe->isSite())
			$path_root = '';
		
		
		
		
		
		jimport('joomla.environment.browser');
		$instance	=& JBrowser::getInstance();
		$language	=& JFactory::getLanguage();
	

		if ($language->isRTL()) {
			$direction = 'rtl';
		} else {
			$direction = 'ltr';
		}
		
		
		/* Load the CK's Parameters */
		$toolbar 			=	$params->def( 'toolbar', 'Full' );
		$toolbar_ft 		=	$params->def( 'toolbar_ft', 'Full' );
		$skin				= 	$params->def( 'skin', 'office2007' );
		$text_direction		=	$params->def( 'text_direction', 'ltr' );
		$wwidth				=   $params->def( 'wwidth', '100%' );
		$hheight			= 	$params->def( 'hheight', 480 );
		$lang_mode			= 	$params->def( 'lang_mode', 0 );
		$lang				= 	$params->def( 'lang_code', 'en' );
		$entermode 			= 	$params->def( 'entermode', 1 );
		$shiftentermode 	= 	$params->def( 'shiftentermode', 0 );
		$uicolor 			= 	$params->def( 'uicolor', '#D6E6F4' );
		$imagepath			=   $params->def( 'magePath','images/stories');
		$returnScript 		= 	$params->get( 'returnScript', true );
		$editorname 		= 	$params->get( 'editorname');
		$bgcolor			= 	$params->get( 'bgcolor','#ffffff');
		
		//override autoLoad value if set in config
		jckimport('ckeditor.autoload.startconfig');
		
		$startConfig = new JCKStartConfig();
		
			
		if(isset($startConfig->$option))
			$excludeEventHandlers = $startConfig->$option;		
		else	
			$excludeEventHandlers	= $returnScript;
			
		
		//set default view for toolabar
		$toolbar = $toolbar == 'Default' ? 'Full' : $toolbar;
		$toolbar_ft = $toolbar_ft == 'Default' ? 'Full' : $toolbar_ft;
		
		if(!$path_root)
		{
		  	//set toolbar to compact mode
			$toolbar = $toolbar_ft;
		}

		// If language mode set 
		
	    // set default Joomla language setting
		 switch ($lang_mode)
		 {
			 case 0:
				 $AutoDetectLanguage = 	$lang; // User selection
				 break;
			 case 1:
			 	$AutoDetectLanguage = 	""; // Joomla Default
				$lang = substr( $language->getTag(), 0, strpos( $language->getTag(), '-' ) ); //access joomlas global configuation and get the language setting from there
				break;
			 case 2:
			 	$AutoDetectLanguage = 	""; // Browser default
 				break; 
		 }
		 	 
		 
		 $stylesheet =& JCKStylesheet::getInstance($path_root);
		 $content_css = $stylesheet->getPath($params,$errors);
		 
		 $stylesheetJSO = $stylesheet->getJSObject();
				
		/*
		 $jsloadJSO = 'var ckstyles_template;
		 
		 			window.addEvent("domready",function()
					{
						CKEDITOR.on("instanceReady",function(evt)
						{
							ckstyles_template = '.$stylesheetJSO .';
						});
					});';	
		$javascript->addScriptDeclaration($jsloadJSO);
		*/
		
		//Get toolbar plugins object
		jckimport('ckeditor.plugins');
		jckimport('ckeditor.plugins.toolbarplugins');
		$plugins = new JCKtoolbarPlugins();
	
		$javascript->addScriptDeclaration(
		"window.addEvent(\"domready\",function() 
		{
			CKEDITOR.on('instanceCreated',function(evt)
			{
				 var editor = evt.editor;
				 
				 
				 
				 editor.on( 'customConfigLoaded', function()
				 {
					 CKEDITOR.tools.extend( editor.config, 
											{
												removePlugins : '" . $plugins->getRemovedPlugins() ."', 
												extraPlugins :	'" . $plugins->getExtraPlugins() ."'
											}, true );
	
				 });	 
				 
				 //addCustom CSS
				 editor.addCss( 'body { background: ". $bgcolor . " none; }' );
				 
			});
								
		});");
	
		
		
		//add JS for selected toolbar
		
		jckimport('ckeditor.toolbar');
		$toolbarFileName = strtolower($toolbar);
	    jckimport('ckeditor.toolbar.' . $toolbarFileName);
		
		$toolbarClassName = 'JCK'.$toolbar;
		$toolbarObj = new $toolbarClassName();
		
		$jsonToolbarArray = $toolbarObj->toString();
		
		jckimport('ckeditor.plugins.helper');
		
		$session =& JFactory::getSession();
		//clear stored jckplugins
		$session->clear('jckplugins');		
		
		
		$_GET['client'] = $mainframe->getClientId();
		
		JCKPluginsHelper::storePlugins('editor');
		JCKPluginsHelper::importPlugin('editor');
		
		$beforeloadResult = $mainframe->triggerEvent('beforeLoad',array( $params));
		$afterloadResult = $mainframe->triggerEvent('afterLoad', array( $params));
		
		$javascript->addScriptDeclaration(
		"window.addEvent(\"domready\",function() 
		{
			CKEDITOR.on('instanceCreated',function(evt)
			{
				 var editor = evt.editor;
				 editor.on( 'customConfigLoaded', function()
				 {
					editor.config.toolbar_$toolbar = $jsonToolbarArray;
	
				 });
			" .  (!empty($beforeloadResult) ? implode(chr(13), $beforeloadResult) : '') ."	
					
				 
			});
		});");
		
		
		$javascript->addScriptDeclaration(
		"window.addEvent(\"domready\",function() 
		{
			CKEDITOR.on('instanceReady',function(evt)
			{
				 var editor = evt.editor;
				 " .  (!empty($afterloadResult) ? implode(chr(13), $afterloadResult) : '') ."	
			});
		});");
			
			
		$javascript->addScriptDeclaration("var oEditor;
								   
				function ReplaceTextContainer(div,autoHeight)
				{
					//destroy editor instance if one already exist 
					if ( oEditor )
						oEditor.destroy();
					
								
					CKEDITOR.config.startupFocus = true;		
					//create editor instance
					oEditor = CKEDITOR.replace(div,
					{ 
						 baseHref : '" .JURI::root() . "',
						 imagePath :  '$imagepath',     
						 toolbar : CKEDITOR.config.expandedToolbar ? '$toolbar' : 'Image',
						 toolbarStartupExpanded : CKEDITOR.config.expandedToolbar,
						 uiColor	: '$uicolor',
						 skin : '$skin',	
						 contentsCss :'$content_css',
						 contentsLangDirection : '$direction',
						 language : '$AutoDetectLanguage',
						 defaultLanguage :'$lang', 
						 enterMode : '$entermode',
						 shiftEnterMode : '$shiftentermode',
						 stylesSet : ". $stylesheetJSO .",
						 width : '$wwidth',
						 height: autoHeight ? div.clientHeight +28 : '$hheight'
					});
				}"); 
		
		$javascript->addScriptDeclaration("
								   
				function Replace" . $editorname . "TextContainer(div)
				{
					CKEDITOR.config.startupFocus = true;		
					
					//create editor instance
					var oEditor = CKEDITOR.replace(div,
					{ 
						 baseHref : '" .JURI::root() . "',
						 imagePath :  '$imagepath',     
						 toolbar : CKEDITOR.config.expandedToolbar ? '$toolbar' : 'Image',
						 toolbarStartupExpanded : CKEDITOR.config.expandedToolbar,
						 uiColor	: '$uicolor',
						 skin : '$skin',	
						 contentsCss :'$content_css',
						 contentsLangDirection : '$direction',
						 language : '$AutoDetectLanguage',
						 defaultLanguage :'$lang', 
						 enterMode : '$entermode',
						 shiftEnterMode : '$shiftentermode',
						 stylesSet : " . $stylesheetJSO .",
						 width : '$wwidth',
						 height: '$hheight'
					});
				}"); 
		
		
		 
	 	
		$handlerjs ="
		
		function editor_onDoubleClick( ev )
		{
			// Get the element which fired the event. This is not necessarily the
			// element to which the event has been attached.
			var element = ev.target || ev.srcElement;
			// Find out the divtext container that holds this element.
			
			while( !(element.nodeName.toLowerCase() == 'div' && (element.hasAttribute('ckid') || element.className.indexOf( 'editable' ) != -1  )) && element.nodeName.toLowerCase() != 'textarea'
					&& (element.parentNode && element.parentNode.nodeName.toLowerCase() != 'body'))
				element = element.parentNode;
			
			if ( (element.nodeName.toLowerCase() == 'div' && (element.hasAttribute('ckid') || element.className.indexOf( 'editable' ) != -1 )) || element.nodeName.toLowerCase() == 'textarea')
			{
				if(element.hasAttribute('ckid') && element.getAttribute('ckid') == 'image'){
				
					CKEDITOR.config.expandedToolbar = false;
					ReplaceTextContainer( element,true);
				}else{
					CKEDITOR.config.expandedToolbar = true;
					ReplaceTextContainer( element,false);}
			}		
		}

		var editor_implementOnInstanceReady = function() 
		{
			//CKEDITOR.config.expandedToolbar = false;
			
			CKEDITOR.on('instanceReady',function(evt)
			{
				
				evt.editor.focus(); // why do we need to do this?
				if(!CKEDITOR.config.expandedToolbar)
				{
					var editor = evt.editor;
					var imgElement  = editor.document.getBody().getElementsByTag('img').getItem(0);
					if(imgElement)
					{
						if(editor.getSelection())
							editor.getSelection().selectElement(imgElement);
					}		
					//add double click
					editor.document.on('dblclick', function(evt)
					{
						evt.listenerData.editor.getCommand('ImageManager').exec(evt.listenerData.editor);	
					},null,{editor : editor});
				
					if(editor.getSelection())
						editor.getCommand('ImageManager').exec(editor);	
						
				}	

			});
			
		}		
		if ( window.addEventListener )
		{
			window.addEventListener( 'load', editor_implementOnInstanceReady, false );	
			window.addEventListener( 'dblclick', editor_onDoubleClick, false );
		}
		else if ( window.attachEvent )
		{
			window.attachEvent( 'onload', editor_implementOnInstanceReady);
			window.document.attachEvent( 'ondblclick', editor_onDoubleClick );
		}";
		
		if(!$excludeEventHandlers)
			$javascript->addScriptDeclaration($handlerjs);		  
	  
	  return $javascript;
	}
	
	
	 function addInsertEditorTextMethod($name)
	 {
		$javascript = new JCKJavascript();
		$javascript->addScriptDeclaration(		
			"function jInsertEditorText( text) {
				if(oEditor) 
					oEditor.insertHtml( text ); 
				else
					CKEDITOR.instances.$name.insertHtml( text );
		}");
		$javascript->addToHead();
		
		return true;
	 
	 }
	 
	 function setContent($editor,$html)
	 {
	 	return " if (!oEditor) CKEDITOR.instances.$editor.setData('" .  htmlentities($html) . 
			"') ; else oEditor.setData('" .  htmlentities($html) . "')";
	 }
	 
	 function getContent($editor)
	 {
	 	return " (!oEditor) ? CKEDITOR.instances.$editor.getData() : oEditor.getData();";
	 }
	 

}

?>