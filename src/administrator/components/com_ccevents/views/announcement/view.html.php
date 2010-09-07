<?php
/**
 * Announcement View for CCEvents Component
 * 
 * @package     CCEvents
 * @subpackage  Components
 * @license     GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Announcement View
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsViewAnnouncement extends JView
{
    /**
     * Announcement view display method
     * @return void
     **/
    function display($tpl = null)
    {
        //get the announcement
        $announcement =& $this->get('Data');
        $isNew      = ($announcement->eoid < 1);

        $text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
        JToolBarHelper::title(   JText::_( 'Announcement' ).': <small><small>[ ' . $text.' ]</small></small>' );
        JToolBarHelper::save();
        if ($isNew)  {
            JToolBarHelper::cancel();
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::cancel( 'cancel', 'Close' );
        }

        $this->assignRef('announcement', $announcement);

        parent::display($tpl);
    }
	}