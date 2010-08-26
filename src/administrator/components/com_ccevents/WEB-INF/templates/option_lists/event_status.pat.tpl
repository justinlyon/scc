<mos:comment>
/**
 *  $Id$: event_status.pat.tpl, Sep 21, 2006 6:56:32 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="event_status">
	<select name="eventStatus">
		<mos:tmpl name="eventStatus_options">
		<option value="{VALUE}" {SELECTED}>{VALUE}</option>
		</mos:tmpl>
	</select>	
</mos:tmpl>