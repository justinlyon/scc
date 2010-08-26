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
require_once(WEB_INF.DS.'actions'.DS.'FrontExhibitionAction.php');

/**
 * This controller class is a half-way step to Joomla 1.5 native compatibility
 * It reuses the FrontExhibitionAction class to beuild the model, then
 * passes it to the Joomla 1.5 view engine
 */
class CCEventsExhibitionController extends JController
{
	public $action;
	
	
	function execute()
	{
		$this->summary();	
	}
	
	function summary()
	{
                global $mainframe;
                $action = new FrontExhibitionAction();
                $model = $action->summary($mainframe);

                // Create the view
                $view = & $this->getView('exhibition', 'html');
                $view->setModel($model);

		// Set the layout
		$view->setLayout('summary');
		
                // Display the view
                $view->summary();
	}
	
	
	function current()
	{
		global $mainframe;
		$action = new FrontExhibitionAction();
		$model = $action->current($mainframe);

		// Create the view
		$view = & $this->getView('exhibition', 'html');
		$view->setModel($model);
		
		// Display the view
		$view->current();
	}

	function special()
	{
		global $mainframe;
		$action = new FrontExhibitionAction();
		$model = $action->special($mainframe);

		// Create the view
		$view = & $this->getView('exhibition', 'html');
		$view->setModel($model);
		
		// Display the view
		$view->special();
	}

	function ongoing()
	{
		global $mainframe;
		$action = new FrontExhibitionAction();
		$model = $action->ongoing($mainframe);

		// Create the view
		$view = & $this->getView('exhibition', 'html');
		$view->setModel($model);
		
		// Display the view
		$view->ongoing();
	}

	function upcoming()
	{
		global $mainframe;
		$action = new FrontExhibitionAction();
		$model = $action->upcoming($mainframe);

		// Create the view
		$view = & $this->getView('exhibition', 'html');
		$view->setModel($model);
		
		// Display the view
		$view->upcoming();
	}

	function past()
	{
		global $mainframe;
		$action = new FrontExhibitionAction();
		$model = $action->past($mainframe);

		// Create the view
		$view = & $this->getView('exhibition', 'html');
		$view->setModel($model);
		
		// Display the view
		$view->past();
	}


	function detail()
	{
		global $mainframe;
		$action = new FrontExhibitionAction();
		$model = $action->detail($mainframe);
		
		// Create the view
		$view = & $this->getView('exhibition', 'html');
		$view->setModel($model);
		
		// Set the layout
		$view->setLayout('detail');
		
		// Display the view
		$view->detail();
	}	
	
	function highlight()
	{		
		global $mainframe;
		$action = new FrontExhibitionAction();
		$model = $action->highlight($mainframe);
		
		// Create the view
		$view = & $this->getView('exhibition', 'html');
		$view->setModel($model);
		
		// Set the layout
		$view->setLayout('highlight');
		
		// Display the view
		$view->highlight();
	}


	function artist()
	{		
		global $mainframe;
		$action = new FrontExhibitionAction();
		$model = $action->artist($mainframe);
		
		// Create the view
		$view = & $this->getView('exhibition', 'html');
		$view->setModel($model);
		
		// Set the layout
		$view->setLayout('artist');
		
		// Display the view
		$view->artist();
	}	
	
	/**
	 * Returns the action
	 * @return action 
	 */
	function getAction()
	{
		return $this->action;
	}
	
	/**
	 * Sets the action in the class attributes
	 * @param action
	 * @return void
	 */		
	function setAction($action)
	{
		$this->action = $action;
	}
}
?>
