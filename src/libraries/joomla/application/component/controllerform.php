<?php
/**
 * @version		$Id: controllerform.php 18214 2010-07-22 06:32:52Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

// @TODO Add ability to set redirect manually to better cope with frontend usage.

/**
 * Controller tailored to suit most form-based admin operations.
 *
 * @package		Joomla.Framework
 * @subpackage	Application
 * @since		1.6
 */
class JControllerForm extends JController
{
	/**
	 * @var string	The context for storing internal data, eg record.
	 * @since	1.6
	 */
	protected $context;

	/**
	 * @var	string	The URL option for the component.
	 * @since	1.6
	 */
	protected $option;

	/**
	 * @var	string	The URL view item variable.
	 * @since	1.6
	 */
	protected $view_item;

	/**
	 * @var	string	The URL view list variable.
	 * @since	1.6
	 */
	protected $view_list;

	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix;

	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		// Guess the option as com_NameOfController
		if (empty($this->option)) {
			$this->option = 'com_'.strtolower($this->getName());
		}

		// Guess the JText message prefix. Defaults to the option.
		if (empty($this->text_prefix)) {
			$this->text_prefix = strtoupper($this->option);
		}

		// Guess the context as the suffix, eg: OptionControllerContent.
		if (empty($this->context)) {
			$r = null;
			if (!preg_match('/(.*)Controller(.*)/i', get_class($this), $r)) {
				JError::raiseError(500, JText::_('JLIB_APPLICATION_ERROR_CONTROLLER_GET_NAME'));
			}
			$this->context = strtolower($r[2]);
		}

		// Guess the item view as the context.
		if (empty($this->view_item)) {
			$this->view_item = $this->context;
		}

		// Guess the list view as the plural of the item view.
		if (empty($this->view_list)) {
			// @TODO Probably worth moving to an inflector class based on http://kuwamoto.org/2007/12/17/improved-pluralizing-in-php-actionscript-and-ror/

			// Simple pluralisation based on public domain snippet by Paul Osman
			// For more complex types, just manually set the variable in your class.
			$plural = array(
				array( '/(x|ch|ss|sh)$/i',		"$1es"),
				array( '/([^aeiouy]|qu)y$/i',	"$1ies"),
				array( '/([^aeiouy]|qu)ies$/i',	"$1y"),
				array( '/(bu)s$/i',				"$1ses"),
				array( '/s$/i',					"s"),
				array( '/$/',					"s")
			);

			// check for matches using regular expressions
			foreach ($plural as $pattern) {
				if (preg_match($pattern[0], $this->view_item)) {
					$this->view_list = preg_replace( $pattern[0], $pattern[1], $this->view_item);
					break;
				}
			}
		}

		// Apply, Save & New, and Save As copy should be standard on forms.
		$this->registerTask('apply',		'save');
		$this->registerTask('save2new',		'save');
		$this->registerTask('save2copy',	'save');
	}

	/**
	 * Method to add a new record.
	 */
	public function add()
	{
		// Initialise variables.
		$app		= JFactory::getApplication();
		$context	= "$this->option.edit.$this->context";

		$tmpl		= JRequest::getString('tmpl');
		$layout		= JRequest::getString('layout', 'edit');
		$append		= '';

		// Setup redirect info.
		if ($tmpl) {
			$append .= '&tmpl='.$tmpl;
		}
		if ($layout) {
			$append .= '&layout='.$layout;
		}

		// Access check.
		if (!$this->allowAdd()) {
			$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));
			return JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_CREATE_RECORD_NOT_PERMITTED'));
		}

		// Clear the record edit information from the session.
		$app->setUserState($context.'.id', null);
		$app->setUserState($context.'.data', null);

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_item.$append, false));
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param	array	An array of input data.
	 *
	 * @return	boolean
	 */
	protected function allowAdd($data = array())
	{
		return JFactory::getUser()->authorise('core.create', $this->option);
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param	array	An array of input data.
	 * @param	string	The name of the key for the primary key.
	 *
	 * @return	boolean
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		return JFactory::getUser()->authorise('core.edit', $this->option);
	}

	/**
	 * Method to check if you can save a new or existing record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param	array	An array of input data.
	 * @param	string	The name of the key for the primary key.
	 *
	 * @return	boolean
	 */
	protected function allowSave($data, $key = 'id')
	{
		// Initialise variables.
		$recordId	= isset($data[$key]) ? $data[$key] : '0';

		if ($recordId) {
			return $this->allowEdit($data, $key);
		} else {
			return $this->allowAdd($data);
		}
	}

	/**
	 * Method to cancel an edit
	 */
	public function cancel()
	{
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app		= JFactory::getApplication();
		$model		= $this->getModel();
		$table		= $model->getTable();
		$checkin	= property_exists($table, 'checked_out');
		$context	= "$this->option.edit.$this->context";
		$tmpl		= JRequest::getString('tmpl');
		$layout		= JRequest::getString('layout', 'edit');
		$append		= '';

		// Setup redirect info.
		if ($tmpl) {
			$append .= '&tmpl='.$tmpl;
		}
		if ($layout) {
			$append .= '&layout='.$layout;
		}

		// Get the record id.
		$recordId = (int) $app->getUserState($context.'.id');

		// Attempt to check-in the current record.
		if ($checkin && $recordId) {
			if(!$model->checkin($recordId)) {
				// Check-in failed, go back to the record and display a notice.
				$message = JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError());
				$this->setRedirect('index.php?option='.$this->option.'&view='.$this->view_item.$append, $message, 'error');
				return false;
			}
		}

		// Clean the session data and redirect.
		$app->setUserState($context.'.id',		null);
		$app->setUserState($context.'.data',	null);
		$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));
	}

	/**
	 * This controller does not have a display method. Redirect back to the list view of the component.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	void
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));
	}

	/**
	 * Method to edit an existing record.
	 */
	public function edit()
	{
		// Initialise variables.
		$app		= JFactory::getApplication();
		$model		= $this->getModel();
		$table		= $model->getTable();
		$cid		= JRequest::getVar('cid', array(), 'post', 'array');
		$context	= "$this->option.edit.$this->context";
		$tmpl		= JRequest::getString('tmpl');
		$layout		= JRequest::getString('layout', 'edit');
		$append		= '';

		// Setup redirect info.
		if ($tmpl) {
			$append .= '&tmpl='.$tmpl;
		}
		if ($layout) {
			$append .= '&layout='.$layout;
		}

		// Get the previous record id (if any) and the current record id.
		$previousId	= (int) $app->getUserState($context.'.id');
		$recordId	= (int) (count($cid) ? $cid[0] : JRequest::getInt('id'));
		$checkin	= property_exists($table, 'checked_out');

		// Access check.
		$key		= $table->getKeyName();
		if (!$this->allowEdit(array($key => $recordId), $key)) {
			$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));
			return JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
		}

		// If record ids do not match, checkin previous record.
		if ($checkin && ($previousId > 0) && ($recordId != $previousId)) {
			if (!$model->checkin($previousId)) {
				// Check-in failed, go back to the record and display a notice.
				$message = JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError());
				$this->setRedirect('index.php?option='.$this->option.'&view='.$this->view_item.$append, $message, 'error');
				return false;
			}
		}

		// Attempt to check-out the new record for editing and redirect.
		if ($checkin && !$model->checkout($recordId)) {
			// Check-out failed, go back to the list and display a notice.
			$message = JText::sprintf('JLIB_APPLICATION_ERROR_CHECKOUT_FAILED', $model->getError());
			$this->setRedirect('index.php?option='.$this->option.'&view='.$this->view_item.$append.'&id='.$recordId, $message, 'error');
			return false;
		} else {
			// Check-out succeeded, push the new record id into the session.
			$app->setUserState($context.'.id',	$recordId);
			$app->setUserState($context.'.data', null);
			$this->setRedirect('index.php?option='.$this->option.'&view='.$this->view_item.$append);
			return true;
		}
	}

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param	string	The model name. Optional.
	 * @param	string	The class prefix. Optional.
	 * @param	array	Configuration array for model. Optional.
	 *
	 * @return	object	The model.
	 */
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		if (empty($name)) {
			$name = $this->context;
		}

		return parent::getModel($name, $prefix, $config);
	}

	/**
	 * Function that allows child controller access to model data after the data has been saved.
	 *
	 * @param	JModel	$model	The data model object.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function postSaveHook(JModel &$model)
	{
	}

	/**
	 * Method to save a record.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function save()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app		= JFactory::getApplication();
		$lang		= JFactory::getLanguage();
		$model		= $this->getModel();
		$table		= $model->getTable();
		$data		= JRequest::getVar('jform', array(), 'post', 'array');
		$checkin	= property_exists($table, 'checked_out');
		$context	= "$this->option.edit.$this->context";
		$task		= $this->getTask();
		$recordId	= (int) $app->getUserState($context.'.id');
		$tmpl		= JRequest::getString('tmpl');
		$layout		= JRequest::getString('layout', 'edit');
		$append		= '';

		// Setup redirect info.
		if ($tmpl) {
			$append .= '&tmpl='.$tmpl;
		}
		if ($layout) {
			$append .= '&layout='.$layout;
		}

		// Populate the row id from the session.
		$key		= $table->getKeyName();
		$data[$key] = $recordId;

		// The save2copy task needs to be handled slightly differently.
		if ($task == 'save2copy') {
			// Check-in the original row.
			if ($checkin  && !$model->checkin($data[$key])) {
				// Check-in failed, go back to the item and display a notice.
				$message = JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError());
				$this->setRedirect('index.php?option='.$this->option.'&view='.$this->view_item.$append, $message, 'error');
				return false;
			}

			// Reset the ID and then treat the request as for Apply.
			$data['id']	= 0;
			$task		= 'apply';
		}

		// Access check.
		if (!$this->allowSave($data)) {
			$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));
			return JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'));
		}

		// Validate the posted data.
		// Sometimes the form needs some posted data, such as for plugins and modules.
		$form = $model->getForm($data, false);

		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		// Test if the data is valid.
		$validData = $model->validate($form, $data);

		// Check for validation errors.
		if ($validData === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if (JError::isError($errors[$i])) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'notice');
				} else {
					$app->enqueueMessage($errors[$i], 'notice');
				}
			}

			// Save the data in the session.
			$app->setUserState($context.'.data', $data);

			// Redirect back to the edit screen.
			$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_item.$append, false));
			return false;
		}

		// Attempt to save the data.
		if (!$model->save($validData)) {
			// Save the data in the session.
			$app->setUserState($context.'.data', $validData);

			// Redirect back to the edit screen.
			$this->setMessage(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()), 'notice');
			$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_item.$append, false));
			return false;
		}

		// Save succeeded, check-in the record.
		if ($checkin && !$model->checkin($validData[$key])) {
			// Save the data in the session.
			$app->setUserState($context.'.data', $validData);

			// Check-in failed, go back to the record and display a notice.
			$message = JText::sprintf('JError_Checkin_saved', $model->getError());
			$this->setRedirect('index.php?option='.$this->option.'&view='.$this->view_item.$append, $message, 'error');
			return false;
		}

		$this->setMessage(JText::_(($lang->hasKey($this->text_prefix.'_SAVE_SUCCESS') ? $this->text_prefix : 'JLIB_APPLICATION') .  '_SAVE_SUCCESS'));

		// Redirect the user and adjust session state based on the chosen task.
		switch ($task) {
			case 'apply':
				// Set the record data in the session.
				$app->setUserState($context.'.id',		$model->getState($this->context.'.id'));
				$app->setUserState($context.'.data',	null);

				// Redirect back to the edit screen.
				$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_item.$append, false));
				break;

			case 'save2new':
				// Clear the record id and data from the session.
				$app->setUserState($context.'.id', null);
				$app->setUserState($context.'.data', null);

				// Redirect back to the edit screen.
				$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_item.$append, false));
				break;

			default:
				// Clear the record id and data from the session.
				$app->setUserState($context.'.id', null);
				$app->setUserState($context.'.data', null);

				// Redirect to the list screen.
				$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));
				break;
		}

		// Invoke the postSave method to allow for the child class to access the model.
		$this->postSaveHook($model);

		return true;
	}
}
