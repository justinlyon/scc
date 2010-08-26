<?php
/**
 *  $Id$: AddressUtil.php, Sep 10, 2006 9:31:44 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/



/**
 * This class serves as a collection of utilities to support
 * common web application uses of postal addresses.  It 
 * currently supports US State functionality, but is intended
 * to be extended to support geolocation and maping.
 */ 
 class AddressUtil
 {
 	
 	/**
 	 * Returns an associative array representation of the
 	 * 50 US states, keyed by their 2-letter postal code and
 	 * ordered alphabetically by the State name.
 	 * @return array (e.g.)'AL'=>'ALABAMA','AK'=>'ALASKA'...'WY'=>'WYOMING'
 	 */
 	public function getUsStates()	
 	{
 		$states = array(
			'AL'=>'ALABAMA',
			'AK'=>'ALASKA',
			'AZ'=>'ARIZONA',
			'AR'=>'ARKANSAS',
			'CA'=>'CALIFORNIA',
			'CO'=>'COLORADO',
			'CT'=>'CONNECTICUT',
			'DE'=>'DELAWARE',
			'DC'=>'DISTRICT OF COLUMBIA',
			'FL'=>'FLORIDA',
			'GA'=>'GEORGIA',
			'HA'=>'HAWAII',
			'ID'=>'IDAHO',
			'IL'=>'ILLINOIS',
			'IN'=>'INDIANA',
			'IA'=>'IOWA',
			'KS'=>'KANSAS',
			'KY'=>'KENTUCKY',
			'LA'=>'LOUISIANA',
			'ME'=>'MAINE',
			'MD'=>'MARYLAND',
			'MA'=>'MASSACHUSETTS',
			'MI'=>'MICHIGAN',
			'MN'=>'MINNESOTA',
			'MS'=>'MISSISSIPPI',
			'MO'=>'MISSOURI',
			'MT'=>'MONTANA',
			'NE'=>'NEBRASKA',
			'NV'=>'NEVADA',
			'NH'=>'NEW HAMPSHIRE',
			'NJ'=>'NEW JERSEY',
			'NM'=>'NEW MEXICO',
			'NY'=>'NEW YORK',
			'NC'=>'NORTH CAROLINA',
			'ND'=>'NORTH DAKOTA',
			'OH'=>'OHIO',
			'OK'=>'OKLAHOMA',
			'OR'=>'OREGON',
			'PA'=>'PENNSYLVANIA',
			'RI'=>'RHODE ISLAND',
			'SC'=>'SOUTH CAROLINA',
			'SD'=>'SOUTH DAKOTA',
			'TN'=>'TENNESSEE',
			'TX'=>'TEXAS',
			'UT'=>'UTAH',
			'VT'=>'VERMONT',
			'VA'=>'VIRGINIA',
			'WA'=>'WASHINGTON',
			'WV'=>'WEST VIRGINIA',
			'WI'=>'WISCONSIN',
			'WY'=>'WYOMING'); 	
		return $states;
 	}
 }
 
 
?>
