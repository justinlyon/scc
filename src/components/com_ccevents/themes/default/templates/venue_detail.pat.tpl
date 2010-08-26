<mos:comment>
/**
 *  $Id$: program_detail.pat.tpl, Oct 5, 2006 10:51:29 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="venue">

<mos:tmpl name="intro">
	<h2><span>Facilities Tour</span></h2>
	<a href="javascript:void(0);" onclick="javascript:history.go(-1);">Return to Previous Page</a>
</mos:tmpl>


<div class="location">
	<div class="location_media">

	<mos:tmpl name="photo" type="simpleCondition" requiredvars="gallery">
		<div class="photo"><img src="{URL}" width="240" height="240" alt="" /></div>
		<mos:tmpl varscope="photo" type="simpleCondition" requiredvars="author">
			<p class="caption">Photo courtesy of {AUTHOR}</p>
		</mos:tmpl>
	</mos:tmpl>
	</div><!-- location_media -->
	
	<div class="location_info">
		<h4>{NAME}</h4>
		
		<mos:tmpl name="video" type="simpleCondition" requiredvars="videoClip">
			<a href="{VIDEOCLIP}" class="qtvr">View a 360º photo (QuickTimeVR)</a>
		</mos:tmpl>
		
		<mos:tmpl varscope="venue" type="simpleCondition" requiredvars="address">
			<p class="location">{ADDRESS}</p>
		</mos:tmpl>

	</div><!-- location_info -->
	<div id="description">
		{DESCRIPTION}
	</div>
</div><!-- location-->

</mos:tmpl>
