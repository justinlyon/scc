<?php /* Smarty version 2.6.20, created on 2010-08-10 19:58:35
         compiled from gallery:modules/core/templates/blocks/ItemInfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'gallery:modules/core/templates/blocks/ItemInfo.tpl', 14, false),)), $this); ?>
<div class="<?php echo $this->_tpl_vars['class']; ?>
">
<?php if (! empty ( $this->_tpl_vars['showDate'] )): ?>
<div class="date summary">
<?php ob_start(); ?><?php echo $this->_reg_objects['g'][0]->date(array('timestamp' => $this->_tpl_vars['item']['originationTimestamp']), $this);?>
<?php $this->_smarty_vars['capture']['childTimestamp'] = ob_get_contents(); ob_end_clean(); ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Date: %s",'arg1' => $this->_smarty_vars['capture']['childTimestamp']), $this);?>

</div>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['showOwner'] )): ?>
<div class="owner summary">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Owner: %s",'arg1' => ((is_array($_tmp=@$this->_tpl_vars['item']['owner']['fullName'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['item']['owner']['userName']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['item']['owner']['userName']))), $this);?>

</div>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['showSize'] ) && $this->_tpl_vars['item']['canContainChildren'] && $this->_tpl_vars['item']['childCount'] > 0): ?>
<div class="size summary">
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "Size: %d item",'many' => "Size: %d items",'count' => $this->_tpl_vars['item']['childCount'],'arg1' => $this->_tpl_vars['item']['childCount']), $this);?>

<?php if ($this->_tpl_vars['item']['descendentCount'] > $this->_tpl_vars['item']['childCount']): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "(%d item total)",'many' => "(%d items total)",'count' => $this->_tpl_vars['item']['descendentCount'],'arg1' => $this->_tpl_vars['item']['descendentCount']), $this);?>

<?php endif; ?>
</div>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['showViewCount'] ) && $this->_tpl_vars['item']['viewCount'] > 0): ?>
<div class="viewCount summary">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Views: %d",'arg1' => $this->_tpl_vars['item']['viewCount']), $this);?>

</div>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['showSummaries'] )): ?>
<?php $_from = $this->_tpl_vars['item']['itemSummaries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['summary']):
?>
<div class="summary-<?php echo $this->_tpl_vars['name']; ?>
 summary">
<?php echo $this->_tpl_vars['summary']; ?>

</div>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</div>