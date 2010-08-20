<?php
/**
 * J!Dump
 * @version      $Id: node.php 31 2008-04-28 14:46:40Z jenscski $
 * @package      mjaztools_dump
 * @copyright    Copyright (C) 2007 J!Dump Team. All rights reserved.
 * @license      GNU/GPL
 * @link         http://joomlacode.org/gf/project/jdump/
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class DumpNode {
    
    function & getNode( $var, $name, $type = null, $level = 0, $source = null ) {
        
        $node['name']       = $name;
        $node['type']       = strtolower( $type ? $type : gettype( $var ) );
        $node['children']   = array();
        $node['level']      = $level;
				$node['source']     = $source;
        
        // expand the var according to type
        switch ( $node['type'] ) {
			case 'backtrace': // Skip source when backtrace, and change to array
				$node['source'] = null;
				$node['type']   = 'array';
            
            case 'array':
                if ( $level >= DumpHelper::getMaxDepth() ) {
                    $node['children'][] = & DumpNode::getNode( 'Maximum depth reached', null, 'message' );
                } else {
                    foreach ( $var as $key => $value ) {
                        $node['children'][] = & DumpNode::getNode( $value, $key, null, $level + 1 );
                    }
                }
                break;
            
            case 'object':
                if ( $level >= DumpHelper::getMaxDepth() ) {
                    $node['children'][] = & DumpNode::getNode( 'Maximum depth reached', null, 'message' );
                } else {
                    $object_vars = get_object_vars( $var ) ;
                    $methods     = get_class_methods( $var ) ;
                    if( count( $object_vars ) ) {
                        $node['children'][] = & DumpNode::getNode( $var, 'Properties', 'properties', $level );
                    }
                    if( count( $methods ) ) {
                        $node['children'][] = & DumpNode::getNode( $var, 'Methods', 'methods', $level );
                    }
                }
                $node['classname'] = get_class( $var );
                break;
            
            case 'properties':
                $object_vars = get_object_vars( $var ) ;
                foreach ( $object_vars as $key => $value ) {
                    $node['children'][] = & DumpNode::getNode( $value, $key, null, $level + 1 );
                }
                break;
            
            case 'methods':
                $methods = get_class_methods( $var ) ;
                foreach ( $methods as $value ) {
                    $node['children'][] = & DumpNode::getNode( null, $value, 'method' );
                }   
                break;
            
			
            case 'string':
				jimport( 'joomla.application.component.helper' );
				// settings from config.xml
				$dumpConfig		= & JComponentHelper::getParams( 'com_dump' );
				$trimstrings	= $dumpConfig->get( 'trimstrings', 1);
				$maxstrlength	= $dumpConfig->get( 'maxstrlength', 150);
				
				//original string length
				$length			= JString::strlen( $var );
				
				// trim string if needed
				if( $trimstrings AND $length > $maxstrlength ) {
					$var = JString::substr( $var, 0, $maxstrlength ) . '...';
					$node['length'] = $length;
				}

                $node['value']	= $var;
                break;

            default:
                $node['value']        = & $var;
                break;
            
        }
        
        return $node;
    }

}
