<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     GNU General Public License, see http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: shjlang16helper.php 1235 2010-04-11 11:09:22Z silianacom-svn $
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class shjlang16Helper {


  /**
   * Get an instance of language object
   * handling Joomla 1.6 lang file format
   * If running on J! 1.6.x, just use native language object
   *
   * @access PUBLIC
   */
  function & getLanguage() {

    static $instance;

    if (!is_object($instance))
    {
      //get the debug configuration setting
      $conf =& JFactory::getConfig();
      $debug = $conf->getValue('config.debug_lang');
      
      // create language, using either Joomla framework or backport of J! 1.6 framework
      // depending on current version
      $instance = self::_isPatchRequired() ? self::_createLanguage() : JFactory::getLanguage();

      $instance->setDebug($debug);
    }

    return $instance;

  }

  /*
   *
   * Check Joomla version and returns true if
   * this patch is required to handled
   * J! 1.6 lang file format
   */

  function _isPatchRequired() {

    // current Joomla version object
    $version = new JVersion();
    
    // disable the patch for any 1.6.x version and up
    $isRequired = version_compare( JVERSION, '1.5', 'ge' ) == 1;

    // send that back
    return $isRequired;
    
  }

  /**
   * Create a language object
   *
   * @access private
   * @return object Jlanguage16
   * @since 1.5
   */
  function &_createLanguage()
  {
    jimport('joomla.language.language');

    $conf =& JFactory::getConfig();
    $locale = $conf->getValue('config.language');
    $lang =& Jlanguage16::getInstance($locale);
    $lang->setDebug($conf->getValue('config.debug_lang'));

    return $lang;
  }

  /**
   * Reads a XML file.
   *
   * @todo This may go in a separate class - error reporting may be improved.
   *
   * @param string $data Full path and file name.
   * @param boolean $isFile true to load a file | false to load a string.
   *
   * @return mixed JXMLElement on success | false on error.
   */
  public static function _getXML($data, $isFile = true)
  {
    jimport('joomla.utilities.xmlelement');

    // Disable libxml errors and allow to fetch error information as needed
    libxml_use_internal_errors(true);

    if ($isFile) {
      // Try to load the xml file
      $xml = simplexml_load_file($data, 'J16XMLElement');
    } else {
      // Try to load the xml string
      $xml = simplexml_load_string($data, 'J16XMLElement');
    }

    if (empty($xml)) {
      // There was an error
      JError::raiseWarning(100, JText::_('Failed loading XML file'));

      if ($isFile) {
        JError::raiseWarning(100, $data);
      }

      foreach (libxml_get_errors() as $error) {
        JError::raiseWarning(100, 'XML: '.$error->message);
      }
    }

    return $xml ;
  }

}