<mos:comment>
/**
 *  $Id$: program_detail.pat.tpl, Oct 5, 2006 10:51:29 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="program">

<mos:tmpl name="intro">
	<h2><span><mos:var name="genre" copyFrom="program.genre"/>: Program Details</span></h2>
	<mos:tmpl type="simpleCondition" varscope="intro" requiredVars="announcement">
		<p>{ANNOUNCEMENT}</p><br/>
	</mos:tmpl>
</mos:tmpl>
	
<div class="event">
  <mos:tmpl name="mediacolumn" type="simpleCondition" requiredVars="display">
	<div class="event_media">
	
	<mos:tmpl name="photo" type="simpleCondition" requiredVars="imageurl">
		<div class="photo"><img src="{IMAGEURL}" width="160" height="160" alt="<mos:var name="title" copyFrom="program.title"/>" /></div>
		<mos:tmpl type="simpleCondition" varScope="photo" requiredVars="caption">
			<p class="caption">{CAPTION}</p>
		</mos:tmpl>
		<br />
	</mos:tmpl>
	
	<mos:tmpl name="audio" varScope="program" type="simpleCondition" requiredVars="audioClip">
		<a href="{AUDIOCLIP}" class="listen" target="media">Listen to Sample</a>
	</mos:tmpl>
	<mos:tmpl name="video" varScope="program" type="simpleCondition" requiredVars="videoClip">
		<a href="{VIDEOCLIP}" class="watch" target="media">Watch Video</a>
	</mos:tmpl>
	
	</div><!-- event_media -->
  </mos:tmpl>


	<div class="event_info">
		<h4 class="program">{TITLE}</h4>
		<mos:tmpl type="simpleCondition" requiredVars="subtitle" varscope="program">
			<h5 class="subtitle">{SUBTITLE}</h5>
		</mos:tmpl>
		<mos:tmpl name="series">
			<h4 class="series"><A href="{SERIES_LINK}">{NAME}</a></h4>
		</mos:tmpl>
		<div class="time">
            <mos:tmpl type="simpleCondition" requiredVars="time_display" varscope="program">
                <p>{TIME_DISPLAY}</p>
            </mos:tmpl>
            <mos:tmpl type="simpleCondition" requiredVars="show_dates" varscope="program">
			<mos:tmpl name="performance">
				<p>{TIME} {STATUS_IMAGE}</p>
			</mos:tmpl>
			</mos:tmpl>            
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
		<mos:tmpl type="simpleCondition" varScope="program" requiredvars="pricing">
			<h6>ADMISSION:</h6>
			<p>{PRICING}</p>
		</mos:tmpl>

		<mos:tmpl type="simpleCondition" varscope="program" requiredvars="ticketDesc">
			<h6>PURCHASE TICKETS:</h6>
			{TICKETDESC}
		</mos:tmpl>

		<div id="description">
		{DESCRIPTION}
		</div>

		<mos:tmpl name="exhibition">
			<p><mos:var name="prgm_title" copyFrom="program.TITLE" /> is presented in conjunction with:<br/>
				<mos:tmpl name="exhibit">
					<span><a href="{EXBT_LINK}">{TITLE}</a></span><br/>
				</mos:tmpl>
			</p>
		</mos:tmpl>

		<mos:tmpl name="series_related" type="simpleCondition" requiredvars="title">
			<h6>OTHER PROGRAMS IN THIS SERIES:</h6>
			<ul>
				<mos:tmpl name="related">
					<li><a href="{PRGM_LINK}">{TITLE}</a> (<mos:var name="startTime" modifier="dateformat" format="%B %d, %Y"/>)</li>
				</mos:tmpl>
			</ul>
		</mos:tmpl>

</div><!-- event_info -->
</div><!-- event -->
</mos:tmpl>

