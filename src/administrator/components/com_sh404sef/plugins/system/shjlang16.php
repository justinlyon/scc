<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     GNU General Public License, see http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: shjlang16.php 1233 2010-04-11 09:37:45Z silianacom-svn $
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin'); // import base class

/**
 * sh404SEF system plugin
 *
 * @author
 */
class  plgSystemShjlang16 extends JPlugin
{

  /**
   * Constructor
   *
   * For php4 compatability we must not use the __constructor as a constructor for plugins
   * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
   * This causes problems with cross-referencing necessary for the observer design pattern.
   *
   * @access	protected
   * @param	object	$subject The object to observe
   * @param 	array   $config  An array that holds the plugin configuration
   * @since	1.5
   */
  function plgSystemShjlang16(& $subject, $config) {
    
    // register our library
    JLoader::register( 'JLanguage16', JPATH_PLUGINS.DS.'system'. DS .'shjlang16' . DS.'jlanguage16.php');
    JLoader::register( 'JText16', JPATH_PLUGINS.DS.'system'. DS .'shjlang16' . DS.'jtext16.php');
    JLoader::register( 'shjlang16Helper', JPATH_PLUGINS.DS.'system'. DS .'shjlang16' . DS.'shjlang16helper.php');
    JLoader::register( 'J16XMLElement', JPATH_PLUGINS.DS.'system'. DS .'shjlang16' . DS.'xmlelement.php');
    
    parent::__construct($subject, $config);
  }

}
