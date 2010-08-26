<?php
/*
 *  $Id: BaseBean.php 711 2008-04-17 01:36:14Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */
require_once( 'BeanUtil.php' );

/**
 * This class provides support for default accessor methods (get/set)
 * for each public attribute declared in its subclass(es). Custom
 * accessor methods may also be defined as needed by the subclass(es),
 *
 * The accessor method names follow standard JavaBean and PHP naming conventions.
 * Specifically, the first letter of the attribute name will be converted to
 * uppercase and the result will be prepended by 'get' or 'set' accordingly.
 * Alternatively, the unchanged attribute name may be prepended by 'get_' or
 * 'set_'.
 *
 * To create a new bean class, simply extend this class and declare the attributes
 * with public visibility (public or var). See the DemoBean class (end of this file)
 * for an example for creating your own bean classes.
 */
abstract class BaseBean
{
     /**
     * An additional object identifier
     * @var mixed (defined by DAO implementation)
     * @orm int()
     */
    public $oid;

    /**
     * Intercepts undeclared methods to look for accessors (get/set) which
     * are then implemented with the expected default behavior.
     * @param string $method method name
     * @param array arguments
     * @return mixed
     */
    final public function __call($method, $args)
    {
        // TODO: Add logic to support both PHP and Java naming conventions
        // when accessing attribute names.  In the meantime, clients of this
        // method must use the naming pattern as defined in the object.
        // e.g. The attribute $foo_bar must use the getFoo_bar or get_foo_bar
        // accessor methods.

        if (substr($method, 0, 3) == 'get' || substr($method, 0, 3) == 'set') {
        	if (substr($method, 3, 1) == '_') {
	            $attribute = substr($method, 4);
         	} else {
	            $attribute = strtolower(substr($method, 3, 1)) . substr($method, 4);
        	}
			if (substr($method, 0, 3) == 'set') {
				$this->$attribute = isset($args[0]) ? $args[0] : null;
			}
            return $this->$attribute;
        } else {
        	$className = get_class($this);
			trigger_error("Call to undefined method $className :: $method", E_USER_ERROR);
        }
	}

	public function validate() {
		return true;
	}

	public function __construct($source=null) {
		if (is_object($source)) {
			BeanUtil::copyBean($source, $this);
		} else if (is_array($source)) {
			foreach($source as $key => $value) {
				if( property_exists( $this, $key ) ) {
					$setter = 'set_' . $key;
					$this->$setter($value);
				}
			}
		}
	}

    /**
     * Convert this bean instance to an associative array.
     *
     * @return array An associative array
     */
    public function toArray()
    {
    	$result = array();
    	$vars = get_class_vars(get_class($this));
        foreach($vars as $key=>$value) {
            // build the accessor names
            $getter = 'get' . ucfirst($key);
            if (!method_exists($this, $getter)) {
            	$getter = 'get_' . $key;
            }
            // populate the array
            $val = $this->$getter();
            if (is_object($val) || is_array($val)) {
            	$result[$key] = BeanUtil::beanToArray($val);
            } else {
	    		$result[$key] = $val;
            }
        }
        return $result;
    }
	
    /**
	 * Render this bean as a tab-delimited string. If the header argument
	 * is true, the result will be prepended with a header row containing
	 * the attribute names from the bean class.
	 *
	 * @param $hdr True to include a header row with the resulting string
	 * @return A tab-delimited string containing the bean attribute values
	 */
	public function toString($hdr=false) {
        $header = $detail = '';
		$map = get_object_vars($this);
		foreach ($map as $label => $value) {
			if ($hdr) { $header .= "$label\t"; }
			$detail .= "$value\t";
		}
		$result = $hdr ? rtrim($header) : '';
		$result .= rtrim($detail);
        return result;
	}

    public function __toString() {
        return get_class($this);
    }
    
	/**
	 * Render this bean as HTML using table row/cell tags. If the header argument
	 * is true, the result will be prepended with a table row (<th>) containing
	 * the attribute names from the bean class.
	 *
	 * @param $hdr True to include a header row with the resulting HTML
	 * @return An HTML string containing the bean attribute values
	 */
	public function toHtml($hdr=false) {
		$header = $detail = '<tr>';
		$map = get_object_vars($this);
		foreach ($map as $label => $value) {
			if ($hdr) { $header .= "<th>$label</th>"; }
			$detail .= "<td>$value</td>";
		}
		$result = $hdr ? "$header</tr>" : '';
		$result .= "$detail</tr>";
	}
}

/**
 * Subclass to demonstrate usage and initialization for bean classes.
 */
class DemoBean extends BaseBean {
	var $demo;
}

// Usage example
$bean = new DemoBean();
$bean->setDemo(true); 		// Java style
assert($bean->get_demo()); 	// PHP style

?>