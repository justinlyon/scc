<mos:comment>
/**
 *  $Id$: calendar_control.pat.tpl, Sep 19, 2006 11:37:21 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="calendar_control" varScope="calendar">

<form name="control" id="control" action="index.php" method="post">
	<input type="hidden" name="option" value="com_ccevents" />
	<input type="hidden" name="scope" value="cldr" />
	<input type="hidden" name="task" id="task" value="{CAL_TYPE}" />
	<input type="hidden" name="ccmenu" id="ccmenu" value="{CCMENU}" />

<div class="calendar_links">
	<div class="return"><a href="#" onclick="history.go(-1);">Return to Previous Page</a></div>

<mos:tmpl name="switch_view" type="condition" conditionVar="CAL_TYPE" varScope="calendar">
	<mos:sub condition="text">
		<div class="view"><a href="{CAL_VIEW_LINK}">View as Graphical Calendar</a></div></div>
	</mos:sub>
	<mos:sub condition="month">
		<div class="view"><a href="{CAL_VIEW_LINK}">View as Text Calendar</a></div></div>
	</mos:sub>
</mos:tmpl>


<div id="family_key">
<div class="calendar_title">
<h2 class="cal"><span>Calendar</span></h2>
</div>
</div>


<div class="cal_date_select">
<select name="month">
	<mos:tmpl name="month_options">
		<option value="{VALUE}" {SELECTED}>{TEXT}</option>
	</mos:tmpl>
</select>

<select name="year">
	<mos:tmpl name="year_options">
		<option value="{VALUE}" {SELECTED}>{VALUE}</option>
	</mos:tmpl>
</select>


<input type="image" src="/components/com_ccevents/themes/default/images/button_cal_submit.gif" class="submit_button" name="submit" value="Submit" />
</div>

<div class="cal_program_filter">
<select name="category" onchange="control.submit();">
	<option value="">Filter by Type of Program</option>
	<mos:tmpl name="category_options">
		<option value="{COID}" {SELECTED}>{NAME}</option>
	</mos:tmpl>
</select>
</div>

<div class="current_month_wrapper">
	<span class="current_month">
		<a href="index.php?option=com_ccevents&scope=cldr&task={CAL_TYPE}&month={PREV_MONTH}&year={PREV_MONTH_YEAR}" class="left_arrow"><img src="/components/com_ccevents/themes/default/images/arrow_left.gif" width="11" height="13" alt="" align="absmiddle" /></a>&nbsp;&nbsp;
		<span class="theMonth">{CUR_VIEW}</span>&nbsp;&nbsp;
		<a href="index.php?option=com_ccevents&scope=cldr&task={CAL_TYPE}&month={NEXT_MONTH}&year={NEXT_MONTH_YEAR}" class="right_arrow"><img src="/components/com_ccevents/themes/default/images/arrow_right.gif" width="11" height="13" alt="" align="absmiddle" /></a>
	</span>
</div>

</form>

<script>
	function changeTask(task) {
		elm = document.forms['control'].task.value = task;
	}
	
</script>

</mos:tmpl>
