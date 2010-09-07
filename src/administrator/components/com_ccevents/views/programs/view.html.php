<?php
/**
 * Programs View for CCEvents Component
 * 
 * @package     CCEvents
 * @subpackage  Components
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Programs View
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsViewPrograms extends JView
{
	/**
	 * Programs view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title( JText::_( 'Program Manager' ), 'generic.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Get data from the model
		$items = & $this->get( 'Data');

		$this->assignRef('items', $items);

		parent::display($tpl);
	}
}