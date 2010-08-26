<mos:comment>
/**
 *  $Id$: venue_summary.pat.tpl, Sep 5, 2006 7:43:08 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="venue_summary">
  <form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>Venue Manager</th>
		</tr>
		</table>
		
		<table class="adminlist" border="0">
		<tr>
			<th width="5">#</th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll({TOTAL});" /></th>
	 		<th style="text-align: left;">Venue Name</th>
	 		<th style="text-align: left;">Address</th>
	 		<th>Published</th>
	 		<th>ID</th>
	 		<th># Exhibits</th>
	 		<th># Programs</th>
	 		<th># Courses</th>
	 	</tr>

		<mos:tmpl name="venue" autoclear="yes">
			<tr class="row{ITER}">
				<td>{INDEX}.</td>
				<td align="center">
					<input type="checkbox" id="cb{ITER}" name="cid[]" 
  					value="{ITER}" onclick="setOids(this, {OID} ); isChecked(this.checked);" />
  				</td>
  				<td align="left">
  					<a href="index2.php?option=com_ccevents&scope=vnue&task=read&oid={OID}">{NAME}</a>
  				</td>
  				<td align="left"><mos:var name="address" default="n/a" /></td>
  				<td align="center">
  					<a href="javascript: void(0);"  
						onclick="return toggleButton('{PUBTASK}',{OID},'{PUBTOGGLE}');">
						<img src="images/{PUBIMG}" width="12" height="12" border="0" alt="{PUBALT}" />
					</a>
  				</td>
  				<td align="center">{OID}</td>
				<td align="center"><mos:var name="exhibition" default="0"/></td>
				<td align="center"><mos:var name="program" default="0"/></td>
				<td align="center"><mos:var name="course" default="0"/></td>
			</tr>
		</mos:tmpl>
  </table>
  	
  	<mos:comment>INCLUDE THE PAGE NAVIGATION HERE</mos:comment>

	<input type="hidden" name="option" value="com_ccevents" />
	<input type="hidden" name="scope" value="vnue" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="oids" value="" />
	<input type="hidden" name="toggle_value" value="" />
	<input type="hidden" name="hidemainmenu" value="0" />
	</form>


	<mos:tmpl src="summary_script.pat.tpl" relative="yes" />
</mos:tmpl>

