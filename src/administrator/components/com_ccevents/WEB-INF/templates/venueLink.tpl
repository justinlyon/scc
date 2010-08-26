{**
 *  $Id: venueLink.tpl 123 2006-06-28 10:42:41Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **}

 <div id="c2_block{$id}" name="c2_block{$id}" class="c2_block">
 		<div class="c2_messages">{$c2_message}</div>
 		<div class="c2_intro">This {$section|lower} will be hosted at the following <strong>venues</strong>:</div>
 		<select name="venues[]" id="venues[]" size="10" multiple>
 			{html_options options=$model.venues_options selected=$model.venues_selected}
 		</select>
 		<div class="c2_buttons"><input type="submit" value="Save Venues"/><input type="button" value="Venue Manager" class="button"/></div>
 		<div class="c2_footer">{$c2_footer}</div>
 </div>