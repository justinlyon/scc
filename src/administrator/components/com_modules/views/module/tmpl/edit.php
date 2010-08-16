<?php
/**
 * @version		$Id: edit.php 18212 2010-07-22 06:02:54Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_modules
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.combobox');

$hasContent = empty($this->item->module) || $this->item->module == 'custom' || $this->item->module == 'mod_custom';
?>
<script type="text/javascript">
	function submitbutton(task)
	{
		if (task == 'module.cancel' || document.formvalidator.isValid(document.id('module-form'))) {
			<?php
			if ($hasContent) :
				echo $this->form->getField('content')->save();
			endif;
			?>
			submitform(task);
		}
		else {
			alert('<?php echo $this->escape(JText::_('COM_MODULES_ERROR_TITLE'));?>');
		}
	}
</script>

<form action="<?php JRoute::_('index.php?option=com_modules'); ?>" method="post" name="adminForm" id="module-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('JDETAILS'); ?></legend>
			<ul class="adminformlist">

			<li><?php echo $this->form->getLabel('title'); ?>
			<?php echo $this->form->getInput('title'); ?></li>

			<li><?php echo $this->form->getLabel('position'); ?>
			<?php echo $this->form->getInput('custom_position'); ?>
			<?php echo $this->form->getInput('position'); ?></li>

			<?php if ((string) $this->item->xml->name != 'Login Form'): ?>
			<li><?php echo $this->form->getLabel('published'); ?>
			<?php echo $this->form->getInput('published'); ?></li>
			<?php endif; ?>

			<li><?php echo $this->form->getLabel('access'); ?>
			<?php echo $this->form->getInput('access'); ?></li>

			<li><?php echo $this->form->getLabel('ordering'); ?>
			<?php echo $this->form->getInput('ordering'); ?></li>

			<li><?php echo $this->form->getLabel('showtitle'); ?>
			<?php echo $this->form->getInput('showtitle'); ?></li>

			<?php if ((string) $this->item->xml->name != 'Login Form'): ?>
			<li><?php echo $this->form->getLabel('publish_up'); ?>
			<?php echo $this->form->getInput('publish_up'); ?></li>

			<li><?php echo $this->form->getLabel('publish_down'); ?>
			<?php echo $this->form->getInput('publish_down'); ?></li>
			<?php endif; ?>

			<li><?php echo $this->form->getLabel('language'); ?>
			<?php echo $this->form->getInput('language'); ?></li>

			<li><?php echo $this->form->getLabel('note'); ?>
			<?php echo $this->form->getInput('note'); ?></li>

			<?php if ($this->item->id) : ?>
				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
			<?php endif; ?>

			<li><?php echo $this->form->getLabel('module'); ?>
			<?php echo $this->form->getInput('module'); ?>
			<input type="text" size="35" value="<?php if ($this->item->xml) echo ($text = (string) $this->item->xml->name) ? JText::_($text) : $this->item->module;else echo JText::_(MODULES_ERR_XML);?>" class="readonly" readonly="readonly" /></li>

			<li><?php echo $this->form->getLabel('client_id'); ?>
			<input type="text" size="35" value="<?php echo $this->item->client_id == 0 ? JText::_('JSITE') : JText::_('JADMINISTRATOR'); ?>	" class="readonly" readonly="readonly" />
			<?php echo $this->form->getInput('client_id'); ?>
			</li>
			</ul>
			<div class="clr"></div>
			<?php if ($this->item->xml) : ?>
				<?php if ($text = trim($this->item->xml->description)) : ?>
					<label>
						<?php echo JText::_('COM_MODULES_MODULE_DESCRIPTION'); ?>
					</label>
					<span class="readonly mod-desc"><?php echo JText::_($text); ?></span>
				<?php endif; ?>
			<?php else : ?>
				<p class="error"><?php echo JText::_('COM_MODULES_ERR_XML'); ?></p>
			<?php endif; ?>
			<div class="clr"></div>
		</fieldset>
	</div>

	<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','plugin-sliders-'.$this->item->id); ?>

		<?php echo $this->loadTemplate('options'); ?>

		<div class="clr"></div>

	<?php echo JHtml::_('sliders.end'); ?>
	</div>

	<div class="clr"></div>
	<?php if ($hasContent) : ?>
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_MODULES_CUSTOM_OUTPUT'); ?></legend>
			<ul class="adminformlist">
			<div class="clr"></div>
			<li><?php echo $this->form->getLabel('content'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('content'); ?></li>
			</ul>
		</fieldset>
	</div>

	<div class="clr"></div>
	<?php endif; ?>
	<?php if ($this->item->client_id == 0) :?>
	<div class="width-60 fltlft">
		<?php echo $this->loadTemplate('assignment'); ?>
	</div>
	<?php endif; ?>

	<div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
