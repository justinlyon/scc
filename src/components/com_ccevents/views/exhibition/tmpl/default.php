<?php defined('_JEXEC') or die('Restricted access'); ?>

<div id="body" class="wide">

<div id="title">
	<h1><?php echo $this->heading; ?></h1>
</div>

	<?php if (trim($this->announcement) != '') { ?>
	<div id="overview">
		<?php echo $this->announcement; ?>
	</div>
	<?php } ?>

	<table id="highlights">
		<colgroup>
			<col width="50%" />
			<col width="50%" />
		</colgroup>
		
	<?php 
	for($i=0; $i<count($this->events); $i++) {
		$event = $this->events[$i];
		$thumbnail = '';
		$gallery = $event->getGallery();		
		if ($gallery && $gallery->getImages()) {
			$images = $gallery->getImages();
			$image = $images[0];
			if ($image && $image->getMedium()) {
				$thumbnail = $image->getMedium()->getUrl();
			}
		} 
		
		$link = JRoute::_('index.php?option=com_ccevents&scope=exbt&task=detail&oid='. $event->getOid());
		if ($i%2==0) { ?><tr><?php } ?>
			<td>
				<img src="<?php echo $thumbnail; ?>" alt="<?php echo $event->getTitle(); ?>" width="110" height="110" class="left" />
				<h2><a href="<?php echo $link; ?>"><?php echo $event->getTitle(); ?></a></h2>
				<?php if ($event->getSubtitle()) { ?>
				<h3 class="subtitle"><?php echo $event->getSubtitle(); ?></h3>
				<?php } ?>
				<h3><?php echo $event->getScheduleNote(); ?></h3>
				<p><?php echo $event->getSummary(); ?></p>
			</td>
		<?php if ($i%2==1) { ?></tr><?php } ?>

	<?php } if (count($this->events)%2 != 1) {?></tr><?php } ?>	
	</table>

</div>