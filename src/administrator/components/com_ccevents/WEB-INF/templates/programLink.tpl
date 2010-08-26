{**
 *  $Id: programLink.tpl 123 2006-06-28 10:42:41Z tevans $
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
 		<div class="c2_intro">This {$section|lower} is related to the following <strong>programs</strong>:</div>
 		<select name="program_id" id="program_id" size="10" multiple>
 			{html_options values=$model.programs.oid output=$model.programs.name selected=$model.event.relatedEvents}
 		</select>
 		<div class="c2_buttons">
 			<input type="submit" value="Save Programs"/>
 			<input type="button" value="Program Manager" class="button"/>
 		</div>
 		 <div class="c2_footer">{$c2_footer}</div>
 </div>