<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'HomePage Manager: ' . $this->homepage->name ); ?></legend>

		<table class="admintable">
		<tr>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo JText::_( 'HomePage Title' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area req" type="text" name="name" id="name" size="32" maxlength="250" value="<?php echo $this->homepage->name;?>" />
            </td>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo JText::_( 'Published' ); ?>:
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
<input type="hidden" name="id" value="<?php echo $this->homepage->eoid; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="homepage" />
<input type="hidden" name="oid" id="oid" value="<?php echo $this->homepage->eoid; ?>"/>
</form>
