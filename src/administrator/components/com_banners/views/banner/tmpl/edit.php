<?php
/**
 * @version		$Id: edit.php 18204 2010-07-22 04:00:25Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_banners
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
		if (task == 'banner.cancel' || document.formvalidator.isValid(document.id('banner-form'))) {
			submitform(task);
		}
	}
	window.addEvent('domready', function() {
		document.id('jform_type0').addEvent('click', function(e){
			document.id('image').setStyle('display', 'block');
			document.id('url').setStyle('display', 'block');
			document.id('custom').setStyle('display', 'none');
		});
		document.id('jform_type1').addEvent('click', function(e){
			document.id('image').setStyle('display', 'none');
			document.id('url').setStyle('display', 'none');
			document.id('custom').setStyle('display', 'block');
		});
		if(document.id('jform_type0').checked==true) {
			document.id('jform_type0').fireEvent('click');
		} else {
			document.id('jform_type1').fireEvent('click');
		}
	});
</script>

<form action="<?php JRoute::_('index.php?option=com_banners'); ?>" method="post" name="adminForm" id="banner-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_BANNERS_NEW_BANNER') : JText::sprintf('COM_BANNERS_BANNER_DETAILS', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('name'); ?>
				<?php echo $this->form->getInput('name'); ?></li>

				<li><?php echo $this->form->getLabel('alias'); ?>
				<?php echo $this->form->getInput('alias'); ?></li>

				<li><?php echo $this->form->getLabel('access'); ?>
				<?php echo $this->form->getInput('access'); ?></li>

				<li><?php echo $this->form->getLabel('catid'); ?>
				<?php echo $this->form->getInput('catid'); ?></li>

				<li><?php echo $this->form->getLabel('type'); ?>
				<?php echo $this->form->getInput('type'); ?></li>

				<li>
				<div id="image">
					<?php foreach($this->form->getFieldset('image') as $field): ?>
						<?php if (!$field->hidden): ?>
							<?php echo $field->label; ?>
						<?php endif; ?>
						<?php echo $field->input; ?>
					<?php endforeach; ?>
				</div>
				</li>

				<li><div id="custom">
					<?php echo $this->form->getLabel('custombannercode'); ?>
					<?php echo $this->form->getInput('custombannercode'); ?>
				</div>
				</li>

				<li><div id="url">
				<?php echo $this->form->getLabel('clickurl'); ?>
				<?php echo $this->form->getInput('clickurl'); ?>
				</div>
				</li>

				<li><?php echo $this->form->getLabel('description'); ?>
				<?php echo $this->form->getInput('description'); ?></li>



				<li><?php echo $this->form->getLabel('language'); ?>
				<?php echo $this->form->getInput('language'); ?></li>

				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
			</ul>
			<div class="clr"> </div>

		</fieldset>
	</div>

<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','banner-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

	<?php echo JHtml::_('sliders.panel',JText::_('COM_BANNERS_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details'); ?>
		<fieldset class="adminform">
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('publish') as $field): ?>
				<li>
					<?php if (!$field->hidden): ?>
						<?php echo $field->label; ?>
					<?php endif; ?>
					<?php echo $field->input; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</fieldset>

	<?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'metadata'); ?>
		<fieldset class="adminform">
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset('metadata') as $field): ?>
					<?php if (!$field->hidden): ?>
						<li><?php echo $field->label; ?></li>
					<?php endif; ?>
					<li><?php echo $field->input; ?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>

	<?php echo JHtml::_('sliders.end'); ?>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</div>

<div class="clr"></div>
</form>
