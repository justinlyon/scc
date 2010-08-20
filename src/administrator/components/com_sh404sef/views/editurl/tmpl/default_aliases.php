<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_aliases.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
  <table class="adminlist">
  <tbody>
    <tr>
      <td width="80%">
        <textarea class="text_area" name="shAliasList" cols="80" rows="15"><?php echo $this->aliases;?></textarea>
      </td>  
      <td width="20%" style="vertical-align: top;">
        <span ><?php echo JHTML::_('tooltip', JText16::_( 'COM_SH404SEF_TT_ALIAS_LIST')); ?></span>
      </td>
    </tr>
  </tbody>  
  </table>
