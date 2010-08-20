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

require_once(dirname(__FILE__).DS.'helper.php');
AdminPraiseHelper::checkLogin();

require_once('assets/variables'.DS.'variables.php');

// gzip
//ob_start('ob_gzhandler');

//New Head
require_once(dirname(__FILE__).DS.'head.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo  $this->language; ?>" lang="<?php echo  $this->language; ?>" dir="<?php echo  $this->direction; ?>" id="minwidth" >
<head>
<?php if(!$safe){?>
<jdoc:include type="head" />
<?php } else {?>
<?php echo $buffer?>
<?php } ?>
<link href="templates/<?php echo  $this->template ?>/css/template.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="templates/<?php echo  $this->template ?>/css/min-ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?php
require_once('assets/styles'.DS.'styles.php');
?>
</head>
<body id="minwidth-body" class="<?php echo $templateTheme. " " .$option;if ($showSidebar){echo " minwidth";}?>">
<?php if($this->countModules('status') != 0) { ?>
<div id="module-status" class="ap-status <?php if ($bottomStatus){echo "status-bottom";}?>"><jdoc:include type="modules" name="status" /></div>
<?php } ?>
<div class="ap-main">
	<div id="ap-header">
		<div id="ap-topleft" class="dl10">
			<!--begin-->
			<ul>
				<li><a href="<?php echo JURI::root(); ?>" target="_blank"><?php echo JText::_( 'PREVIEW SITE' ); ?></a></li>
			</ul>
			<!--end-->		
		</div>
		<div id="ap-topright" class="ml10 fluid">
			<!--begin-->
			
			<ul>
				<li <?php if ($option =="com_admin" && $task =="help") { echo "class=\"active\"";} ?> class="first"><a href="index.php?option=com_admin&task=help"><?php echo JText::_( 'HELP' ) ;?></a></li>
				<li><?php echo $profilelink; ?></li>
				<li class="last"><a href="index.php?option=com_login&task=logout"><?php echo JText::_( 'LOGOUT' );?> <?php echo $user->username; ?></a></li>
			</ul>
			<!--end-->
		</div>
		<div class="clear"></div>
		<jdoc:include type="module" name="mod_myeditor" />
		<div id="ap-logo">
			<!--begin-->
			<?php
				if(file_exists($logoFile)) { ?>
					<a href="<?php echo $url;?>administrator"><img src="<?php echo $logoFile;?>" /></a>
				<?php } else { ?>
					<a href="<?php echo $url;?>administrator"><?php echo $mainframe->getCfg( 'sitename' ) . " " . JText::_( 'ADMIN' );?> </a>
				<?php }?>
			<!--end-->
		</div>
		<div class="clear"></div>
		<div id="ap-mainmenu" class="mr20 fluid">
			<!--begin-->
			<ul>
				<li <?php if ($option == "com_cpanel" && $ap_task_set != "list_components") { echo "class=\"active\"";}?>><a href="<?php echo $url;?>administrator"><?php echo JText::_( 'DASHBOARD' ); ?></a></li>
				<?php if (($user->get('gid') >= $menusAcl) && $menusAcl != 0) { ?><li <?php if ($option =="com_menus") { echo "class=\"active\""; } ?>><a href="index.php?option=com_menus"><?php echo JText::_( 'MENUS' ); ?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $sectionsAcl) && $sectionsAcl != 0) { ?><li <?php if ($option =="com_sections") { echo "class=\"active\""; } ?>><a href="index.php?option=com_sections&scope=content"><?php echo JText::_( 'SECTIONS' );?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $categoriesAcl) && $categoriesAcl != 0) { ?><li <?php if ($option =="com_categories" && $scope="content") { echo "class=\"active\""; } ?>><a href="index.php?option=com_categories&scope=content"><?php echo JText::_( 'CATEGORIES' );?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $articlesAcl) && $articlesAcl != 0) { ?><li <?php if ($option =="com_content" || $option == "com_sections" && $sectionsAcl == 0 || ($option =="com_categories" && $scope =="content") && $categoriesAcl == 0 || $option =="com_frontpage") { echo "class=\"active\""; } ?>><a href="index.php?option=com_content"><?php echo JText::_( 'ARTICLES' );?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $componentsAcl) && $componentsAcl != 0) { ?><li <?php if ($ap_task =="list_components") { echo "class=\"active\""; } ?>><a href="index.php?ap_task=list_components"><?php echo JText::_( 'COMPONENTS' );?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $modulesAcl) && $modulesAcl != 0) { ?><li <?php if ($option =="com_modules"){ echo "class=\"active\"";}?>><a href="index.php?option=com_modules"><?php echo JText::_( 'MODULES' );?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $pluginsAcl) && $pluginsAcl != 0) { ?><li <?php if ($option =="com_plugins"){ echo "class=\"active\"";}?>><a href="index.php?option=com_plugins"><?php echo JText::_( 'PLUGINS' );?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $installAcl) && $installAcl != 0) { ?><li <?php if ($option =="com_installer"){ echo "class=\"active\"";}?>><a href="index.php?option=com_installer"><?php echo JText::_( 'INSTALLER' );?></a></li><?php } ?>
				<?php
                for($x = 0; $x < 6; $x++)
                {
                    $custom_main_acl  = $this->params->get('custom'.$x.'Acl', 0);
                    $custom_main_name = $this->params->get('custom'.$x.'Name');
                    $custom_main_link = $this->params->get('custom'.$x.'Link');
                    if ($user->get('gid') >= $custom_main_acl && $custom_main_acl != 0) { ?>
                        <li><a href="<?php echo $custom_main_link;?>"><?php echo htmlspecialchars($custom_main_name);?></a></li>
                    <?php }
                }
                ?>
			</ul>
			<!--end-->
		</div>
		<div id="ap-sidemenu" class="dr20">
			<!--begin-->
			<ul>
				<?php if (($user->get('gid') >= $adminAcl) && $adminAcl != 0) { ?><li <?php if ($ap_task =="admin") { echo "class=\"active\"";}?>><a href="index.php?ap_task=admin"><?php echo JText::_( 'ADMIN' );?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $usersAcl) && $usersAcl != 0) {?><li <?php if ($option =="com_users") { echo "class=\"active\""; } ?>><a href="index.php?option=com_users"><?php echo JText::_( 'USERS' );?></a></li><?php } ?>
				<?php if (($user->get('gid') >= $templatesAcl) && $templatesAcl != 0) {?><li <?php if ($option =="com_templates") { echo "class=\"active\""; } ?>><a href="index.php?option=com_templates"><?php echo JText::_( 'TEMPLATES' );?></a></li><?php } ?>
			</ul>
			<!--end-->
		</div>
		<div class="clear"></div>
	</div>
	<div id="ap-submenu">
		<jdoc:include type="module" name="mod_sessionbar" />
		<?php if (!JRequest::getInt('hidemainmenu')) { ?>		
		<jdoc:include type="modules" name="submenu" id="submenu-box" />
		<?php } ?>
		<?php if ($option == "com_content" || $option == "com_sections" || ($option == "com_categories" && $scope =="content") || $option =="com_frontpage"){ ?>
		<ul id="submenu">
			<li><a href="index.php?option=com_sections&scope=content"><?php echo JText::_( 'SECTIONS' );?></a></li>
			<li><a href="index.php?option=com_categories&scope=content"><?php echo JText::_( 'CATEGORIES' );?></a></li>
			<li><a href="index.php?option=com_frontpage"><?php echo JText::_( 'FRONTPAGE' );?></a></li>
		</ul>
		<?php } ?>
		<?php if ($option =="com_menus") { ?>
			<?php require_once('assets/menus'.DS.'menus.php');?>
		<?php } else if ($option =="com_templates") { ?>
		<ul class="submenu">
			<li><a href="index.php?option=com_templates&task=edit&cid[]=aplite&client=1"><?php echo JText::_( 'ADMIN TEMPLATE PARAMS' );?></a></li>
			<li><a href="index.php?option=com_installer&task=manage&type=templates"><?php echo JText::_( 'MANAGE TEMPLATES' );?></a></li>
			<li><a href="index.php?option=com_installer"><?php echo JText::_( 'INSTALL TEMPLATES' );?></a></li>
		</ul>	
		<?php } else if ($option =="com_modules") { ?>
		<ul class="submenu">
			<li><a href="index.php?option=com_installer&task=manage&type=modules"><?php echo JText::_( 'MANAGE MODULES' );?></a></li>
			<li><a href="index.php?option=com_installer"><?php echo JText::_( 'INSTALL MODULES' );?></a></li>
		</ul>	
		<?php } else if ($option =="com_plugins") { ?>
		<ul class="submenu">
			<li><a href="index.php?option=com_installer&task=manage&type=plugins"><?php echo JText::_( 'MANAGE PLUGINS' );?></a></li>
			<li><a href="index.php?option=com_installer"><?php echo JText::_( 'INSTALL PLUGINS' );?></a></li>
		</ul>	
		<?php } else if ($ap_task == "list_components") { ?>
		<ul class="submenu">
			<li><a href="index.php?option=com_installer&task=manage&type=components"><?php echo JText::_( 'MANAGE COMPONENTS' );?></a></li>
			<li><a href="index.php?option=com_installer"><?php echo JText::_( 'INSTALL COMPONENTS' );?></a></li>
		</ul>			
		<?php } else if ($option =="com_users") { ?>
		<ul class="submenu">
			<li><a href="index.php?option=com_users&filter_logged=1"><?php echo JText::_( 'LOGGED IN USERS' );?></a></li>
		</ul>	
		<?php } else if (($ap_task == "admin") && ($user->get('gid') > 24) || ($option =="com_cpanel") && ($ap_task_set !="list_components") && ($user->get('gid') > 24)) { ?>
		<ul class="submenu">
			<li><a href="index.php?option=com_config"><?php echo JText::_( 'GLOBALS' );?></a></li>
			<li><a href="index.php?option=com_admin&task=sysinfo"><?php echo JText::_( 'SYSTEM INFO' );?></a></li>
			<li><a href="index.php?option=com_templates&client=1"><?php echo JText::_( 'ADMIN TEMPLATES' );?></a></li>
			<li><a href="index.php?option=com_templates&task=edit&cid[]=aplite&client=1"><?php echo JText::_( 'ADMIN TEMPLATE PARAMS' );?></a></li>
			<li><a href="index.php?option=com_modules&client=1"><?php echo JText::_( 'ADMIN MODULES' );?></a></li>
			<li><a href="index.php?option=com_checkin"><?php echo JText::_( 'CHECKIN' );?></a></li>
			<li><a href="index.php?option=com_cache"><?php echo JText::_( 'CACHE' );?></a></li>
			<li><a href="index.php?option=com_plugins"><?php echo JText::_( 'PLUGINS' );?></a></li>
			<li><a href="index.php?option=com_installer"><?php echo JText::_( 'INSTALLER' );?></a></li>
		</ul>
		<?php } ?>	

		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div id="ap-mainbody">
		<jdoc:include type="message" />
		<?php if(($task !="edit") && ($task !="add") && ($showSidebar)){ ?>
		<div id="ap-sidebar" class="<?php if($switchSidebar){?>dl20<?php } else { ?>dr20<?php } ?>">
			<!--begin-->
			<?php if($showQuickAdd) { ?>
			<div id="ap-quicklink" class="panel">
				<div id="ap-quickadd">
					<form id="add_form" name="add_form" action="index.php" method="get">
						<select onchange="location 
	= document.add_form.add_select.options [document.add_form.add_select.selectedIndex].value;" name="add_select" id="filter_menutype">
							<option> - <?php echo JText::_( 'QUICK ADD' );?> - </option>
							<option value="index.php?option=com_content&task=add"><?php echo JText::_( 'NEW ARTICLE' );?></option>
							<option value="index.php?option=com_sections&scope=content&task=add"><?php echo JText::_( 'NEW SECTION' );?></option>
							<option value="index.php?option=com_categories&scope=content&task=add"><?php echo JText::_( 'NEW CATEGORY' );?></option>
							<?php if($user->get('gid') > 23){?>
							<option value="index.php?option=com_menus&task=addMenu"><?php echo JText::_( 'NEW MENU' );?></option>
							<option value="index.php?option=com_modules&task=add"><?php echo JText::_( 'NEW MODULE' );?></option>
							<option value="index.php?option=com_users&task=add"><?php echo JText::_( 'NEW USER' );?></option>
							<option value="index.php?option=com_installer"><?php echo JText::_( 'NEW EXTENSION' );?></option>
							<?php } ?>
						</select>
					</form>
				</div>
			</div>
			<?php } ?>
			<?php if($showBreadCrumbs) { ?>
			<div id="ap-crumbs">
			<!--Begin Crumbs-->
			<?php
				require_once('html'.DS.'mod_breadcrumbs'.DS.'mod_breadcrumbs.php');
				breadcrumbs(); 
			?>
			<!--End Crumbs-->
			</div>
			<?php } ?>
			<?php if($showComponentList) { ?>
			<div class="panel">
			<?php if($ap_task != "list_components" && ($user->get('gid') >= $componentsAcl) && $componentsAcl != 0) {?>
			<h3><?php echo JText::_( 'COMPONENTS' );?></h3>
			<?php require_once('assets/components'.DS.'components.php');?>
			<?php } ?>
				<jdoc:include type="modules" name="apside" style="xhtml" />
				<?php if ($option =="com_cpanel" && !$ap_task_set || $option =="com_users"){
				require_once('html/mod_logged'.DS.'mod_logged.php'); ?>
				<?php } else if ($option =="com_content"){?><h3><?php echo JText::_( 'LATEST' );?></h3><jdoc:include type="module" name="mod_latest" /> <h3><?php echo JText::_( 'POPULAR' );?></h3><jdoc:include type="module" name="mod_popular" />
				<?php } ?>		
			</div>
			<?php } ?>
			<!--end-->		
		</div>
		<?php } ?>	
		<div id="ap-content" class="<?php if(($switchSidebar) && ($showSidebar)){?>ml20<?php } else if($showSidebar) { ?>mr20<?php } ?> <?php if($showSidebar){?>fluid<?php } ?>">	
			<div id="ap-content-inner">	
			<div id="ap-title">
				
				<?php
				// Get the component title div
				$title = $mainframe->get('JComponentTitle');
				// Create component title
				if ($ap_task == "list_components"){
				$title = "<div class=\"header\">" . JText::_( 'COMPONENTS' ) . "</div>";
				} else if ($ap_task == "admin"){
				$title = "<div class=\"header\">" . JText::_( 'ADMINISTRATION' ) . "</div>";
				} 
				// Echo title if it exists
				if ($title) {
					echo $title;
				} else {
				  echo "<div class=\"header\">" .$mainframe->getCfg( 'sitename' ). "</div>";
				}
				?>
				<jdoc:include type="modules" name="toolbar" />
				<div class="clear"></div>
			</div>
			<jdoc:include type="modules" name="aptop" />
			<?php if ($option =="com_cpanel" && !$ap_task_set){?>
			<jdoc:include type="modules" name="icon" /><jdoc:include type="modules" name="cpanel" style="xhtml" />
			<?php } else if ($option =="com_cpanel" && !$ap_task_set && $user->get('gid') > 24){?>
			<jdoc:include type="modules" name="apsuperadmin" />
			<?php } else if($ap_task == "list_components" && ($user->get('gid') >= $componentsAcl) && $componentsAcl != 0) {?>
			<?php require_once('assets/components'.DS.'components.php');?>
			<?php } else if($ap_task == "admin") {?>
			<jdoc:include type="modules" name="apadmin" /><jdoc:include type="module" name="mod_menu" />
			<?php } else if ($option !="com_cpanel" && !$ap_task_set){?><jdoc:include type="component" /><?php } ?>
			<jdoc:include type="modules" name="apbottom" />
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div>
	</div>
	<div id="ap-footer" class="ap-padding">
		<jdoc:include type="modules" name="apfooter" />
		<!--begin-->
		<p class="copyright">
		<a target="_blank" href="http://www.joomlapraise.com">Joomla! Templates</a>
		&amp; <a target="_blank" href="http://www.joomlapraise.com">Joomla! Extensions</a>
		by <a target="_blank" href="http://www.joomlapraise.com">JoomlaPraise</a>.
		<br />
		<a target="_blank" href="http://www.joomla.org">Joomla!</a> 
		<?php 
		if(($user->usertype) == "Super Administrator") {
		echo "<span class=\"version\">" . JText::_('Version') . " " . JVERSION . "</span> ";
		}
		echo JText::_('ISFREESOFTWARE');
		?>
		</p>
		<!--end-->
		<div class="clear">&nbsp;</div>
	</div>
</div>
<?php echo $scriptbuffer?>
<script type="text/javascript" src="templates/<?php echo  $this->template ?>/js/aplite.js"></script>
</body>
</html>