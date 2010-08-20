<?php
/**
 * SEF extension for Joomla! 1.5
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2009-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: shJConfig.class.php 1438 2010-05-26 14:46:45Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


class shJConfig {


  static $_joomlaConfig = false;

  function get( $property, $default = null) {

    // read current config from file
    if (self::$_joomlaConfig === false) {
      self::_readJoomlaConfig();
    }

    // search for requested property
    $pattern = '/\$' . preg_quote($property, '/') . '\s*=\s*\'(.*)\'/Ui';
    $matches = null;
    $found = preg_match( $pattern, self::$_joomlaConfig, $matches);

    // extract result
    if ($found) {
      $value = $matches[1];
    } else {
      $value = $default;
    }

    // return value read or default
    return $value;
  }

  function set( $property, $value) {
    
    // read current config from file
    if (self::$_joomlaConfig === false) {
      self::_readJoomlaConfig();
    }

    // search for requested property
    $pattern = '/(\$' . preg_quote($property, '/') . '\s*=\s*\'(.*)\')/Ui';
    $matches = null;
    $found = preg_match( $pattern, self::$_joomlaConfig, $matches);

    // insert new value
    if ($found) {
      jimport( 'joomla.utilities.string');
      $newValue = '$' . $property . " =  '" . $value . "'";
      self::$_joomlaConfig = str_replace( $matches[1], $newValue, self::$_joomlaConfig);
    }

    // now save to file
    return self::_writeJoomlaConfig();
    
  }

  function _readJoomlaConfig() {

    // import joomla file libraries
    jimport( 'joomla.filesystem.file');

    // read config file content
    $fileName = JPATH_CONFIGURATION . DS . 'configuration.php';
    self::$_joomlaConfig = JFile::read( $fileName);

  }

  function _writeJoomlaConfig() {

    // import joomla file libraries
    jimport( 'joomla.filesystem.file');

    // do we have a content to write ?
    if (self::$_joomlaConfig) {
      $fileName = JPATH_CONFIGURATION . DS . 'configuration.php';
      $written = JFile::write( $fileName, self::$_joomlaConfig);
    }

    // send result
    return $written == JString::strlen( self::$_joomlaConfig);
  }
}

