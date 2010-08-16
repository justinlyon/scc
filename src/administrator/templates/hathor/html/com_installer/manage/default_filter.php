<?php
/**
 * @version		$Id: default_filter.php 17660 2010-06-13 16:34:39Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	templates.hathor
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

// no direct access
defined('_JEXEC') or die;

?>
<fieldset id="filter-bar">
	<div class="filter-search fltlft">
		<?php foreach($this->form->getFieldSet('search') as $field): ?>
			<?php /* remove "onchange" action for accessibility reasons*/?>
			<?php $this->form->setFieldAttribute($field->fieldname, 'onchange', '', 'filters');?>
			<?php if (!$field->hidden): ?>
				<?php echo $field->label; ?>
			<?php endif; ?>
			<?php echo $field->input; ?>
		<?php endforeach; ?>
	</div>
	<div class="filter-select fltrt">
		<?php foreach($this->form->getFieldSet('select') as $field): ?>
			<?php /* remove "onchange" action for accessibility reasons*/?>
			<?php $this->form->setFieldAttribute($field->fieldname, 'onchange', '', 'filters');?>
			<?php if (!$field->hidden): ?>
				<?php echo $field->label; ?>
			<?php endif; ?>
			<?php echo $field->input; ?>
		<?php endforeach; ?>
		<button type="button" id="filter-go" onclick="this.form.submit();">
				<?php echo JText::_('JSUBMIT'); ?></button>
	</div>
</fieldset>
<div class="clr"></div>

