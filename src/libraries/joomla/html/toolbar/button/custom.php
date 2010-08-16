<?php
/**
 * @version		$Id: custom.php 14577 2010-02-04 07:12:36Z eddieajau $
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Renders a custom button
 *
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @since		1.5
 */
class JButtonCustom extends JButton
{
	/**
	 * Button type
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $_name = 'Custom';

	public function fetchButton($type='Custom', $html = '', $id = 'custom')
	{
		return $html;
	}

	/**
	 * Get the button CSS Id
	 *
	 * @access	public
	 * @return	string	Button CSS Id
	 * @since	1.5
	 */
	public function fetchId($type='Custom', $html = '', $id = 'custom')
	{
		return $this->_parent->getName().'-'.$id;
	}
}
