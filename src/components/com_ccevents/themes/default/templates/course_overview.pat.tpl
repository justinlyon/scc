<mos:comment>
/**
 *  $Id$: course_overview.pat.tpl, Jan 22, 2007 9:11:32 AM nchanda
 *  Copyright (c) 2007, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="course_overview">

<mos:tmpl name="intro">
	<h2><span>{TITLE}</span></h2>
	<mos:tmpl type="simpleCondition" varscope="intro" requiredVars="announcement">
		<p>{ANNOUNCEMENT}</p><br/>
	</mos:tmpl>
</mos:tmpl>


<mos:tmpl name="course">

	<mos:tmpl name="group" type="simpleCondition" requiredVars="GROUP_HEADING">
		<h4 class="title">{GROUP_HEADING}</h4>
	</mos:tmpl>

	<div class="class<mos:var name="FIRST_CLASS" varscope="course"/>">
	<h4><a href="{DETAIL_LINK}">{TITLE}</a></h4>
	
	<ul>
	<li>{DATE_DESC}</li>
	<mos:tmpl varscope="course" type="simplecondition" requiredvars="sessions"><li>{SESSIONS}</li></mos:tmpl>
	<mos:tmpl varscope="course" type="simplecondition" requiredvars="venue"><li>{VENUE}</li></mos:tmpl>
	</ul>
	</div>

</mos:tmpl>

</mos:tmpl>
