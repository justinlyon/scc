<?php
/**
 * SEF extension for Joomla! 1.5
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2009-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: sh404SEFMeta.class.php 1257 2010-04-16 02:01:01Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


class sh404SEFMeta extends JTable
{
  /**
   * Error number
   *
   * @var   string
   * @access  protected
   */
  var $_error = '';

  /**
   * Error number
   *
   * @var   int
   * @access  protected
   */
  var $_errorNum = 0;

  /** @var int */
  var $id   = null;
  /** @var string */
  var $newurl = null;
  /** @var string */
  var $metadesc = null;
  /** @var string */
  var $metakey  = null;
  /** @var string */
  var $metatitle  = null;
  /** @var string */
  var $metalang = null;
  /** @var string */
  var $metarobots = null;

  /**
   * Constructor
   */
  function __construct( &$db)
  {
    parent::__construct( '#__sh404SEF_meta', 'id', $db );
  }

  function sh404SEFMeta( &$_db ) {
    parent::__construct( '#__sh404SEF_meta', 'id', $_db );
  }

  function check() {
    //initialize
    $this->_error = null;
    $this->newurl = JString::trim($this->newurl);
    $this->metadesc = JString::trim($this->metadesc);
    $this->metakey = JString::trim($this->metakey);
    $this->metatitle = JString::trim($this->metatitle);
    $this->metalang = JString::trim($this->metalang);
    $this->metarobots = JString::trim($this->metarobots);
    // check for valid URLs
    if ($this->newurl == ''){
      $this->_error .= COM_SH404SEF_EMPTYURL;
      return false;
    }

    if( substr( $this->newurl, 0, 9) != 'index.php') {
      $this->_error .= COM_SH404SEF_BADURL;
    }
    if (is_null($this->_error)) {
      // check for existing URLS
      $this->_db->setQuery( "SELECT id FROM #__sh404SEF_meta WHERE `newurl` LIKE '".$this->newurl."'");
      $xid = intval( $this->_db->loadResult() );
      if ($xid && $xid != intval( $this->id )) {
        $this->_error = COM_SH404SEF_URLEXIST;
        return false;
      }
      return true;
    }else{
      return false;
    }
  }

  /**
   * Legacy Method, use {@link JObject::getError()}  instead
   * @deprecated As of 1.5
   */
  function getError($i = null, $toString = true )
  {
    return $this->_error;
  }

  /**
   * Legacy Method, use {@link JObject::getError()}  instead
   * @deprecated As of 1.5
   */
  function getErrorNum()
  {
    return $this->_errorNum;
  }
}


