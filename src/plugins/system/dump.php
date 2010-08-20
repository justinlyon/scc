<?php
/**
 * J!Dump
 * @version      $Id: dump.php 31 2008-04-28 14:46:40Z jenscski $
 * @package      mjaztools_dump
 * @copyright    Copyright (C) 2007 J!Dump Team. All rights reserved.
 * @license      GNU/GPL
 * @link         http://joomlacode.org/gf/project/jdump/
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.event.helper' );

if( file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_dump'.DS.'helper.php' ) ) {
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_dump'.DS.'helper.php' );
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_dump'.DS.'defines.php' );
} else {
    JError::raiseNotice( 20, 'The Dump Plugin needs the Dump Component to function.' );
}

class plgSystemDump extends JPlugin {
    function plgSystemDump(& $subject, $params) {
        parent::__construct($subject, $params);
    }

    function onAfterRender() {
        global $mainframe;

        // settings from config.xml
        $dumpConfig = & JComponentHelper::getParams( 'com_dump' );
        $autopopup  = $dumpConfig->get( 'autopopup', 1 );

        $userstate = $mainframe->getUserState( 'dump.nodes' );
        $cnt_dumps  = count( $userstate );

        if( $autopopup AND $cnt_dumps) {
            DumpHelper::showPopup();
        }
    }
}


/**
 * Add a variable to the list of variables that will be shown in the debug window
 * @param mixed $var The variable you want to dump
 * @param mixed $name The name of the variable you want to dump
 */
function dump( $var = null, $name = '(unknown name)', $type = null, $level = 0 ) {
    global $mainframe;

    include_once( JPATH_PLUGINS.DS.'system'.DS.'dump'.DS.'node.php' );

		$source = '';
		if (function_exists('debug_backtrace'))
		{
				$trace = debug_backtrace();

				$source = DumpHelper::getSourceFunction($trace);
				//$source .= '@';
				$source .= DumpHelper::getSourcePath($trace);
		}

    // create a new node array
    $node           = & DumpNode::getNode( $var, $name, $type, $level, $source );
    //get the current userstate
    $userstate      = $mainframe->getUserState( 'dump.nodes' );
    // append the node to the array
    $userstate[]    = $node;
    // set the userstate to the new array
    $mainframe->setUserState( 'dump.nodes', $userstate );
}

/**
 * Alias to dump the parameters of a template
 * @param object $var The "$this" object in the template
 */
function dumpTemplateParams( $var, $name = false ) {
  dumpTemplate( $var, $name );
  }
  
/**
 * Shortcut to dump the parameters of a template
 * @param object $var The "$this" object in the template
 */
function dumpTemplate( $var, $name = false ) {
    $name = $name ? $name :  $var->template;
    if (isset($var->params->_registry['_default']['data']))
      dump( $var->params->_registry['_default']['data'], $name );
    else
      dump(null);
}

/**
 * Shortcut to dump a message
 * @param string $msg The message
 */
function dumpMessage( $msg = '(Empty message)' ) {
    dump( $msg, null, 'message', 0 );
}

/**
 * Shortcut to dump system information
 */
function dumpSysinfo() {
    include_once( JPATH_PLUGINS.DS.'system'.DS.'dump'.DS.'sysinfo.php' );
    $sysinfo = new DumpSysinfo();
    dump( $sysinfo->data, 'System Information');
}

/**
 * Alias to dump the backtrace
 */
function dumpBacktrace() {
  dumpTrace();
  }
  
/**
 * Shortcut to dump the backtrace
 */
function dumpTrace()
{
	$trace = debug_backtrace();

	$arr = dumpTraceBuild($trace);

	dump($arr, 'Backtrace', 'backtrace');
}

function dumpTraceBuild($trace)
{
	$ret = array();

	$ret['file']     = $trace[0]['file'];
	$ret['line']     = $trace[0]['line'];
	if (isset($trace[0]['class']) && isset($trace[0]['type']))
		$ret['function'] = $trace[0]['class'].$trace[0]['type'].$trace[0]['function'];
	else
		$ret['function'] = $trace[0]['function'];
	$ret['args']     = $trace[0]['args'];

	array_shift($trace);
	if (count($trace)>0)
	{
		$ret['backtrace'] = dumpTraceBuild($trace);
	}

	return $ret;
}
