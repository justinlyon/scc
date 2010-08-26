{* <!--
 *  $Id: exhibitionForm.tpl 123 2006-06-28 10:42:41Z tevans $: exhibitionForm.tpl.php, Jun 24, 2006 8:33:52 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 * -->*}
 
{literal}
<script>
var openDate = new CalendarPopup();
openDate.setReturnFunction("setMultipleValues4");
function setMultipleValues4(y,m,d) {
     document.forms['adminForm'].startYear.value=y;
     document.forms['adminForm'].startYear.selectedIndex=m;
     for (var i=0; i<document.forms['adminForm'].startDay.options.length; i++) {
          if (document.forms['adminForm'].startDay.options[i].value==d) {
               document.forms['adminForm'].startDay.selectedIndex=i;
          }
     }
}


function getDateString(y_obj,m_obj,d_obj) {
     var y = y_obj.options[y_obj.selectedIndex].value;
     var m = m_obj.options[m_obj.selectedIndex].value;
     var d = d_obj.options[d_obj.selectedIndex].value;
     if (y=="" || m=="") { return null; }
     if (d=="") { d=1; }
     return str= y+'-'+m+'-'+d;
}
 </script>
{/literal}
 
 
<div class="c1_form">
		<ul>
			<li class="first"><label class="req">Exhibition Title:</label><input id="title" name="title" type="text" class="text" value="{$model.event.title}"/></li>
			<li><label>Sub-title:</label><input id="subtitle" name="subtitle" type="text"  class="text" value="{$model.event.subtitle}"/></li>
			<li><label class="req">Published:</label><span class="input_row">
				<select name="pubState" id="pubState">
					{html_options options=$model.pubState_options selected=$model.event.pubState.value}
				</select></span>
			</li>
			<li><label class="req">Event Status:</label><span class="input_row">
				<select name="eventStatus" id="eventStatus">
					{html_options options=$model.eventStatus_options selected=$model.event.eventStatus.value}
				</select></span>
			</li>
			<li>
				<label class="req">Opening Date:</label>
				<span class="input_row">{html_select_date prefix="start" time=$model.event.startTime start_year=$model.startYear end_year=$model.endYear} 
				<a href="javascript: void(0);" onClick="openDate.showCalendar('openDateImage',getDateString(document.forms['adminForm'].startYear,document.forms['adminForm'].startMonth,document.forms['adminForm'].startDay)); return false;">
				<img src="/scc/com_ccevents/app/admin/graphics/cal_24.gif" align="absmiddle" name="openDateImg" id="openDateImg" border="0"/>
				</a>
				</span>
			</li>
			<li>
				<label>Closing Date:</label>
				<span class="input_row">{html_select_date prefix="end" time=$model.event.endTime start_year=$model.startYear end_year=$model.endYear} 
				<img src="/scc/com_ccevents/app/admin/graphics/cal_24.gif" align="absmiddle"/></span>
			</li>
			<li><label class="textarea">Date Description:</label><textarea id="scheduleNote" name="scheduleNote">{$model.event.scheduleNote}</textarea></li>
			<li><label class="textarea">Pricing Description:</label><textarea id="pricing" name="pricing">{$model.event.pricing}</textarea></li>
			<li><label class="textarea req">Summary Description:</label><textarea id="summary" name="summary">{$model.event.summary}</textarea></li>
			<li><label class="textarea req" >Detailed Description:</label><br/>
				{php}
					// parameters : areaname, content, hidden field, width, height, rows, cols
					editorArea( 'editor1', $GLOBALS['description'], 'description', '200;', '350', '75', '20' ) ; 
				{/php}		
			</li>	
			<li class="separator"><hr></li>
			<li><label>Ticket Link:</label><input id="ticketUrl" name="ticketUrl" type="text" class="text" value="{$model.event.ticketUrl}"/></li>
			<li><label class="textarea">Ticket Description:</label><textarea id="ticketDesc" name="ticketDesc">{$model.event.ticketDesc}</textarea></li>	
		</ul>
</div>

<input type="hidden" name="displayOrder" value="{$model.event.displayOrder}" />