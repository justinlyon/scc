<mos:comment>
/**
 *  $Id$: course_detail.pat.tpl, Oct 5, 2006 10:51:29 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="course">

<mos:tmpl name="intro">
	<h2><span><mos:var name="genre" copyFrom="course.genre"/>: Course Details</span></h2>
	<mos:tmpl type="simpleCondition" varscope="intro" requiredVars="announcement">
		<p>{ANNOUNCEMENT}</p><br/>
	</mos:tmpl>
</mos:tmpl>
	
<div class="event">
	<div class="event_media">
	
	<mos:tmpl name="photo" type="simpleCondition" requiredVars="imageurl">
		<div class="photo"><img src="{IMAGEURL}" width="160" height="160" alt="<mos:var name="title" copyFrom="course.title"/>" /></div>
		<mos:tmpl type="simpleCondition" varScope="photo" requiredVars="caption">
			<p class="caption">{CAPTION}</p>
		</mos:tmpl>
		<br />
	</mos:tmpl>
	
	<mos:tmpl name="audio" varScope="course" type="simpleCondition" requiredVars="audioClip">
		<a href="{AUDIOCLIP}" class="listen" target="media">Listen to Sample</a>
	</mos:tmpl>
	<mos:tmpl name="video" varScope="course" type="simpleCondition" requiredVars="videoClip">
		<a href="{VIDEOCLIP}" class="watch" target="media">Watch Video</a>
	</mos:tmpl>
	
	</div><!-- event_media -->



	<div class="event_info">
		<h4 class="course">{TITLE}</h4>
		<mos:tmpl type="simpleCondition" requiredVars="subtitle" varscope="course">
			<h5 class="subtitle">{SUBTITLE}</h5>
		</mos:tmpl>
		<mos:tmpl name="series">
			<h4 class="series"><A href="{SERIES_LINK}">{NAME}</a></h4>
		</mos:tmpl>
		<div class="time">
			<mos:tmpl name="performance">
				<p><mos:var name="startTime" modifier="dateformat" format="%A, %B %d, %I:%M %p"/>
				<mos:tmpl type="simpleCondition" requiredvars="ticketurl" varscope="performance">
					<a href="{TICKETURL}" class="tickets" target="_blank"><img src="{IMGSRC}" align="absmiddle" width="65" height="16" alt="Tickets" /></a>
				</mos:tmpl>
				</p>
			</mos:tmpl>
		</div>
		<p class="location">
			<mos:tmpl name="venues" type="condition" conditionVar="OID">
				<mos:sub condition="__single">
					<a href="{VENUE_LINK}">{NAME}</a>
				</mos:sub>
				<mos:sub condition="__first">
					<a href="{VENUE_LINK}">{NAME}</a>
				</mos:sub>
				<mos:sub condition="__default">
					|&nbsp;<a href="{VENUE_LINK}">{NAME}</a>
				</mos:sub>
			</mos:tmpl>
		</p>

		
		<mos:tmpl name="show_audience" visibility="hidden">
			<h6>APPROPRIATE FOR:</h6>
			<mos:tmpl name="audience">
				<p>{NAME}</p>
			</mos:tmpl>
		</mos:tmpl>

		<mos:tmpl type="simpleCondition" varScope="course" requiredvars="pricing">
			<h6>ADMISSION:</h6>
			<p>{PRICING}</p>
		</mos:tmpl>

		<mos:tmpl type="simpleCondition" varscope="course" requiredvars="ticketDesc">
			<h6>PURCHASE TICKETS:</h6>
			{TICKETDESC}
		</mos:tmpl>

		<div id="description">
		{DESCRIPTION}
		</div>

		<mos:tmpl name="exhibition">
			<p><mos:var name="prgm_title" copyFrom="course.TITLE" /> is presented in conjunction with:<br/>
				<mos:tmpl name="exhibit">
					<span><a href="{EXBT_LINK}">{TITLE}</a></span><br/>
				</mos:tmpl>
			</p>
		</mos:tmpl>

		<mos:tmpl name="series_related">
			<h6>OTHER COURSES IN THIS SERIES:</h6>
			<ul>
				<mos:tmpl name="related">
					<li><a href="{PRGM_LINK}">{TITLE}</a> (<mos:var name="startTime" modifier="dateformat" format="%B %d, %Y"/>)</li>
				</mos:tmpl>
			</ul>
		</mos:tmpl>

		
<!--		
		<div class="support">
		
		<h6>THIS COURSE IS MADE POSSIBLE BY SUPPORT FROM:</h6>
		<table class="sponsors" cellspacing="0">
		<tr>
		<td class="sponsor"><img src="../images/temp_sponsor2.gif" width="100" height="25" alt="" /></td>
		<td>&nbsp;</td>
		<td class="sponsor"><img src="../images/temp_sponsor1.gif" width="100" height="35" alt="" /></td>
		<td>&nbsp;</td>
		<td class="sponsor">The James Irvine Foundation</td>
		</tr>
		<tr><td colspan="5">&nbsp;</td></tr>
		</table>
		
		</div>
-->
</div><!-- event_info -->
</div><!-- event -->
</mos:tmpl>
