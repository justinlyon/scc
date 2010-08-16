<?php /* Smarty version 2.6.20, created on 2010-08-10 19:58:35
         compiled from gallery:modules/comment/templates/blocks/ViewComments.tpl */ ?>
<?php if (empty ( $this->_tpl_vars['item'] )): ?> <?php $this->assign('item', $this->_tpl_vars['theme']['item']); ?> <?php endif; ?>
<?php if (empty ( $this->_tpl_vars['show'] )): ?> <?php $this->assign('show', 3); ?> <?php endif; ?>
<?php echo $this->_reg_objects['g'][0]->callback(array('type' => "comment.LoadComments",'itemId' => $this->_tpl_vars['item']['id'],'show' => $this->_tpl_vars['show']), $this);?>

<?php if (! empty ( $this->_tpl_vars['block']['comment']['LoadComments']['comments'] )): ?>
<div class="<?php echo $this->_tpl_vars['class']; ?>
">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Recent comments'), $this);?>
 </h3>
<?php if (sizeof ( $this->_tpl_vars['block']['comment']['LoadComments']['comments'] ) < $this->_tpl_vars['block']['comment']['LoadComments']['totalComments']): ?>
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=comment.ShowComments",'arg2' => "itemId=".($this->_tpl_vars['block']['comment']['LoadComments']['item']['id'])), $this);?>
">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "(view all %d comments)",'arg1' => $this->_tpl_vars['block']['comment']['LoadComments']['totalComments']), $this);?>

</a>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['block']['comment']['LoadComments']['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
<div class="one-comment gcBorder2">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:modules/comment/templates/Comment.tpl", 'smarty_include_vars' => array('user' => $this->_tpl_vars['block']['comment']['LoadComments']['commenters'][$this->_tpl_vars['comment']['commenterId']],'comment' => $this->_tpl_vars['comment'],'can' => $this->_tpl_vars['block']['comment']['LoadComments']['can'],'item' => $this->_tpl_vars['block']['comment']['LoadComments']['item'],'truncate' => 256)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>