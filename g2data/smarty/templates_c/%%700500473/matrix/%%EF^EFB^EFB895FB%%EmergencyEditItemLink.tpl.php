<?php /* Smarty version 2.6.20, created on 2010-08-10 19:58:35
         compiled from gallery:modules/core/templates/blocks/EmergencyEditItemLink.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'gallery:modules/core/templates/blocks/EmergencyEditItemLink.tpl', 6, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['item'] )): ?> <?php $this->assign('item', $this->_tpl_vars['theme']['item']); ?> <?php endif; ?>
<?php echo $this->_reg_objects['g'][0]->callback(array('type' => "core.ShouldShowEmergencyEditItemLink",'permissions' => ((is_array($_tmp=@$this->_tpl_vars['permissions'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['theme']['permissions']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['theme']['permissions'])),'checkBlocks' => ((is_array($_tmp=@$this->_tpl_vars['checkBlocks'])) ? $this->_run_mod_handler('default', true, $_tmp, null) : smarty_modifier_default($_tmp, null)),'checkSidebarBlocks' => ((is_array($_tmp=@$this->_tpl_vars['checkSidebarBlocks'])) ? $this->_run_mod_handler('default', true, $_tmp, false) : smarty_modifier_default($_tmp, false)),'checkAlbumBlocks' => ((is_array($_tmp=@$this->_tpl_vars['checkAlbumBlocks'])) ? $this->_run_mod_handler('default', true, $_tmp, false) : smarty_modifier_default($_tmp, false)),'checkPhotoBlocks' => ((is_array($_tmp=@$this->_tpl_vars['checkPhotoBlocks'])) ? $this->_run_mod_handler('default', true, $_tmp, false) : smarty_modifier_default($_tmp, false))), $this);?>

<?php if (( $this->_tpl_vars['block']['core']['ShouldShowEmergencyEditItemLink'] )): ?>
<div class="<?php echo $this->_tpl_vars['class']; ?>
">
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.ItemAdmin",'arg2' => "subView=core.ItemEdit",'arg3' => "itemId=".($this->_tpl_vars['item']['id']),'arg4' => "return=true"), $this);?>
"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Edit'), $this);?>
 </a>
</div>
<?php endif; ?>