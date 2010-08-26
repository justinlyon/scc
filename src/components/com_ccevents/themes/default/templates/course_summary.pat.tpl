<mos:comment>
/**
 *  $Id$: course_summary.pat.tpl, Oct 5, 2006 3:59:56 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>


<mos:tmpl name="course_summary" autoclear="true">
<div id="family_key"><!-- use the family_key to place the key on the page -->

<mos:tmpl name="intro">
	<h2><span>Learning for Life: {TITLE}</span></h2>
	<mos:tmpl type="simpleCondition" varscope="intro" requiredVars="introduction">
		<p>{INTRODUCTION}</p><br/>
	</mos:tmpl>
</mos:tmpl>

<mos:tmpl name="course">
	<a name="{OID}"></a>
	<div class="class<mos:var name="FIRST_CLASS" varscope="course"/>">
	
	<mos:tmpl type="simpleCondition" scope="course" requiredvars="IMAGEURL">
		<div class="photo"><img src="{IMAGEURL}" width="160" height="95" alt="{IMAGECREDIT}" /></div>
	</mos:tmpl>
	<h4>{TITLE}</h4>
	<mos:tmpl type="simpleCondition" requiredVars="subtitle" varscope="course">
		<h5 class="subtitle">{SUBTITLE}</h5>
	</mos:tmpl>
	<mos:tmpl type="simpleCondition" requiredVars="partnername" varscope="course" name="partner">
		<p class="info"><strong>{PARTNERNAME}</strong> <mos:tmpl type="simpleCondition" requiredvars="partnerCode" varscope="course">({PARTNERCODE})</mos:tmpl></p>
	</mos:tmpl>
	<ul>
	<li>{DATE_DESC}</li>
	<mos:tmpl varscope="course" type="simplecondition" requiredvars="sessions" autoclear="yes"><li>{SESSIONS}</li></mos:tmpl>
	<mos:tmpl varscope="course" type="simplecondition" requiredvars="venue" name="venue" autoclear="yes"><li>{VENUE}</li></mos:tmpl>
	<mos:tmpl varscope="course" type="simplecondition" requiredvars="pricing" autoclear="yes"><li>{PRICING}</li></mos:tmpl>
	</ul>

	<mos:tmpl name="register" varscope="course" type="simpleCondition" requiredVars="register_link">
		<a href="{REGISTER_LINK}"><img src="{LIVE_SITE}/templates/skirball_main/images/button_add_to_cart.gif" class="submit_button" /></a>
	</mos:tmpl>

	<p>{DESCRIPTION}</p>
	
	<mos:tmpl name="instructor" varscope="course" type="simplecondition" requiredvars="instructorbio">
		<div class="instructor">
			{INSTRUCTORBIO}
		</div>
	</mos:tmpl>

	</div>
</mos:tmpl>
</div>
</mos:tmpl>
