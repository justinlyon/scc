<?php
/**
 * Exhibition Controller for the CCEvents Component
 * 
 * @package    CCEvents
 * @subpackage Components
 * @license     GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * CCEvents Exhibition Controller
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsControllerExhibition extends CCeventsController
{
    /**
     * constructor (registers additional tasks to methods)
     * @return void
     */
    function __construct()
    {
        parent::__construct();

        // Register Extra tasks
        $this->registerTask( 'add'  ,   'edit' );
    }

    function execute($task=null)
    {
    	JRequest::setVar( 'view', 'exhibitions' );
    	parent::execute($task);
    }
    /**
     * display the edit form
     * @return void
     */
    function edit()
    {
        JRequest::setVar( 'view', 'exhibition' );
        JRequest::setVar( 'layout', 'form'  );
        JRequest::setVar('hidemainmenu', 1);
        parent::display();
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    function save()
    {
        $model = $this->getModel('exhibition');

        if ($model->store($post)) {
            $msg = JText::_( 'Exhibition Saved!' );
        } else {
            $msg = JText::_( 'Error Saving Exhibition' );
        }

        // Check the table in so it can be edited.... we are done with it anyway
        $link = 'index.php?option=com_ccevents';
        $this->setRedirect($link, $msg);
    }

    /**
     * remove record(s)
     * @return void
     */
    function remove()
    {
        $model = $this->getModel('exhibition');
        if(!$model->delete()) {
            $msg = JText::_( 'Error: One or More Exhibitions Could not be Deleted' );
        } else {
            $msg = JText::_( 'Exhibition(s) Deleted' );
        }

        $this->setRedirect( 'index.php?option=com_ccevents', $msg );
    }

    /**
     * cancel editing a record
     * @return void
     */
    function cancel()
    {
        $msg = JText::_( 'Operation Cancelled' );
        $this->setRedirect( 'index.php?option=com_ccevents&scope=exbt', $msg );
    }
}