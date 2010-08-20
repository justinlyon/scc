<?php
/**
 * @copyright	Copyright (C) 2009 JoomlaPraise. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//Template Params
$templateTheme    = $this->params->get('templateTheme');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />

<link href="templates/<?php echo  $this->template ?>/css/template.css" rel="stylesheet" type="text/css" />
 <!--[if IE]>
 <link href="templates/<?php echo  $this->template ?>/css/min-ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/aplite.js"></script>
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.login.username.select();
		document.login.username.focus();
	}
    apSetLoginCookie();
</script>

<?php
require_once('assets/variables'.DS.'login.php');
require_once('assets/styles'.DS.'login.php');
?>
</head>
<body id="login" onload="javascript:setFocus()" class="<?php echo $templateTheme;?>">
<div id="ap-login">
	<div id="content-box">
		<div class="padding">
			<h3><?php echo $mainframe->getCfg( 'sitename' ); ?> <?php echo JText::_('Admin Login') ?></h3>			
			<div id="element-box" class="login">
				<div>
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<p class="login-desc"><?php echo JText::_('DESCUSEVALIDLOGIN') ?></p>
					<p class="home-page">
						<a href="<?php echo JURI::root(); ?>"><?php echo JText::_('Return to site Home Page') ?></a>
					</p>
					<div id="lock"></div>
					<div class="clear"></div>
				</div>
			</div>
			<noscript>
				<?php echo JText::_('WARNJAVASCRIPT') ?>
			</noscript>
			<div class="clr"></div>
		</div>
	</div>
</div>
	<div id="ap-footer" class="ap-padding">
		<!--begin-->
		<p class="copyright">
		<a target="_blank" href="http://www.joomlapraise.com">Joomla! Templates</a>
		&amp; <a target="_blank" href="http://www.joomlapraise.com">Joomla! Extensions</a>
		by <a target="_blank" href="http://www.joomlapraise.com">JoomlaPraise</a>.
		<br />
		<a target="_blank" href="http://www.joomla.org">Joomla!</a> 
		<?php echo  JText::_('ISFREESOFTWARE') ?>	</p>
		<!--end-->
		<div class="clear">&nbsp;</div>
	</div>
</body>
</html>
