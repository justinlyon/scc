<mos:comment>
/**
 *  $Id$: announcement.pat.tpl, Oct 23, 2006 2:59:10 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="announcement_open">
	<mos:tmpl name="includes" src="includes.pat.tpl" relative="yes"/>

	<fieldset>
	<legend>Announcement Manager</legend>
	<form action="index2.php?option=com_ccevents&scope=annc&task=annc" method="post" name="adminForm">
	<input type="hidden" name="option" value="com_ccevents"/>
	<input type="hidden" name="scope" value="annc" />
	<input type="hidden" name="task" value="annc" />
		
	<table id="content_container"  style="width:500px;">
		<tr>
			<td id="c1_container" >
</mos:tmpl>

<mos:tmpl name="announcement_close">
			</td>
		</tr>
	</table>
</mos:tmpl>