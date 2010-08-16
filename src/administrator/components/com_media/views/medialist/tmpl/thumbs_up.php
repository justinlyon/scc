<?php
/**
 * @version		$Id: thumbs_up.php 17769 2010-06-20 01:50:48Z dextercowley $
 * @package		Joomla.Administrator
 * @subpackage	com_media
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
?>
		<div class="imgOutline">
			<div class="imgTotal">
				<div align="center" class="imgBorder">
					<a href="index.php?option=com_media&amp;view=mediaList&amp;tmpl=component&amp;folder=<?php echo $this->state->parent; ?>" target="folderframe">
						<?php echo JHTML::_('image','media/folderup_32.png', '..', array('width' => 32, 'height' => 32, 'border' => 0), true); ?></a>
				</div>
			</div>
			<div class="controls">
				<span>&#160;</span>
			</div>
			<div class="imginfoBorder">
				<a href="index.php?option=com_media&amp;view=mediaList&amp;tmpl=component&amp;folder=<?php echo $this->state->parent; ?>" target="folderframe">..</a>
			</div>
		</div>
