<?php /* Smarty version 2.6.20, created on 2010-08-10 19:58:35
         compiled from gallery:themes/matrix/templates/theme.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'markup', 'gallery:themes/matrix/templates/theme.tpl', 12, false),array('modifier', 'default', 'gallery:themes/matrix/templates/theme.tpl', 12, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="<?php echo $this->_reg_objects['g'][0]->language(array(), $this);?>
" xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->_reg_objects['g'][0]->head(array(), $this);?>

<?php if (empty ( $this->_tpl_vars['head']['title'] )): ?>
<title><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['theme']['item']['title'])) ? $this->_run_mod_handler('markup', true, $_tmp, 'strip') : smarty_modifier_markup($_tmp, 'strip')))) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['theme']['item']['pathComponent']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['theme']['item']['pathComponent'])); ?>
</title>
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_reg_objects['g'][0]->theme(array('url' => "theme.css"), $this);?>
"/>
</head>
<body class="gallery">
<div <?php echo $this->_reg_objects['g'][0]->mainDivAttributes(array(), $this);?>
>
<?php if ($this->_tpl_vars['theme']['useFullScreen']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:".($this->_tpl_vars['theme']['moduleTemplate']), 'smarty_include_vars' => array('l10Domain' => $this->_tpl_vars['theme']['moduleL10Domain'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php elseif ($this->_tpl_vars['theme']['pageType'] == 'progressbar'): ?>
<div id="gsHeader">
<img src="<?php echo $this->_reg_objects['g'][0]->url(array('href' => "images/galleryLogo_sm.gif"), $this);?>
" width="107" height="48" alt=""/>
</div>
<?php echo $this->_reg_objects['g'][0]->theme(array('include' => "progressbar.tpl"), $this);?>

<?php else: ?>
<div id="gsHeader">
<a href="<?php echo $this->_reg_objects['g'][0]->url(array(), $this);?>
"><img src="<?php echo $this->_reg_objects['g'][0]->url(array('href' => "images/galleryLogo_sm.gif"), $this);?>
"
width="107" height="48" alt=""/></a>
</div>
<div id="gsNavBar" class="gcBorder1">
<div class="gbSystemLinks">
<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.SystemLinks",'order' => "core.SiteAdmin core.YourAccount core.Login core.Logout",'othersAt' => 4), $this);?>

</div>
<div class="gbBreadCrumb">
<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.BreadCrumb"), $this);?>

</div>
</div>
<?php if ($this->_tpl_vars['theme']['pageType'] == 'album'): ?>
<?php echo $this->_reg_objects['g'][0]->theme(array('include' => "album.tpl"), $this);?>

<?php elseif ($this->_tpl_vars['theme']['pageType'] == 'photo'): ?>
<?php echo $this->_reg_objects['g'][0]->theme(array('include' => "photo.tpl"), $this);?>

<?php elseif ($this->_tpl_vars['theme']['pageType'] == 'admin'): ?>
<?php echo $this->_reg_objects['g'][0]->theme(array('include' => "admin.tpl"), $this);?>

<?php elseif ($this->_tpl_vars['theme']['pageType'] == 'module'): ?>
<?php echo $this->_reg_objects['g'][0]->theme(array('include' => "module.tpl"), $this);?>

<?php endif; ?>
<div id="gsFooter">
<?php echo $this->_reg_objects['g'][0]->logoButton(array('type' => 'validation'), $this);?>

<?php echo $this->_reg_objects['g'][0]->logoButton(array('type' => 'gallery2'), $this);?>

<?php echo $this->_reg_objects['g'][0]->logoButton(array('type' => "gallery2-version"), $this);?>

<?php echo $this->_reg_objects['g'][0]->logoButton(array('type' => 'donate'), $this);?>

</div>
<?php endif; ?>  </div>
<?php echo $this->_reg_objects['g'][0]->trailer(array(), $this);?>

<?php echo $this->_reg_objects['g'][0]->debug(array(), $this);?>

</body>
</html>