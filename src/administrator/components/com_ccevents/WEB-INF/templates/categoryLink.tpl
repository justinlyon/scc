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
  	<div class="c2_messages">{$c2_message}</div>
 		<div class="c2_intro">This {$section|lower} is related to the following <strong>genres</strong>:</div>
 		<select name="program_id" id="program_id" size="5" multiple>
 			{html_options options=$model.genres_options selected=$model.genres_selected}
 		</select>
 		<hr>	
 		<div class="c2_intro">This {$section|lower} is appropriate for the following <strong>audiences</strong>:</div>
 		<select name="program_id" id="program_id" size="5" multiple>
 			{html_options options=$model.audiences_options selected=$model.audiences_selected}
 		</select>
 		<div class="c2_buttons">
 			<input type="submit" value="Save Categories"/>
 			<input type="button" value="Genre Manager" class="button" 
 				onclick="setScope('category_link_form','cat');
 						 setTask('category_link_form','manageGenres');
 						 form.submit();"/>
 			<input type="button" value="Audience Manager" class="button" 
 				onclick="setScope('category_link_form','cat');
 						 setTask('category_link_form','manageAudiences');
 						 form.submit();"/>
 		</div>
 		<div class="c2_footer">{$c2_footer}</div>
 </div>