<?php
/**
 * Program View for CCEvents Component
 * 
 * @package    joomla
 * @subpackage ccevents
 */

jimport( 'joomla.application.component.view');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ccevents'.DS.'WEB-INF'.DS.'base.include.php');
require_once(WEB_INF.DS.'pages'.DS.'FrontProgramPage.php');
require_once(WEB_INF.DS.'beans'.DS.'Category.php');

class CCEventsProgramViewProgram extends JView
{
   const TICKET_VENDOR_BASE = "https://tickets.autrynationalcenter.org";
   const TICKET_VENDOR_INT_QUERY = "/public/loader.asp?target=hall.asp?event=";
   const TICKET_VENDOR_STRING_QUERY = "";
   
   function overview($tpl = null)
   {   
      $heading = "Programs at the Autry National Center";
      $document =& JFactory::getDocument();
      $document->setTitle($heading);
      
      $model =& $this->getModel();   
      $this->assignRef('genres',$model->getList());
      $this->assignRef('announcement', $model->getAnnouncement());
      $this->assignRef('heading',$heading);
               
      parent::display($tpl);
   }
   
   
   function featured($tpl = null)
   {   
      $heading = "Programs at the Autry National Center";
      $document =& JFactory::getDocument();
      $document->setTitle($heading);
      
      $model =& $this->getModel();
      $events = $model->getList();
      
      // 1. formats and sets the display date in a temporary displayDate
      $starts = array();
      for($i=0; $i<count($events); $i++) {
         $event = $events[$i];   
         
         // schedule
         $displayDate = "";
         if ($event->getScheduleNote()) {
            $displayDate = $event->getScheduleNote();   
         } 
         if ($event->getChildren()) {                              
            $next = $this->getNextPerformance($event->getChildren());
            if ($next) {
               $start = $next->getSchedule()->getStartTime();
               $displayDate = ($displayDate) ? $displayDate : date("l, F j, Y, g:i A", $start);
               $starts[$i] = $start;
            }
         }
         $event->setDisplayDate($displayDate);               
      }
      
      // now order the events by start time
      asort($starts);
      foreach($starts as $key=>$value) {
         $ordered[] = $events[$key];   
      }

      $this->assignRef('events',$ordered);
      $this->assignRef('announcement', $model->getAnnouncement());
      $this->assignRef('heading',$heading);
               
      parent::display($tpl);
   }
   
   function summary($tpl = null)
   {   
      $model =& $this->getModel();
      $events = $model->getList();      
      
      $heading = "Program Summary";
      $overview = '';
      if ($model->getGenre() ) {
         //$heading .= ": ". $model->getGenre()->getName();
         $heading = $model->getGenre()->getName();
         $overview = $model->getGenre()->getDescription();   
      }
      $document =& JFactory::getDocument();
      $document->setTitle($heading);
      $this->assignRef('heading',$heading);
      $this->assignRef('overview',$overview);
      
      // formats the sort links
      $filter = "index.php?option=com_ccevents&scope=prgm&task=summary";
      if ($_REQUEST['fid']) {
         $filter   = "&filter=Genre&fid=". $_REQUEST['fid'];
      }
      if (isset($_REQUEST['school'])) {
         $filter   .= "&school=true";
      }
      $this->assignRef('sort_age', JRoute::_($filter."&sort=age"));
      $this->assignRef('sort_title', JRoute::_($filter."&sort=title"));
      $this->assignRef('sort_date', JRoute::_($filter."&sort=date"));
      $this->assignRef('sort_series', JRoute::_($filter."&sort=series"));
      $this->assignRef('sort_current', $_SESSION['summary_sort']);

      // check for a sort preference
      $fpp = new FrontProgramPage();
      if (isset($_SESSION['summary_sort'])) {
         usort($events,array($fpp,'sort_by_' . $_SESSION['summary_sort']));
      } else {
         usort($events,array($fpp,'sort_by_date'));
      }

      // 1. formats and sets the schedule display back in the children attribute
      foreach($events as $event) {
         // schedule
         $schedule = array();
         if ($event->getScheduleNote()) {
             $schedule[] = array('date'=>$event->getScheduleNote(),'date_only'=>$event->getScheduleNote(),'status'=>'Active');   
         }
         $showtimes = $this->getShowtimes($event->getChildren(), $event->getTicketUrl());
         if ($showtimes['showtimes'] || !$event->getScheduleNote()) {                  
            $schedule = $showtimes['performances'];
         }
         $event->setChildren($schedule);         
      }
      
      $this->assignRef('events',$events);
            
      parent::display($tpl);
   }
   
   function detail($tpl = null)
   {   
      $model =& $this->getModel();
      $event = $model->getDetail();

      $this->assignRef('event',$event);
      
      $pg = ($event->getPrimaryGenre()) ? $event->getPrimaryGenre()->getName() : '';
      $this->assignRef('primaryGenre', $pg );
      
      // render the schedule
      $schedule = array();
      if ($event->getScheduleNote()) {
         $schedule[] = array('date'=>$event->getScheduleNote(),'status'=>'Active');   
      }
      $showtimes = $this->getShowtimes($event->getChildren(),$event->getTicketUrl());
      if ($showtimes['showtimes'] || !$event->getScheduleNote()) {                  
         $schedule = $showtimes['performances'];
      }
      $this->assignRef('schedule',$schedule);
      
      $exhibitions = $event->getExhibitions();
      $this->assignRef('exhibitions',$exhibitions);
      
      $heading = "Program Detail: ". $event->getTitle();
      $document =& JFactory::getDocument();
      $document->setTitle($heading);
      
      $auds = array();
      if ($event->getCategories()) {
         $cats = $event->getCategories();
         $auds = $cats['Audience'];
      }
      
      $this->assignRef('audience', $auds);
      
      parent::display($tpl);
   }
   
   
   /**
    * Returns a list of formatted performances and a flag
    * to represent if there is a performance with a ticket 
    * code or a status other than Active 
    * @param array Performace
    * @param ticket url override (optional)
    * @return array ['stowtimes'=>boolean, 'performances' array()]
    */
   function getShowtimes($performances, $ticketUrl)
   {
      $showtimes = false;
      $times = array();
      $i=0;
      foreach ($performances as $performance) {
         $times[$i] = array();

         $start = $performance->getSchedule()->getStartTime();
         $end = $performance->getSchedule()->getEndTime();
            $date_only = date("l, M j, Y", $start);
            $time_only = date("g:i a", $start);

            if ($end) {
                if (date("j",$start) == date("j",$end)) {
                    $time_only .= " - ". date("g:i a", $end);
                } else {
                    $time_only .= " - ". date("l, M j, Y, g:i a", $end);
                }
            }

            $times[$i]['start'] = $start;
            $times[$i]['date'] = $date_only . ", " . $time_only;
            $times[$i]['date_only'] = $date_only;
            $times[$i]['time_only'] = $time_only;
         $times[$i]['status'] = $performance->getActivityStatus()->getValue();
         
         // get the ticket code url
         if ($ticketUrl) {
            $times[$i]['code'] = $ticketUrl;   
         } else {
            $times[$i]['code'] = $this->getTicketLink($performance->getTicketCode());
         }
         if ($times[$i]['code'] || $times[$i]['status'] != 'Active') {
            $showtimes = true;   
         }

         $i++;
      }
      
      // sort the performaces 
      $column = array();
      foreach ($times as $sortarray) {
          $column[] = $sortarray['start'];
      }
      array_multisort($column, SORT_ASC, $times);
      
      $result = array();
      $result['showtimes'] = $showtimes;
      $result['performances'] = $times;
      return $result;
   }
   
   
   function getNextPerformance($performances)
   {
      $nextPerf = null;
      $nextStart = null;
      $now = time();
      foreach($performances as $performance) {
         $schedule = $performance->getSchedule();
         $thisStart = $schedule->getStartTime();         
         if ($thisStart > $now) {            

            $nextStart = $thisStart;
            $nextPerf = $performance; 
         }
      }
      return $nextPerf;
   }   
   
   /**
    * Returns the ticket url for the given code.
    * NOTE: This reimplements the FrontProgramPage 
    * functionality to support the Joomla 1.5 MVC.
    * The other version should be considered deprecated 
    * and removed at the next major release.
    * @param code
    * @return fully qualified URL
    */
   function getTicketLink($code)
   {
      $link = "";
      // the the code is a number, use one link
      // if is a string use a different link
      if ($code > 0) {
            $link = CCEventsProgramViewProgram::TICKET_VENDOR_BASE . CCEventsProgramViewProgram::TICKET_VENDOR_INT_QUERY . $code;
      } elseif (trim($code) != '') {
            $link = CCEventsProgramViewProgram::TICKET_VENDOR_BASE . CCEventsProgramViewProgram::TICKET_VENDOR_STRING_QUERY . $code;
      }
      return $link;   
   }

}
?>
