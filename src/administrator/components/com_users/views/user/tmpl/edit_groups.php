<?php
/**
 * @version		$Id: edit_groups.php 17711 2010-06-16 10:13:41Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
?>

<script>
window.addEvent('domready', function(){
	document.id('user-groups').getElements('input').each(function(i){
		// Event to check all child groups.
		i.addEvent('check', function(e){
			// Check the child groups.
			document.id('user-groups').getElements('input').each(function(c){
				if (this.getProperty('rel') == c.id) {
					c.setProperty('checked', true);
					c.setProperty('disabled', true);
					c.fireEvent('check');
				}
			}.bind(this));
		}.bind(i));

		// Event to uncheck all the parent groups.
		i.addEvent('uncheck', function(e){
			// Uncheck the parent groups.
			document.id('user-groups').getElements('input').each(function(c){
				if (c.getProperty('rel') == this.id) {
					c.setProperty('checked', false);
					c.setProperty('disabled', false);
					c.fireEvent('uncheck');
				}
			}.bind(this));
		}.bind(i));

		// Bind to the click event to check/uncheck child/parent groups.
		i.addEvent('click', function(e){
			// Check the child groups.
			document.id('user-groups').getElements('input').each(function(c){
				if (this.getProperty('rel') == c.id) {
					c.setProperty('checked', true);
					if (this.getProperty('checked')) {
						c.setProperty('disabled', true);
					} else {
						// If there are no other siblings checked, set the parent enabled
						var tmp = false;
						document.id('user-groups').getElements('input[rel='+c.getProperty('id')+']').each(function(d){
							if(d.getProperty('checked')){
								tmp=true;
							}
						});
						c.setProperty('disabled', tmp);
					}
					c.fireEvent('check');
				}
			}.bind(this));

			// Uncheck the parent groups.
			document.id('user-groups').getElements('input').each(function(c){
				if (c.getProperty('rel') == this.id) {
					c.setProperty('checked', false);
					c.setProperty('disabled', false);
					c.fireEvent('uncheck');
				}
			}.bind(this));
		}.bind(i));

		// Initialise the widget.
		if (i.getProperty('checked')) {
			i.fireEvent('click');
		}
	});
});
</script>
<?php echo JHtml::_('access.usergroups', 'jform[groups]', array_keys($this->groups)); ?>
