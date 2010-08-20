/**
 * SEF module for Joomla!
 * 
 * @author $Author: shumisha $
 * @copyright Yannick Gaultier - 2007-2010
 * @package sh404SEF-15
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: cp.js 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

var shQuickControlNeedsUpdate = false;

function shSetupQuickControl() {
	var url = "index.php?option=com_sh404sef&c=config&view=config&layout=qcontrol&format=raw&tmpl=component&noMsg=1";
	new Ajax(url, {
		method : 'get',
		onComplete : function(response) {
			shUpdateQuickControl(response);
		}
	}).request();
}

function shUpdateQuickControl(response) {

	$('qcontrolcontent').setHTML(response);
	var JTooltips = new Tips($$('.hasTip'), {
		maxTitleChars : 50,
		fixed : false
	});
	setTimeout("$('sh-message-box').empty()", 3000);
	setTimeout("$('sh-error-box').empty()", 5000);

}

function shSetupSecStats(task) {
	task = task ? task : 'showsecstats';
	var url = "index.php?option=com_sh404sef&task=" + task
			+ "&layout=secstats&format=raw&tmpl=component&noMsg=1";
	var update = $("sh-progress-cpprogress").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	new Ajax(url, {
		method : 'get',
		onComplete : function(response) {
			update.empty();
			shUpdateSecStats(response);
		}
	}).request();
}

function shUpdateSecStats(response) {

	$('secstatscontent').setHTML(response);
	setTimeout("$('sh-message-box').empty()", 3000);
	setTimeout("$('sh-error-box').empty()", 5000);

}

function shSetupUpdates(forced) {
	forced = forced ? "forced=1" : 'forced=0';
	var url = "index.php?option=com_sh404sef&task=showupdates&layout=updates&format=raw&tmpl=component&noMsg=1&"+forced;
	var update = $("sh-progress-cpprogress").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	new Ajax(url, {
		method : 'get',
		onComplete : function(response) {
			update.empty();
			shUpdateUpdates(response);
		}
	}).request();
}

function shUpdateUpdates(response) {

	$('updatescontent').setHTML(response);
	setTimeout("$('sh-message-box').empty()", 3000);
	setTimeout("$('sh-error-box').empty()", 5000);

}

function shSubmitQuickControl(event) {

	// cancel the event
	new Event(event).stop();

	var form = $('adminForm');

	// Create a progress indicator
	var update = $("sh-progress-cpprogress").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	$("sh-error-box").empty();

	// Set the options of the form"s Request handler.
	var options = {};
	options.onComplete = function(response) {
		var message;
		// alert(response);
		message = "<div id='error-box-content'><ul><li>Sorry, something went wrong on the server while performing this action. Please try again or contact administrator</li></ul></div>";

		// remove progress indicator
		var update = $("sh-progress-cpprogress").empty();

		// insert results
		shUpdateQuickControl(response)

	};

	// Send the form.
	form.send(options);

}
