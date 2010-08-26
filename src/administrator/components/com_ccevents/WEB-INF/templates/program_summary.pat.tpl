<mos:comment>
/**
 *  $Id$: program_summary.pat.tpl, Aug 19, 2006 3:00:20 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **
</mos:comment>
 
<mos:tmpl name="program_summary">
  <form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>Program Manager</th>
		</tr>
		</table>
		
		<table class="adminlist" border="0">
		<tr>
			<th width="5">#</th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll({TOTAL});" /></th>
	 		<th style="text-align: left;">Program Title</th>
	 		<th>Published</th>
	 		<th>Type</th>
	 		<th>Start Date</th>
	 		<th>End Date</th>
	 		<th>ID</th>
	 		<th>Series?</th>
	 		<th># Perf.</th>
	 		<th># Exhib.</th>
	 		<th># Course</th>
	 	</tr>

		<mos:tmpl name="program" autoclear="yes">
			<tr class="row{ITER}">
				<td>{INDEX}.</td>
				<td align="center">
					<input type="checkbox" id="cb{ITER}" name="cid[]" 
  					value="{ITER}" onclick="setOids(this, {OID} ); isChecked(this.checked);" />
  				</td>
  				<td align="left">
  					<a href="index2.php?option=com_ccevents&scope=prgm&task=read&oid={OID}">{TITLE}</a>
  				</td>
  				<td align="center">
  					<a href="javascript: void(0);"  
						onclick="return toggleButton('{PUBTASK}',{OID},'{PUBTOGGLE}');">
						<img src="images/{PUBIMG}" width="12" height="12" border="0" alt="{PUBALT}" />
					</a>
  				</td>
  				<td align="center">{PROGRAMTYPE}</td>
  				<td align="center">{STARTTIME|Dateformat|format:%b %d, %Y}</td>
  				<td align="center">{ENDTIME|Dateformat|format:%b %d, %Y}</td>
  				<td align="center">{OID}</td>
  				<td align="center">{SERIES}</td>
  				<td align="center">{PERFORMANCE}</td>
				<td align="center">{EXHIBITION}</td>
				<td align="center">{COURSE}</td>
			</tr>
		</mos:tmpl>
  </table>
  	
  	<mos:comment>INCLUDE THE PAGE NAVIGATION HERE</mos:comment>

	<input type="hidden" name="option" value="com_ccevents" />
	<input type="hidden" name="scope" value="prgm" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="oids" value="" />
	<input type="hidden" name="toggle_value" value="" />
	<input type="hidden" name="hidemainmenu" value="0" />
	</form>


	<mos:tmpl src="summary_script.pat.tpl" relative="yes" />
</mos:tmpl>

