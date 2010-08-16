<?php
/**
 * String Stream Controller
 *
 * Used to control the string stream
 *
 * PHP4/5
 *
 * Created on Sep 18, 2008
 *
 * @package stringstream
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 * @version SVN: $Id: stringcontroller.php 17854 2010-06-23 17:43:55Z eddieajau $
 */


// No direct access
defined('JPATH_BASE') or die();


class JStringController {

	function _getArray() {
		static $strings = Array();
		return $strings;
	}

	function createRef($reference, &$string) {
		$ref = &JStringController::_getArray();
		$ref[$reference] =& $string;
	}


	function getRef($reference) {
		$ref = &JStringController::_getArray();
		if(isset($ref[$reference])) {
			return $ref[$reference];
		} else {
			return false;
		}
	}
}