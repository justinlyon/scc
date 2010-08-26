<mos:comment>
/**
 *  $Id$: homepage_events.pat.tpl, Dec 5, 2006 9:30:07 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="homepage">

<mos:tmpl name="intro">
	<h2><span>{TITLE}</span></h2>
	<mos:tmpl type="simpleCondition" varscope="intro" requiredVars="announcement">
		<p>{ANNOUNCEMENT}</p><br/>
	</mos:tmpl>
</mos:tmpl>


<div class="events">

<mos:tmpl name="event">
	<div class="event">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td class="event_media"><div class="photo"><img src="{IMG_SRC}" width="160" height="95" alt="{IMG_ALT}" /></div></td>
				<td class="event_info">
					<h4 class="category">{GENRE}</h4>
					<h4 class="program"><a href="{EVENT_LINK}">{TITLE}</a></h4>
					<mos:tmpl varscope="event" type="simpleCondition" requiredVars="time">
						<div class="time">
							<p>{TIME}
								<mos:tmpl type="simpleCondition" varscope="event" requiredVars="status_img">
								{STATUS_IMG}
								</mos:tmpl>
							</p>
						</div>
					</mos:tmpl>
				</td>
			</tr>
		</table>
	</div>
</mos:tmpl>

</div> <!-- events -->
</mos:tmpl>
