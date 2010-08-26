<?php 
/**
 *  $Id$: 
 *  Copyright (c) 2008, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
 // Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.controller');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ccevents'.DS.'WEB-INF'.DS.'base.include.php');
require_once(WEB_INF.DS.'actions'.DS.'FrontCalendarAction.php');

class CCEventsCalendarController extends JController
{
	
	function execute()
	{
		$this->month();	
	}
	
	
        /**
         * Builds the model for the list view
         */
        function events()
        {
                global $mainframe;
                $action = new FrontCalendarAction();
                $model = $action->events($mainframe);

                // Create the view
                $view =& $this->getView('calendar', 'html');
                $view->setModel($model);

                if (isset($_REQUEST['layout'])) {
                        $view->setLayout($_REQUEST['layout']);
                }
		else {
			$view->setLayout("events");
		}

                // Display the view
                $view->events();
        }


	/**
	 * Builds the model for the month view
	 */
	function month()
	{
		global $mainframe;
		$action = new FrontCalendarAction();
		$model = $action->month($mainframe);

		// Create the view
		$view =& $this->getView('calendar', 'html');
		$view->setModel($model);
		
		if (isset($_REQUEST['layout'])) {
			$view->setLayout($_REQUEST['layout']);	
		}
		
		// Display the view
		$view->month();
	}
	
	/**
	 * Builds the model for the month view
	 */
	function feed()
	{
		global $mainframe;
		$action = new FrontCalendarAction();
		$model = $action->feed($mainframe);

		// Create the view
		$view =& $this->getView('calendar', 'html');
		$view->setModel($model);
		
		$layout = (isset($_REQUEST['layout'])) ? $_REQUEST['layout'] : 'rss2';
		$view->setLayout($layout);
		
		// Display the view
		$view->feed();
	}
	
}
