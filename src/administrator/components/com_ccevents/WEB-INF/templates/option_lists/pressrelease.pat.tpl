<mos:comment>
/**
 *  $Id$:
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="pressrelease">
	<select name="pressRelease">
		<option value="">No Press Release</option>
		<mos:tmpl name="pressrelease_options">
		<option value="{VALUE}" {SELECTED}>{TITLE}</option>
		</mos:tmpl>
	</select>	
</mos:tmpl>