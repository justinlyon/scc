<?php
/**
 * @version		$Id: default.php 18117 2010-07-13 18:09:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_users_latest
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;
?>
	<ul  class="latestusers<?php echo $params->get('moduleclass_sfx') ?>" >
<?php foreach($names as $name) : ?>

		<li>
		<?php if ($linknames==1) { ?>
		<a href="index.php?option=com_users&view=profile&member_id=<?php echo (int) $name->id ?>">
		<?php } ?>
		<?php echo $name->username; ?>
			<?php if ($linknames==1) : ?>
				</a>
			<?php endif; ?>
		</li>
<?php endforeach;  ?>
	</ul>
