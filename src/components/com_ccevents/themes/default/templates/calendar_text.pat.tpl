<mos:comment>
/**
 *  $Id$: calendar_flat.pat.tpl, Sep 18, 2006 10:29:51 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="calendar">

<mos:tmpl src="calendar_control.pat.tpl" relative="yes"/>

<div class="calendar_table_text">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
<th id="date">Date</th>
<th id="day">Day</th>
<th id="time">Time/Event</th>
</tr>

<mos:tmpl name="day">
<tr <mos:tmpl name="today" varScope="day" type="simpleCondition" requiredVars="today">id="today"</mos:tmpl>>
<td class="date_num">{DAY_NUM}</td>
<td>{DAY_NAME}</td>
<td><!-- time tag -->
	<mos:tmpl name="event">
	<p><span class="time">{FORMATTED_TIME}</span> <mos:tmpl name="prime_genre" varScope="event" type="simpleCondition" requiredVars="genre">{GENRE}: </mos:tmpl><a href="{URL}">{TITLE}</a>
		<mos:tmpl name="family" varScope="event" type="simpleCondition" requiredVars="family">
			<img src="/templates/skirball_main/images/icon_calendar_family.gif" width="13" height="11" alt="" />
		</mos:tmpl>
	</p>
	</mos:tmpl>
</td>
</tr>
</mos:tmpl>


</table>
</div>

</mos:tmpl>
