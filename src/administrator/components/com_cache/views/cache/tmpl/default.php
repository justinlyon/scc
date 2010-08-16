<?php
/**
 * @version		$Id: default.php 17992 2010-07-01 05:00:53Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	com_cache
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>

<form action="<?php echo JRoute::_('index.php?option=com_cache'); ?>" method="post" name="adminForm" id="adminForm">
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" width="10">
				<?php echo JText::_('COM_CACHE_NUM'); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
			</th>
			<th class="title nowrap">
				<?php echo JHtml::_('grid.sort',  'COM_CACHE_GROUP', 'group', $listDirn, $listOrder); ?>
			</th>
			<th width="5%" class="center nowrap">
				<?php echo JHtml::_('grid.sort',  'COM_CACHE_NUMBER_OF_FILES', 'count', $listDirn, $listOrder); ?>
			</th>
			<th width="10%" class="center">
				<?php echo JHtml::_('grid.sort',  'COM_CACHE_SIZE', 'size', $listDirn, $listOrder); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="6">
			<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?php
		$i = 0;
		foreach ($this->data as $folder => $item): ?>
		<tr class="row<?php echo $i % 2; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset($i); ?>
			</td>
			<td>
				<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $item->group; ?>" onclick="isChecked(this.checked);" />
			</td>
			<td>
				<strong><?php echo $item->group; ?></strong>
			</td>
			<td class="center">
				<?php echo $item->count; ?>
			</td>
			<td class="center">
				<?php echo $item->size ?>
			</td>
		</tr>
		<?php $i++; endforeach; ?>
	</tbody>
</table>
<div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="client" value="<?php echo $this->client->id;?>" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>
