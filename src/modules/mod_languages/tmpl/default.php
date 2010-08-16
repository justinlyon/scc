<?php
/**
 * @version		$Id: default.php 18062 2010-07-09 02:58:04Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_languages
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('stylesheet', 'mod_languages/template.css', array(), true);
?>
<div class="mod_languages<?php echo $params->get('moduleclass_sfx') ?>">
<?php if ($headerText) : ?>
	<div class="header"><p><?php echo $headerText; ?></p></div>
<?php endif; ?>
		<ul>
<?php foreach($list as $language):?>
			<li>
				<a href="<?php echo JRoute::_('index.php?Itemid='.$language->id.'&lang=' . $language->sef);?>">
	<?php if ($params->get('image', 1)):?>
		<?php echo JHtml::_('image', 'mod_languages/'.$language->image.'.gif', $language->title, array('title'=>$language->title), true);?>
	<?php else:?>
		<?php echo $language->title;?>
	<?php endif;?>
				</a>
			</li>
<?php endforeach;?>
		</ul>
<?php if ($footerText) : ?>
	<div class="footer"><p><?php echo $footerText; ?></p></div>
<?php endif; ?>
</div>