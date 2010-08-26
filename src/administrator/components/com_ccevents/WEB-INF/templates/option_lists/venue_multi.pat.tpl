<mos:comment>
/**
 *  $Id$: venue_multi.pat.tpl, Sep 21, 2006 7:03:26 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="venue_select">

	<div class="tab_block">
		<p>This {SCOPE} is hosted at the following Venues:</p>
		<select name="venue[]" size="10" multiple>
		<option value="0">[Select None]</option>
		<mos:tmpl name="venue_options">
		<option value="{OID}" {SELECTED}>{NAME}</option>
		</mos:tmpl>
		</select>	
		<p>Visit the <a href="index2.php?option=com_ccevents&scope=vnue">Venue Manager</a></p>
	</div>
	
</mos:tmpl>