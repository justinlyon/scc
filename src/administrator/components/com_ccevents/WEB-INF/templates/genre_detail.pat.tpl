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

<mos:tmpl name="genre_detail">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>Genre Manager:&nbsp;{NAME}</legend>
	<form action="index2.php" method="post" name="adminForm">
		<input type="hidden" name="oid" id="oid" value="{OID}"/>
		<table id="content_container">
		<tr>
			<td id="c1_container">
		
			<div class="c1_form">
			<ul>
				<li class="first"><label class="req">Genre Name:</label><input id="name" name="name" type="text" class="text" value="{NAME}"/></li>
				<li><label>Subtitle:</label><input id="subtitle" name="subtitle" type="text" class="text" value="{SUBTITLE}"/></li>	
                                <li><label>Alias:</label><input id="alias" name="alias" type="text" class="text" value="{ALIAS}"/></li>

				<li><label class="req">Published:</label><span class="input_row">
					<mos:tmpl src="option_lists/pubstates.pat.tpl" relative="yes"/></span>
				</li>
				<li><label>Image URL:</label><input id="image" name="image" type="text" class="text" value="{IMAGE}"/></li>		
				<mos:tmpl type="simpleCondition" requiredVars="image" varscope="genre_detail">
					<li><label>&nbsp;</label><img src="{IMAGE}" alt="image preview"/> 
				</mos:tmpl>
				
				<li><label>School-Related:</label>
					<input type="checkbox" name="school" id="school" 
						<mos:tmpl varscope="genre_detail" type="simpleCondition" requiredVars="school=on">
							checked
						</mos:tmpl>
					/> 
				</li>
				<li><label class="textarea">Genre Description:</label><br/>
					{DESC_EDITOR}
				</li>	
				<li><label class="textarea">Genre Introduction:</label><br/>
					{INTRO_EDITOR}
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
		<input type="hidden" name="scope" value="gnre" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="oids" value="" />
		<input type="hidden" name="toggle_value" value="" />
		<input type="hidden" name="catscope" value="Genre" />
	</form>
</mos:tmpl>


