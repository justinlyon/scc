<?php /* Smarty version 2.6.20, created on 2010-08-10 19:58:35
         compiled from gallery:modules/core/templates/blocks/ItemLinks.tpl */ ?>
<?php if (! isset ( $this->_tpl_vars['links'] ) && isset ( $this->_tpl_vars['theme']['itemLinks'] )): ?>
<?php $this->assign('links', $this->_tpl_vars['theme']['itemLinks']); ?>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['links'] )): ?>
<?php if (empty ( $this->_tpl_vars['item'] )): ?>
<?php $this->assign('item', $this->_tpl_vars['theme']['item']); ?>
<?php endif; ?>
<?php if (! isset ( $this->_tpl_vars['lowercase'] )): ?>
<?php $this->assign('lowercase', false); ?>
<?php endif; ?>
<?php if (! isset ( $this->_tpl_vars['useDropdown'] )): ?>
<?php $this->assign('useDropdown', true); ?>
<?php endif; ?>
<div class="<?php echo $this->_tpl_vars['class']; ?>
">
<?php if (count ( $this->_tpl_vars['links'] ) > 1 && $this->_tpl_vars['useDropdown']): ?>
<select onchange="var value = this.value; this.options[0].selected = true; eval(value)">
<option value="">
<?php if ($this->_tpl_vars['item']['canContainChildren']): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "&laquo; album actions &raquo;"), $this);?>

<?php else: ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "&laquo; item actions &raquo;"), $this);?>

<?php endif; ?>
</option>
<?php $_from = $this->_tpl_vars['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
<?php echo $this->_reg_objects['g'][0]->itemLink(array('link' => $this->_tpl_vars['link'],'type' => 'option','lowercase' => $this->_tpl_vars['lowercase']), $this);?>

<?php endforeach; endif; unset($_from); ?>
</select>
<?php else: ?>
<?php $_from = $this->_tpl_vars['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
<?php echo $this->_reg_objects['g'][0]->itemLink(array('link' => $this->_tpl_vars['link'],'lowercase' => $this->_tpl_vars['lowercase']), $this);?>

<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</div>
<?php endif; ?>