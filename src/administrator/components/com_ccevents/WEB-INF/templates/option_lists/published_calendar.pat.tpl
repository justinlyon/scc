<mos:comment>
/**
 *  $Id$: published_events.php, Sep 14, 2006 11:58:32 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="published_calendar">
<label>Calendar Promotion - Position #{COUNT}:</label>
	<select name="event{INDEX}">
		<option value="0">[Empty]</option>
		<optgroup label="Exhibitions">
		<mos:tmpl name="published_cal_exhibition_options">
		<option value="{TYPE}.{OID}" {SELECTED}>{TITLE}</option>
		</mos:tmpl>
		</optgroup>
		<optgroup label="Programs">
		<mos:tmpl name="published_cal_program_options">
		<option value="{TYPE}.{OID}" {SELECTED}>{TITLE}</option>
		</mos:tmpl>
		</optgroup>
	</select>	
<br /><br />
</mos:tmpl>
