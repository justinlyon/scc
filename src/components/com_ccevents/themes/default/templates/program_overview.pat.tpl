<mos:comment>
/**
 *  $Id$: program_overview.pat.tpl, Jan 22, 2007 9:11:32 AM nchanda
 *  Copyright (c) 2007, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="program_overview">

<mos:tmpl name="intro">
	<h2><span>{TITLE}</span></h2>
	<mos:tmpl type="simpleCondition" varscope="intro" requiredVars="announcement">
		<p>{ANNOUNCEMENT}</p><br/>
	</mos:tmpl>
</mos:tmpl>


<mos:tmpl name="genre">
	<div class="category" id="num{PAT_ROW_VAR}">
		<div class="photo"><a href="{LINK_URL}"><img src="{PHOTO_URL}" width="160" height="95" alt="" /></a></div>
		<h4><a href="{LINK_URL}">{NAME}</a></h4>
		<p>{DESCRIPTION}</p>
	</div>
</mos:tmpl>

</mos:tmpl>
