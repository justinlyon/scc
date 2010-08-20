<?php 
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: qcontrol.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');
// we'll use panes so import Joomla library and instantiate one
jimport( 'joomla.html.pane');
$pane =& JPane::getInstance('Tabs');

?>

<div class="sh404sef-qcontrol" id="sh404sef-qcontrol">

  <dl id="system-message">
  <dt class="error"></dt>
  <dd class="error message fade">
    <div id="sh-error-box">
  <?php if (!empty( $this->errors)) : ?>
      <div id="error-box-content">
        <ul>
        <?php 
          foreach ($this->errors as $error) : 
            echo '<li>' . $error . '</li>';
          endforeach;
        ?>    
        </ul>
      </div>  
    <?php endif; ?>
    </div>
  </dd>
  </dl>

  <dl id="system-message">
  <dt class="message"></dt>
  <dd class="message message fade">
  <div id="sh-message-box">
  <?php if (!empty( $this->message)) : ?>
    <ul>
      <li><div id="message-box-content"><?php if (!empty( $this->message)) echo $this->message; ?></div></li>
    </ul>
    <?php endif; ?>
    </div>
  </dd>
  </dl>
  
<!-- start quick control panel markup -->

<form action="index.php" method="post" name="adminForm" id="adminForm">

  <div id="qcontrol-editcell"><!-- start of configuration html -->
<table class="qcontrol">
<tr>
<td>
<table class="adminlist">
  <thead>
	<tr>
		<td width="250" colspan="2" ><?php echo JText16::_('COM_SH404SEF_SEF_ENABLED'); ?></td>
	</tr>
	</thead>
	<tr>	
		<td width="150">
		<input type="radio" name="Enabled" id="Enabled0" value="0" <?php echo $this->sefConfig->Enabled ? '' : 'checked="checked"'; ?> class="inputbox" size="2" /> 
		  <label for="Enabled0">No</label>

		<input type="radio" name="Enabled" id="Enabled1" value="1" <?php echo !$this->sefConfig->Enabled ? '' : 'checked="checked"'; ?> class="inputbox" size="2" /> 
		<label for="Enabled1">Yes</label>
		</td>
		<td><?php echo JHTML::_('tooltip', JText16::_('COM_SH404SEF_TT_SEF_ENABLED'), JText16::_('COM_SH404SEF_SEF_ENABLED') ); ?></td>
	</tr>
	
	<thead>
	<tr>
		<td width="250" colspan="2"><?php echo JText16::_('COM_SH404SEF_SELECT_REWRITE_MODE'); ?></td>
	</tr>
	</thead>
	<tr>	
		<td width="150">
		  <select name="shRewriteMode" id="shRewriteMode"	class="inputbox" size="1">
			   <option value="0" <?php echo $this->sefConfig->shRewriteMode == 0 ? 'selected="selected"' : ''; ?> >with .htaccess (mod_rewrite)</option>
			   <option value="1" <?php echo $this->sefConfig->shRewriteMode == 1 ? 'selected="selected"' : ''; ?> >without .htaccess (index.php)</option>
			   <option value="2" <?php echo $this->sefConfig->shRewriteMode == 2 ? 'selected="selected"' : ''; ?> >without .htaccess (index.php?)</option>
		</select>
		</td>
		<td><?php echo JHTML::_('tooltip', JText16::_('COM_SH404SEF_TT_SELECT_REWRITE_MODE'), JText16::_('COM_SH404SEF_SELECT_REWRITE_MODE') ); ?></td>
  </tr>  

  <thead>
		<tr>
			<td width="250" colspan="2"><?php echo JText16::_('COM_SH404SEF_ACTIVATE_SECURITY'); ?></td>
		</tr>
	</thead>	
		<tr>	
			<td width="150">
			  <input type="radio" name="shSecEnableSecurity" id="shSecEnableSecurity0" value="0" 
			  <?php echo $this->sefConfig->shSecEnableSecurity ? '' : 'checked="checked"'; ?> class="inputbox" size="2" /> 
			  <label for="shSecEnableSecurity0">No</label>
			  <input type="radio" name="shSecEnableSecurity"	id="shSecEnableSecurity1" value="1" 
			  <?php echo !$this->sefConfig->shSecEnableSecurity ? '' : 'checked="checked"'; ?> class="inputbox" size="2" /> 
			  <label for="shSecEnableSecurity1">Yes</label>
			</td>
			<td><?php echo JHTML::_('tooltip', JText16::_('COM_SH404SEF_TT_ACTIVATE_SECURITY'), JText16::_('COM_SH404SEF_ACTIVATE_SECURITY') ); ?></td>
		</tr>
  <tr>
    <td class="qbutton" colspan="2">
       <a href="javascript: void(0);" onclick="shSubmitQuickControl(event)" ><span class="icon-48-save" title="Save"></span>Go!</a>
    </td>
  </tr>
</table>
</td>
<td style="padding: 5px;text-align: justify;">
    <?php echo JText16::_('COM_SH404SEF_QCONTROL'); ?>
</td>
</tr>
</table>

<!-- start quick control panel markup -->

    <input type="hidden" name="c" value="config" />
    <input type="hidden" name="view" value="config" />
    <input type="hidden" name="layout" value="qcontrol" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="tmpl" value="component" />
    <input type="hidden" name="format" value="raw" />
    
    <?php echo JHTML::_( 'form.token' ); ?>
  </div>  
</form>

</div>

