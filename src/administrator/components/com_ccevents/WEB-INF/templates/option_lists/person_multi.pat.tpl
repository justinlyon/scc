<mos:comment>
/**
 *  $Id$: program_multi.pat.tpl, Sep 12, 2006 9:11:23 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="person_select">

	<div class="tab_block">
		<p>This Exhibition is associated with the following Artists:</p>
		<select name="person[]" size="6" multiple>
		<option value="0">[Select None]</option>
		<mos:tmpl name="person_options">
		<option value="{OID}" {SELECTED}>{TITLE}</option>
		</mos:tmpl>
		</select>	
		<br/>
		<p>And the following Artifacts:</p>
		<select name="artifact[]" size="10" multiple>
		<option value="0">[Select None]</option>
		<mos:tmpl name="object_options">
		<option value="{OID}" {SELECTED}>{NAME}</option>
		</mos:tmpl>
		</select>
	</div>
	
</mos:tmpl>
