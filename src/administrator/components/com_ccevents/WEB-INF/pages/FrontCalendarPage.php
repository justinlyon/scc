<?php
/**
 *  $Id$: FrontCalendarPage.php, Sep 18, 2006 8:40:38 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

require_once WEB_INF . '/base.include.php';
require_once WEB_INF . '/beans/CalendarForm.php';
require_once WEB_INF . '/pages/MasterPage.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/web/AddressUtil.php');

class FrontCalendarPage extends MasterPage
{	
	/**
	 * The default render method.  Displays the month view
	 * @param bean $model The calendar summary model
	 */
	public function render($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::render()');
		$this->month($model);	
	} 
	
	/**
	 * Renders the month view.
	 * @param bean $model The calendar summary model
	 */
	public function month($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::month()');
		
		$this->setRequestFlags('general');
		
		$list = $this->formatEntries($model->getList());
		
		$selected = $model->getSelected(); 
		
		$selectedTime = CalendarForm::getMonthStart($selected);
		$grid = $this->setMonthGrid($selectedTime,$list);	
		
		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'calendar_month.pat.tpl' );
		$tmpl->addVar('calendar','cal_type','month');
			
		$this->renderControls($tmpl,$model);
			
		// Load the grid
		$counter = 0;
		$numweeks = count($grid)/7;
		
		// loop for each week
		for ($w = 0; $w < $numweeks; $w++) {
		  // clear days from last week
		  $tmpl->clearTemplate( "day" );
		
		  // put data for one week in a new array 
		  $weekData = array();
		  for ($d = 0; $d < 7; $d++) {	
			
			$day = $grid[$counter]['date'];
		  	$logger->debug("day value in renderer: ". $day);
		  	$tmpl->addVar('day','date',$day);
		  	$tmpl->addVar('day','today',$grid[$counter]['today']);
		  	
		  	$tmpl->clearTemplate("event");
		  	$tmpl->setAttribute('event','visibility','hidden');
		  	if (isset($list[$day])) {
		  		
		  		foreach ($list[$day]["schedules"] as $sched) {
					
					// load the event info
					$tmpl->setAttribute('event','visibility','visible');
					$tmpl->addVars('event', BeanUtil::beanToArray($sched,true)); // scalars only
					
					// Format the start time 
					$st = date("g:i a", $sched->getStartTime());;
					$tmpl->addVar('event','formatted_time',$st);
				
					// figure out the proper url
					if ($sched->getScope() == Event::EXHIBITION) {
						$tmpl->addVar('event','url','index.php?option=com_ccevents&scope=exbt&task=detail&oid='. $sched->getOid());
					} elseif ($sched->getScope() == Event::PROGRAM) {
						$tmpl->addVar('event','url','index.php?option=com_ccevents&scope=prgm&task=detail&oid='. $sched->getOid());
					} elseif ($sched->getScope() == Event::COURSE) {
						$tmpl->addVar('event','url','index.php?option=com_ccevents&scope=crse&task=summary&filter=Genre&fid='. $sched->getFid());
					}
					
					$tmpl->parseTemplate('event','a');
			  	}
		  	}
		  	$counter++;
		  	$tmpl->parseTemplate("day","a");
		  }

		  // parse this week and append the data to previously parsed weeks 
		  $tmpl->parseTemplate( "week", "a" );
		}				

		$cal_link = $this->cceventSefUrl('index.php?option=com_ccevents&scope=cldr&task=text');
	    $tmpl->addVar('calendar','cal_view_link',$cal_link);
		
		$tmpl->displayParsedTemplate('calendar');
		
	} 
	 
 	/**
	 * Renders the flat text view.
	 * @param bean $model The calendar summary model
	 */
	public function text($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::text()');
		
		$this->setRequestFlags('text');
			
		$list = $model->getList();
		$selected = $model->getSelected();
		$selectedTime = CalendarForm::getMonthStart($selected);
			
		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'calendar_text.pat.tpl' );
		$tmpl->addVar('calendar','cal_type','text');
		
		$this->renderControls($tmpl,$model);

		$logger->debug("Nuumber of events in the page:". count($model->getList()));
		
		// render the list
		$days = $this->formatEntries($list);
		foreach ($days as $entry) {
						
			$start = $entry["start"];
			$tmpl->addVar('day','day_num',date('j',$start));
			$tmpl->addVar('day','day_name',date('l',$start));
			
			$tmpl->clearTemplate('event');
			foreach ($entry["schedules"] as $sched) {
				// load the event info
				$tmpl->addVars('event', BeanUtil::beanToArray($sched,true)); // scalars only

				// Format the start time
                                $st = date("g:i a", $sched->getStartTime()); 
                                $tmpl->addVar('event','formatted_time',$st);
	
				// figure out the proper url
				if ($sched->getScope() == Event::EXHIBITION) {
					$tmpl->addVar('event','url','index.php?option=com_ccevents&scope=exbt&task=detail&oid='. $sched->getOid());
				} elseif ($sched->getScope() == Event::PROGRAM) {
					$tmpl->addVar('event','url','index.php?option=com_ccevents&scope=prgm&task=detail&oid='. $sched->getOid());
				} elseif ($sched->getScope() == Event::COURSE) {
					$tmpl->addVar('event','url','index.php?option=com_ccevents&scope=crse&task=summary&filter=Genre&fid='. $sched->getFid());
				}
				$tmpl->parseTemplate('event','a');
			}
			$tmpl->parseTemplate('day','a');
		}
	
		$cal_link = $this->cceventSefUrl('index.php?option=com_ccevents&scope=cldr&task=month&month='. $selected->getMonth() .'&year='. $selected->getYear());
        	$tmpl->addVar('calendar','cal_view_link',$cal_link);
		
		$tmpl->displayParsedTemplate('calendar');
		
	} 
	
	
	/**
	 * Takes the array of CalendarEntries and adds them to
	 * an array that is more convenient for the patTemplate 
	 * engine to render.
	 * 
	 * @param array CalendarEntry
	 * @return array (day, start, array of calendar entries)
	 */
	function formatEntries($list)
	{
		global $logger;
		$logger->debug(get_class($this) . "::formatEntries($list)");
		
		// separate the entries into days
		$day = 0;
		$days = array();
		foreach($list as $sched) {
				
			$st = $sched->getStartTime();
			$date = intval(date('Ymd',$st));
			
			// is this a new day
			if ($date != $day) {
				$days[$date] = array("day"=>$date,"start"=>$st,"schedules"=>array($sched));
				$day = $date;
			} else {
				array_push($days[$date]["schedules"], $sched);
			}			
		}
		$logger->debug("Number of days with entries: ". count($days));	

		ksort($days);
		return $days;
	}	
	
	
	/**
	 * A shared private method used to render the common
	 * controls.
	 * 
	 * @access private
	 * @param template $tmpl the template object
	 * @param model $model the page model
	 */
	 function renderControls($tmpl,$model)
	 {
	 	global $mainframe;
	 	
	 	$options = $model->getOptions();
	 	$selected = $model->getSelected();
	 	$selectedTime = CalendarForm::getMonthStart($selected);
	 	
	 	// set the select lists
		$months = $options['month'];
		for ($i=0; $i<count($months['value']); $i++) {
			$tmpl->addVar('month_options','value',$months['value'][$i]);
			$tmpl->addVar('month_options','text',$months['text'][$i]);	
			if ($months['value'][$i] == $selected->getMonth()) {
				$tmpl->addVar('month_options','selected','selected');	
			} else {
				$tmpl->addVar('month_options','selected','');
			}
			$tmpl->parseTemplate('month_options','a');
		}	
		
		$years = $options['year'];
		for ($i=0; $i<count($years['value']); $i++) {
			$tmpl->addVar('year_options','value',$years['value'][$i]);
			if ($years['value'][$i] == $selected->getYear()) {
				$tmpl->addVar('year_options','selected','selected');	
			} else {
				$tmpl->addVar('year_options','selected','');
			}
			$tmpl->parseTemplate('year_options','a');
		}
		
		$categories = $options['category'];
		foreach ($categories as $cat) {
			$tmpl->addVar('category_options','coid',$cat['oid']);
			$tmpl->addVar('category_options','name',$cat['name']);
			if ($cat['oid'] == $selected->getCategory()) {
				$tmpl->addVar('category_options','selected','selected');	
			} else {
				$tmpl->addVar('category_options','selected','');
			}
			$tmpl->parseTemplate('category_options','a');
		}	
		
		
		$control['cur_view'] = date("F Y", $selectedTime);
		$control['cur_month'] = $selected->getMonth();
		$control['cur_year'] = $selected->getYear();
		$control['prev_month'] = (intval($selected->getMonth())-1 > 0) ? intval($selected->getMonth())-1 : 12;
		$control['prev_month_year'] = ($control['prev_month'] == 12) ? intval($selected->getYear()) - 1 : $selected->getYear();
		$control['next_month'] = (intval($selected->getMonth())+1 < 13) ? intval($selected->getMonth())+1 : 1;
		$control['next_month_year'] = ($control['next_month'] == 1) ? intval($selected->getYear()) + 1 : $selected->getYear();
		
		// page title
		$mainframe->setPageTitle("Calendar of Events | ". $control['cur_view']);
		
		// add the menu marker
		if (isset($_REQUEST['ccmenu'])) {
			$control['ccmenu'] = $_REQUEST['ccmenu'];	
		}
		
		$cal_link = $this->cceventSefUrl('index.php?option=com_ccevents&scope=cldr&task=month&month='. $selected->getMonth() .'&year='. $selected->getYear());
        $tmpl->addVar('calendar','cal_view_link',$cal_link);
		
		$tmpl->addVars('calendar',$control);
	 }
	
	
	
	 
	/**
	 * Returns a timestamp object for the given
	 * month yean and day.  If no day is given,
	 * the first day of the month will be assumed.
	 * 
	 * @param string $month 2-digit month value
	 * @param string $year 4-digit year value
	 * @param string $day optional 2-digit day value 
	 */
	function getTimestamp($month, $year, $day=null)
	{
		$day = ($day) ? $day : 1;
		return mktime(0,0,0,$month,$day,$year);
	}

	/**
	 * Returns the formatted month view array.  An array
	 * position will be created for each square in the 
	 * grid regardless of whether it has a date or
	 * any entries.
	 * 
	 * @access private
	 * @param string $selectedTime a timestamp representation of the given month
	 * @param array an optional list of scheduled events/activities
	 * @param boolean should the grid start on monday instead of sunday
	 * @return array The populated month grid
	 */
	function setMonthGrid($selectedTime, $list=null, $mondayStart=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setMonthGrid($selectedTime, $list)");

		$grid = array();
		$month = date("n",$selectedTime);
		$year = date("Y",$selectedTime);

		$date = mktime(12, 0, 0, $month, 1, $year);
		$daysInMonth = date("t", $date);
		$today = time();

		
		// calculate the position of the first day in the calendar (sunday = 1st column, etc)
		$weekday = date("w", $date);
		$offset = ($mondayStart) ? ($weekday - 1 < 0) ? 6 : $weekday - 1 : $weekday;
		$masterindex = 0;
		
		// add the padding
		for($i=1; $i<= $offset; $i++) {
			$grid[$masterindex] = array();
			$grid[$masterindex]['today'] = "no";
			$grid[$masterindex]['date'] = "none";
			$grid[$masterindex]['past'] = false;
			$masterindex++;
		}
		
		// add the days
		for($day = 1; $day <= $daysInMonth; $day++) {
			$startDay = mktime(12, 0, 0, $month, $day, $year);
			$endDay = mktime(23, 59, 59, $month, $day, $year);
		    $grid[$masterindex] = array();
			$grid[$masterindex]['today'] = ($startDay < $today && $today < $endDay) ? 'yes' : 'no';
			$grid[$masterindex]['date'] = $day;
			$grid[$masterindex]['past'] = ($today > $endDay) ? true : false;
			$masterindex++;
		}
		
		// add the end padding
		 while( $masterindex%7 != 0) {
	        $grid[$masterindex] = array();
			$grid[$masterindex]['today'] = "no";
			$grid[$masterindex]['date'] = "none";
			$grid[$masterindex]['past'] = false;
			$masterindex++;
	    }
	    
	    return $grid;
	}
	
	/**
	 * A convenience method to set the required flags in the
	 * request object for the template renderer.
	 * @param string $subtype The string representation of the subtype ('general'/'text')
	 */
	function setRequestFlags($subtype=null)
	{	
		$subtype = ($subtype) ? $subtype : 'general';
		
		$_REQUEST['cce_cols'] = '1';
		$_REQUEST['cce_scope'] = 'programs';
		$_REQUEST['cce_page'] = 'calendar';	
		$_REQUEST['cce_subtype'] = $subtype;	
	}
}
 
?>

