<?php
/**
 * Calendar View for CCEvents Component
 * 
 * @package    joomla
 * @subpackage ccevents
 */

jimport( 'joomla.application.component.view');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ccevents'.DS.'WEB-INF'.DS.'base.include.php');
require_once(WEB_INF.DS.'pages'.DS.'FrontCalendarPage.php');

class CCEventsCalendarViewCalendar extends JView
{
	function events($tpl = null)
	{
		$fcp = new FrontCalendarPage();

                $model =& $this->getModel();
                $options = $model->getOptions();
                $this->assignRef('options',$options);
		$events = $model->getList();
		$miniCal = array_shift($events);
                $list = $fcp->formatEntries($events);
                $this->assignRef('events',$list);
                $this->assignRef('miniCal',$miniCal);

		$heading = "Events Calendar". $this->cur_view;
		$document =& JFactory::getDocument();
		$document->setTitle($heading);
		$this->assignRef('heading',$heading);

		parent::display($tpl);
        }

	function month($tpl = null)
	{	
		$fcp = new FrontCalendarPage();
		
		$model =& $this->getModel();
		$this->assignRef('highlights',$model->getAnnouncement());		
		
		$list = $fcp->formatEntries($model->getList());
		$selected = $model->getSelected(); 
		$this->assignRef('selected',$selected);
		
		$options = $model->getOptions();
		$this->assignRef('options',$options);		
		
		$selectedTime = CalendarForm::getMonthStart($selected);
		$mondayStart = true;
		$grid = $fcp->setMonthGrid($selectedTime,$list,$mondayStart);
		$this->assignRef('grid',$grid);
		
		$this->assignRef('weekday', date("w"));
		$this->assignRef('events',$list);

		$curview = date("F Y", $selectedTime);
		$curmonth = $selected->getMonth();
		$curyear = $selected->getYear();
		$prevmonth = (intval($selected->getMonth())-1 > 0) ? intval($selected->getMonth())-1 : 12;
		$prevyear = ($prevmonth == 12) ? intval($selected->getYear()) - 1 : $selected->getYear();
		$nextmonth = (intval($selected->getMonth())+1 < 13) ? intval($selected->getMonth())+1 : 1;
		$nextyear = ($nextmonth == 1) ? intval($selected->getYear()) + 1 : $selected->getYear();

		$this->assignRef('cur_view', $curview);
		$this->assignRef('cur_month',$curmonth);
		$this->assignRef('cur_year', $curyear );
		$this->assignRef('prev_month', $prevmonth );
		$this->assignRef('prev_year', $prevyear );
		$this->assignRef('next_month', $nextmonth );
		$this->assignRef('next_year', $nextyear );
		
		$heading = "Calendar of Events: ". $this->cur_view;
		$document =& JFactory::getDocument();
		$document->setTitle($heading);

		parent::display($tpl);
	}
	
	function feed($tpl = null)
	{	
		$fcp = new FrontCalendarPage();
		
		$model =& $this->getModel();		
		$list = $fcp->formatEntries($model->getList());	
		$this->assignRef('events',$list);

		parent::display($tpl);
	}
	
}
