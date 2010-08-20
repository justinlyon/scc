<?php
/**
 * @version		$Id: jtext16.php 1283 2010-04-25 13:11:10Z silianacom-svn $
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * 
 * Modified as a backport to Joomla! 1.5.x 
 * (c) 2010 Yannick Gaultier
 * 
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Text  handling class
 *
 * @static
 * @package 	Joomla.Framework
 * @subpackage	Language
 * @since		1.5
 */
class JText16
{
  /**
   * Translates a string into the current language
   *
   * @access	public
   * @param	string $string The string to translate
   * @param	boolean	$jsSafe		Make the result javascript safe
   * @since	1.5
   *
   */
  function _($string, $jsSafe = false)
  {

    if (defined( $string)) {
      return constant( $string);
    }
    
    $lang = & shjlang16Helper::getLanguage();
    return $lang->_($string, $jsSafe);
  }

  /**
   * Passes a string thru an sprintf
   *
   * @access	public
   * @param	format The format string
   * @param	mixed Mixed number of arguments for the sprintf function
   * @since	1.5
   */
  function sprintf($string)
  {
    $lang = & shjlang16Helper::getLanguage();
    $args = func_get_args();
    if (count($args) > 0) {
      $args[0] = $lang->_($args[0]);
      return call_user_func_array('sprintf', $args);
    }
    return '';
  }

  /**
   * Passes a string thru an printf
   *
   * @access	public
   * @param	format The format string
   * @param	mixed Mixed number of arguments for the sprintf function
   * @since	1.5
   */
  function printf($string)
  {
    $lang = & shjlang16Helper::getLanguage();
    $args = func_get_args();
    if (count($args) > 0) {
      $args[0] = $lang->_($args[0]);
      return call_user_func_array('printf', $args);
    }
    return '';
  }

}
