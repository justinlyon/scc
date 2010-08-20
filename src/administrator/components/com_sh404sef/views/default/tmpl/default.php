<?php

/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

  ?>
  
<div id="cpanel">

  <div id="left" class="cp-block">
      <div class="cp-icons-config">
        <fieldset class="adminform">
        <legend><?php echo JText16::_('COM_SH404SEF_CONFIGURATION');?></legend>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_base'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_ext'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_seo'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_sec'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_error_page'); ?>
        </div>
        </fieldset>
      </div>
      
      <div class="cp-icons-others">
        <fieldset class="adminform">
        <legend><?php echo JText16::_('COM_SH404SEF_MANAGEMENT');?></legend>  
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'urlmanager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'aliasesmanager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'pageidmanager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( '404manager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'metamanager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'doc'); ?>
        </div>
        </fieldset>
      </div>
  </div>
  
  <div id="right" class="cp-block">
  
    <div id="right-bottom" class="cp-inner-block">
    
    <?php 
      $pane = &JPane::getInstance('Tabs', array('allowAllClose' => true));
      echo $pane->startPane("content-pane");
      
      echo $pane->startPanel( JText16::_('Quick start'), 'qcontrol' );
      
    ?>
      <div id="qcontrolcontent" class="qcontrol">

      </div>
      
    <?php 
      echo $pane->endPanel();
      
      // security stats
      echo $pane->startPanel( JText16::_('COM_SH404SEF_SEC_STATS_TITLE'), 'security' );
    
     ?>
   
    <div id="secstatscontent" class="secstats">

    </div>
      
    <?php
    echo $pane->endPanel();
    
      $tabTitle = $this->updates->shouldUpdate ? '<b><font color="red">(!) ' . JText16::_('COM_SH404SEF_VERSION_INFO') . '</font></b>' : JText16::_('COM_SH404SEF_VERSION_INFO');
      
      echo $pane->startPanel( $tabTitle, 'infos' );
      
    ?>
    <table class="adminlist">
      <thead>
        <tr>
          <td width="130"><?php echo COM_SH404SEF_INSTALLED_VERS ;?></td>
          <td><?php if (!empty($this->sefConfig)) echo $this->sefConfig->version;
          else echo 'Please review and save configuration first'; ?></td>
        </tr>
      </thead>
      <tr>
        <td><?php echo COM_SH404SEF_COPYRIGHT ;?></td>
        <td><a href="http://dev.anything-digital.com/sh404SEF/">&copy; 2006-<?php echo date('Y');?>
        Yannick Gaultier - Anything Digital</a></td>
      </tr>
      <tr>
        <td><?php echo COM_SH404SEF_LICENSE ;?></td>
        <td><a
          href="http://dev.anything-digital.com/sh404SEF/License-and-Terms.html"
          target="_blank">see License & terms</a></td>
      </tr>
    </table>

    <div id="updatescontent" class="updates">

    </div>
    
      <?php 
      echo $pane->endPanel();
        
      // configuration and global stats
      $output = '';
      foreach ($this->sefConfig->fileAccessStatus as $file => $access) {
        if ($access == COM_SH404SEF_UNWRITEABLE) {
          $output .= '<tr><td>'.$file.'</td><td colspan="2">'.COM_SH404SEF_UNWRITEABLE.'</td></tr>';
        }
      }
      if (!empty($output)) {
        $output =  '<th class="cpanel" colspan="3" >'.COM_SH404SEF_NOACCESS.'</th>' . $output;
      }
      
      // ad red on tab title if something special
      if (!empty($output) || $this->sefConfig->debugToLogFile) {
        $tabTitle = '<b><font color="red">(!) ' . JText16::_('COM_SH404SEF_ACCESS_URLS_STATS') . '</font></b>';
      } else {
        $tabTitle = JText16::_('COM_SH404SEF_ACCESS_URLS_STATS');
      }
      
      echo $pane->startPanel( $tabTitle, 'stats' );
    ?>
    <table class="adminform" width="100%">
      <tr>
      <?php 
        if (!empty($output)) {
          echo $output;
        }
        if ($this->sefConfig->debugToLogFile) {
          echo '<tr><th class="cpanel" colspan="3" >DEBUG to log file : ACTIVATED <small>at '
          .date('Y-m-d H:i:s', $this->sefConfig->debugStartedAt).'</small></th></tr>';
        }
      ?>
      </tr>
    </table> 
     
    <table class="adminform" width="100%">
      <th class="cpanel" colspan="8"> <?php echo JText16::_('COM_SH404SEF_URLS_STATS')?></th>
      <tr>
        <td width="8%"><?php echo COM_SH404SEF_REDIR_TOTAL.':'; ?></td>
        <td align="left" width="12%" style="font-weight: bold"><?php echo $this->sefCount+$this->Count404+$this->customCount; ?>
        </td>
        <td width="8%"><?php echo COM_SH404SEF_REDIR_SEF.':'; ?></td>
        <td align="left" width="12%" style="font-weight: bold"><?php echo $this->sefCount; ?>
        </td>
        <td width="8%"><?php echo COM_SH404SEF_REDIR_404.':'; ?></td>
        <td align="left" width="12%" style="font-weight: bold"><?php echo $this->Count404; ?>
        </td>
        <td width="8%"><?php echo COM_SH404SEF_REDIR_CUSTOM.':'; ?></td>
        <td align="left" width="12%" style="font-weight: bold"><?php echo $this->customCount; ?>
        </td>
      </tr>
    </table>    
    <?php 
    echo $pane->endPanel();
    
    echo $pane->endPane();
    ?>
     
     </div>
  </div>

</div>
