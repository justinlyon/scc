<mos:comment>
/**
 *  $Id$: program_detail.pat.tpl, Sep 14, 2006 4:55:31 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="program_form">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>Program Manager:&nbsp;{TITLE}</legend>
	<form action="index2.php" method="post" name="adminForm">
	<input type="hidden" name="oid" id="oid" value="{OID}"/>
		
		<table id="content_container">
		<tr>
			<td id="c1_container">
		
			<div class="c1_form">
			<ul>
				<li class="first"><label class="req">Program Title:</label><input id="title" name="title" type="text" class="text" value="{TITLE}"/></li>
				<li><label>Subtitle:</label><input id="subtitle" name="subtitle" type="text" class="text" value="{SUBTITLE}"/></li>
                                <li><label>Alias:</label><input id="alias" name="alias" type="text" class="text" value="{ALIAS}"/></li>
				<li><label class="req">Published:</label><span class="input_row">
					<mos:tmpl src="option_lists/pubstates.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="req">Primary Genre:</label><span class="input_row">
					<mos:tmpl src="option_lists/primary_genre.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="req">Default Venue:</label><span class="input_row">
					<mos:tmpl src="option_lists/default_venue.pat.tpl" relative="yes"/></span>
				</li>
				<li><label>Featured:</label>
					<input type="checkbox" name="featured" id="featured" 
						<mos:tmpl varscope="program_form" type="simpleCondition" requiredVars="featured=1">
							checked
						</mos:tmpl>
					/> 
				</li>
				<li><label class="textarea">Date Description:</label><textarea id="scheduleNote" name="scheduleNote">{SCHEDULENOTE}</textarea></li>
				<li><label class="textarea">Contact:</label><textarea id="contact" name="contact">{CONTACT}</textarea></li>
				<li><label class="textarea req">Summary Description:</label><br/>
					{SUMMARY_EDITOR}
				</li>
				<li><label class="textarea req" >Detailed Description:</label><br/>
					{DESCRIPTION_EDITOR}
				</li>
				<li><label class="textarea" >Sponsor Credits:</label><br/>
					{CREDIT_EDITOR}
				</li>
				<li class="separator"><hr></li>
				<li><label class="textarea">Pricing Description:</label><textarea id="pricing" name="pricing">{PRICING}</textarea></li>
				<li><label>Ticket Override URL:</label><input id="ticketUrl" name="ticketUrl" type="text" class="text" value="{TICKETURL}"/></li>
				<li><label class="textarea">Ticket Description:</label><textarea id="ticketDesc" name="ticketDesc">{TICKETDESC}</textarea></li>	
				<li><label>Audio URL:</label><input id="audioClip" name="audioClip" type="text" class="text" value="{AUDIOCLIP}"/></li>
				<li><label>Video URL:</label><input id="videoClip" name="videoClip" type="text" class="text" value="{VIDEOCLIP}"/></li>
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

<mos:tmpl name="perfTab" src="activity_tab.pat.tpl" relative="yes" />

<mos:tmpl name="exbtTab" src="option_lists/exhibition_multi.pat.tpl" relative="yes" />

<mos:tmpl name="crseTab" src="option_lists/course_multi.pat.tpl" relative="yes" />

<mos:tmpl name="catsTab" src="option_lists/category_multi.pat.tpl" relative="yes" />

<mos:tmpl name="sersTab" src="option_lists/series_multi.pat.tpl" relative="yes" />

<mos:tmpl name="glryTab" src="option_lists/gallery.pat.tpl" relative="yes" />

<mos:tmpl name="close_form">
			</td>
		</tr>
		</table>
	
		<input type="hidden" name="option" value="com_ccevents" />
		<input type="hidden" name="scope" value="prgm" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="oids" value="" />
		<input type="hidden" name="toggle_value" value="" />
	</form>
	</fieldset>
</mos:tmpl>


