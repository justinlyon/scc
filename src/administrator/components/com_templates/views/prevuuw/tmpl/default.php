<?php
/**
 * @version		$Id: default.php 17780 2010-06-20 09:03:02Z dextercowley $
 * @package		Joomla.Administrator
 * @subpackage	com_templates
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>


<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm">
<div class="width-100">
	<h3 class="title fltlft">
		<?php echo JText::_('COM_TEMPLATES_SITE_PREVIEW'); ?>
	</h3>
	<h3 class="fltrt">
		<?php echo JHTML::_('link',$this->url.'index.php?tp='.$this->tp.'&amp;template='.$this->id, JText::_('JBROWSERTARGET_NEW'), array('target' => '_blank')); ?>
	</h3>
	<div class="clr"></div>
	<div class="width-100 temprev">
		<?php echo JHTML::_('iframe',$this->url.'index.php?tp='.$this->tp.'&amp;template='.$this->id,'previewframe',  array('class' => 'previewframe')) ?>
	</div>
</div>

<div>
	<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
	<input type="hidden" name="template" value="<?php echo $this->template; ?>" />
	<input type="hidden" name="option" value="<?php echo $this->option;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="client" value="<?php echo $this->client->id;?>" />
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>
