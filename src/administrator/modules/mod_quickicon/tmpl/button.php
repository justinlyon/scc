<?php
/**
 * @version		$Id: button.php 15113 2010-02-28 14:34:26Z hackwar $
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

?>

<div class="icon-wrapper">
	<div class="icon">
		<a href="<?php echo $button['link']; ?>">
			<?php echo JHTML::_('image','header/'.$button['image'], NULL, NULL, true); ?>
			<span><?php echo $button['text']; ?></span></a>
	</div>
</div>