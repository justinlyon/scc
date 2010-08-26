<mos:comment>
/**
 *  $Id$: Genre_detail.pat.tpl, Sep 5, 2006 8:43:25 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="person_detail">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>Artist Manager:&nbsp;{NAME}</legend>
	<form action="index2.php" method="post" name="adminForm">
		<input type="hidden" name="oid" id="oid" value="{OID}"/>
		<table id="content_container">
		<tr>
			<td id="c1_container">
		
			<div class="c1_form">
			<ul>
				<li class="first"><label class="req">Artist First Name:</label><input id="firstName" name="firstName" type="text" class="text" value="{FIRSTNAME}"/></li>
				<li ><label class="req">Artist Last Name:</label><input id="lastName" name="lastName" type="text" class="text" value="{LASTNAME}"/></li>
				<li ><label>Display Name:</label><input id="displayName" name="displayName" type="text" class="text" value="{DISPLAYNAME}"/></li>
                                <li><label>Alias:</label><input id="alias" name="alias" type="text" class="text" value="{ALIAS}"/></li>

				<li><label>Title:</label><input id="title" name="title" type="text" class="text" value="{TITLE}"/></li>	
				<li><label class="req">Published:</label><span class="input_row">
					<mos:tmpl src="option_lists/pubstates.pat.tpl" relative="yes"/></span>
				</li>
				<li><label class="textarea">Summary Biography:</label><br/>
					{SUMMARY_EDITOR}
				</li>	
			</ul>
			</div>

			</td>
			<td id="c2_container">
</mos:tmpl>

<mos:tmpl name="glryTab" src="option_lists/gallery.pat.tpl" relative="yes" />
<mos:tmpl name="exbtTab" src="option_lists/exhibition_multi.pat.tpl" relative="yes" />

<mos:tmpl name="close_form">
			</td>
		</tr>
		</table>
	
		<input type="hidden" name="option" value="com_ccevents" />
		<input type="hidden" name="scope" value="pers" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="oids" value="" />
		<input type="hidden" name="toggle_value" value="" />
		<input type="hidden" name="persscope" value="Artist" />
	</form>
</mos:tmpl>


