<?php
/**
 * @version		$Id: default.php 18117 2010-07-13 18:09:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="custom<?php echo $params->get('moduleclass_sfx') ?>">
	<?php echo $module->content;?>
</div>