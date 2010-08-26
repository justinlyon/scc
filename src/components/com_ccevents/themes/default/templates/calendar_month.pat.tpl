<mos:comment>
/**
 *  $Id$: calendar_month.php, Sep 18, 2006 9:27:49 PM nchanda
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

<div class="calendar_table">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
<th id="sunday">Sunday</th>
<th id="monday">Monday</th>
<th id="tuesday">Tuesday</th>
<th id="wednesday">Wednesday</th>
<th id="thursday">Thursday</th>
<th id="friday">Friday</th>
<th id="saturday">Saturday</th>
</tr>

<mos:tmpl name="week">
<tr>
	<mos:tmpl name="day">
		<mos:tmpl name="no_date" type="condition" conditionVar="day.DATE">
			
			<mos:sub condition="none">
				<td valign="top" class="no_date">&nbsp;</td>
			</mos:sub>
			
			<mos:sub condition="__default">
				<mos:tmpl name="today" type="condition" conditionVar="day.TODAY">
					<mos:sub condition="yes"><td valign="top" id="today"></mos:sub>
					<mos:sub condition="__default"><td valign="top"></mos:sub>
				</mos:tmpl>
					<div class="date_num"><mos:var name="date" copyFrom="day.DATE" /></div>
					
					<mos:tmpl name="event" visibility="hidden">		
						<div class="cal_event">
							<div class="time">{FORMATTED_TIME}</div><!-- time tag -->
							<p>
							  	<mos:tmpl name="prime_genre" varScope="event" type="simpleCondition" requiredVars="genre">{GENRE}: </mos:tmpl><a href="{URL}">{TITLE}</a>
							  	<mos:tmpl name="family" varScope="event" type="simpleCondition" requiredVars="family">
									<img src="/templates/skirball_main/images/icon_calendar_family.gif" width="13" height="11" alt="" />
							  	</mos:tmpl>
							</p><!-- title tag/ link-->
						</div>
					</mos:tmpl>
					
				</td>
			</mos:sub>
			
		</mos:tmpl>
	</mos:tmpl>
</tr>
</mos:tmpl>

</table>
</div>


</mos:tmpl>

