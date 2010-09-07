<?php
/**
 * HomePages Model for CCEvents Component
 * 
 * @package    CCEvents
 * @subpackage Components
 * @license     GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * HomePages Model
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsModelHomePages extends JModel
{
    /**
     * HomePages data array
     *
     * @var array
     */
    var $_data;


    /**
     * Returns the query
     * @return string The query to be used to retrieve the rows from the database
     */
    function _buildQuery()
    {
        $query = ' SELECT eoid, name, startTime '
            . ' FROM #__cce_homepage '
        ;

        return $query;
    }

    /**
     * Retrieves the homepage data
     * @return array Array of objects containing the data from the database
     */
    function getData()
    {
        // Lets load the data if it doesn't already exist
        if (empty( $this->_data ))
        {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList( $query );
        }

        return $this->_data;
    }
}