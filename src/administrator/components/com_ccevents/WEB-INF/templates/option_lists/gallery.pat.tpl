<mos:comment>
/**
 *  $Id$: gallery.pat.tpl, Sep 30, 2006 5:00:50 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="gallery_select">

	<div class="tab_block">
		<p>This {SCOPE} is associated with the following Gallery:</p>
		<select name="gallery" size="10">
		<option value="0">[Select None]</option>
		<mos:tmpl name="gallery_options">
		<option value="{GID}" {SELECTED}>{NAME}</option>
		</mos:tmpl>
		</select>	
		<p>Visit the <a href="/gallery2/">Gallery Manager</a></p>
	</div>
	
</mos:tmpl>