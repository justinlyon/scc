<?php defined('_JEXEC') or die('Restricted access'); ?>

<div id="body" class="full">

	<script language="JavaScript" src="/templates/autry/js/calendar.js" type="text/javascript"></script>
   
	<!-- Title: Modified slightly for the calendar layout -->
	
	<div id="title">
		<div class="paging">
			<a onclick="javascript:document.calendarForm.month.value='<?php echo $this->prev_month; ?>';document.calendarForm.year.value='<?php echo $this->prev_year; ?>';document.calendarForm.submit();" href="#"><img src="/templates/autry/images/calendar/last.gif" width="19" height="19" alt="Last Month" /></a>
			<h1 class="date"><?php echo $this->cur_view; ?></h1>
			<a onclick="javascript:document.calendarForm.month.value='<?php echo $this->next_month; ?>';document.calendarForm.year.value='<?php echo $this->next_year; ?>';document.calendarForm.submit();" href="#"><img src="/templates/autry/images/calendar/next.gif" width="19" height="19" alt="Next Month" /></a>
		</div>
		
		<form action="index.php" method="get" name="calendarForm">
			<input type="hidden" name="option" value="com_ccevents" />
			<input type="hidden" name="scope" value="cldr" />
			<input type="hidden" name="task" id="task" value="month" />
			
			<select name="month" onchange="this.form.submit();">
				<?php for($i=0; $i<count($this->options['month']['value']); $i++) { 
					
					$value = $this->options['month']['value'][$i]; 
					$text = $this->options['month']['text'][$i];
					$selected = ((int) $this->selected->getMonth() == (int) $value) ? 'selected="selected"' : '';
				?>			
				<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $text; ?></option>
				<?php } ?>
			</select>
			
			<select name="year" onchange="this.form.submit();">
				<?php for($i=0; $i<count($this->options['year']['value']); $i++) { 
					
					$value = $this->options['year']['value'][$i]; 
					$text = $value;
					$selected = ((int) $this->selected->getYear() == (int) $value) ? 'selected="selected"' : '';
				?>			
				<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $text; ?></option>
				<?php } ?>
			</select>
			
			<select name="fid" onchange="this.form.submit();">
				<option value="0">Show All Events</option>
				<?php foreach($this->options['category'] as $key=>$scope) { ?>
					<optgroup label="By <?php echo $key; ?>"> 
						<?php foreach ($scope as $category) { 
							$selected = ( isset($_REQUEST['fid']) && $_REQUEST['fid'] == $category->getOid()) ? 'selected="selected"' : ''; ?>
						<option value="<?php echo $category->getOid(); ?>" <?php echo $selected; ?>><?php echo $category->getName(); ?></option>	
						<?php } ?>
					</optgroup>
				<?php } ?>
			</select>
			
			<?php $filter = (isset($_REQUEST['filter'])) ? $_REQUEST['filter'] : ''; ?>
			<input type="hidden" name="filter" value="<?php echo $filter; ?>" />
			
			<button type="submit" title="Go">Go</button>
		</form>

	</div><!--//end #title-->

	<!--	
		#highlights:	
		maximum of 4 highlights/LI
	-->
	
	<?php if ($this->highlights) { ?>
	<div id="highlights">
		<h2>Calendar Highlights</h2>	
		<ul>
			<?php foreach($this->highlights as $h) { 
				$compimage = $h->getImage();
				$thumbnail = null;
				if ($compimage->getSmall() && $compimage->getSmall()->getUrl())	{
					$thumbnail = $compimage->getSmall()->getUrl();
				}
			?>			
			<li>
				<?php if ($thumbnail) { ?>
				<img src="<?php echo $thumbnail; ?>" width="75" height="75" alt="<?php echo $h->getTitle(); ?>" />
				<?php } ?>
				<p>
					<a href="<?php echo $h->getLink(); ?>"><span><?php echo $h->getScope(); ?>:</span><br /><?php echo $h->getTitle(); ?></a>
					<?php 
						$now = time();
						if ($h->getScheduleNote()) {
							echo $h->getScheduleNote(); 
						} elseif ($h->getDate()) {
							if ($h->getScope() == 'Exhibition') {	
								if ($h->getDate() < $now) {
									echo "Opened ". date("F j, Y", $h->getDate());
								} else {
									echo "Opens ". date("F j, Y", $h->getDate());	
								}
							} else {
								echo date("l, F j, Y g:i A", $h->getDate());
							}	
						}?>
				</p>
			</li>
			<?php } ?>
		</ul>
	</div><!--//end #highlights-->
	<?php } ?>
    <p class="calendarnote">Free public tours of current exhibitions and the Museum's architecture are offered daily. <a href="/index.php?option=com_content&amp;task=view&amp;view=article&amp;id=13">Click here for more information.</a></p>
	<!-- Calendar Grid -->
	<table>
		<thead>
			<tr>
				<th <?php echo ($this->weekday == 1) ? 'class="current"' : ''; ?>>Monday</th>
				<th <?php echo ($this->weekday == 2) ? 'class="current"' : ''; ?>>Tuesday</th>
				<th <?php echo ($this->weekday == 3) ? 'class="current"' : ''; ?>>Wednesday</th>
				<th <?php echo ($this->weekday == 4) ? 'class="current"' : ''; ?>>Thursday</th>
				<th <?php echo ($this->weekday == 5) ? 'class="current"' : ''; ?>>Friday</th>
				<th <?php echo ($this->weekday == 6) ? 'class="current"' : ''; ?>>Saturday</th>
				<th <?php echo ($this->weekday == 0) ? 'class="current"' : ''; ?>>Sunday</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			for($i=0; $i<count($this->grid); $i++) {				
				$day = $this->grid[$i];				
				$tdclass = '';
				if ($day['today'] == 'yes') {
					$tdclass = 'class="current"';
				} elseif ($day['past']) {
					$tdclass = 'class="past"';
				}
				$datespan = ($day['date'] > 0) ? '<span class="date">'. $day['date'] .'</span>' : '';
				$daydate = $day['date'];
				if ($i%7==0) { echo "<tr>\n"; } ?>
				<td <?php echo $tdclass; ?>><?php echo $datespan; ?>
					
					<?php // show the events
					if (isset($this->events[$daydate]) && $this->events[$daydate]) {
						$list = $this->events[$daydate]; 
						foreach($list['schedules'] as $event) {								
							$time = date("g:iA",$event->startTime);
							$genre = $event->genre;
							if ($event->scope == 'Exhibition') {
								$link = JRoute::_('index.php?option=com_ccevents&scope=exbt&task=detail&oid='. $event->oid);
							?>
								<p><?php echo $event->genre; ?>: <a href="<?php echo $link; ?>"><?php echo $event->title; ?></a></p>
							<?php } else { 
								$link = JRoute::_('index.php?option=com_ccevents&scope=prgm&task=detail&fid='. $event->fid .'&oid='. $event->oid); 
							?>
								<p><span class="time"><?php echo $time; ?></span> <?php echo $event->genre; ?>: <a href="<?php echo $link; ?>"><?php echo $event->title; ?></a></p>
							<?php } ?>
					<?php } 
					}
					?>
				</td>
				<?php if ($i%7==6) {echo "</tr>\n";} 
			}
		?>
		</tbody>
	</table>
	<!--//end Calendar Grid-->
	
</div>
