<mos:comment>
/**
 *  $Id$: course_multi.pat.tpl, Sep 12, 2006 9:11:23 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="course_select">

	<div class="tab_block">
		<p>This {SCOPE} is associated with the following Courses:</p>
		<select name="course[]" size="10" multiple>
		<option value="0">[Select None]</option>
		<mos:tmpl name="course_options">
		<option value="{OID}" {SELECTED}>{TITLE}</option>
		</mos:tmpl>
		</select>	
		<p>Visit the <a href="index2.php?option=com_ccevents&scope=crse">Course Manager</a></p>
	</div>
	
</mos:tmpl>
