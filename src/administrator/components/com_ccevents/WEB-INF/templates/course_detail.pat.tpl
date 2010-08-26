<mos:comment>
/**
 *  $Id$: course_detail.pat.tpl, Sep 14, 2006 4:55:31 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="course_form">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>Course Manager:&nbsp;{TITLE}</legend>
	<form action="index2.php" method="post" name="adminForm">
	<input type="hidden" name="oid" id="oid" value="{OID}"/>
		
		<table id="content_container">
		<tr>
			<td id="c1_container">
		
			<div class="c1_form">
			<ul>
				<li class="first"><label class="req">Course Title:</label><input id="title" name="title" type="text" class="text" value="{TITLE}"/></li>
				<li><label>Subtitle:</label><input id="subtitle" name="subtitle" type="text" class="text" value="{SUBTITLE}"/></li>
				<li><label class="req">Published:</label><span class="input_row">
					<mos:tmpl src="option_lists/pubstates.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="req">Primary Genre:</label><span class="input_row">
					<mos:tmpl src="option_lists/primary_genre.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="req">Default Venue:</label><span class="input_row">
					<mos:tmpl src="option_lists/default_venue.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="textarea">Date Description Override:</label><textarea id="scheduleNote" name="scheduleNote">{SCHEDULENOTE}</textarea></li>
				<li><label class="textarea">Pricing Description:</label><textarea id="pricing" name="pricing">{PRICING}</textarea></li>
				<li><label class="textarea req">Summary Description:</label><br>
					{SUMMARY_EDITOR}
				<li><label class="textarea req" >Detailed Description:</label><br/>
					{DESCRIPTION_EDITOR}
				</li>
				<li><label class="textarea req" >Sponsor Credits:</label><br/>
					{CREDIT_EDITOR}
				</li>
				<li class="separator"><hr></li>
				<li><label class="textarea">Instructor Bio:</label><br/>
					{INSTRUCTOR_EDITOR}	
				</li>
				<li class="separator"><hr></li>
				<li><label>Additional Info Title:</label><input type="text" id="addtitle" name="addtitle" class="text" value="{ADDTITLE}" /></li>
				<li><label class="textarea" >Additional Information:</label><br/>
					{ADDINFO_EDITOR}
				</li>	
				<li class="separator"><hr></li>
				<li><label>On-line Product ID:</label><input id="ticketUrl" name="ticketUrl" type="text" class="text" value="{TICKETURL}"/></li>
				<li><label>Partner Name:</label><input id="partnerName" name="partnerName" type="text" class="text" value="{PARTNERNAME}"/></li>
				<li><label>Partner Registration Code:</label><input id="partnerCode" name="partnerCode" type="text" class="text" value="{PARTNERCODE}"/></li>
			</ul>
			</div>

			</td>
			<td id="c2_container">
</mos:tmpl>

<mos:tmpl name="seminarTab" src="activity_tab.pat.tpl" relative="yes" />

<mos:tmpl name="exbtTab" src="option_lists/exhibition_multi.pat.tpl" relative="yes" />

<mos:tmpl name="prgmTab" src="option_lists/program_multi.pat.tpl" relative="yes" />

<mos:tmpl name="catsTab" src="option_lists/category_multi.pat.tpl" relative="yes" />

<mos:tmpl name="sersTab" src="option_lists/series_multi.pat.tpl" relative="yes" />

<mos:tmpl name="glryTab" src="option_lists/gallery.pat.tpl" relative="yes" />

<mos:tmpl name="close_form">
			</td>
		</tr>
		</table>
	
		<input type="hidden" name="option" value="com_ccevents" />
		<input type="hidden" name="scope" value="crse" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="oids" value="" />
		<input type="hidden" name="toggle_value" value="" />
	</form>
	</fieldset>
</mos:tmpl>



