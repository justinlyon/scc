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
require_once(WEB_INF.DS.'actions'.DS.'FrontSeriesAction.php');

/**
 * This controller class is a half-way step to Joomla 1.5 native compatibility
 * It reuses the FrontSeriesAction class to beuild the model, then
 * passes it to the Joomla 1.5 view engine
 */
class CCEventsSeriesController extends JController
{
	public $action;
	
	
	function execute()
	{
		$this->summary();	
	}
	
	
	function featured()
	{
		$action = new FrontSeriesAction();
		$model = $action->featured();

		// Display the view
		$view =& $this->getView('program', 'html');
		$view->setModel($model);
		$view->setLayout("featured");
		$view->featured();
	}
	
	function summary()
	{
		$action = new FrontSeriesAction();
		$model = $action->summary();
	
		// Display the view
		$view =& $this->getView('series', 'html');
		$view->setModel($model);
		$view->setLayout("summary");
		$view->summary();
	}


	function detail()
	{
		global $mainframe;
		$action = new FrontSeriesAction();
		$model = $action->detail($mainframe);
		
		// Create the view
		$view = & $this->getView('program', 'html');
		$view->setModel($model);
		
		// Set the layout
		$view->setLayout('detail');
		
		// Display the view
		$view->detail();
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
