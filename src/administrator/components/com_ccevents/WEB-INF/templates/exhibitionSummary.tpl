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

 <form class="summary_form" name="adminForm">
 <table class="summary_container" cellspacing="0">
 	<tr class="titlerow">
 		<th><input type="checkbox"></th>
 		<th class="left">Exhibition Title</th>
 		<th>Published</th>
 		<th>Order</th>
 		<th class="left">Start Date</th>
 		<th class="left">End Date</th>
 		<th>ID</th>
 		<th># Venues</th>
 		<th># Programs</th>
 		<th># Courses</th>
 	</tr>
 	
 	{if count($model.exhibitions) > 0 }
	 	{assign var=events value=$model.exhibitions}
	 	{section name=list loop=$events}
	 	{strip}
	 	<tr class="{cycle values="primerow,altrow"}">
	 		<td><input type="checkbox" /></td>
	 		<td class="left">
	 			<a href="?scope=exbt&task=read&eventId={$events[list].oid}">{$events[list].title}</a>
	 		</td>
	 		<td>
	 			{*$events[list].pubState.value*}
	 			<a href="#" onclick="togglePubState('summary_form',{$events[list].oid},'Published');" >
	 				<img id="pubState_{$events[list].oid}" name="pubState_{$events[list].oid}" 
	 					src="http://demo.joomla.org/administrator/images/publish_g.png" border="0" align="abdmiddle"/>
	 			</a>
	 		</td>
	 		<td><input id="order" name="order" size="2" value="{$events[list].displayOrder}" /></td>
	 		<td class="left">{*$events[list].start_date*}</td>
	 		<td class="left">{*$events[list].end_date*}</td>
	 		<td>{$events[list].oid}</td>
	 		<td>{*$events[list].venue_count*}0</td>
	 		<td>{*$events[list].program_count*}0</td>
	 		<td>{*$events[list].course_count*}0</td>
	 	</tr>
	 	{/strip}
	 	{/section}
	 {else}
	 	<tr>
	 		<td colspan=10" style="text-align:center;font-weight:bold;">
	 			No {$model.scope.title|lower} were found.
	 		</td>
	 	</tr>
	 {/if} 
 </table>
 </form>