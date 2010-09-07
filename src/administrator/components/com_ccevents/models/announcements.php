<?php
/**
 * Announcements Model for CCEvents Component
 * 
 * @package    CCEvents
 * @subpackage Components
 * @license     GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Announcements Model
 *
 * @package    CCEvents
 * @subpackage Components
 */
class CCEventsModelAnnouncements extends JModel
{
    /**
     * Announcements data array
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
        $query = ' SELECT eoid, scope, published '
            . ' FROM #__cce_announcement '
        ;

        return $query;
    }

    /**
     * Retrieves the announcement data
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