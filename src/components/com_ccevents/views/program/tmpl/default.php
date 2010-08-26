<?php defined('_JEXEC') or die('Restricted access'); ?>

	<div id="body">
		
		<div id="title">
			<h1><?php echo $this->heading; ?></h1>
		</div>

		<?php if (trim($this->announcement) != '') { ?>
		<div id="overview">
			<?php echo $this->announcement; ?>
		</div>
		<?php } ?>
			
		<table id="highlights">
			<caption>
				Highlights
			</caption>
			
			<?php
			$i = 0;
			foreach($this->genres as $genre) { 
				if ($i%2==0) { echo "<tr>\n"; }
			?>
				<td>
					<img src="../images/FPO/75x75.png" alt="ALT" width="75" height="75" />
					<h4><?php echo $genre->getName(); ?></h4>
					<h2><a href="detail.html">In the Beginning: Artists Respond to Genesis</a></h2>
					<h3 class="date">June 8, 2008 through January 4, 2009</h3>
					<p><a href="listing.html" class="more_alt">Browse all CATEGORY programs</a></p>
				</td>
				<?php if ($i%2!=1) { 
						echo "<td class='gutter'>&nbsp;</td>\n"; 
					  } else {
					  	echo "</tr>\n";
					  }
				$i++;
			} ?>
		</table>

	</div>