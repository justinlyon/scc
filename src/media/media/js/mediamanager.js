/**
 * @version		$Id: mediamanager.js 16235 2010-04-20 04:13:25Z pasamio $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * JMediaManager behavior for media component
 *
 * @package		Joomla.Extensions
 * @subpackage  Media
 * @since		1.5
 */
(function($) {
var MediaManager = this.MediaManager = {

	initialize: function()
	{
		this.folderframe	= $('folderframe');
		this.folderpath		= $('folderpath');

		this.updatepaths	= $$('input.update-folder');

		this.frame		= window.frames['folderframe'];
		this.frameurl	= this.frame.location.href;
		//this.frameurl   = window.frames['folderframe'].location.href;

		this.tree = new MooTreeControl({ div: 'media-tree_tree', mode: 'folders', grid: true, theme: '../media/system/images/mootree.gif', onClick:
				function(node){
					target = $chk(node.data.target) ? node.data.target : '_self';

					// Get the current URL.
				   	uri = this._getUriObject(this.frameurl);
				   	current	= uri.file+'?'+uri.query;

					if (current != node.data.url) {
						window.frames[target].location.href = node.data.url;
					}
				}.bind(this)
			},{ text: 'Media', open: true, data: { url: 'index.php?option=com_media&view=mediaList&tmpl=component', target: 'folderframe'}});
		this.tree.adopt('media-tree');
	},

	submit: function(task)
	{
		form = window.frames['folderframe'].document.getElementById('mediamanager-form');
		form.task.value = task;
		if ($('username')) {
			form.username.value = $('username').value;
			form.password.value = $('password').value;
		}
		form.submit();
	},

	onloadframe: function()
	{
		// Update the frame url
		this.frameurl = this.frame.location.href;

		var folder = this.getFolder();
		if (folder) {
			this.updatepaths.each(function(path){ path.value =folder; });
			this.folderpath.value = basepath+'/'+folder;
			node = this.tree.get('node_'+folder);
			node.toggle(false, true);
		} else {
			this.updatepaths.each(function(path){ path.value = ''; });
			this.folderpath.value = basepath;
			node = this.tree.root;
		}

		if (node) {
			this.tree.select(node);
		}
return;
		$(viewstyle).addClass('active');

		a = this._getUriObject($('uploadForm').getProperty('action'));
		q = $H(this._getQueryObject(a.query));
		q.set('folder', folder);
		var query = [];
		q.each(function(v, k){
			if ($chk(v)) {
				this.push(k+'='+v);
			}
		}, query);
		a.query = query.join('&');

		if (a.port) {
			$('uploadForm').setProperty('action', a.scheme+'://'+a.domain+':'+a.port+a.path+'?'+a.query);
		} else {
			$('uploadForm').setProperty('action', a.scheme+'://'+a.domain+a.path+'?'+a.query);
		}
	},

	oncreatefolder: function()
	{
		if ($('foldername').value.length) {
			$('dirpath').value = this.getFolder();
			submitbutton('createfolder');
		}
	},

	setViewType: function(type)
	{
		$(type).addClass('active');
		$(viewstyle).removeClass('active');
		viewstyle = type;
		var folder = this.getFolder();
		this._setFrameUrl('index.php?option=com_media&view=mediaList&tmpl=component&folder='+folder+'&layout='+type);
	},

	refreshFrame: function()
	{
		this._setFrameUrl();
	},

	getFolder: function()
	{
		var url	 = this.frame.location.search.substring(1);
		var args	= this.parseQuery(url);

		if (args['folder'] == "undefined") {
			args['folder'] = "";
		}

		return args['folder'];
	},

	parseQuery: function(query)
	{
		var params = new Object();
		if (!query) {
			return params;
		}
		var pairs = query.split(/[;&]/);
		for ( var i = 0; i < pairs.length; i++ )
		{
			var KeyVal = pairs[i].split('=');
			if ( ! KeyVal || KeyVal.length != 2 ) {
				continue;
			}
			var key = unescape( KeyVal[0] );
			var val = unescape( KeyVal[1] ).replace(/\+ /g, ' ');
			params[key] = val;
	   }
	   return params;
	},

	_setFrameUrl: function(url)
	{
		if ($chk(url)) {
			this.frameurl = url;
		}
		this.frame.location.href = this.frameurl;
	},

	_getQueryObject: function(q) {
		var vars = q.split(/[&;]/);
		var rs = {};
		if (vars.length) vars.each(function(val) {
			var keys = val.split('=');
			if (keys.length && keys.length == 2) rs[encodeURIComponent(keys[0])] = encodeURIComponent(keys[1]);
		});
		return rs;
	},

	_getUriObject: function(u){
		var bits = u.match(/^(?:([^:\/?#.]+):)?(?:\/\/)?(([^:\/?#]*)(?::(\d*))?)((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[\?#]|$)))*\/?)?([^?#\/]*))?(?:\?([^#]*))?(?:#(.*))?/);
		return (bits)
			? bits.associate(['uri', 'scheme', 'authority', 'domain', 'port', 'path', 'directory', 'file', 'query', 'fragment'])
			: null;
	}
};
})(document.id);

window.addEvent('domready', function(){
	// Added to populate data on iframe load
	MediaManager.initialize();
	MediaManager.trace = 'start';
	document.updateUploader = function() { MediaManager.onloadframe(); };
	// MediaManager.onloadframe();
});
