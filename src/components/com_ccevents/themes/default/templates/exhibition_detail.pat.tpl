<mos:comment>
/**
 *  $Id$: exhibition_detail.pat.tpl, Oct 5, 2006 10:51:29 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="exbt_detail">

<h2><span>Exhibition Details</span></h2>

<div class="event">
	<mos:tmpl name="photo" type="simpleCondition" requiredVars="imageurl">
   	<div class="event_media">
		<div class="photo"><img src="{IMAGEURL}" width="160" height="160" alt="<mos:var name="title" copyFrom="program.title"/>" /></div>
		<mos:tmpl type="simpleCondition" varScope="photo" requiredVars="caption">
			<p class="caption">{CAPTION}</p>
		</mos:tmpl>
		<br />
    </div><!-- event_media -->
	</mos:tmpl>
	
	<div class="event_info">
		<h4 class="program">{TITLE}</h4>
		<mos:tmpl type="simpleCondition" requiredVars="subtitle" varscope="exbt_detail">
			<h5 class="subtitle">{SUBTITLE}</h5>
		</mos:tmpl>
		<div class="time">
			<p>{TIME_DISPLAY} 
			   <mos:tmpl name="event_status" type="condition" conditionvar="status" varscope="exbt_detail">
			       <mos:sub condition="Cancelled">
			       	  <img src="/joomla/components/com_ccevents/themes/default/images/button_cancelled.gif" width="69" align="absmiddle" height="16" alt="Cancelled" />
			       </mos:sub>
			       <mos:sub condition="Sold Out">
			          <img src="/joomla/components/com_ccevents/themes/default/images/button_soldout.gif" width="69" align="absmiddle" height="16" alt="Sold Out" />
			       </mos:sub>
			       <mos:sub condition="__default">
			       	  <mos:tmpl name="ticket_link" type="simpleCondition" requiredVars="TICKETURL">
			     		<a href="<mos:var name="ticket_link" copyFrom="TICKETURL"/>" class="tickets" target="_blank"><img src="/joomla/components/com_ccevents/themes/default/images/button_tickets.gif" width="69" align="absmiddle" height="16" alt="Tickets" /></a>
			          </mos:tmpl>
			       </mos:sub>
			   </mos:tmpl>
			</p>
		</div>
		<p class="location">
			<mos:tmpl name="venues" type="condition" conditionVar="OID">
				<mos:sub condition="__single">
					{VENUE_LINK}
				</mos:sub>
				<mos:sub condition="__first">
					{VENUE_LINK}
				</mos:sub>
				<mos:sub condition="__default">
					|&nbsp;{VENUE_LINK}
				</mos:sub>
			</mos:tmpl>
		</p>

		
		<mos:tmpl type="simpleCondition" varScope="exbt_detail" requiredvars="audience">
			<h6>APPROPRIATE FOR:</h6>
			<p>{AUDIENCE}</p>
		</mos:tmpl>

		<mos:tmpl type="simpleCondition" varScope="exbt_detail" requiredvars="pricing">
			<h6>ADMISSION:</h6>
			<p>{PRICING}</p>
		</mos:tmpl>

		<mos:tmpl type="simpleCondition" varscope="exbt_detail" requiredvars="ticketDesc">
			<h6>PURCHASE TICKETS:</h6>
			<ul>
			<li>Click the TICKETS button to purchase on TicketWeb</li>
			<li>Call TicketWeb at (866) 468-3399</li>
			<li>At the Skirball Admissions Desk</li>
			</ul>
		</mos:tmpl>

		<div id="description">
		{DESCRIPTION}
		</div>

		
		<mos:tmpl name="show_related" visibility="hidden">
			<h6>RELATED PROGRAMS:</h6>
			<ul>
			<mos:tmpl name="related">
				<li><a href="index.php?option=com_ccevents&scope=prgm&task=detail&oid={OID}">{TITLE}</a> {STARTTIME}</li>
			</mos:tmpl>
			</ul>
		</mos:tmpl>


</div><!-- event_info -->
</div><!-- event -->
</mos:tmpl>
