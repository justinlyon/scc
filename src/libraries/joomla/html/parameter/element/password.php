<?php
/**
 * @version		$Id: password.php 14575 2010-02-04 07:10:09Z eddieajau $
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Renders a password element
 *
 * @package		Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementPassword extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	protected $_name = 'Password';

	public function fetchElement($name, $value, &$node, $control_name)
	{
		$size = ($node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '');
		$class = ($node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"');

		return '<input type="password" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' />';
	}
}
