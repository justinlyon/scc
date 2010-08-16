<?php
/**
 * @version		$Id: default.php 17024 2010-05-13 12:47:15Z hackwar $
 * @package		Joomla.Administrator
 * @subpackage	com_modules
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
?>

<ul id="new-modules-list">
<?php foreach ($this->items as &$item) : ?>
	<li>
		<?php
		// Prepare variables for the link.

		$link	= 'index.php?option=com_modules&task=module.add&eid='. $item->extension_id;
		$name	= $this->escape(JText::_($item->name));
		$desc	= $this->escape(JText::_('COM_MODULES_NODESCRIPTION'));

		if (isset($item->xml)) {
			if ($text = trim($item->xml->description)) {
				$desc = $this->escape(JText::_($text));
			}
		}
		?>
		<span class="editlinktip hasTip" title="<?php echo $name.' :: '.$desc; ?>">
			<a href="<?php echo JRoute::_($link);?>" target="_top">
				<?php echo $name; ?></a></span>
	</li>
<?php endforeach; ?>
</ul>
