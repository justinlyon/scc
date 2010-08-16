<?php
/**
 * @version		$Id: default_phpinfo.php 17769 2010-06-20 01:50:48Z dextercowley $
 * @package		Joomla.Administrator
 * @subpackage	com_admin
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<fieldset class="adminform">
	<legend><?php echo JText::_('COM_ADMIN_PHP_INFORMATION'); ?></legend>
	<table class="adminform">
		<thead>
			<tr>
				<th colspan="2">
					&#160;
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th colspan="2">
					&#160;
				</th>
			</tr>
		</tfoot>
		<tbody>
			<tr>
				<td>
					<?php echo $this->php_info;?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>
