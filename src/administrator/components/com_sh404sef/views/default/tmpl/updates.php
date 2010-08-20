<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: updates.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>

<div class="sh404sef-updates"
	id="sh404sef-updates"><!-- start updates panel markup -->

<table class="adminlist">
<?php if(!$this->updates->status) : ?>
	<thead>
		<tr>
			<td width="130">
			   <?php
			     echo '<a href="javascript: void(0);" onclick="javascript: shSetupUpdates(\'forced\');" > ['
			     . Jtext16::_('COM_SH404SEF_CHECK_UPDATES').']</a>';
			 ?>
			</td>
			<td >
        <?php echo JText16::_('COM_SH404SEF_ERROR_CHECKING_NEW_VERSION'); ?>
      </td
		</tr>
	</thead>

	<?php else : ?>
	<thead>
		<tr>
			<td width="130">    
			   <?php echo '<a href="javascript: void(0);" onclick="javascript: shSetupUpdates(\'forced\');" > ['
			   . Jtext16::_('COM_SH404SEF_CHECK_UPDATES').']</a>';
			   ?>
			</td>
			<td >
      <?php echo $this->updates->statusMessage; ?>
      </td>
		</tr>
	</thead>
	<?php if ($this->updates->shouldUpdate) : ?>
	<tr>
	   <td >
	     <?php echo JText16::_( 'COM_SH404SEF_AVAILABLE_VERSION')?>
	   </td>
	   <td>
	   <?php 
	   if (!empty( $this->updates->current)) {
	       echo $this->updates->current . ' [' 
	       . '<a target="_blank" href="' . $this->escape( $this->updates->changelogLink) . '" >'
	       . Jtext16::_('COM_SH404SEF_VIEW_CHANGELOG') 
	       . '</a>]'
	       . '&nbsp['
	       . '<a target="_blank" href="' . $this->escape( $this->updates->downloadLink) . '" >'
         . Jtext16::_('COM_SH404SEF_GET_IT') 
         . '</a>]';
	   }  
	   ?>
     </td>
	</tr>
	<tr>
     <td>
       <?php echo JText16::_( 'COM_SH404SEF_NOTES')?>
     </td>
     <td>
     <?php 
         echo $this->escape($this->updates->note);
     ?>
     </td>
  </tr>
	<?php 
	
	   endif;
	endif; 
	?>
</table

<!-- end updates panel markup --></div>

