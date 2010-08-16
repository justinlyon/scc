<?php
/**
 * @version		$Id: edit.php 18204 2010-07-22 04:00:25Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_languages
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	function submitbutton(task)
	{
		if (task == 'language.cancel' || document.formvalidator.isValid(document.id('language-form'))) {
			submitform(task);
		}
	}
</script>

<form action="<?php JRoute::_('index.php?option=com_languages'); ?>" method="post" name="adminForm" id="language-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<?php if ($this->item->lang_id) : ?>
				<legend><?php echo JText::sprintf('JGLOBAL_RECORD_NUMBER', $this->item->lang_id); ?></legend>
			<?php endif; ?>

			<?php echo $this->form->getLabel('title'); ?>
			<?php echo $this->form->getInput('title'); ?>

			<?php echo $this->form->getLabel('title_native'); ?>
			<?php echo $this->form->getInput('title_native'); ?>

			<?php echo $this->form->getLabel('sef'); ?>
			<?php echo $this->form->getInput('sef'); ?>

			<?php echo $this->form->getLabel('image'); ?>
			<?php echo $this->form->getInput('image'); ?>

			<?php echo $this->form->getLabel('lang_code'); ?>
			<?php echo $this->form->getInput('lang_code'); ?>

			<?php echo $this->form->getLabel('published'); ?>
			<?php echo $this->form->getInput('published'); ?>

			<?php echo $this->form->getLabel('description'); ?>
			<?php echo $this->form->getInput('description'); ?>

			<?php echo $this->form->getLabel('lang_id'); ?>
			<?php echo $this->form->getInput('lang_id'); ?>
		</fieldset>
	</div>
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','language-sliders-'.$this->item->lang_code, array('useCookie'=>1)); ?>

		<?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'metadata'); ?>
			<fieldset class="adminform">
				<?php foreach($this->form->getFieldset('metadata') as $field): ?>
					<?php if (!$field->hidden): ?>
						<?php echo $field->label; ?>
					<?php endif; ?>
					<?php echo $field->input; ?>
				<?php endforeach; ?>
			</fieldset>

		<?php echo JHtml::_('sliders.end'); ?>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<div class="clr"> </div>
</form>
