/**
 *  $Id: links.js 123 2006-06-28 10:42:41Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
 
 
 function focusBlock(index, count)
 {
 	if (count) {
 		var tabId, blockId, block;
 		for (var i=0; i<count; i++) {
 			tabId = "tab"+ i;
 			blockId = "c2_block"+ i;
 			block = getElement(blockId);	
 			if ( i == parseInt(index) ) {
 				changeClass(tabId, 'active');
 				block.style.display = "block";
 			} else {
 				changeClass(tabId, 'inactive');
 				block.style.display = "none";
 			}
 		}
 	}
 }
 
 function setTask(formName,task)
 {
 	document.forms[formName].elements['task'].value = task;
 }
 
 function setScope(formName,scope)
 {
 	document.forms[formName].elements['scope'].value = scope;
 }
 
 function togglePubState(formName,oid,curState)
 {
 	//document.forms[formName].elements['eventId'] = oid;
 	/* TODO:  Put in the form submit logic here (replace the image src toggle) */
 	var img = "pubState_"+ oid;
 	var imgSrc = document.images[img].src;
 	if (imgSrc.indexOf("publish_g.png") > -1) {
 		document.images[img].src = "http://demo.joomla.org/administrator/images/publish_x.png";
 	} else {
 		document.images[img].src = "http://demo.joomla.org/administrator/images/publish_g.png";
 	}
 }
 
 function changeClass(id, class)
 {
 	var elmnt = getElement(id);
 	if(elmnt && class) {
 		elmnt.className = class;
 	}
 }
 
 function getElement(elementId)
 {
 	if (document.all) {
		return document.all[ elementId ];
	} else {
		return document.getElementById( elementId );
	}
 }
 