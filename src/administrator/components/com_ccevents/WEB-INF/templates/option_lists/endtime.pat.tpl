<mos:comment>
/**
 *  $Id$: start_dateor.pat.tpl, Sep 21, 2006 7:45:55 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="end_time">

	<select name="endHour">
		<mos:tmpl name="end_hour_options">
			<option value="{VALUE}" {SELECTED}>{VALUE}</option>
		</mos:tmpl>
	</select>
	
	<select name="endMinute">
		<mos:tmpl name="end_minute_options">
			<option value="{VALUE}" {SELECTED}>{VALUE}</option>
		</mos:tmpl>
	</select>
	
	<select name="endAmpm">
		<mos:tmpl name="end_ampm_options">
			<option value="{VALUE}" {SELECTED}>{VALUE}</option>
		</mos:tmpl>
	</select>

</mos:tmpl>
