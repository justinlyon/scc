<?php
/**
 *  $Id $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/..');
}
require_once WEB_INF . '/base.include.php'; 
require_once WEB_INF . '/pdo/model.php'; 

class EnumeratedValueService
{
	/**
	 * Returns one or more EnumeratedValue instances as a multi-valued array.
	 * If the $enumType parameter is given, the result set will be limited
	 * to the named scope. If the $enumValue parameter is given, only matching
	 * instance(s) will be returned.
	 *  
	 * @param string enumType The enum type (e.g. PublicationState, EventStatus, ProgramType, ResourceType)
	 * @param string value A specific enum value
	 * @return Zero or more EnumeratedValues as an array keyed by enum type
	 */
	function fetch($enumType=null, $enumValue=null)
	{
		global $logger;
		
		$logger->debug(get_class($this) . "::fetch($enumType, $enumValue)");
		
		$pdo = epManager::instance();
		$result = array();
		if ($enumType == null) {
			$enumeratedValues = $pdo->find('from EnumeratedValue order by oid');
		} else {
			$enumeratedValues = $pdo->find('from EnumeratedValue where scope = ? order by oid', $enumType);
		}
		foreach ($enumeratedValues as $value) {
			if ($enumValue == null || $enumValue == $value->getValue()) {
				$result[$value->getScope()][] = $value;
			}
		}
		
		return $result;
	}
}

?>
