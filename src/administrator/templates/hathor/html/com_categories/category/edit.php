<?php
/**
 * @version	 $Id: edit.php 18212 2010-07-22 06:02:54Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	templates.hathor
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

// no direct access
defined('_JEXEC') or die;

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
		if (task == 'category.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			<?php echo $this->form->getField('description')->save(); ?>
			submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<div class="category-edit">

<form action="<?php JRoute::_('index.php?option=com_menus'); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="col main-section">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_CATEGORIES_FIELDSET_DETAILS');?></legend>
				<ul class="adminformlist">
					<li><?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?></li>

					<li><?php echo $this->form->getLabel('alias'); ?>
					<?php echo $this->form->getInput('alias'); ?></li>

					<li><?php echo $this->form->getLabel('extension'); ?>
					<?php echo $this->form->getInput('extension'); ?></li>

					<li><?php echo $this->form->getLabel('parent_id'); ?>
					<?php echo $this->form->getInput('parent_id'); ?></li>

					<li><?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?></li>

					<li><?php echo $this->form->getLabel('access'); ?>
					<?php echo $this->form->getInput('access'); ?></li>

					<li><?php echo $this->form->getLabel('language'); ?>
					<?php echo $this->form->getInput('language'); ?></li>

					<li><?php echo $this->form->getLabel('id'); ?>
					<?php echo $this->form->getInput('id'); ?></li>
				</ul>

				<div class="clr"></div>
				<?php echo $this->form->getLabel('description'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('description'); ?>
				<div class="clr"></div>
		</fieldset>
	</div>

	<div class="col options-section">

		<?php echo JHtml::_('sliders.start','plugin-sliders-'.$this->item->id); ?>
			<?php echo $this->loadTemplate('options'); ?>
			<div class="clr"></div>

			<?php echo JHtml::_('sliders.panel',JText::_('COM_CATEGORIES_FIELDSET_RULES'), 'meta-rules'); ?>
			<fieldset>
				<legend class="element-invisible"><?php echo JText::_('COM_CATEGORIES_FIELDSET_RULES'); ?></legend>
					<?php //echo $this->form->getLabel('rules'); ?>
					<?php echo $this->form->getInput('rules'); ?>
			</fieldset>

			<?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'meta-options'); ?>
			<fieldset class="panelform">
				<legend class="element-invisible"><?php echo JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?></legend>
				<?php echo $this->loadTemplate('metadata'); ?>
			</fieldset>

		<?php echo JHtml::_('sliders.end'); ?>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
</div>
