<mos:comment>
/**
 *  $Id$: default_venue.php, Sep 14, 2006 11:58:32 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="activity_venue">
	<select name="activityVenue">
		<option value="">Please Select</option>
		<mos:tmpl name="activityVenue_options">
		<option value="{OID}" {SELECTED}>{NAME}</option>
		</mos:tmpl>
	</select>	
</mos:tmpl>
