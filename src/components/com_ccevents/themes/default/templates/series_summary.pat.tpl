<mos:comment>
/**
 *  $Id$: series_summary.pat.tpl, Dec 6, 2006 4:53:48 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>


<mos:tmpl name="series">
<div id="family_key"><!-- use the family_key to place the key on the page -->

<mos:tmpl name="intro">
	<h2><span>{TITLE}</span></h2>
	<mos:tmpl type="simpleCondition" varscope="intro" requiredVars="announcement">
		<p>{ANNOUNCEMENT}</p><br/>
	</mos:tmpl>
</mos:tmpl>

<mos:tmpl type="simpleCondition" requiredVars="description" varscope="series">
	<p>{DESCRIPTION}</p>
</mos:tmpl>

<div class="events">
<mos:tmpl name="program">

<div class="event first"><!-- the first event in each section, or each peage must have the class "event_first" instead of just "event" -->
	<div class="event_media">
		<div class="photo">
			<img src="<mos:var name="IMAGEURL" default="/joomla/components/com_ccevents/themes/default/images/default_exhibition.jpg"/>" 
				width="160" alt="<mos:var name="imagealt" copyFrom="program.TITLE"/>" />
		</div>
		<mos:tmpl name="image_credit" varScope="program" type="simpleCondition" requiredVars="IMAGEGREDIT">
			<p class="caption">Photo courtesy of {IMAGECREDIT}</p>
		</mos:tmpl>
		
		<mos:tmpl name="audio" varScope="program" type="simpleCondition" requiredVars="audioClip">
			<a href="{AUDIOCLIP}" class="listen" target="media">Listen to Sample</a>
		</mos:tmpl>
		<mos:tmpl name="video" varScope="program" type="simpleCondition" requiredVars="videoClip">
			<a href="{VIDEOCLIP}" class="watch" target="media">Watch Video</a>
		</mos:tmpl>
	</div><!-- event_media -->

	<div class="event_info">
		<h4 class="category">{GENRE}</h4>
		<h4 class="program">
			<a href="index.php?option=com_ccevents&scope=prgm&task=detail&oid={OID}">{TITLE}</a>
			<mos:tmpl name="family" varScope="program" type="simpleCondition" requiredVars="family">
				<span class="family"><img src="/templates/skirball_main/images/icon_family.gif" width="17" height="15" alt="" /></span>
			</mos:tmpl>
		</h4>
		<mos:tmpl type="simpleCondition" requiredVars="subtitle" varscope="program">
			<h5 class="subtitle">{SUBTITLE}</h5>
		</mos:tmpl>
		<mos:tmpl type="simpleCondition" requiredVars="series">
			<h4 class="series"><A href="index.php?option=com_ccevents&scope=sers&task=summary&oid={OID}">{SERIES_TITLE}</a></h4>
		</mos:tmpl>
		
		<mos:tmpl varscope="program" type="simpleCondition" requiredVars="time">
			<div class="time">
				<p>{TIME}
					<mos:tmpl type="simpleCondition" varscope="program" requiredVars="status_img">
						{STATUS_IMG}
					</mos:tmpl>
				</p>
			</div>
		</mos:tmpl>

		<p class="info">{SUMMARY} <a href="index.php?option=com_ccevents&scope=prgm&task=detail&oid={OID}">More...</a></p>

        <mos:tmpl name="show_audience" visibility="hidden" whitespace="trim">
           <h6>APPROPRIATE FOR:</h6>
           <p>
              <mos:tmpl name="audience" type="condition" conditionVar="OID" whitespace="trim">
                 <mos:sub condition="__single">
                    {NAME}
                 </mos:sub>
                 <mos:sub condition="__first">
                    {NAME}
                 </mos:sub>
                 <mos:sub condition="__default">
                    ,&nbsp;{NAME}
                 </mos:sub>
              </mos:tmpl>
           </p>
        </mos:tmpl>
		
		<mos:tmpl name="admission" type="simpleCondition" requiredVars="program.PRICING">
			<h6>ADMISSION:</h6>
			<p><mos:var name="pricing" copyFrom="program.PRICING"/></p>
		</mos:tmpl>
		
		<mos:tmpl name="purchase" type="simpleCondition" requiredVars="program.TICKETDESC">
			<h6>PURCHASE TICKETS:</h6>
			<mos:var name="ticket_desc" copyFrom="program.TICKETDESC"/><br/><br/>
		</mos:tmpl>

	</div><!-- event_info -->
</div><!-- event -->
</mos:tmpl>


</div><!-- events -->
</div>

</mos:tmpl>
