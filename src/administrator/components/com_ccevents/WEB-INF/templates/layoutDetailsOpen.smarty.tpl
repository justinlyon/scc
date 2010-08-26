{*<!-- 
 *  Id: layout.base.php, Jun 24, 2006 9:01:08 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 * -. *}
 

{include file="head.tpl" title="$title $section_title"}
<form class="adminForm" name="adminForm" id="adminForm" method="post">
<input type="hidden" name="option" value="com_ccevents" />
<input type="hidden" name="scope" value="exbt" />
<input type="hidden" name="oid" value="{$model.event.oid}" />
<input type="hidden" name="task" value="" />

<fieldset>
<legend>{$model.section|capitalize}:&nbsp;{$model.event.title|capitalize}</legend>

<table id="content_container">
	<tr>
		{assign var=c1_file value=$model.c1_file}
		<td id="c1_container">{include file="$c1_file"}</td>
		<td id="c2_container">
						


