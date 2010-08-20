/**
 * SEF module for Joomla!
 * 
 * @author $Author: shumisha $
 * @copyright Yannick Gaultier - 2007-2010
 * @package sh404SEF-15
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: config.js 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

function shAjaxHandler(task, options, closewindow) {

	var form = $('adminForm');
	form.task.value = task;

	if (task == 'save' || task == 'apply') {
		if (typeof shCollectEditorData != 'undefined') {
			shCollectEditorData();
		}
	}

	// Create a progress indicator
	var update = $("sh-message-box").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	$("sh-error-box").empty();

	// Set the options of the form"s Request handler.
	options.onComplete = function(response, responseXML) {
		var root, status, message, messageCode, taskexecuted;
		//alert(response);
		try {
			root = responseXML.documentElement;
			status = root.getElementsByTagName("status").item(0).firstChild.nodeValue;
			message = root.getElementsByTagName("message").item(0).firstChild.nodeValue;
			messageCode = root.getElementsByTagName("messagecode").item(0).firstChild.nodeValue;
			taskexecuted = root.getElementsByTagName("taskexecuted").item(0).firstChild.nodeValue;
		} catch (err) {
			status = 'failure';
			message = "<div id='error-box-content'><ul><li>Sorry, something went wrong on the server while performing this action. Please retry or cancel</li></ul></div>";
		}

		// remove progress indicator
		var update = $("sh-message-box").empty();

		// insert results
		if (status == "success") {
			update.setHTML(message);
			if (closewindow) { // save
				parent.shReloadModal = false;
				if (taskexecuted=='default' || taskexecuted=='ext' || taskexecuted=='sec') {
				  parent.shSetupQuickControl();
				  setTimeout("parent.SqueezeBox.close();", 1500);
				} else {
				  setTimeout("parent.SqueezeBox.close();", 1500);
				}
					
			} else { // apply
				if (taskexecuted=='default' || taskexecuted=='ext' || taskexecuted=='sec') {
				  parent.shSetupQuickControl();
				}
				if (taskexecuted!='default' && taskexecuted!='ext') {
					setTimeout("$('sh-message-box').empty()", 3000);
				}
			}
		} else if (status == 'redirect') {
			setTimeout("parent.window.location='" + message + "';", 100);
			//parent.shReloadModal = false;
			//parent.SqueezeBox.close();
		} else {
			$('sh-error-box').setHTML(message);
			setTimeout("$('sh-error-box').empty();", 5000);
		}

	};

	// Send the form.
	form.send(options);
}

function submitbutton(pressbutton) {
	if (pressbutton == "cancel") {
		parent.shReloadModal = false;
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