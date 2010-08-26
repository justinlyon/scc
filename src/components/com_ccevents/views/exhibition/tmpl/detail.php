<?php
/**
 *  $Id$: detail.php, Mar 21, 2008 4:55:33 PM nchanda
 *  Copyright (c) 2008, Tachometry Corporation
 *      http://www.tachometry.com
 *
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

?>
<?php defined('_JEXEC') or die('Restricted access'); ?>

<div id="body" class="wide">

	<div id="title">
	        <h1><?php echo $this->event->getTitle(); ?></h1>
			<?php if ($this->event->getSubtitle()) { ?>
	    		<h2 class="subtitle"><?php echo $this->event->getSubtitle(); ?></h2>
			<?php } ?>                           
	        <h2><?php echo $this->schedule; ?></h2>
	</div>

	
	<div id="main">
	    <?php
	 if ($this->image) {
	    $largeImg = $this->image->getLarge();
	    $imgWidth = $largeImg->getWidth();
	    $imgHeight = $largeImg->getHeight();
	    if($imgWidth > $imgHeight)  { ?>
	        <div class="photo">
	            <img src="<?php echo $largeImg->getUrl(); ?>" alt="<?php echo $this->image->getTitle(); ?>" width="<?php echo $imgWidth; ?>" height="<?php echo $imgHeight; ?>" />
	            <p class="caption"><?php echo $this->image->getDescription(); ?></p>
	        </div>
	    <?php 
	    } else { ?>
	        <table class="photo">
	           <tr>
	              <td><img src="<?php echo $largeImg->getUrl(); ?>" alt="<?php echo $this->image->getTitle(); ?>" width="<?php echo $imgWidth; ?>" height="<?php echo $imgHeight; ?>" /></td>
	              <td><p class="caption"><?php echo $this->image->getDescription(); ?></p></td>
	           </tr>
	        </table>
	    <?php 
	    }
	 }  ?>
	            <div class="container">
	                <h2>About the Exhibition</h2>
	                <div id="details">
	                	<p><?php echo $this->event->getDescription(); ?></p>
	                </div>
			</div>
	
	        <?php if ($this->event->getPressRelease()) {                                
	                $prlink = JRoute::_('index.php?option=com_pressroom&scope=archive&task=detail&id='. $this->event->getPressRelease() );                        ?>
	        <ul class="tiny">                          
	        	<li><a href="<?php echo $prlink; ?>"><img src="/templates/autry/images/tiny_press.gif" width="10" height="11" alt="" /><span>Press Release</span></a></li>
	        </ul>
	        <?php } ?>
	
	        <?php 
	        // Remove false && to get artists back
	        if (false && $this->event->getArtists() && count($this->event->getArtists()) > 0) {
	                $artists = $this->event->getArtists();
	                $half = ceil( count($artists)/2 );                        ?>
	        <hr />
	        <h2>The Artists</h2>
	
	        <table class="columns">
	                <tr>
	                        <td>
	                                <?php
	                                	$artbaselink = 'index.php?option=com_ccevents&scope=exbt&task=artist&format=raw&aid=';
	                                	for($i=0;$i<$half;$i++) {
	                                		$artist = $artists[$i];
	                                		$artlink = JRoute::_($artbaselink . $artist->getOid());
	                           		?>
	                           			<?php if ($artist->getSummary()) { ?>
	                               		<a href="<?php echo $artlink; ?>" rel="facebox">
	                               		<?php }
	                               		 echo $artist->getFriendlyName(); 
	                               		 if ($artist->getSummary()) { ?></a><?php } ?>
	                               		<br />
	                                <?php } ?>
	                        </td>
	                        <td>
	                                <?php for($i=$half;$i<count($artists);$i++) {
	                                        $artist = $artists[$i];
	                                        $artlink = JRoute::_($artbaselink . $artist->getOid());
	                                ?>
	                                	<?php if ($artist->getSummary()) { ?>
	                               		<a href="<?php echo $artlink; ?>" rel="facebox">
	                               		<?php }
	                               		 echo $artist->getFriendlyName(); 
	                               		 if ($artist->getSummary()) { ?></a><?php } ?>
	                               		<br />
	                               	<?php } ?>
	                        </td>
	                </tr>
	        </table>
	        <?php } ?>
	
	
	        <?php if ($this->event->getAddinfo() ) { ?>
	        <hr />
	        <h2><?php echo $this->event->getAddtitle() ?></h2>                        
	        <p><?php echo $this->event->getAddinfo() ?></p>
	        <?php } ?>
	
	
	        <?php if ($this->event->getCredit()) { ?>
	        <hr />
	        <h2>Sponsors:</h2>
	        <div class="logos">
	            <?php echo $this->event->getCredit(); ?>
	        </div>
	        <?php } ?>
	</div>
	
	<div id="sidebar">
	
		<?php if ($this->event && $this->event->getArtifacts()) { ?>
	        <h3>Exhibition Highlights</h3>
	        <div class="thumbnails">
	        	<?php foreach($this->event->getArtifacts() as $image) {	
	        		$thumbnail = $image->getSmall();
	        		if ($thumbnail) {
	        		$link = JRoute::_('index.php?option=com_ccevents&scope=exbt&task=highlight&format=raw&eid='. $image->getLarge()->getId() );
	        		
	        	?>
	                <a href="<?php echo $link; ?>" rel="facebox"><img src="<?php echo $thumbnail->getUrl(); ?>" alt="<?php echo $image->getTitle(); ?>" width="64" height="64"/></a>
	            <?php } } ?>   
	               <p>(Click images for details)</p>
	        </div>
		<?php } ?>

        <?php if (count ($this->event->getRelatedArticles()) > 0) { ?>
	        <h3>Related Articles</h3>
	        <ul class="no-bullets">
	                <?php foreach($this->event->getRelatedArticles() as $article) {                                        
	                	$link = JRoute::_('index.php?option=com_content&task=view&view=article&id='. $article->getId() .'&scope=exbt&oid='. $this->event->getOid() );
	                ?>
	                <li><a href="<?php echo $link; ?>"><?php echo $article->getTitle(); ?></a></li>
	                <?php } ?>
	        </ul>
	        <?php } ?>
	
	
	
	        <?php if ($this->event->getPrograms() && count($this->event->getPrograms()) > 0) {
	                $programs = $this->event->getPrograms();
	        ?>
	        <hr />
	        <h3>Related Programs</h3>
	                <?php foreach ($programs as $program) { 
	                   	if ($program->getPubState() == "Published") {
	                   	$pg = $program->getPrimaryGenre();
	                	$link = JRoute::_('index.php?option=com_ccevents&scope=prgm&task=detail&fid='. $pg->getOid() .'&oid='. $program->getOid());
	                ?>
	                <p>
	                        <a href="<?php echo $link ?>"><?php echo $program->getTitle() ?></a><br />
	                        <?php
	                                // schedule
	                                $time_display = "";
	                                if ($program->getScheduleNote()) {
	                                        $time_display = $program->getScheduleNote();
	                                } elseif ( count($program->getChildren()) > 0) {
	                                        $performances = $program->getChildren();
	                                        $next_time = 0;
	                                        $now = time();
	                                        foreach ($performances as $performance) {
	                                                $st = $performance->getSchedule()->getStartTime();
	                                                if ( ($st>$now) && ($next_time == 0 || $st < $next_time)) {
	                                                        $next_time = $st;
	                                                }
	                                        }
	                                        $time_display = date("D, M j, Y - g:i A", $next_time);
	                                }
	                                echo $time_display;
	                        ?>  </p>
	                <?php } ?>
	            <?php } ?>
	        <?php } ?>
	
			<?php if ($this->event->getAddinfo2() ) { ?>
	        <hr />
	        <h3><?php echo $this->event->getAddtitle2() ?></h3>                        
	        <p><?php echo $this->event->getAddinfo2() ?></p>
	        <?php } ?>
	
	
			<?php if ($this->event->getCommentArticle() ) { ?>
	        <hr />
	        <h3>Join the Discussion</h3>
			<?php 
				$comments = $this->event->getCommentArticle();
				for($i=0; $i<count($comments); $i++) {
					$comment = $comments[$i]; 
					$link = JRoute::_('index.php?option=com_content&task=view&view=article&id='. $comment->getArticle() );
					$alt = ($i%2 == 0 ) ? 'class="alt"' : '';
			?>
	        <blockquote <?php echo $alt; ?>>
	        	<div>
	                <p><?php echo $comment->getComment(); ?></p>
	                <cite><?php echo $comment->getName(); ?></cite>
	            </div>
	        </blockquote>
			<?php } ?>
	
	        <p>
	          <a href="<?php echo $link; ?>" class="more" title="view more">View all comments</a><br />
	          <a href="<?php echo $link; ?>" class="more" title="view more">Add your comment</a>
	        </p>
	        <?php } ?>	
	
		
	</div>
</div>
