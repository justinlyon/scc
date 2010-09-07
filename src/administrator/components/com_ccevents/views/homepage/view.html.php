<?php
/**
 * HomePage View for CCEvents Component
 * 
 * @package     CCEvents
 * @subpackage  Components
 * @license     GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * HomePage View
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsViewHomePage extends JView
{
    /**
     * HomePage view display method
     * @return void
     **/
    function display($tpl = null)
    {
        //get the homepage
        $homepage =& $this->get('Data');
        $isNew      = ($homepage->eoid < 1);

        $text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
        JToolBarHelper::title(   JText::_( 'HomePage' ).': <small><small>[ ' . $text.' ]</small></small>' );
        JToolBarHelper::save();
        if ($isNew)  {
            JToolBarHelper::cancel();
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::cancel( 'cancel', 'Close' );
        }

        $this->assignRef('homepage', $homepage);

        parent::display($tpl);
    }
	}