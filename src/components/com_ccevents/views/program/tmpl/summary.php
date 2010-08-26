<div id="body">
	
	<?php 
		$date_css = '';
		$title_css = '';
		$age_css = '';
		switch ($this->sort_current) {
			case 'date' : $date_css = " class='current'"; break;
			case 'title' : $title_css = " class='current'"; break;
			case 'age' : $age_css = " class='current'"; break;
		}
	?>
	<div id="title">
		<h1><?php echo $this->heading; ?></h1>
		<p><span>Sort By:</span> <a href="<?php echo $this->sort_date; ?>" title="sort by date" <?php echo $date_css; ?>>Date</a> | 
		<a href="<?php echo $this->sort_title; ?>" title="sort alphabetically" <?php echo $title_css; ?>>Alphabetical</a> | 
		<a href="<?php echo $this->sort_age; ?>" title="sort by appropriate age" <?php echo $age_css; ?>>Appropriate Age</a></p>
	</div>
	
	<?php if ($this->overview) { ?>
	<div>
		<?php echo $this->overview; ?>
	</div>
	<?php } ?>
			
	<table class="listing">
		<?php foreach($this->events as $event) { 
			$details = JRoute::_("index.php?option=com_ccevents&scope=prgm&task=detail&fid=". $_REQUEST['fid'] ."&oid=". $event->getOid() );	
			$categories = $event->getCategories();
			$audience = (isset($categories['Audience'])) ? $categories['Audience'] : null;
		?>
		<tr>
			<td><?php if ($event->getGallery()) { 
					$images = $event->getGallery()->getImages();
					$image = $images[0];
					$imageurl = ($image->getMedium()) ? $image->getMedium()->getUrl() : '';
				?>
				<img src="<?php echo $imageurl; ?>" alt="<?php echo $event->getTitle(); ?>" width="160" height="110" /></td>
			<?php }?>
			<td class="date">x
			<?php
				if($event->getScheduleNote())	{
					echo $event->getScheduleNote();
				}	else	{ 
					foreach ($event->getChildren() as $date) { 
						$status = "";
						if ($date['status'] == 'Active' && isset($date['code']) && trim($date['code']) != '') {
							$link = $date['code'];
							$status = "<a href='". $link ."' target='_blank' class='tickets'>Buy Tickets</a>";	
						} elseif ($date['status'] == 'Sold Out' ) {
							$status = "<span class='sold_out'>". $date['status'] ."</span>";	
						} elseif ($date['status'] == 'Cancelled' ) {
							$status = "<span class='canceled'>". $date['status'] ."</span>";	
						}
						echo $date['date_only'];
                      	echo (isset($date['time_only']) ? '<br />' . $date['time_only'] : '');
                      	echo ($status != '' ? '<br />' . $status : ''); ?><br/>
            <?php 	}
				} ?>
			</td>
			<td>
				<h2><a href="<?php echo $details; ?>"><?php echo $event->getTitle(); ?></a></h2>
				<?php if ($event->getSubtitle()) { ?>
				<h3><?php echo $event->getSubtitle(); ?></h3>
				<?php } ?>
				
				<p>
					<?php if ($audience) { ?>
					<em>Appropriate for:</em> 
						<?php 
						for($i=0; $i<count($audience); $i++) {
							if ($i > 0) {
								echo ", ";
							}
							echo $audience[$i]->getName();
						} ?><br/>
					<? } ?>
					
						
					<?php if ($event->getPricing()) { ?>
					<em>Admission:</em> <?php echo $event->getPricing() ?>
					<?php } ?>
				</p>
				
				
				<?php if ($event->getSummary()) { ?>
				<p><?php echo stripslashes($event->getSummary()); ?></p>
				<?php } ?>
				<p><a href="<?php echo $details; ?>" class="more">Details</a></p>
			</td>
		</tr>
		<?php } ?>
	</table>

</div>