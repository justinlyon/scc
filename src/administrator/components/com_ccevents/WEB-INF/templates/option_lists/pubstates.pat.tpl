<mos:comment>
/**
 *  $Id$: option_pubstates.pat.tpl, Sep 5, 2006 11:32:58 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="pubState_select">
	<select name="pubState">
	<mos:tmpl name="pubState_options">
	<option value="{VALUE}" {SELECTED}>{VALUE}</option>
	</mos:tmpl>
	</select>
</mos:tmpl>
