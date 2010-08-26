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

<mos:tmpl name="relatedcategory">
	<select name="relatedArticles">
		<option value="">No Releated Content</option>
		<mos:tmpl name="relatedcategory_options">
		<option value="{VALUE}" {SELECTED}>{TITLE}</option>
		</mos:tmpl>
	</select>	
</mos:tmpl>