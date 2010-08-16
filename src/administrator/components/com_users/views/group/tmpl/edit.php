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
		if (task == 'group.cancel' || document.formvalidator.isValid(document.id('group-form'))) {
			submitform(task);
		}
	}
</script>

<form action="<?php JRoute::_('index.php?option=com_users'); ?>" method="post" name="adminForm" id="group-form" class="form-validate">
	<div class="width-100">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_USERS_USERGROUP_DETAILS');?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?></li>

				<?php $parent_id = $this->form->getField('parent_id');?>
				<li><?php if (!$parent_id->hidden) echo $parent_id->label; ?>
				<?php echo $parent_id->input; ?></li>
			</ul>
		</fieldset>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<div class="clr"></div>
