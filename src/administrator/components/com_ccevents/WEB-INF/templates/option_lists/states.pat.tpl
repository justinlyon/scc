<mos:comment>
/**
 *  $Id$: states.pat.tpl, Sep 5, 2006 11:32:58 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="state_select">
	<select name="state">
	<option value="">Please Select</option>
	<mos:tmpl name="state_options">
	<option value="{CODE}" <mos:var name="selected" /> >{NAME}</option>
	</mos:tmpl>
	</select>
</mos:tmpl>
