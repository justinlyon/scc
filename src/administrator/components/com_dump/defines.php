<?php
/**
 * J!Dump
 * @version      $Id: defines.php 31 2008-04-28 14:46:40Z jenscski $
 * @package      mjaztools_dump
 * @copyright    Copyright (C) 2007 J!Dump Team. All rights reserved.
 * @license      GNU/GPL
 * @link         http://joomlacode.org/gf/project/jdump/
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

global $mainframe;
$phpversion = explode( '.', phpversion() );

define( 'DUMP_VERSION', '1.1.1' );
define( 'DUMP_PHP',     intval($phpversion[0]) );
define( 'DUMP_URL',     JURI::root() . 'administrator/components/com_dump/' );
