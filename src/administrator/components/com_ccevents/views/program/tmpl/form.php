<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Program Manager: ' . $this->program->title ); ?></legend>

		<table class="admintable">
		<tr>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo JText::_( 'Program Title' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area req" type="text" name="title" id="title" size="32" maxlength="250" value="<?php echo $this->program->title;?>" />
            </td>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo JText::_( 'Subtitle' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="subtitle" id="subtitle" size="32" maxlength="250" value="<?php echo $this->program->subtitle;?>" />
            </td>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo JText::_( 'Alias' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="250" value="<?php echo $this->program->alias;?>" />
            </td>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo JText::_( 'Alias' ); ?>:
                </label>
            </td>
            <td>
                <select name="pubState">
                    <option value="Published" selected>Published</option>
                    <option value="Unpublished" >Unpublished</option>
                    <option value="Archived" >Archived</option>
                </select>
            </td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_ccevents" />
<input type="hidden" name="id" value="<?php echo $this->program->eoid; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="program" />
<input type="hidden" name="oid" id="oid" value="<?php echo $this->program->eoid; ?>"/>
<input type="hidden" name="scheduleOid" id="scheduleOid" value="<?php echo $this->program->schedule; ?>"/>
<input type="hidden" name="displayOrder" value="<?php echo $this->program->displayOrder; ?>" />
</form>
