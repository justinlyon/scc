<?php defined('_JEXEC') or die('Restricted access'); ?>

<div id="body">
	
	<div id="title">
		<h1><?php echo $this->heading; ?></h1>
	</div>

	<?php if ($this->announcement) { ?>
	<div id="overview">
		<?php echo $this->announcement; ?>
	</div>
	<?php } ?>
		
	<table id="highlights">
		<caption>
			Highlights
		</caption>
		<?php 
			$index = 0;
			$max = 6; // only show 6 events 
			foreach($this->events as $event) {
				if ($index < $max) {
					$detail = JRoute::_('index.php?option=com_ccevents&scope=prgm&task=detail&fid='. $event->getPrimaryGenre()->getOid() .'&oid='. $event->getOid());
					$category = JRoute::_('index.php?option=com_ccevents&scope=prgm&task=summary&filter=Genre&fid='. $event->getPrimaryGenre()->getOid());
					if ($index%2==0) { echo "<tr>\n"; }?>
				<td>
					<?php 
						$images = $event->getGallery()->getImages();
						$img = $images[0];
						$imgurl = ($img && $img->getSmall()) ? $img->getSmall()->getUrl() : ''; 
						if ($imgurl) {
					?>
					<img src="<?php echo $imgurl; ?>" alt="<?php echo $event->getTitle(); ?>" width="75" height="75" />
					<?php } ?>
					<h4><?php echo strtoupper($event->getPrimaryGenre()->getName()); ?></h4>
					<h2><a href="<?php echo $detail; ?>"><?php echo $event->getTitle(); ?></a></h2>
					<h3 class="date"><?php echo $event->getDisplayDate(); ?></h3>
					<p><a href="<?php echo $category; ?>" class="more_alt">Browse all <?php echo $event->getPrimaryGenre()->getName(); ?>  programs</a></p>
				</td>
				<?php if ($index%2==0) { 
						echo "<td class='gutter'>&nbsp;</td>\n"; 
					  } else {
					  	echo "</tr>\n";
					  }
				  $index++;
				} else {
					break;
				}
			}
			?>
	</table>

</div>