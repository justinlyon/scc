<?php
/**
 * @version		$Id: default_profile.php 18216 2010-07-22 09:35:13Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if (JPluginHelper::isEnabled('user', 'profile')) : ?>
<div class="jcontact-profile">
	<ol>
		<?php foreach ($this->contact->profile as $profile) :	?>
			<li>

				<?php echo $profile->text = htmlspecialchars($profile->profile_value, ENT_COMPAT, 'UTF-8'); ?>

			</li>
		<?php endforeach; ?>
	</ol>
</div>
<?php endif; ?>
