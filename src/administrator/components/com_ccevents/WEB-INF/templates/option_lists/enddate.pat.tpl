<mos:comment>
/**
 *  $Id$: end_dateor.pat.tpl, Sep 21, 2006 7:45:55 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="end_date">

	<mos:tmpl name="end_month_select">
		<select name="endMonth">
			<mos:tmpl name="end_month_options">
				<option value="{VALUE}" {SELECTED}>{TEXT}</option>
			</mos:tmpl>
		</select>
	</mos:tmpl>
	
	<mos:tmpl  name="end_day_select">
		<select name="endDay">
			<mos:tmpl name="end_day_options">
				<option value="{VALUE}" {SELECTED}>{VALUE}</option>
			</mos:tmpl>
		</select>
	</mos:tmpl>
	
	<mos:tmpl  name="end_year_select">
		<select name="endYear">
			<mos:tmpl name="end_year_options">
				<option value="{VALUE}" {SELECTED}>{VALUE}</option>
			</mos:tmpl>
		</select>
	</mos:tmpl>

</mos:tmpl>
