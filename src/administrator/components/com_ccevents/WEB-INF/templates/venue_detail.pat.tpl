<mos:comment>
/**
 *  $Id$: venue_detail.pat.tpl, Sep 5, 2006 8:43:25 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="venue_form">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>Venue Manager:&nbsp;{NAME}</legend>
	<form action="index2.php" method="post" name="adminForm">
		<input type="hidden" name="oid" id="oid" value="{OID}"/>
		<table id="content_container">
		<tr>
			<td id="c1_container">
		
			<div class="c1_form">
			<ul>
				<li class="first"><label class="req">Venue Name:</label><input id="name" name="name" type="text" class="text" value="{NAME}"/></li>
                                <li><label>Alias:</label><input id="alias" name="alias" type="text" class="text" value="{ALIAS}"/></li>
				<li><label class="req">Published:</label><span class="input_row">
					<mos:tmpl src="option_lists/pubstates.pat.tpl" relative="yes"/></span>
				</li>
				<li><span>Address and Phone not required if venue is located at the Autry National Center</span></li>
				<mos:tmpl name="address">
					<input type="hidden" name="aoid" id="aoid" value="{OID}"/>
					<li><label>Address:</label><input id="street" name="street" type="text" class="text" value="{STREET}"/></li>
					<li><label>Unit/Suite:</label><input id="unit" name="unit" type="text" class="text" value="{UNIT}"/></li>
					<li><label>City:</label><input id="city" name="city" type="text" class="text" value="{CITY}"/></li>
					<li><label>State:</label><span class="input_row">
						<mos:tmpl src="option_lists/states.pat.tpl" relative="yes"/></span>
					</li>
					<li><label>Zip Code:</label><input id="postalCode" name="postalCode" type="text" class="text" value="{POSTALCODE}"/></li>
					<li><label>Phone:</label><input id="phone" name="phone" type="text" class="text" value="{PHONE}"/></li>
				</mos:tmpl>
				<li><label class="textarea">Venue Description:</label><br/>
					{DESCRIPTION_EDITOR}
				</li>
			</ul>
			</div>

			</td>
			<td id="c2_container">
</mos:tmpl>

<mos:tmpl name="exbtTab" src="option_lists/exhibition_multi.pat.tpl" relative="yes" />

<mos:tmpl name="prgmTab" src="option_lists/program_multi.pat.tpl" relative="yes" />

<mos:tmpl name="crseTab" src="option_lists/course_multi.pat.tpl" relative="yes" />

<mos:tmpl name="glryTab" src="option_lists/gallery.pat.tpl" relative="yes" />

<mos:tmpl name="close_form">
			</td>
		</tr>
		</table>
	
		<input type="hidden" name="option" value="com_ccevents" />
		<input type="hidden" name="scope" value="vnue" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="oids" value="" />
		<input type="hidden" name="toggle_value" value="" />
	</form>
</mos:tmpl>


