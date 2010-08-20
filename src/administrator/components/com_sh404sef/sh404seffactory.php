<?php
/**
 * SEF module for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: sh404seffactory.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

/**
 * A factory class to assist in handling our objects
 * @author yannick
 *
 */
abstract class Sh404sefFactory {

  public static function getController( $name = 'default', $config = array(), $prefix = 'Sh404sef') {

    // if no name, use default
    $name = empty( $name) ? 'default' : $name;

    // find about controller class name
    // warning : if prefix is no 'Sh404sef', need to include the class file first
    // autoloader won't autoload it otherwise
    $controllerClass = ucfirst( $prefix) . 'Controller' . ucfirst( $name);

    // instantiate our class
    $controller = new $controllerClass( $config);

    return $controller;
  }

}