<?php
/**
 *  $Id$: artist.php, Apr 28, 2008 11:58:07 AM nchanda
 *  Copyright (c) 2008, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
 
?>
<?php defined('_JEXEC') or die('Restricted access'); ?>

<h1><?php echo $this->artist->getFriendlyName(); ?></h1>
<?php if ($this->artist->getTitle()) { ?>
<h2 class="subtitle"><?php echo $this->artist->getTitle() ?></h2>
<?php } ?>

<?php echo $this->artist->getSummary(); ?>
