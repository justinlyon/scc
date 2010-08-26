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

<mos:tmpl name="commentarticle">
	<select name="commentArticle">
		<option value="">No Related Comments</option>
		<mos:tmpl name="commentarticle_options">
		<option value="{VALUE}" {SELECTED}>{TITLE}</option>
		</mos:tmpl>
	</select>	
</mos:tmpl>