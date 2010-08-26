<mos:comment>
/**
 *  $Id$: exhibition_multi.pat.tpl, Sep 12, 2006 9:11:23 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="exhibition_select">

	<div class="tab_block">
		<p>This {SCOPE} is associated with the following Exhibitions:</p>
		<select name="exhibition[]" size="10" multiple>
		<option value="0">[Select None]</option>
		<mos:tmpl name="exhibition_options">
		<option value="{OID}" {SELECTED}>{TITLE}</option>
		</mos:tmpl>
		</select>	
		<p>Visit the <a href="index2.php?option=com_ccevents&scope=exbt">Exhibition Manager</a></p>
	</div>
	
</mos:tmpl>
