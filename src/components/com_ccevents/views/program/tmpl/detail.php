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

<div id="body">

        <div id="title">
                <h1><?php echo $this->event->getTitle(); ?></h1>
                <?php if ($this->event->getSubtitle()) { ?>
                    <h2 class="subtitle"><?php echo $this->event->getSubtitle(); ?></h2>
                <?php } ?>                   
                <h2><?php echo $this->primaryGenre; ?></h2>
        </div>

        <div id="main">

                <?php if ($this->event->getGallery()) { 
                	$images = $this->event->getGallery()->getImages();
                	$image = ($images[0]) ? $images[0] : null;
                	if ($image && $image->getLarge()) {    		
                ?>
                <div class="photo">
                        <img src="<?php echo $image->getLarge()->getUrl(); ?>" alt="<? $image->getTitle(); ?>" width="500" height="200" />
                        <p class="caption"><?php echo $image->getCaption(); ?></p>
                </div>
                <?php } }?>

                <dl>
                        <dt>Date/Time:</dt>
                        <dd>
                        <?php foreach ($this->schedule as $date) { 
								$status = "";
								if ($date['status'] == 'Active' && isset($date['code']) && trim($date['code']) != '') {
									$link = $date['code'];
									$status = "<a href='". $link ."' target='_blank' class='tickets'>Buy Tickets</a>";	
								} elseif ($date['status'] == 'Sold Out' ) {
									$status = "<span class='sold_out'>". $date['status'] ."</span>";	
								} elseif ($date['status'] == 'Cancelled' ) {
									$status = "<span class='canceled'>". $date['status'] ."</span>";	
								}
							?>
							<strong><?php echo $date['date']; ?></strong> <?php echo $status; ?><br/>
			            <?php } ?>
                        </dd>
                        <?php
                            $venue = $this->event->getDefaultVenue();
                            $venueText = $venue->getName();
                              if(($venueText != "Default Venue") && ($venueText != ""))   {
                             ?>
                                <dt>Venue:</dd>
                                <dd><?php echo $venueText;
                                           ?></dd>
                        <?php } ?>
                        <?php if ($this->audience) { ?>
                        <dt>Appropriate For:</dt>
                        <dd>
                                <?php foreach ($this->audience as $aud) {
                                        echo $aud->getName() ."<br/>";
                                }
                                ?>
                        </dd>
                        <?php } ?>

                        <?php if ($this->event->getPricing()) { ?>
                        <dt>Admission:</dt>
                        <dd><?php echo $this->event->getPricing(); ?></dd>
                        <?php } ?>

                        <?php if ($this->event->getTicketDesc()) { ?>
                        <dt>RSVP/Reservations:</dt>
                        <dd><?php echo $this->event->getTicketDesc(); ?></dd>
                        <?php }?>

                        <?php if ($this->event->getContact()) { ?>
                        <dt>Contact:</dt>
                        <dd><?php echo $this->event->getContact(); ?></dd>
                        <?php } ?>
                </dl>

                <hr />

                <h2>About the Program</h2>
                <?php echo $this->event->getDescription(); ?>

                <?php if ($this->event->getPressRelease()) {
                            $prlink = JRoute::_('index.php?option=com_pressroom&scope=archive&task=detail&id='. $this->event->getPressRelease() );                        ?>
                        <ul class="tiny">
                          <li><a href="<?php echo $prlink; ?>"><img src="../images/tiny_press.gif" width="10" height="11" alt="" /><span>Press Release</span></a></li>
                        </ul>
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


                <?php if ($this->exhibitions) { ?>
                <h3>Related Exhibitions</h3>
                <?php foreach ($this->exhibitions as $exhibit) {
                        $elink = JRoute::_("index.php?option=com_ccevents&scope=exbt&task=detail&oid=". $exhibit->getOid());
                ?>
                <p>
                        <a href="<?php echo $elink; ?>"><?php echo $exhibit->getTitle(); ?></a><br />
                        <?php echo $exhibit->getScheduleNote(); ?>
                </p>
                <?php } 
                 } ?>

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
						$comment = $comment[$i]; 
						$link = JRoute::_('index.php?option=com_pressroom&scope=archive&task=detail&id='. $comment->getArticle() );
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
