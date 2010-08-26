{**
 *  $Id: categoryLink.tpl 123 2006-06-28 10:42:41Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **}

 <div id="c2_block{$id}" name="c2_block{$id}" class="c2_block">
  	<div class="c2_messages">{$bean.tabs[$id].message}</div>
  	<fieldset name="performance" id="performance">
  		<legend>New / Edit Performance</legend>
	 		<input type="hidden" name="event_id" value="{$event_id}" />
	 		<div class="c2_intro">This {$section|lower} is related to the following <strong>genres</strong>:</div>
	 		<select name="program_id" id="program_id" size="5" multiple>
	 			{html_options values=$genres output=$genres selected=$selected_genres}
	 		</select>
	 		<div class="c2_buttons">
	 			<input type="submit" value="Save Genres"/>
	 			<input type="button" value="Genre Manager" class="button"/>
	 		</div>
	 	</form>
	</fieldset>
 	<hr>	
 	<fieldset name="performance_link" id="performance_link">
 		<legend>Current Performances</legend>
		<form name="genre_link_form" id="genre_link_form" class="c2_form">
	 		<input type="hidden" name="event_id" value="{$event_id}" />
	 		<div class="c2_intro">This {$section|lower} is appropriate for the following <strong>audiences</strong>:</div>
	 		<select name="program_id" id="program_id" size="5" multiple>
	 			{html_options values=$audiences output=$audiences selected=$selected_audiences}
	 		</select>
	 		<div class="c2_buttons">
	 			<input type="submit" value="Save Audiences"/>
	 			<input type="button" value="Audience Manager" class="button"/>
	 		</div>
	 		<div class="c2_footer">{$c2_footer}</div>
	</fieldset>	 
 </div>