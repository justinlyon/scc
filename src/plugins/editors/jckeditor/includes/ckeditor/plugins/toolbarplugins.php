<?php

/*------------------------------------------------------------------------
# Copyright (C) 2005-2010 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 

class JCKToolbarPlugins extends JCKPlugins  
{
	//core plugins to remove
	var $dialog = 0;
	var $htmldataprocessor = 0;
	var $flash = 0;
	var $filebrowser = 0;	
	var $save = 0;
	var $toolbar = 0;
	var $about = 0;
	
	//extra plgins to add
	var $jhtmldataprocessor = 1;
	var $jflash = 1;
	var $jfilebrowser = 1;
	var $jsave = 1;
	var $jlink = 1;
	var $jdocumentlistener = 1;
	var $jtoolbar = 1;
	var $jdialogdefinitionlistener =1;
	var $jroverride =1;
	var $safariroverride = 1;
	var $stylesoverride = 1;
	var $jabout = 1;
	var $ajaxoverride = 1;

}