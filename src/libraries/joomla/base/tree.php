<?php
/**
 * @version		$Id: tree.php 14644 2010-02-05 08:35:59Z chdemko $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;
require_once dirname(__FILE__).'/node.php';

/**
 * Tree Class.
 *
 * @package		Joomla.Framework
 * @subpackage	Base
 * @since		1.5
 */
class JTree extends JObject
{
	/**
	 * Root node
	 */
	protected $_root = null;

	/**
	 * Current working node
	 */
	protected $_current = null;

	function __construct()
	{
		$this->_root = new JNode('ROOT');
		$this->_current = & $this->_root;
	}

	function addChild(&$node, $setCurrent = false)
	{
		$this->_current->addChild($node);
		if ($setCurrent) {
			$this->_current = &$node;
		}
	}

	function getParent()
	{
		$this->_current = &$this->_current->getParent();
	}

	function reset()
	{
		$this->_current = &$this->_root;
	}
}

