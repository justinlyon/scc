<mos:comment>
/**
 *  $Id$:
 *  Copyright (c) 2008, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **
</mos:comment>
 
<mos:tmpl name="person_summary">
  <form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>Artist Manager</th>
		</tr>
		</table>
		
		<table class="adminlist" border="0">
		<tr>
			<th width="5">#</th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" /></th>
	 		<th style="text-align: left;">Last Name</th>
	 		<th style="text-align: left;">First Name</th>
	 		<th style="text-align: left;">Display Name</th>
	 		<th style="text-align: left;">Title</th>
	 		<th>Published</th>
	 		<th>ID</th>
	 	</tr>

		<mos:tmpl name="person" autoclear="yes">
			<tr class="row{ITER}">
				<td>{INDEX}.</td>
				<td align="center">
					<input type="checkbox" id="cb{ITER}" name="cid[]" 
  					value="{ITER}" onclick="setOids(this, {OID} ); isChecked(this.checked);" />
  				</td>
  				<td align="left">
  					<a href="index2.php?option=com_ccevents&scope=pers&task=read&oid={OID}">{LASTNAME}</a>
  				</td>
  				<td align="left">
  					<a href="index2.php?option=com_ccevents&scope=pers&task=read&oid={OID}">{FIRSTNAME}</a>
  				</td>
  				<td align="left">
  					<a href="index2.php?option=com_ccevents&scope=pers&task=read&oid={OID}">{DISPLAYNAME}</a>
  				</td>
  				<td align="left">{TITLE}</a>
  				</td>
  				<td align="center">
  					<a href="javascript: void(0);"  
						onclick="return toggleButton('{PUBTASK}',{OID},'{PUBTOGGLE}');">
						<img src="images/{PUBIMG}" width="12" height="12" border="0" alt="{PUBALT}" />
					</a>
  				</td>
 				<td align="center">{OID}</td>
			</tr>
		</mos:tmpl>
  </table>
  	
  	<mos:comment>INCLUDE THE PAGE NAVIGATION HERE</mos:comment>

	<input type="hidden" name="option" value="com_ccevents" />
	<input type="hidden" name="scope" value="pers" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="oids" value="" />
	<input type="hidden" name="toggle_value" value="" />
	<input type="hidden" name="hidemainmenu" value="0" />
	</form>


	<mos:tmpl src="summary_script.pat.tpl" relative="yes" />
</mos:tmpl>

