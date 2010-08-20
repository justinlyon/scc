<?php 
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: secstats.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');
// we'll use panes so import Joomla library and instantiate one
jimport( 'joomla.html.pane');
$pane =& JPane::getInstance('Tabs');

function displaySecLine($color, $title, $ItemName, $shSecStats) {
  ?>
<tr>
  <td width="120" bgcolor="<?php echo $color ?>"><?php echo $title; ?></td>
  <td width="120" bgcolor="<?php echo $color ?>"
    style="text-align: center;"><?php echo $shSecStats[$ItemName]; ?></td>
  <td bgcolor="<?php echo $color ?>" style="text-align: right;"><?php 
  echo sprintf('%1.1f',$shSecStats[$ItemName.'Pct']). ' %  |  '.sprintf("%05.1f",$shSecStats[$ItemName.'Hrs']).' '.COM_SH404SEF_TOTAL_PER_HOUR.'&nbsp;';
  ?></td>
</tr>
  <?php
}

?>

<div class="sh404sef-secstats" id="sh404sef-secstats">

<!-- start security stats panel markup -->

    <table border="1" class="adminform">

      <tr>
        <th class="cpanel" colspan="3"><?php echo COM_SH404SEF_SEC_STATS_TITLE.': ';
        if ($this->sefConfig->shSecEnableSecurity) {
          echo $this->shSecStats['curMonth'];
          echo '<a href="javascript: void(0);" onclick="javascript: shSetupSecStats(\'updatesecstats\');" > ['.COM_SH404SEF_SEC_STATS_UPDATE.']</a>';
          echo '<small> ('.$this->shSecStats['lastUpdated'].')</small>';
          echo '<div class=\'sh-ajax-loading\'></div>';
        } else {
          echo COM_SH404SEF_SEC_DEACTIVATED;
        }
        ?></th>
      </tr>
      <tr>
        <td width="240" bgcolor="#EFEFEF"><b><?php echo COM_SH404SEF_TOTAL_ATTACKS; ?></b></td>
        <td width="120" bgcolor="#EFEFEF" style="text-align: center;"><b><?php echo $this->shSecStats['totalAttacks']; ?></b>
        </td>
        <td bgcolor="#EFEFEF" style="text-align: right;"><?php echo sprintf('%5.1f',$this->shSecStats['totalAttacksHrs']).' '.COM_SH404SEF_TOTAL_PER_HOUR.'&nbsp;'?>
        </td>
      </tr>
      <?php
        displaySecLine('#F4F4F4', COM_SH404SEF_TOTAL_CONFIG_VARS,'totalConfigVars', $this->shSecStats);
        displaySecLine('#EFEFEF', COM_SH404SEF_TOTAL_BASE64,'totalBase64', $this->shSecStats);
        displaySecLine('#F4F4F4', COM_SH404SEF_TOTAL_SCRIPTS,'totalScripts', $this->shSecStats);
        displaySecLine('#EFEFEF', COM_SH404SEF_TOTAL_STANDARD_VARS,'totalStandardVars', $this->shSecStats);
        displaySecLine('#F4F4F4', COM_SH404SEF_TOTAL_IMG_TXT_CMD,'totalImgTxtCmd', $this->shSecStats);
        displaySecLine('#EFEFEF', COM_SH404SEF_TOTAL_IP_DENIED,'totalIPDenied', $this->shSecStats);
        displaySecLine('#F4F4F4', COM_SH404SEF_TOTAL_USER_AGENT_DENIED,'totalUserAgentDenied', $this->shSecStats);
        displaySecLine('#EFEFEF', COM_SH404SEF_TOTAL_FLOODING,'totalFlooding', $this->shSecStats);
        displaySecLine('#F4F4F4', COM_SH404SEF_TOTAL_PHP,'totalPHP', $this->shSecStats);
        displaySecLine('#EFEFEF', COM_SH404SEF_TOTAL_PHP_USER_CLICKED,'totalPHPUserClicked', $this->shSecStats);
      ?>
  </table>

<!-- end security stats panel markup -->

</div>

