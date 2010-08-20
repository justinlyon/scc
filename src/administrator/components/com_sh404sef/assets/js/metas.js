/**
 * SEF module for Joomla!
 * 
 * @author $Author: shumisha $
 * @copyright Yannick Gaultier - 2007-2010
 * @package sh404SEF-15
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: metas.js 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

function shAjaxHandler(task, options, closewindow) {

	var form = $('adminForm');
	form.task.value = task;
	form.format.value = "raw";
	form.shajax.value = 1;
	//form.tmpl.value="component";

	// Create a progress indicator
	var update = $("sh-message-box").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	$("sh-error-box").empty();

	// Set the options of the form"s Request handler.
	var options = {};
	options.onComplete = function(response, responseXML) {
		//alert(response);
		var root, status, message;
		try {
			root = responseXML.documentElement;
			status = root.getElementsByTagName("status").item(0).firstChild.nodeValue;
			message = root.getElementsByTagName("message").item(0).firstChild.nodeValue;
		} catch (err) {
			status = 'failure';
			message = "<div id='error-box-content'><ul><li>Sorry, something went wrong on the server while performing this action. Please retry or cancel</li></ul></div>";
		}

		// remove progress indicator
		var update = $("sh-message-box").empty();

		// insert results
		if (status == "success") {
			update.setHTML(message);
			if (closewindow) {
				setTimeout("parent.SqueezeBox.close()", 1500);
			} else {
				setTimeout("$('sh-message-box').empty()", 3000);
			}
		} else if (status == 'redirect') {
			setTimeout( "parent.window.location='" + message + "';", 100);
			parent.shReloadModal = false;
			parent.SqueezeBox.close();
		} else {
			$('sh-error-box').setHTML(message);
			setTimeout("$('sh-error-box').empty();", 5000);
		}

	};

	// Send the form.
	form.send(options);
}
