<?php
/**
 * HomePages View for CCEvents Component
 * 
 * @package     CCEvents
 * @subpackage  Components
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * HomePages View
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsViewHomePages extends JView
{
	/**
	 * HomePages view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title( JText::_( 'HomePage Manager' ), 'generic.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Get data from the model
		$items = & $this->get( 'Data');

		$this->assignRef('items', $items);

		parent::display($tpl);
	}
}