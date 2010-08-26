<mos:comment>
/**
 *  $Id$: home_page_detail.pat.tpl, Sep 5, 2006 8:43:25 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="home_page_form">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>Home Page Manager:&nbsp;{NAME}</legend>
	<form action="index2.php" method="post" name="adminForm">
		<input type="hidden" name="oid" id="oid" value="{OID}"/>
		<table id="content_container">
		<tr>
			<td id="c1_container">
		
			<div class="c1_form">
			<ul>
				<li class="first"><label class="req">Home Page:</label><input id="name" name="name" type="text" class="text" value="{NAME}"/></li>
				<li><label class="req">Published:</label><span class="input_row">
					<mos:tmpl src="option_lists/pubstates.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="req">Publish Date:</label>
					<span class="input_row">
						<mos:tmpl src="option_lists/startdate.pat.tpl" relative="yes" />
						<!--
						<a href="javascript: void(0);" onClick="openDate.showCalendar('openDateImage',getDateString(document.forms['adminForm'].startYear,document.forms['adminForm'].startMonth,document.forms['adminForm'].startDay)); return false;">
						<img src="/scc/com_ccevents/app/admin/graphics/cal_24.gif" align="absmiddle" name="openDateImg" id="openDateImg" border="0"/>
						</a>
						-->
					</span>
				</li>
			</ul>
			</div>

			</td>
			<td id="c2_container">
</mos:tmpl>

<mos:tmpl name="exhibitions" src="option_lists/published_exhibitions.pat.tpl" relative="yes" />
<mos:tmpl name="programs" src="option_lists/published_events.pat.tpl" relative="yes" />
<mos:tmpl name="calendar" src="option_lists/published_calendar.pat.tpl" relative="yes" />

<mos:tmpl name="close_form">
			</td>

		</tr>
		</table>
	
		<input type="hidden" name="option" value="com_ccevents" />
		<input type="hidden" name="scope" value="home" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="oids" value="" />
		<input type="hidden" name="toggle_value" value="" />
	</form>
</mos:tmpl>


