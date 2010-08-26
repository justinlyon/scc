<?php
/*
 *  $Id: BeanUtil.php 757 2008-05-14 14:22:52Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

require_once 'CopyBeanOption.php';

/**
 * This class provides utility support for bean classes.  Initially, the
 * copyBean method has been implemented, but other standard bean utilities should
 * be added here.
 *
 * @example BeanUtil::copyBean($source, $target, [$copyBeanOptions])
 */

class BeanUtil
{
 	/**
     * Copy the values of the attribute from another object.  Will by defaule
     * copy all values from source to target.  An optional CopyBeanOptions bean
     * may be passed in to flag additional functionality.
     *
     * The copyBean method currently supports the following attributes of the
     * CopyBeanOption object:
     *
     * $strict: Setting the strict parameter to true will cause the method
     *          to throw an exception if a matching target attribute is
     *          not found for a given source.
     *
     * $use_target_vars: By default, the attributes of the source object
     *          $source) will determine the list of attributes to be
     * 			copied. Set the $useTargetVars parameter to true if the
     * 			target object should determine the list of atttributes.
     *
     * $ignore_null_values: By default, all attribute values will be copied from
     * 			the source bean to the target bean, even if the value is null.
     * 			Set the $ignoreNullValues parameter to require the value to be
     * 			non-null (and non-empty string) before copying to the target bean.
     * 			This allows for a bean to be safely updated when only a partial
     * 			source bean is available.
     *
     * @param bean $source
     * @param bean|string $target
     * @param [bean CopyBeanOption]
     * @return $target as a bean
     */
    public static function copyBean($source, $target, $option=null) {
        // validate input arguments
        if ($source == null || $target == null) {
			trigger_error("Invalid copy; source and/or target is null", E_USER_ERROR);
			return;
        }
        if (is_string($target)) {
			$result = new $target;
        } else if (is_object($target)) {
        	$result = $target;
        } else {
			trigger_error("Invalid copy; target is not an object", E_USER_ERROR);
			return;
        }

        // Set the options
        if ($option == null ) {
        	$option = new CopyBeanOption();
        } else if (get_class($option) != 'CopyBeanOption') {
        	trigger_error("Incoming CopyBeanOption not valid. Using default options.", E_USER_WARNING);
        	$option = new CopyBeanOption();
        }

        $source_vars = $option->getUseTargetVars() ? get_class_vars(get_class($result)) : get_class_vars(get_class($source));
        $target_vars = $option->getUseTargetVars() ? get_class_vars(get_class($source)) : get_class_vars(get_class($result));

        // check for strict attribute enforcment
        if ($option->getStrict()) {
        	$diff = array_diff_assoc($source_vars, $target_vars);
        	if (count($diff) > 0) {
        		trigger_error("Invalid copy; $getter not found", E_USER_ERROR);
        		return;
        	}
        }

        // copy over values from input
        foreach($source_vars as $name => $value) {
        	if (is_string($name) && 
        	    (empty($option->includes) ||   in_array($name, $option->includes)) &&
        	    (empty($option->excludes) || !(in_array($name, $option->excludes))) &&
        	   !($name == "false" || $name == "true" || $name == "null" || $name == '')) {
	            // build the accessor names
	            $getter = 'get' . ucfirst($name);
	            if (!method_exists($source, $getter)) {
	            	$getter = 'get_' . $name;
		            if (!method_exists($source, $getter) && !method_exists($source, '__call') ) {
		            	if ($option->getStrict()) {
		            		trigger_error("Invalid copy; $getter not found", E_USER_ERROR);
		            		return;
		            	} else { continue; }
		            }
	            }
	            $setter = 'set' . ucfirst($name);
	            if (!method_exists($target, $setter)) {
					$setter = 'set_' . $name;
		            if (!method_exists($target, $setter) && !method_exists($target, '__call')) {
		            	if ($option->getStrict()) {
		            		trigger_error("Invalid copy; $setter not found", E_USER_ERROR);
		            		return;
		            	} else { continue; }
		            }
	            }
	            $value = $source->$getter();
	            
	            // Add to the target if all conditions are met
	            $valid = true;
    			if ( $option->getIgnoreNullValues() && $value == null ) { $valid = false; }
    			if ( $option->getScalarsOnly() && ( is_array($value) || is_object($value) ) ) { $valid = false; }	
	            if ( $valid ) {
	            	$target->$setter($value);
	            }
        	}
        }

        return $result;
    }


    /**
     * This method will convert any bean object to a corresponding
     * associative array.
     *
     * @param bean Source bean object
     * @param boolean scalar only (no nested arrays or objects)
     * @return array An associative array
     */
    public function beanToArray($bean=null,$scalar=false)
    {
    	$result = array();
    	if (is_array($bean)) {
	    	foreach($bean as $key => $value) {
	    		$result[$key] = BeanUtil::beanToArray($value,$scalar);
	    	}
       	} else if (is_object($bean)) {
	    	if (is_subclass_of($bean, 'BaseBean')) {
		    	$vars = get_class_vars(get_class($bean));
		    	// copy over values from bean
		        foreach($vars as $key=>$value) {
		            // build the accessor names
		            $getter = 'get' . ucfirst($key);
		            if (!method_exists($bean, $getter)) {
		            	$getter = 'get_' . $key;
		            }
		            // populate the array
		            $val = $bean->$getter();
		            if (!$scalar && (is_object($val) || is_array($val))) {
		            	$result[$key] = BeanUtil::beanToArray($val,$scalar);
		            } elseif ($scalar && (is_object($val) || is_array($val))) {
		            	$result[$key] = null;
		            } else {
			    		$result[$key] = $val;
		            }
		        }
	    	} else {
	    		$result = get_object_vars($bean);
	    	}
       	} else {
       		$result[] = $bean;
       	}
        return $result;
    }

    public function beanToHash($bean)
    {
		$hash = array();
		foreach ($bean as $key => $value) {
			if (is_object($value)) {
				$hash[$key] = BeanUtil::beanToHash($value);
			} else if (is_array($value)) {
				$hash[$key] = array('key' => $key, 'value' => BeanUtil::beanToHash($value));
			} else {
				$hash[] = array('key' => $key, 'value' => $value);
			}
		}
		return $hash;
    }

	public function arrayToString($values)
	{
		return print_r($values, true);
	}
	
}



?>
