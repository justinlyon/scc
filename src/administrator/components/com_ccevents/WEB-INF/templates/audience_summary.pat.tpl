<mos:comment>
/**
 *  $Id$: audience_summary.php, Oct 13, 2006 5:28:33 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="audience_summary">
  <form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>Audience Manager</th>
		</tr>
		</table>
		
		<table class="adminlist" border="0">
		<tr>
			<th width="5">#</th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll({TOTAL});" /></th>
	 		<th style="text-align: left;">Series Name</th>
	 		<th>Published</th>
	 		<th>Family</th>
	 		<th>ID</th>
	 		<th># Programs</th>
	 	</tr>

		<mos:tmpl name="audience" autoclear="yes">
			<tr class="row{ITER}">
				<td>{INDEX}.</td>
				<td align="center">
					<input type="checkbox" id="cb{ITER}" name="cid[]" 
  					value="{ITER}" onclick="setOids(this, {OID} ); isChecked(this.checked);" />
  				</td>
  				<td align="left">
  					<a href="index2.php?option=com_ccevents&scope=audc&task=read&oid={OID}">{NAME}</a>
  				</td>
  				<td align="center">
  					<a href="javascript: void(0);"  
						onclick="return toggleButton('{PUBTASK}',{OID},'{PUBTOGGLE}');">
						<img src="images/{PUBIMG}" width="12" height="12" border="0" alt="{PUBALT}" />
					</a>
  				</td>
  				<td align="center">
  					<mos:tmpl varscope="audience" type="condition" conditionvar="family">
  						<mos:sub condition="1">yes</mos:sub>
  						<mos:sub condition="__default">no</mos:sub>
  					</mos:tmpl>
  				</td>
  				<td align="center">{OID}</td>
				<td align="center"><mos:var name="program" default="0"/></td>
			</tr>
		</mos:tmpl>
  </table>
  	
  	<mos:comment>INCLUDE THE PAGE NAVIGATION HERE</mos:comment>

	<input type="hidden" name="option" value="com_ccevents" />
	<input type="hidden" name="scope" value="audc" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="oids" value="" />
	<input type="hidden" name="toggle_value" value="" />
	<input type="hidden" name="hidemainmenu" value="0" />
	</form>


	<mos:tmpl src="summary_script.pat.tpl" relative="yes" />
</mos:tmpl>
