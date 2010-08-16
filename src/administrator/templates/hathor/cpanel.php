<?php
/**
 * @version		$Id: cpanel.php 17856 2010-06-23 17:48:24Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	templates.hathor
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

// no direct access
defined('_JEXEC') or die;
$app	= JFactory::getApplication();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo  $this->language; ?>" lang="<?php echo  $this->language; ?>" dir="<?php echo  $this->direction; ?>">
<head>
<jdoc:include type="head" />

<!-- Load system style CSS -->
<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />

<!-- Load Template CSS -->
<link href="templates/<?php echo  $this->template ?>/css/template.css" rel="stylesheet" type="text/css" />

<!-- Load CSS for Alternate Menu or Standard Accessible Menu -->
<?php if ($this->params->get('altMenu')) : ?>
	<link href="templates/<?php echo  $this->template ?>/css/menu2.css" rel="stylesheet" type="text/css" />
<?php else : ?>
	<link href="templates/<?php echo  $this->template ?>/css/menu.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

<!-- Load additional CSS styles for rtl sites -->
<?php if ($this->direction == 'rtl') : ?>
	<link href="templates/<?php echo  $this->template ?>/css/template_rtl.css" rel="stylesheet" type="text/css" />

	<!-- Load additional CSS for Alternate Menu or Standard Accessible Menu for rtl sites-->
	<?php if ($this->params->get('altMenu')) : ?>
		<link href="templates/<?php echo  $this->template ?>/css/menu2_rtl.css" rel="stylesheet" type="text/css" />
	<?php else : ?>
		<link href="templates/<?php echo  $this->template ?>/css/menu_rtl.css" rel="stylesheet" type="text/css" />
	<?php endif; ?>
<?php endif; ?>

<!-- Load additional CSS styles for High Contrast colors -->
<?php if ($this->params->get('highContrast')) : ?>
	<link href="templates/<?php echo $this->template ?>/css/highcontrast.css" rel="stylesheet" type="text/css" />
	<link href="templates/<?php echo $this->template ?>/css/menu_hc.css" rel="stylesheet" type="text/css" />
<?php  endif; ?>

<!-- Load additional CSS styles for bold Text -->
<?php if ($this->params->get('boldText')) : ?>
	<link href="templates/<?php echo $this->template ?>/css/boldtext.css" rel="stylesheet" type="text/css" />
<?php  endif; ?>

<!-- Load additional CSS styles for Internet Explorer -->
<!--[if IE 7]>
	<link href="templates/<?php echo  $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if lte IE 6]>
	<link href="templates/<?php echo  $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!-- Load JavaScript for Alternate Menu or standard Accessible Administrator Menu -->
<?php if ($this->params->get('altMenu')) : ?>
	<script type="text/javascript" src="templates/<?php  echo  $this->template  ?>/js/menu2.js"></script>
<?php else : ?>
	<script type="text/javascript" src="templates/<?php  echo  $this->template  ?>/js/menu.js"></script>
<?php endif; ?>

<!-- Load Template JavaScript -->
<script type="text/javascript" src="templates/<?php  echo  $this->template  ?>/js/template.js"></script>

</head>
<body id="minwidth">
<div id="containerwrap">

	<!-- Header Logo -->
	<div id="header">

		<!-- Site Title and Skip to Content -->
		<div class="title-ua">
			<h1 class="title"><?php echo $this->params->get('showSiteName') ? $app->getCfg('sitename') . " " . JText::_('JADMINISTRATION') : JText::_('JADMINISTRATION'); ?></h1>
			<div id="skiplinkholder"><p><a id="skiplink" href="#skiptarget"><?php echo JText::_('TPL_HATHOR_SKIP_TO_MAIN_CONTENT'); ?></a></p></div>
      	</div>

	</div><!-- end header -->

	<!-- Main Menu Navigation -->
	<div id="nav">
		<div id="module-menu">
			<h2 class="element-invisible"><?php echo JText::_('TPL_HATHOR_MAIN_MENU'); ?></h2>
			<jdoc:include type="modules" name="menu" />
		</div>
		<div class="clr"></div>
	</div><!-- end nav -->

	<!-- Status Module -->
	<div id="module-status">
		<jdoc:include type="modules" name="status"  />
	</div>

	<!-- Content Area -->
	<div id="content">

		<!-- Component Title -->
		<jdoc:include type="modules" name="title" />

		<!-- System Messages -->
		<jdoc:include type="message" />
		<!-- Sub Menu Navigation -->
		<div id="no-submenu"></div>
   		<div class="clr"></div>

		<!-- Beginning of Actual Content -->
		<div id="element-box" class="cpanel">
			<p id="skiptargetholder"><a id="skiptarget" name="skiptarget" class="skip" tabindex="-1"></a></p>

				<div class="adminform">

					<!-- Display the Quick Icon Shortcuts -->
					<div class="cpanel-icons">
						<jdoc:include type="modules" name="icon" />
					</div>

					<!-- Display Admin Information Panels -->
					<div class="cpanel-component">
						<jdoc:include type="component" />
					</div>

				</div>
				<div class="clr"></div>

		</div><!-- end element-box -->

		<noscript>
			<?php echo  JText::_('JGLOBAL_WARNJAVASCRIPT') ?>
		</noscript>
		<div class="clr"></div>

	</div><!-- end content -->
		<div class="clr"></div>
	</div><!-- end containerwrap -->

	<!-- Footer -->
	<div id="footer">
		<p class="copyright">
			<?php $joomla= '<a href="http://www.joomla.org">Joomla!</a>';
			echo JText::sprintf('JGLOBAL_ISFREESOFTWARE', $joomla) ?>
			<span class="version"><?php echo  JText::_('JVERSION') ?> <?php echo  JVERSION; ?></span>
		</p>
	</div>
</body>
</html>
