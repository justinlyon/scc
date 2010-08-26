<mos:comment>
@version 4.5.2
@package HelloWorld
@copyright (C) 2005 Andrew Eddie
@license http://www.gnu.org/copyleft/gpl.html GNU/GPL
</mos:comment>

<mos:tmpl name="layoutDetailsOpen">

<mos:tmpl src="head.tpl" parse="on" />
	
<form action="index2.php" method="post" name="adminForm">
<fieldset>
	<legend>{SCOPE_NAME}:&nbsp;{EXHIBITION.TITLE}</legend>

	<mos:tmpl name="messages" visibility="hidden" >{MESSAGES}</mos:tmpl>
	
	
	<table id="content_container">
	<tr>
		<td id="c1_container" width="50%">
			<mos:tmpl name="exhibition" src="exhibitionForm.tpl" parse="on" />
		</td>
		<td valign="top" width="50%"> 
</mos:tmpl>

<mos:comment>Tabs will render here</mos:comment>

<mos:tmpl name="layoutDetailsClose">
			
		</td>
	</tr>
	</table>

</fieldset>
	
	
	<input type="hidden" name="option" value="{OPTION}" />
	<input type="hidden" name="scope" value="{SCOPE_KEY}" />
	<input type="hidden" name="task" value="" />
	</form>
</mos:tmpl>