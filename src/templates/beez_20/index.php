<?php
/**
 * @version                $Id: index.php 18060 2010-07-08 16:04:59Z dextercowley $
 * @package                Joomla.Site
 * @subpackage        tpl_beez2
 * @copyright        Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license                GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// check modules
$showRightColumn        = ($this->countModules('position-3') or $this->countModules('position-6') or $this->countModules('position-8'));
$showbottom                        = ($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11'));
$showleft                        = ($this->countModules('position-4') or $this->countModules('position-7') or $this->countModules('position-5'));

if ($showRightColumn==0 and $showleft==0) {
        $showno = 0;
}

JHTML::_('behavior.mootools');

// get params
$color                        = $this->params->get('templatecolor');
$logo                        = $this->params->get('logo');
$navposition        = $this->params->get('navposition');
$app                        = JFactory::getApplication();
$templateparams        = $app->getTemplate(true)->params;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
        <head>
                <jdoc:include type="head" />
                <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/beez_20/css/template.css" type="text/css" />
                <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/beez_20/css/position.css" type="text/css" media="screen,projection" />
                <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/beez_20/css/layout.css" type="text/css" media="screen,projection" />
                <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/beez_20/css/print.css" type="text/css" media="Print" />
<?php
        $files = JHtml::_('stylesheet','templates/beez_20/css/general.css',null,false,true);
        if ($files):
                if (!is_array($files)):
                        $files = array($files);
                endif;
                foreach($files as $file):
?>
                <link rel="stylesheet" href="<?php echo $file;?>" type="text/css" />
<?php
                 endforeach;
        endif;
?>
                <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/beez_20/css/<?php echo $color; ?>.css" type="text/css" />
                <?php if ($this->direction == 'rtl') : ?>
                <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/beez_20/css/template_rtl.css" type="text/css" />
                <?php endif; ?>
                <!--[if lte IE 6]>
                <link href="<?php echo $this->baseurl ?>/templates/beez_20/css/ieonly.css" rel="stylesheet" type="text/css" />

                <?php if ($color=="personal") : ?>
                <style type="text/css">
                #line
                {      width:98% ;
                }
                .logoheader
                {
                        height:200px;

                }
                #header ul.menu
                {
                display:block !important;
                      width:98.2% ;


                }
                 </style>
                <?php endif;  ?>
                <![endif]-->
                <!--[if IE 7]>
                        <link href="<?php echo $this->baseurl ?>/templates/beez_20/css/ie7only.css" rel="stylesheet" type="text/css" />
                <![endif]-->
                <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/beez_20/javascript/md_stylechanger.js"></script>
                <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/beez_20/javascript/hide.js"></script>
                <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/beez_20/javascript/html5.js"></script>

                <script type="text/javascript">
                        var big ='<?php echo $this->params->get('wrapperLarge');?>%';
                        var small='<?php echo $this->params->get('wrapperSmall'); ?>%';
                        var altopen='<?php echo JText::_('TPL_BEEZ2_ALTOPEN',true); ?>';
                        var altclose='<?php echo JText::_('TPL_BEEZ2_ALTCLOSE',true); ?>';
                        var bildauf='<?php echo $this->baseurl ?>/templates/beez_20/images/plus.png';
                        var bildzu='<?php echo $this->baseurl ?>/templates/beez_20/images/minus.png';
                        var rightopen='<?php echo JText::_('TPL_BEEZ2_TEXTRIGHTOPEN',true); ?>';
                        var rightclose='<?php echo JText::_('TPL_BEEZ2_TEXTRIGHTCLOSE'); ?>';
                </script>

        </head>

        <body>

<div id="all">
        <div id="back">
                <div id="header">
                                <div class="logoheader">
                                        <h1 id="logo">

                                        <?php if ($logo): ?>
                                        <img src="<?php echo $this->baseurl ?>/<?php echo $logo; ?>"  alt="<?php echo $templateparams->get('sitetitle');?>" />
                                        <?php endif;?>
                                        <?php if (!$logo ): ?>
                                        <?php echo $templateparams->get('sitetitle');?>
                                        <?php endif; ?>
                                        <span class="header1">
                                        <?php echo $templateparams->get('sitedescription');?>
                                        </span></h1>
                                </div><!-- end logoheader -->
                                        <ul class="skiplinks">
                                                <li><a href="#main" class="u2"><?php echo JText::_('TPL_BEEZ2_SKIP_TO_CONTENT'); ?></a></li>
                                                <li><a href="#nav" class="u2"><?php echo JText::_('TPL_BEEZ2_JUMP_TO_NAV'); ?></a></li>
                                            <?php if($showRightColumn ):?>
                                            <li><a href="#additional" class="u2"><?php echo JText::_('TPL_BEEZ2_JUMP_TO_INFO'); ?></a></li>
                                           <?php endif; ?>
                                        </ul>
                                        <h2 class="unseen"><?php echo JText::_('TPL_BEEZ2_NAV_VIEW_SEARCH'); ?></h2>
                                        <h3 class="unseen"><?php echo JText::_('TPL_BEEZ2_NAVIGATION'); ?></h3>
                                        <jdoc:include type="modules" name="position-1" />
                                        <div id="line">
                                        <div id="fontsize">
                                                        <script type="text/javascript">
                                                        //<![CDATA[
                                                        document.write('<h3><?php echo JText::_('TPL_BEEZ2_FONTSIZE'); ?></h3><p class="fontsize">');
                                                        document.write('<a href="index.php" title="<?php echo JText::_('TPL_BEEZ2_INCREASE_SIZE'); ?>" onclick="changeFontSize(2); return false;" class="larger"><?php echo JText::_('TPL_BEEZ2_BIGGER'); ?></a><span class="unseen">&#160;</span>');
                                                        document.write('<a href="index.php" title="<?php echo JText::_('TPL_BEEZ2_REVERT_STYLES_TO_DEFAULT'); ?>" onclick="revertStyles(); return false;" class="reset"><?php echo JText::_('TPL_BEEZ2_RESET'); ?></a> ');
                                                        document.write('<a href="index.php" title="<?php echo JText::_('TPL_BEEZ2_DECREASE_SIZE'); ?>" onclick="changeFontSize(-2); return false;" class="smaller"><?php echo JText::_('TPL_BEEZ2_SMALLER'); ?></a><span class="unseen">&#160;</span></p>');
                                                        //]]>
                                                        </script>
                                        </div>
                                        <h3 class="unseen"><?php echo JText::_('TPL_BEEZ2_SEARCH'); ?></h3>
                                        <jdoc:include type="modules" name="position-0" />
                                        </div> <!-- end line -->


                        </div><!-- end header -->
                        <div id="<?php echo $showRightColumn ? 'contentarea2' : 'contentarea'; ?>">
                                        <div id="breadcrumbs">
                                                <p>
                                                        <?php echo JText::_('TPL_BEEZ2_YOU_ARE_HERE'); ?>
                                                        <jdoc:include type="modules" name="position-2" />
                                                </p>
                                        </div>

                                        <?php if ($navposition=='left' AND $showleft) : ?>


                                                        <div class="left1 <?php if ($showRightColumn==NULL){ echo 'leftbigger';} ?>" id="nav">
                                                   <jdoc:include type="modules" name="position-7" style="beezDivision" headerLevel="3" />
                                                                <jdoc:include type="modules" name="position-4" style="beezHide" headerLevel="3" state="0 " />
                                                                <jdoc:include type="modules" name="position-5" style="beezTabs" headerLevel="2"  id="3" />


                                                        </div><!-- end navi -->
               <?php endif; ?>

                                        <div id="<?php echo $showRightColumn ? 'wrapper' : 'wrapper2'; ?>" <?php if (isset($showno)){echo 'class="shownocolumns"';}?>>

                                                <div id="main">

                                                <?php if ($this->countModules('position-12')): ?>
                                                        <div id="top"><jdoc:include type="modules" name="position-12"   />
                                                        </div>
                                                <?php endif; ?>

                                                <?php if ($this->getBuffer('message')) : ?>
                                                        <div class="error">
                                                                <h2>
                                                                        <?php echo JText::_('JNOTICE'); ?>
                                                                </h2>
                                                                <jdoc:include type="message" />
                                                        </div>
                                                <?php endif; ?>

                                                        <jdoc:include type="component" />

                                                </div><!-- end main -->

                                        </div><!-- end wrapper -->

                                <?php if ($showRightColumn) : ?>
                                        <h2 class="unseen">
                                                <?php echo JText::_('TPL_BEEZ2_ADDITIONAL_INFORMATION'); ?>
                                        </h2>
                                        <div id="close">
                                                <a href="#" onclick="auf('right')">
                                                        <span id="bild">
                                                                <?php echo JText::_('TPL_BEEZ2_TEXTRIGHTCLOSE'); ?></span></a>
                                        </div>


                                        <div id="right">
                                                <a name="additional"></a>
                                                <jdoc:include type="modules" name="position-6" style="beezDivision" headerLevel="3"/>
                                                <jdoc:include type="modules" name="position-8" style="beezDivision" headerLevel="3"  />
                                                <jdoc:include type="modules" name="position-3" style="beezDivision" headerLevel="3"  />
                                        </div><!-- end right -->
                                        <?php endif; ?>

                        <?php if ($navposition=='center' AND $showleft) : ?>

                                        <div class="left <?php if ($showRightColumn==NULL){ echo 'leftbigger';} ?>" id="nav" >

                                                <jdoc:include type="modules" name="position-7"  style="beezDivision" headerLevel="3" />
                                                <jdoc:include type="modules" name="position-4" style="beezHide" headerLevel="3" state="0 " />
                                                <jdoc:include type="modules" name="position-5" style="beezTabs" headerLevel="2"  id="3" />


                                        </div><!-- end navi -->
                   <?php endif; ?>

                                <div class="wrap"></div>

                                </div> <!-- end contentarea -->

                        </div><!-- back -->

                </div><!-- all -->

                <div id="footer-outer">
                        <?php if ($showbottom) : ?>
                        <div id="footer-inner">

                                <div id="bottom">
                                        <div class="box box1"> <jdoc:include type="modules" name="position-9" style="beezDivision" headerlevel="3" /></div>
                                        <div class="box box2"> <jdoc:include type="modules" name="position-10" style="beezDivision" headerlevel="3" /></div>
                                        <div class="box box3"> <jdoc:include type="modules" name="position-11" style="beezDivision" headerlevel="3" /></div>
                                </div>


                                <jdoc:include type="modules" name="debug" />

                        </div>
                                <?php endif ; ?>

                        <div id="footer-sub">


                                <div id="footer">

                                        <jdoc:include type="modules" name="position-14" />
                                        <p>
                                                <?php echo JText::_('TPL_BEEZ2_POWERED_BY');?> <a href="http://www.joomla.org/">Joomla!</a>
                                        </p>


                                </div><!-- end footer -->

                        </div>

                </div>

        </body>
</html>