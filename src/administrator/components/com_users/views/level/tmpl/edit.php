<?php
/**
 * @version		$Id: edit.php 18204 2010-07-22 04:00:25Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>

<script type="text/javascript">
function submitbutton(task)
{
	if (task == 'level.cancel' || document.formvalidator.isValid(document.id('level-form'))) {
		submitform(task);
	}
}
/*
window.addEvent('domready', function(){
	$('user-groups').getElements('input').each(function(i){
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
						c.setProperty('disabled', false);
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
*/
</script>


<form action="<?php JRoute::_('index.php?option=com_users'); ?>" method="post" name="adminForm" id="level-form" class="form-validate">
	<div class="width-100">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_USERS_LEVEL_DETAILS');?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('title'); ?></li>
				<li><?php echo $this->form->getInput('title'); ?></li>
			</ul>
		</fieldset>
	</div>

	<div class="width-50">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_USERS_USER_GROUPS_HAVING_ACCESS');?></legend>
			<?php echo JHtml::_('access.usergroups', 'jform[rules]', $this->item->rules); ?>
		</fieldset>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<div class="clr"></div>
