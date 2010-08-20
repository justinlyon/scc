<?php 
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view404.php 1478 2010-06-30 10:35:05Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
<form method="post" name="adminForm">

<?php 

  echo $this->loadTemplate( 'filters');

?>

<div id="editcell">
    <table class="adminlist">
      <thead>
        <tr>
          <th class="title" width="3%">
            <?php echo JText::_( 'NUM' ); ?>
          </th>
          <th width="2%">
            <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $this->itemCount; ?>);" />
          </th>
          <th class="title" width="5%" >
            <?php echo JHTML::_('grid.sort', JText16::_( 'COM_SH404SEF_HITS'), 'cpt', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>

          <th class="title" width="30%" style="text-align: left;" >
            <?php echo JHTML::_('grid.sort', JText16::_( 'COM_SH404SEF_SEF_URL'), 'oldurl', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>

        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="4">
            <?php echo $this->pagination->getListFooter(); ?>
          </td>
        </tr>
      </tfoot>
      <tbody>
        <?php
        $k = 0;
        if( $this->itemCount > 0 ) {
          for ($i=0; $i < $this->itemCount; $i++) {
            
            $url = &$this->items[$i]; 
            $checked = JHtml::_( 'grid.id', $i, $url->id); 
            $custom = '&nbsp;'; ?>
            
        <tr class="<?php echo "row$k"; ?>">
          <td align="center" width="3%">
            <?php echo $this->pagination->getRowOffset( $i ); ?>
          </td>
          <td align="center" width="2%">
            <?php echo $checked; ?>
          </td>
          <td align="center" width="5%">
            <?php echo empty($url->cpt) ? '&nbsp;' : $this->escape( $url->cpt); ?>
          </td>

          <td width="30%">
            <?php
              $linkData = array( 'c' => 'editurl', 'task' => 'edit', 'cid[]' => $url->id, 'tmpl' => 'component');
              $urlData = array( 'title' => $url->oldurl, 'class' => 'modalediturl');
              $modalOptions = array( 'size' => array('x' =>700, 'y' => 500));
              echo Sh404sefHelperHtml::makeLink( $this, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');  
              ?>
          </td>

        </tr>
        <?php
        $k = 1 - $k;
      }
    } else {
      ?>
        <tr>
          <td align="center" colspan="4">
            <?php echo JText16::_( 'COM_SH404SEF_NO_URL' ); ?>
          </td>
        </tr>
        <?php
      }
      ?>
      </tbody>
    </table>
    <input type="hidden" name="c" value="urls" />
    <input type="hidden" name="view" value="urls" />
    <input type="hidden" name="layout" value="view404" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->options->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->options->filter_order_Dir; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </div>  
</form>