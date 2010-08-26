{*<!-- 
 *  Id: layoutSunnary.php, Jun 24, 2006 9:01:08 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 * --> *}
 
<html>
{include file="head.tpl"}

<body>

<fieldset>
<legend>{$model.scope.title|capitalize} Summary</legend>
{assign var=file value=$model.scope.c1_file}
{include file=$file }

</fieldset>

</body>
</html>