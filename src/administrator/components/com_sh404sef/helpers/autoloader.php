<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: autoloader.php 1493 2010-07-18 16:24:05Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefAutoloader {

  public static $_prefix = 'Sh404sef';
  /**
   * Finds path to file containing requested class
   * according to sh404sef naming conventions
   * Feed that filename to JLoader so that
   * it gets loaded next
   *
   * Can be
   *       PrefixControllerSuffix
   *       PrefixModelSuffix
   *       PrefixHelperSuffix
   *       PrefixTableSuffix
   *       PrefixElementSuffix
   *       PrefixViewHelperSuffix
   *       PrefixClassSuffix
   *       PrefixAdapterSuffix
   *       PrefixExceptionSuffix
   *       PrefixFactory
   * with Prefix = 'Sh404sef'
   *
   * Classes are aways stored in backend, in Sh404sef folder
   * file is in controllers subdir (resp views, models, helpers)
   * file is named suffix.php
   *
   * @param string $class the class to load
   */
  public static function doAutoload ($class) {

    // check if not already there
    if (class_exists( $class)) {
      return true;
    }

    // check if not ours
    if (substr( $class, 0, 8) != self::$_prefix) {
      return false;
    }

    // root path for including files
    $basePath = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_sh404sef';

    // easy : is it our factory ?
    if ($class == self::$_prefix . 'Factory') {
      $classes = JLoader::register( $class, $basePath . DS . strtolower($class) . '.php');
      $loaded = JLoader::load( $class);
      return $loaded;
    }

    // if not our factory
    $types = array( 'Controller', 'Model', 'Helper', 'ViewHelper', 'Table', 'Element', 'Class', 'Adapter', 'Exception');

    foreach( $types as $type) {
      $suffix = self::matchClassName( self::$_prefix, $type, $class);
      if ($suffix) {
        // we found a class name that matches our pattern,
        // make JLoader find it, with a special case for view helpers
        if ($type == 'ViewHelper') {
          $fileName = $basePath . DS . 'views' . DS . strtolower( $suffix) . DS . 'helpers.php';
        } else {
          // simplistic pluralization
          $plural = strtolower( $type) . (strtolower(substr( $type, -1)) == 's' ? 'es' : 's');
          $fileName = $basePath . DS . $plural . DS . strtolower( $suffix) . '.php';
        }

        $classes = JLoader::register( $class, $fileName);

        // go straight to exit
        break;
      }
    }

    // we must call explicitely Jloadeer::load. We could simply return false
    // so that it's called automatically later on, but that would fail
    // if several extensions use the same system, as __autoload (hence JLoader)
    // can be fired before one of the copies of our autoloader
    $loaded = JLoader::load( $class);
    return $loaded;
  }

  /**
   * Try to match a pattern based on our filename format
   * in the class name
   * @param $prefix should be Sh404sef
   * @param $type Controller, View, model
   * @param $class
   */
  public static function matchClassName( $prefix, $type, $class) {

    // try to match
    $match = preg_match('/' . $prefix . $type . '(.*)/i', $class, $matches);

    // return Suffix we found, if any
    return $match ? $matches[1] : '';

  }

}