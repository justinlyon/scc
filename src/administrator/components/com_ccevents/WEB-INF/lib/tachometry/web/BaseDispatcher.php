<?php
/*
 *  $Id: BaseDispatcher.php 501 2008-12-11 20:08:24Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

if (!defined('HORDE_BASE')) {
    @define('HORDE_BASE', dirname(__FILE__) . '/../../Horde');
}
require_once HORDE_BASE . '/Horde.php';
require_once HORDE_BASE . '/Horde/Timer.php';

require_once 'BaseAction.php';
require_once 'BasePage.php';

/**
 * This class defines the standard MVC dispatch semantics used by web
 * applications in various frameworks (e.g. Joomla, Horde, php.MVC, etc.).
 *
 * Extend this class and implement the abstract methods
 * required to identify the action class and method.
 */
abstract class BaseDispatcher
{
	// framework-specific object passed via execute(...)
	private $param = null;

	// name of the target method for the action/page invocation
	private $task = null;

	// scope name for an action redirect
	private $redirect = null;

	// shared array for storing application timers
	public $timers = array();

	/**
	 * Create a Dispatcher instance
	 * @param mixed A framework-specific argument for the execute(...) method
	 */
	public function __construct($arg=null){
		$this->param = $arg;
	}

	/**
	 * Creates an instance of the appropriate action class
	 * then invokes the "execute" method on the instance. An optional
	 * framework parameter may be delegated to the action. If
	 * the Action implements a method matching the given task, it
	 * will be invoked rather than the "execute" method.
	 *
	 * The return value from the Action will be passed to a
	 * corresponding Page instance (created in the same manner) via
	 * its "render" method. The given task may override the target
	 * method as described above.
	 *
	 * If the Dispatcher instance is visible in global scope, the Action
	 * implementation may dynamically override the task method for the
	 * subsequent Page invocation as follows:
	 * <pre>
	 *     global $dispatcher;
	 *     $dispatcher->setTask('pageTask');
	 * </pre>
	 *
	 * @param String $scope	 A key for finding the action/page prefix
	 * @param String $task An optional target method to invoke
 	 */
	public function dispatch($scope, $task=null)
	{
		$timer = Horde_Timer::singleton();
		$timer->push(); 	// overall timer for action+page
		$this->setTask($task);
		$this->setRedirect(null);
        $action = $this->getAction($scope);
        if (!is_subclass_of($action, 'BaseAction')) {
			trigger_error("Invalid Action class: get_class($action)", E_USER_ERROR);
			return;
		}
		$bean = null;
		$method = $this->getTask();
		$timer->push(); 	// timer for action
		if (!empty($method) && in_array($method, get_class_methods($action))) {
			$bean = $action->$method($this->param);
		} else {
			$bean = $action->execute($this->param);
		}
		$this->timers[$scope . ':action'] = $timer->pop();

		if ($this->getRedirect() == null || ($scope == $this->getRedirect() && $task == $this->getTask())) {
			$page = $this->getPage($scope);
			if (!is_subclass_of($page, 'BasePage')) {
				trigger_error("Invalid Page class: get_class($action)", E_USER_ERROR);
				return;
			}
			$method = $this->getTask();
			$timer->push(); 	// timer for page
			if (!empty($method) && in_array($method, get_class_methods($page))) {
				$page->$method($bean);
			} else {
				$page->render($bean);
			}
			$this->timers[$scope . ':page'] = $timer->pop();
		} else {
			$this->dispatch($this->getRedirect(), $this->getTask());
		}
		$this->timers[$scope . ':overall'] = $timer->pop();
      Horde::logMessage("Dispatcher timing (ms) for $scope [$this->task]: " . print_r($this->timers, true), __FILE__, __LINE__, PEAR_LOG_DEBUG);
	}

	/**
	 * Set the invocation target method name for this instance
	 */
	public function setTask($task)
	{
		$this->task = $task;
	}

	/**
	 * Returns the invocation target method name for this instance
	 */
	public function getTask()
	{
		return $this->task;
	}

	/**
	 * Set the redirect scope name for this instance
	 */
	public function setRedirect($scope)
	{
		$this->redirect = $scope;
	}

	/**
	 * Returns the redirect scope name for this instance
	 */
	public function getRedirect()
	{
		return $this->redirect;
	}

	/**
	 * Load the action class corresponding to the given scope
	 * and return an instance for the action
	 * @param String $scope	The action key
	 * @return Action The instance of the action for the given scope
	 */
	public abstract function getAction($scope);

	/**
	 * Load the page class corresponding to the given scope
	 * and return an instance for the page
	 * @param String $scope	The page key
	 * @return Page The instance of the page for the given scope
	 */
	public abstract function getPage($scope);
}

?>
