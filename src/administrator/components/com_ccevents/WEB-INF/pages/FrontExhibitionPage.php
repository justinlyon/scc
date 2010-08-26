<?php
/**
 *  $Id $
 *  Copyright (c) 2006, Tachometry Corporation
 *    http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/


if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/..');
}

require_once WEB_INF . '/pages/MasterPage.php';
require_once WEB_INF . '/beans/Exhibition.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/Category.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/web/BasePage.php');

class FrontExhibitionPage extends MasterPage
{   
   /**
    * The default render method.  Displays the summary list
    * @param bean $model The exhibition summary model
    */
   public function render($model)
   {
      global $logger;
      $logger->debug(get_class($this) . '::render()');
      $this->current($model);   
   }
   
        /**
         * Sets the appropriate attributes for a list of current exhibitions
         * then envokes the private summary() method.
         * @param bean $model The exhibition summary model
         */
        public function special($model)
        {
                global $logger;
                $logger->debug(get_class($this) . '::special()');
                $model->setViewType('Special');
                $this->summary($model);
        }

        /**
         * Sets the appropriate attributes for a list of ongoing exhibitions
         * then envokes the private summary() method.
         * @param bean $model The exhibition summary model
         */
        public function ongoing($model)
        {
                global $logger;
                $logger->debug(get_class($this) . '::ongoing()');
                $model->setViewType('Ongoing');
                $this->summary($model);
        }

   /**
    * Sets the appropriate attributes for a list of current exhibitions
    * then envokes the private summary() method.
    * @param bean $model The exhibition summary model
    */
   public function current($model)
   {
      global $logger;
      $logger->debug(get_class($this) . '::current()');
      $model->setViewType('Current');
      $this->summary($model);
   }
   
   /**
    * Sets the appropriate attributes for a list of upcoming exhibitions
    * then envokes the private summary() method.
    * @param bean $model The exhibition summary model
    */
   public function upcoming($model)
   {
      global $logger;
      $logger->debug(get_class($this) . '::upcoming()');
      $model->setViewType('Upcoming');
      $this->summary($model);
   }
   
   /**
    * Renders the summary of given exhibitions (current or upcoming)
    * @param bean $model The exhibition summary model
    */
   private function summary($model)
   {
      global $logger, $mainframe;
      $logger->debug(get_class($this) . '::summary()');
      
      $list = $model->getList();   
      
      $tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
      $tmpl->readTemplatesFromInput( 'exhibition_summary.pat.tpl' );   
            
      $mainframe->setPageTitle($model->getViewType() . " Exhibitions");
      
      $tmpl->addVar('intro','view_type',$model->getViewType());
      if ($model->getAnnouncement() != null) {
         $tmpl->addVar('intro','announcement',$model->getAnnouncement());
      }
      
      // Add the objects to the nested templates
      for ($i=0; $i<count($list); $i++) {
         $event = $list[$i];
         
         // simple attributes
         $tmpl->addVars('exhibition', BeanUtil::beanToArray($event,true)); // scalars only
         
         // Event Status & Tickets
         $tmpl->addVar('exhibition','status',$event->getEventStatus());
         
         if ($event->getTicketUrl() != null) {
            $tmpl->addVar('ticket_link','ticketurl',$this->getTicketUrl($event->getTicketUrl()));
         }
         
         // schedule
         $time_display = "";
         if ($event->getScheduleNote()) {
            $time_display = $event->getScheduleNote();
         } elseif ($event->getSchedule() != null) {
            $st = $event->getSchedule()->getStartTime();
            $et = $event->getSchedule()->getEndTime();   
            $time_display = $this->formatDate($st,'tiny');
            
            if ($et > $st) {
               $time_display .= " - ". $this->formatDate($et,'tiny');
               $time_display .= date(", Y", $et);
            }            
         }
         $tmpl->addVar('exhibition','time_display',$time_display);
         
         
         // image
         if ($event->getGallery() != null) {
            $images = $event->getGallery()->getImages();
            $logger->debug('Number of images [1]: '. count($images));
            $img = $images[0];
            $logger->debug('Class of img [Image]: '. get_class($img));
            $tmpl->addVar('exhibition','imageurl',$img->getUrl());
            $tmpl->addVar('exhibition','imagecredit',$img->getAuthor());
         }
         
         // venues
         $logger->debug("Number of venues for event ID ". $event->getOid() .": ". count($event->getVenues()));
         if ($event->getVenues() != null) {
            $tmpl->clearTemplate('venues');
            $logger->debug("type of venue collection [array]: ". gettype($event->getVenues()));
         
            foreach ( $event->getVenues() as $venue ) {
               $logger->debug("Venue is of class [Venue]: ". get_class($venue));
               $vlink = $this->getVenueTitleLink($venue);
               $tmpl->addVar('venues','venue_link',$vlink);
               $tmpl->parseTemplate('venues',"a");
            }
         }
      
         // related
         $tmpl->clearTemplate('show_related');
         $tmpl->setAttribute( "show_related", "visibility", "hidden" );   
         $tmpl->clearTemplate('related');
         if($event->getPrograms() != null) {
            $res = $event->getPrograms();   
            if (count($res) > 0) {      
               foreach($res as $prg) {
                  // only show published programs
                  if ($prg->getPubState() == 'Published') {
                                                            
                     if (count($prg->getChildren()) > 0) {
                        $next = $this->getNextActivity($prg->getChildren());

                        if ($next) {
                           $tmpl->addVar('related','oid',$prg->getOid());
                           $tmpl->addVar('related','title',$prg->getTitle());
                           $schedule = $next->getSchedule();
                           $startTime = "(". $this->formatDate($schedule->getStartTime()) .")";
                           $tmpl->addVar('related','startTime',$startTime);   
                           $tmpl->parseTemplate('related',"a");
                           $tmpl->setAttribute( "show_related", "visibility", "visible" );   
                        } 
                     }
                  }
               }
            }
         }
                                    
         // audience
         $tmpl->clearTemplate('show_audience');
         $tmpl->setAttribute( "show_audience", "visibility", "hidden" );
         $tmpl->clearTemplate('audience');
         $family = false;
         $cats = $event->getCategories();
         if (isset($cats[Category::AUDIENCE])) {
            foreach( $cats[Category::AUDIENCE] as $aud) {
               if ($aud->getFamily()) {
                  $family = true;   
               }   
               $tmpl->addVar('audience','name',$aud->getName());
               $tmpl->parseTemplate('audience','a');   
               $tmpl->setAttribute( "show_audience", "visibility", "visible" );   
            }   
         }      
         $tmpl->addVar('exhibition','family',$family);
            
         $tmpl->parseTemplate('exhibition',"a");
      }
      $tmpl->displayParsedTemplate( 'exbt_summary' );
   }
   
   /**
    * Renders the detail of a given exhibition
    * @param bean $model The exhibition detail model
    */
   function detail($model)
   {
      global $logger, $mainframe;
      $logger->debug(get_class($this) . "::detail($model)");
      
      $event = $model->getDetail();
      
      $tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
      $tmpl->readTemplatesFromInput( 'exhibition_detail.pat.tpl' );
      
      $mainframe->setPageTitle("Exhibition | ". $event->getTitle());
      
      $tmpl->addVars('exbt_detail', BeanUtil::beanToArray($event,true)); // scalars only
      
      // schedule
      $time_display = "";
      if ($event->getScheduleNote()) {
         $time_display = $event->getScheduleNote();
      } elseif ($event->getSchedule() != null) {
         $st = $event->getSchedule()->getStartTime();
         $et = $event->getSchedule()->getEndTime();   
         $time_display = $this->formatDate($st,'tiny');
         
         if ($et > $st) {
            $time_display .= " - ". $this->formatDate($et,'tiny');
            $time_display .= date(", Y", $et);
         }            
      }
      $tmpl->addVar('exbt_detail','time_display',$time_display);
      
      // Event Status & Tickets
      $tmpl->addVar('exbt_detail','status',$event->getEventStatus());
      if ($event->getTicketUrl() != null) {
         $tmpl->addVar('ticket_link','ticketurl',$this->getTicketUrl($event->getTicketUrl()));
      }
            
      // venues
      if ($event->getVenues() != null) {
         $tmpl->clearTemplate('venues');
         $logger->debug("type of venue collection [array]: ". gettype($event->getVenues()));
         
         foreach ( $event->getVenues() as $venue ) {
            $logger->debug("Venue is of class [Venue]: ". get_class($venue));
            $vlink = $this->getVenueTitleLink($venue);
            $tmpl->addVar('venues','venue_link',$vlink);
            $tmpl->parseTemplate('venues',"a");
         }
      }
      
      // gallery images
      if ($event->getGallery() != null) {
            $tmpl->addVar('photoArea','displayPhotos',true);
         $images = $event->getGallery()->getImages();
         $logger->debug('Number of images: '. count($images));
         foreach($images as $img) {
            $tmpl->addVar('photo','imageurl',$img->getUrl());
            $tmpl->addVar('photo','caption',$img->getAuthor());
            $tmpl->parseTemplate('photo','a');
         }
      }

      // related
      $tmpl->clearTemplate('show_related');
      $tmpl->setAttribute( "show_related", "visibility", "hidden" );   
      $tmpl->clearTemplate('related');
      if($event->getPrograms() != null) {
         $res = $event->getPrograms();   
         if (count($res) > 0) {      
            foreach($res as $prg) {
               // only show published programs
               if ($prg->getPubState() == 'Published') {
                                                         
                  if (count($prg->getChildren()) > 0) {
                     $next = $this->getNextActivity($prg->getChildren());

                     if ($next) {
                        $tmpl->addVar('related','oid',$prg->getOid());
                        $tmpl->addVar('related','title',$prg->getTitle());
                        $schedule = $next->getSchedule();
                        $startTime = "(". $this->formatDate($schedule->getStartTime()) .")";
                        $tmpl->addVar('related','startTime',$startTime);   
                        $tmpl->parseTemplate('related',"a");
                        $tmpl->setAttribute( "show_related", "visibility", "visible" );   
                     } 
                  }
               }
            }
         }
      }
      
      
      $tmpl->displayParsedTemplate( 'exbt_detail' );
   }
}
