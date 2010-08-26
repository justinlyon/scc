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
 
<mos:tmpl name="exbt_summary">
	<div class="family_key" id="family_key">
	<mos:tmpl name="intro">
		<h2><span>{VIEW_TYPE} Exhibitions</span></h2>
		<!--<p class="links"><a href="index.php?option=com_ccevents&scope=exbt&task=current">Current Exhibitions</a> | <a href="index.php?option=com_ccevents&scope=exbt&task=upcoming"">Upcoming Exhibitions</a></p>-->
		<mos:tmpl type="simpleCondition" varscope="intro" requiredVars="announcement">
			<p>{ANNOUNCEMENT}</p>
		</mos:tmpl>
	</mos:tmpl>
	
	<div class="exhibitions">
	<mos:tmpl name="exhibition">
		<div class="exhibition <mos:tmpl name="first_exhibition" type="simpleCondition" requiredVars="exhibition.ROW=0">first</mos:tmpl>">
		
			
<div class="exhibition_intro_wrapper"> 
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="exhibition_intro <mos:tmpl name="family_key" type="simpleCondition" requiredVars="exhibition.FAMILY=true">family</mos:tmpl>">
<tr>
<td class="exhibition_media"><div class="photo">
			<img src="<mos:var name="IMAGEURL" default="/joomla/components/com_ccevents/themes/default/images/default_exhibition.jpg"/>" 
				width="200" height="120" alt="<mos:var name="imagealt" copyFrom="exhibition.TITLE"/>" />
	
		
	</div></td> 	
	<td class="exhibition_intro_info"> 	
		<h4 class="program"><a href="index.php?option=com_ccevents&scope=exbt&task=detail&oid={OID}">{TITLE}</a></h4>
		<mos:tmpl type="simpleCondition" requiredVars="subtitle" varscope="exhibition">
			<h5 class="subtitle">{SUBTITLE}</h5>
		</mos:tmpl>
		<div class="time">
			<p>{TIME_DISPLAY}
				<mos:tmpl name="event_status" type="condition" conditionvar="status" varscope="exhibition">
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
		
		
		
</td></tr>
</table> 
		</div><!-- exhibition_intro wrapper-->
		
		
		
		
		
		
		
		
		
		
		
		
		<div class="exhibition_info">
		
		<p class="info">{SUMMARY} <a href="index.php?option=com_ccevents&scope=exbt&task=detail&oid={OID}">More...</a></p>
		
		
		<mos:tmpl name="show_audience" visibility="hidden">
			<h6>APPROPRIATE FOR:</h6>
			<p>
			<mos:tmpl name="audience">
				<span>{NAME}</span>
			</mos:tmpl>
			</p>
		</mos:tmpl>
		
		<mos:tmpl name="admission" type="simpleCondition" requiredVars="exhibition.PRICING">
			<h6>ADMISSION:</h6>
			<p><mos:var name="pricing" copyFrom="exhibition.PRICING"/></p>
		</mos:tmpl>
		
		<mos:tmpl name="purchase" type="simpleCondition" requiredVars="exhibition.TICKETDESC">
			<h6>PURCHASE TICKETS:</h6>
			<mos:var name="ticket_desc" copyFrom="exhibition.TICKETDESC"/><br/><br/>
		</mos:tmpl>
		
		<mos:tmpl name="show_related" visibility="hidden">
			<h6>RELATED PROGRAMS:</h6>
			<ul>
			<mos:tmpl name="related">
				<li><a href="index.php?option=com_ccevents&scope=prgm&task=detail&oid={OID}">{TITLE}</a> {STARTTIME}</li>
			</mos:tmpl>
			</ul>
		</mos:tmpl>

		<mos:tmpl name="photo_credit" type="simpleCondition" requiredVars="exhibition.IMAGECREDIT">
			<p class="caption">Photo courtesy of <mos:var name="credit" copyFrom="exhibition.IMAGECREDIT"/></p>
		</mos:tmpl>
		</div><!-- exhibtion_info -->
		</div><!-- exhibition -->

		
	</mos:tmpl>
	</div>	
	</div>
</mos:tmpl>
