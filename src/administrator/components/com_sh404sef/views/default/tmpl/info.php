<?php

/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: info.php 1478 2010-06-30 10:35:05Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
  
<table class="adminlist">
  <tr>
    <td><?php include( JPATH_ROOT . '/administrator/components/com_sh404sef/readme.inc.php' ); ?>
    </td>
  </tr>
</table>

<form method="post" name="adminForm" >
    <input type="hidden" name="c" value="default" />
    <input type="hidden" name="view" value="default" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="" />
</form>
  
