/**
 * SEF module for Joomla!
 * 
 * @author $Author: shumisha $
 * @copyright Yannick Gaultier - 2007-2010
 * @package sh404SEF-15
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: list.js 1414 2010-05-23 21:04:41Z silianacom-svn $
 */


function shStopEvent(event) {

	// cancel the event
	new Event(event).stop();

}

function shProcessToolbarClick(id, pressbutton) {

	if (pressbutton != 'cancel') {
		var el = document.getElementById(id);
		var options = el.rel;
		if (typeof this.baseurl == 'undefined') {
			this.baseurl = [];
		}
		if (typeof this.baseurl[pressbutton] == 'undefined') {
			this.baseurl[pressbutton] = el.href;
		}
		var url = baseurl[pressbutton];
		var cid = document.getElementsByName('cid[]');
		var list = '';
		if (cid) {
			var length = cid.length;
			for ( var i = 0; i < length; i++) {
				if (cid[i].checked) {
					list += '&cid[]=' + cid[i].value;
				}
			}
		}
		url += list;
		el.href = url;
		SqueezeBox.fromElement(el, options);
	}

	return false;
}

function submitbutton(pressbutton) {
	if (pressbutton == "cancelPopup") {
		parent.shReloadModal = false;
		parent.SqueezeBox.close();
	} else if (pressbutton == "backPopup") {
		parent.shReloadModal = true;
		parent.SqueezeBox.close();
	} else {
		if (pressbutton) {
			document.adminForm.task.value = pressbutton;
		}
		if (typeof document.adminForm.onsubmit == "function") {
			document.adminForm.onsubmit();
		}
		document.adminForm.submit();
	}
}
