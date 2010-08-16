<?php /* Smarty version 2.6.20, created on 2010-08-10 19:58:35
         compiled from gallery:modules/core/templates/blocks/SystemLinks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'gallery:modules/core/templates/blocks/SystemLinks.tpl', 5, false),array('modifier', 'default', 'gallery:modules/core/templates/blocks/SystemLinks.tpl', 6, false),array('modifier', 'split', 'gallery:modules/core/templates/blocks/SystemLinks.tpl', 6, false),)), $this); ?>
<?php $this->assign('class', ((is_array($_tmp=$this->_tpl_vars['class'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'SystemLinks', 'SystemLink') : smarty_modifier_replace($_tmp, 'SystemLinks', 'SystemLink'))); ?>
<?php $this->assign('order', ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['order'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")))) ? $this->_run_mod_handler('split', true, $_tmp) : smarty_modifier_split($_tmp))); ?>
<?php $this->assign('othersAt', ((is_array($_tmp=@$this->_tpl_vars['othersAt'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
<?php $this->assign('othersAt', $this->_tpl_vars['othersAt']-1); ?>
<?php $this->assign('separator', ((is_array($_tmp=@$this->_tpl_vars['separator'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, ""))); ?>
<?php ob_start(); ?>
<?php $_from = $this->_tpl_vars['theme']['systemLinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['linkId'] => $this->_tpl_vars['link']):
?>
<?php if (! in_array ( $this->_tpl_vars['linkId'] , $this->_tpl_vars['order'] )): ?>
<span class="<?php echo $this->_tpl_vars['class']; ?>
">
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('params' => $this->_tpl_vars['link']['params']), $this);?>
"><?php echo $this->_tpl_vars['link']['text']; ?>
</a>
</span>
<?php echo $this->_tpl_vars['separator']; ?>

<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $this->_smarty_vars['capture']['SystemLinks'] = ob_get_contents(); ob_end_clean(); ?>
<?php $_from = $this->_tpl_vars['order']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['linkId']):
?>
<?php if ($this->_tpl_vars['index'] == $this->_tpl_vars['othersAt']): ?>
<?php $this->assign('SystemLinksShown', true); ?>
<?php echo $this->_smarty_vars['capture']['SystemLinks']; ?>

<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['theme']['systemLinks'][$this->_tpl_vars['linkId']] )): ?>
<span class="<?php echo $this->_tpl_vars['class']; ?>
">
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('params' => $this->_tpl_vars['theme']['systemLinks'][$this->_tpl_vars['linkId']]['params']), $this);?>
"><?php echo $this->_tpl_vars['theme']['systemLinks'][$this->_tpl_vars['linkId']]['text']; ?>
</a>
</span>
<?php echo $this->_tpl_vars['separator']; ?>

<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php if (! isset ( $this->_tpl_vars['SystemLinksShown'] )): ?><?php echo $this->_smarty_vars['capture']['SystemLinks']; ?>
<?php endif; ?>