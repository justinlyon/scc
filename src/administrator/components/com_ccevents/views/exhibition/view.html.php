<?php
/**
 * Exhibition View for CCEvents Component
 * 
 * @package     CCEvents
 * @subpackage  Components
 * @license     GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Exhibition View
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsViewExhibition extends JView
{
    /**
     * Exhibition view display method
     * @return void
     **/
    function display($tpl = null)
    {
        //get the exhibition
        $exhibition =& $this->get('Data');
        $isNew      = ($exhibition->eoid < 1);

        $text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
        JToolBarHelper::title(   JText::_( 'Exhibition' ).': <small><small>[ ' . $text.' ]</small></small>' );
        JToolBarHelper::save();
        if ($isNew)  {
            JToolBarHelper::cancel();
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::cancel( 'cancel', 'Close' );
        }

        $this->assignRef('exhibition', $exhibition);

        parent::display($tpl);
    }
	}