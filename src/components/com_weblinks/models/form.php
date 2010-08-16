<?php
/**
 * @version		$Id: form.php 17686 2010-06-14 22:20:14Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'models' . DS . 'weblink.php';

/**
 * Weblinks model.
 *
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @since		1.6
 */
class WeblinksModelForm extends WeblinksModelWeblink {}
