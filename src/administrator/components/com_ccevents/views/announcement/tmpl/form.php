<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Announcement Manager' ); ?></legend>

		<table class="admintable">
		<tr>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo JText::_( 'Scope' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area req" type="text" name="scope" id="scope" size="32" maxlength="250" value="<?php echo $this->announcement->scope;?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="content"><?php echo JText::_( 'Content' ); ?>:</label>
            </td>
            <td>
                <?php
                    $editor =& JFactory::getEditor();
                    echo $editor->display('content', $this->announcement->content, '550', '400', '60', '20', false);
                ?>
            </td>
        </tr>
        <tr>
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
<input type="hidden" name="id" value="<?php echo $this->announcement->eoid; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="announcement" />
</form>
