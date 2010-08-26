<mos:comment>
/**
 *  $Id$: exhibition_detail.pat.tpl, Sep 21, 2006 6:50:22 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="exhibition_form">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>{SCOPE} Manager:&nbsp;{TITLE}</legend>
	<form action="index2.php" method="post" name="adminForm">
	<input type="hidden" name="oid" id="oid" value="{OID}"/>
	<input type="hidden" name="scheduleOid" id="scheduleOid" value="{SCHEDULEOID}"/>
	<input type="hidden" name="displayOrder" value="{DISPLAYORDER}" />
		
		<table id="content_container">
		<tr>
			<td id="c1_container">
		
			<div class="c1_form">
			<ul>
				<li class="first"><label class="req">{SCOPE} Title:</label><input id="title" name="title" type="text" class="text" value="{TITLE}"/></li>
				<li><label>Subtitle:</label><input id="subtitle" name="subtitle" type="text" class="text" value="{SUBTITLE}"/></li>
                                <li><label>Alias:</label><input id="alias" name="alias" type="text" class="text" value="{ALIAS}"/></li>
                                
				<li><label class="req">Published:</label><span class="input_row">
					<mos:tmpl src="option_lists/pubstates.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="req">Event Status:</label><span class="input_row">
					<mos:tmpl src="option_lists/event_status.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="req">Opening Date:</label>
					<span class="input_row">
						<mos:tmpl src="option_lists/startdate.pat.tpl" relative="yes" />
						<!--
						<a href="javascript: void(0);" onClick="openDate.showCalendar('openDateImage',getDateString(document.forms['adminForm'].startYear,document.forms['adminForm'].startMonth,document.forms['adminForm'].startDay)); return false;">
						<img src="/scc/com_ccevents/app/admin/graphics/cal_24.gif" align="absmiddle" name="openDateImg" id="openDateImg" border="0"/>
						</a>
						-->
					</span>
				</li>
				<li>
					<label>Exhibition Type:</label>
					<span class="input_row">
						<select name="close_type" id="close_type" onchange="showHideClosing();">
							<option value="ongoing">Ongoing</option>
							<option value="ending">Set a Closing Date</option>
						</select>	
					</span>
				</li>
				<li id="close_date" style="display: none;">
					<label>Closing Date:</label>
					<span class="input_row">
						<mos:tmpl src="option_lists/enddate.pat.tpl" relative="yes" />
						<img src="/scc/com_ccevents/app/admin/graphics/cal_24.gif" align="absmiddle"/>
					</span>
				</li>
				<li><label class="textarea">Date Description:</label><textarea id="scheduleNote" name="scheduleNote">{SCHEDULENOTE}</textarea></li>
				<li><label class="textarea req">Summary Description:</label><br/>
					{SUMMARY_EDITOR}
				</li>
				<li><label class="textarea req" >Detailed Description:</label><br/>
					{DESCRIPTION_EDITOR}
				</li>
				<li><label class="textarea" >Sponsor Credits:</label><br/>
					{CREDIT_EDITOR}
				</li>
				<li><label>External Link:</label><input id="externalLink" name="externalLink" type="text" class="text" value="{EXTERNALLINK}"/></li>
				<li class="separator"><hr></li>
				<li><label class="textarea">Pricing Description:</label><textarea id="pricing" name="pricing">{PRICING}</textarea></li>
				<li><label>Ticket Code:</label><input id="ticketUrl" name="ticketUrl" type="text" class="text" value="{TICKETURL}"/></li>
				<li><label class="textarea">Ticket Description:</label><textarea id="ticketDesc" name="ticketDesc">{TICKETDESC}</textarea></li>	
				<li class="separator"><hr></li>
				<li><label>Main Additional Info Title:</label><input type="text" id="addtitle" name="addtitle" class="text" value="{ADDTITLE}" /></li>	
				<li><label class="textarea" >Main Additional Information:</label><br/>
					{ADDINFO_EDITOR}
				</li>
				<li><label>Sidebar Additional Info Title:</label><input type="text" id="addtitle" name="addtitle2" class="text" value="{ADDTITLE2}" /></li>	
				<li><label class="textarea" >Sidebar Additional Information:</label><br/>
					{ADDINFO2_EDITOR}
				</li>
				<li><label class="">Press Release:</label><span class="input_row">
					<mos:tmpl src="option_lists/pressrelease.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="">Comment Article:</label><span class="input_row">
					<mos:tmpl src="option_lists/commentarticle.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="">Related Content Category:</label><span class="input_row">
					<mos:tmpl src="option_lists/relatedcategory.pat.tpl" relative="yes"/></span>
				</li>
			</ul>
			</div>

			</td>
			<td id="c2_container">
</mos:tmpl>


<mos:tmpl name="vnueTab" src="option_lists/venue_multi.pat.tpl" relative="yes" />

<mos:tmpl name="catsTab" src="option_lists/category_multi.pat.tpl" relative="yes" />

<mos:tmpl name="prgmTab" src="option_lists/program_multi.pat.tpl" relative="yes" />

<mos:tmpl name="crseTab" src="option_lists/course_multi.pat.tpl" relative="yes" />

<mos:tmpl name="glryTab" src="option_lists/gallery.pat.tpl" relative="yes" />

<mos:tmpl name="persTab" src="option_lists/person_multi.pat.tpl" relative="yes" />

<mos:tmpl name="close_form">
			</td>
		</tr>
		</table>
	
		<input type="hidden" name="option" value="com_ccevents" />
		<input type="hidden" name="scope" value="exbt" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="oids" value="" />
		<input type="hidden" name="toggle_value" value="" />
	</form>
	</fieldset>
	
	<script>
		function showHideClosing() {
			var showHide = (document.adminForm.close_type.value == 'ongoing') ? 'none' : 'block';
			document.getElementById("close_date").style.display = showHide;
		}
		function initClosing(show) {
			if (show) {
				document.getElementById("close_date").style.display = 'block';
				document.adminForm.close_type.value = 'ending'
			}
		}
		initClosing({SHOW_CLOSING});
	</script>
</mos:tmpl>
