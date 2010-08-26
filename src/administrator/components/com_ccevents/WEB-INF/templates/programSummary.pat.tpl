<mos:comment>
/**
 *  $Id$: exhibitionSummary.pat.tpl, Aug 19, 2006 3:00:20 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **
</mos:comment>
 
<mos:tmpl name="table_header">
  <form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>Exhibition Manager</th>
		</tr>
		</table>
		
		<table class="adminlist" border="0">
		<tr>
			<th width="5">#</th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" /></th>
	 		<th style="text-align: left;">Exhibition Title</th>
	 		<th>Published</th>
	 		<th>Event Status</th>
	 		<th colspan="2" align="center" width="5%">Reorder</th>
			<th width="2%">Order</th>
			<th width="1%"><a href="javascript: saveorder({COUNT})
				"><img src="images/filesave.png" border="0" width="16" height="16" 
				alt="Save Order" /></a></th>
	 		<th class="left">Start Date</th>
	 		<th class="left">End Date</th>
	 		<th>ID</th>
	 		<th># Venues</th>
	 		<th># Programs</th>
	 		<th># Courses</th>
	 	</tr>
</mos:tmpl>


<mos:tmpl name="table_row" autoclear="yes">
  <tr class="row{ITER}">
  	<td>{ITER}.</td>
  	<td align="center">
  		<input type="checkbox" id="cb{ITER}" name="cid[]" 
  		value="{ITER}" onclick="setOids(this, {OID} ); isChecked(this.checked);" />
  		</td>
	<td align="left"><a href="{DLINK}">{TITLE}</a></td>
	<td align="center">
		<a href="javascript: void(0);"  
			onclick="return toggleButton('{PUBTASK}',{OID},'{PUBTOGGLE}');">
			<img src="images/{PUBIMG}" width="12" height="12" border="0" alt="{PUBALT}" />
		</a>
		</td>
	<td align="center">
	 	<a href="javascript: void(0);"  
			onclick="return toggleButton('toggleEventStatus', {OID}, '{STATUSTOGGLE}')">
			<img src="images/{STATUSIMG}" width="12" height="12" border="0" alt="{STATUSALT}" />
		</a>
	 	</td>
	<td align="right">
	 	<mos:tmpl name="move_up" type="simpleCondition" requiredVars="FIRST=no">
	 		<a href="javascript: void(0);" onClick="return reorder(<mos:var name="oid" copyFrom="table_row.OID"/>,'orderup')" title="Move Up">
				<img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up">
			</a>
		</mos:tmpl>
		</td>
	<td align="left">
		<mos:tmpl name="move_down" type="simpleCondition" requiredVars="LAST=no">
			<a href="javascript: void(0);" onClick="return reorder(<mos:var name="oid" copyFrom="table_row.OID"/>,'orderdown')" title="Move Down">
				<img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down">
			</a>
		</mos:tmpl>
		</td>
	<td align="center" colspan="2">
		<input type="text" name="order[]" size="5" value="{DISPLAYORDER}" class="text_area" style="text-align: center" />
		</td>
	<td align="center">{STARTTIME|Dateformat|format:%b %d, %Y}</td>
	<td align="center">{ENDTIME|Dateformat|format:%b %d, %Y}</td>
	<td align="center">{OID}</td>
	<td align="center">{NUM_VENUES}</td>
	<td align="center">{NUM_PROGRAMS}</td>
	<td align="center">{NUM_COURSES}</td>
  </tr>
</mos:tmpl>


<mos:tmpl name="table_close">
  </table>
  {PAGNAV}
</mos:tmpl>


<mos:tmpl name="form_close">
	<input type="hidden" name="option" value="com_ccevents" />
	<input type="hidden" name="scope" value="exbt" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="oids" value="" />
	<input type="hidden" name="toggle_value" value="" />
	</form>
</mos:tmpl>





<mos:tmpl name="script">
	<script>
		function setOids(checkbox, oid)
		{
			var myoids = new Array();
			if(document.adminForm.oids.value != "") {
				myoids = document.adminForm.oids.value.split(",");
			}
			if(checkbox.checked) {				
				var found = false;
				for(i=0; i<myoids.length; i++) {
					if(oid == myoids[i]) {
						found = true;
					}	
				}
				if(!found) {
					myoids.push(oid);
				}
				
			}
			else {
				var tmpoids = myoids;
				for(i=0; i<myoids.length; i++) {
					if(oid == myoids[i]) {
						tmpoids.splice(i,1);
					}	
				}
				myoids = tmpoids;
			}
			document.adminForm.oids.value = myoids.join();
		}
		function reorder(oid, direction)
		{
			document.adminForm.oids.value = oid;
			if (direction == 'orderup') {
				submitbutton('orderUp');
			} else {
				submitbutton('orderDown');
			}
			document.adminForm.submit();
		}
		function toggleButton(task, oid, value)
		{
			document.adminForm.task.value = task;
			document.adminForm.oids.value = oid;
			document.adminForm.toggle_value.value = value;
			document.adminForm.submit();
		}
	</script>
</mos:tmpl>