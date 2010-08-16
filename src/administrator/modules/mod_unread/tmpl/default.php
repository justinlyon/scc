<?php
/**
 * @version		$Id: default.php 16131 2010-04-16 02:22:44Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	mod_unread
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Set the inbox class.
$inboxClass = $unread ? 'unread-messages' : 'no-unread-messages';
?>
<?php if (!empty($inboxLink)) : ?>
	<span class="<?php echo $inboxClass;?>"><a href="<?php echo $inboxLink;?>"><?php echo JText::sprintf('MOD_UNREAD_MESSAGES', $unread);?></a></span>
<?php else : ?>
	<span class="<?php echo $inboxClass;?>"><?php echo JText::sprintf('MOD_UNREAD_MESSAGES', $unread);?></span>
<?php endif; ?>