{*<!-- 
 *  Id: layout.base.php, Jun 24, 2006 9:01:08 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 * --> *}
 

{include file="head.tpl" title="$title $section_title"}

<fieldset>
<legend>{$model.section|capitalize}:&nbsp;{$model.event.title|capitalize}</legend>

<table id="content_container">
	<tr>
		{assign var=c1_file value=$model.c1_file}
		<td id="c1_container">{include file="$c1_file"}</td>
		<td id="c2_container">
			<div id="c2_tabs">
				<ul>
				{section name="tabs" loop=$model.tabs}
				{assign var=idx value=$smarty.section.tabs.index}
					<li id="tab{$smarty.section.tabs.index}"><a href="#" 
							onclick="focusBlock({$smarty.section.tabs.index}, count);"
							>{$model.tabs[$idx].title}</a>
					</li>
					{if $model.tabs[$idx].title|lower eq $model.selected_tab|lower}
						{assign var="focusBlock" value=$idx}
					{/if}					
				{/section}
				</ul>
			</div>
			{section name="blocks" loop=$model.tabs}
				{assign var=idx value=$smarty.section.blocks.index}
				{assign var=file value=$model.tabs[$idx].file }
				{include file="$file" id="$idx"}
			{/section}
			
			<div id="c2_block3" name="c2_block3" class="c2_block">block 3</div>

			<script> 
				var count = {$smarty.section.tabs.loop};
				var focused = {$focusBlock|default:"0"};
				focusBlock(focused, count); 
			</script>
		</td>
	</tr>
</table>

</fieldset>
