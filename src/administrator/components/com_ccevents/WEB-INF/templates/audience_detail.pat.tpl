<mos:comment>
/**
 *  $Id$: Audience_detail.pat.tpl, Sep 5, 2006 8:43:25 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="audience_detail">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>Audience Manager:&nbsp;{NAME}</legend>
	<form action="index2.php" method="post" name="adminForm">
		<input type="hidden" name="oid" id="oid" value="{OID}"/>
		<table id="content_container">
		<tr>
			<td id="c1_container">
		
			<div class="c1_form">
			<ul>
				<li class="first"><label class="req">Audience Name:</label><input id="name" name="name" type="text" class="text" value="{NAME}"/></li>
				<li><label>Subtitle:</label><input id="subtitle" name="subtitle" type="text" class="text" value="{SUBTITLE}"/></li>	
                                <li><label>Alias:</label><input id="alias" name="alias" type="text" class="text" value="{ALIAS}"/></li>

				<li><label class="req">Published:</label><span class="input_row">
					<mos:tmpl src="option_lists/pubstates.pat.tpl" relative="yes"/></span>
				</li>
				<li><label>Family Friendly:</label>
					<input type="checkbox" name="family" id="family" 
						<mos:tmpl varscope="audience_detail" type="simpleCondition" requiredVars="family=1">
							checked
						</mos:tmpl>
					/> 
				</li>
				<li><label class="textarea">Audience Description:</label><br/>
					{DESC_EDITOR}
				</li>	
			</ul>
			</div>

			</td>
			<td id="c2_container">
</mos:tmpl>

<mos:tmpl name="prgmTab" src="option_lists/program_multi.pat.tpl" relative="yes" />

<mos:tmpl name="close_form">
			</td>
		</tr>
		</table>
	
		<input type="hidden" name="option" value="com_ccevents" />
		<input type="hidden" name="scope" value="audc" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="oids" value="" />
		<input type="hidden" name="toggle_value" value="" />
		<input type="hidden" name="catscope" value="Audience" />
	</form>
</mos:tmpl>


