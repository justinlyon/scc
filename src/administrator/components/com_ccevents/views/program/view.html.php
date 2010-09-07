<?php
/**
 * Program View for CCEvents Component
 * 
 * @package     CCEvents
 * @subpackage  Components
 * @license     GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Program View
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsViewProgram extends JView
{
    /**
     * Program view display method
     * @return void
     **/
    function display($tpl = null)
    {
        //get the program
        $program =& $this->get('Data');
        $isNew      = ($program->eoid < 1);

        $text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
        JToolBarHelper::title(   JText::_( 'Program' ).': <small><small>[ ' . $text.' ]</small></small>' );
        JToolBarHelper::save();
        if ($isNew)  {
            JToolBarHelper::cancel();
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::cancel( 'cancel', 'Close' );
        }

        $this->assignRef('program', $program);

        parent::display($tpl);
    }
	}