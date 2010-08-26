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
<div id="program_form" class="c1_form_container">
	<form class="c1_form" name="c1_form" id="c1_form">
		<input type="hidden" name="event_id" value="{$event_id}" />
		<ul>
			<li class="first"><label class="req">Program Title:</label><input id="title" name="title" type="text" class="text" value="{$bean.title}"/></li>
			<li><label>Sub-title:</label><input type="text"  class="text" value="{$bean.subtitle}"/></li>
			<li><label>Published:</label><select id="published" name="published">{html_options values="$bean.published.ids" output="$bean.published.names" selected="$bean.published.selected"}</select></li>
			<li><label class="req">Primary Genre:</label><select id="primaryGenre" name="primaryGenre">{html_options values="$bean.genres.ids" output="$bean.genres.names" selected="$bean.genres.primary"}</select></li>
			<li><label class="req">Default Venue:</label><select id="defaultVenue" name="defaultVenue">{html_options values="$bean.venues.ids" output="$bean.venues.names" selected="$bean.venues.default"}</select></li>
			<li><label>Audio Link:</label><input name="audio" id="audio" type="text" class="text" value="{$bean.subtitle}"/></li>
			<li><label class="req">Opening Date:</label><span class="input_row">{html_select_date prefix="Start" time="$bean.start.time"}</span></li>
			<li><label>Closing Date:</label><span class="input_row">{html_select_date prefix="End" time="$bean.end.time"}</span></li>
			<li><label class="textarea">Date Description:</label><textarea id="dateDescription" name="dateDescription">{$bean.dateDescription}</textarea></li>
			<li><label class="textarea">Pricing Description:</label><textarea id="priceDescription" name="priceDescription">{$bean.priceDescription}</textarea></li>
			<li><label class="textarea req">Summary Description:</label><textarea id="summary" name="summary">{$bean.summary}</textarea></li>
			<li><label class="textarea req">Detailed Description:</label><textarea id="description" name="description">{$bean.description}</textarea></li>
			<li class="separator"><hr></li>
			<li><label>Ticket Link:</label><input id="ticketUrl" value="ticketUrl" type="text" class="text" value="{$bean.ticketUrl}"/></li>
			<li><label class="textarea">Ticket Description:</label><textarea id="ticketDescription" name="ticketDescription">{$bean.ticketDescription}</textarea></li>
		</ul>
	</form>
</div>