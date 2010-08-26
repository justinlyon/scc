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

<mos:tmpl name="start_date">

	<select name="startMonth" onchange="updateEndTime()">
		<mos:tmpl name="start_month_options">
			<option value="{VALUE}" {SELECTED}>{TEXT}</option>
		</mos:tmpl>
	</select>
	
	<select name="startDay" onchange="updateEndTime()">
		<mos:tmpl name="start_day_options">
			<option value="{VALUE}" {SELECTED}>{VALUE}</option>
		</mos:tmpl>
	</select>
	
	<select name="startYear" onchange="updateEndTime()">
		<mos:tmpl name="start_year_options">
			<option value="{VALUE}" {SELECTED}>{VALUE}</option>
		</mos:tmpl>
	</select>

</mos:tmpl>
