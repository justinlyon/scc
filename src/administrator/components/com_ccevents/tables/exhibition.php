<?php
/**
 * CCevents table class
 * 
 * @package    CCEvents
 * @subpackage Components
 * @license     GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once dirname(__FILE__) . '/event.php';

/**
 * Exhibition Table
 *
 * Extends Event to provide user-defined sorting features.
 *
 * @author     Justin Lyon <justin.lyon@gmail.com>
 * @package    CCEvents
 * @subpackage Components
 */
class TableExhibition extends TableEvent
{
    /**
     * Related programs
     * 
     * @var Program
     * @orm has many Program inverse(exhibitions)
     */
    public $programs;        

    /**
     * Related courses
     * 
     * @var Course
     * @orm has many Course inverse(exhibitions)
     */
    public $courses;  
    
    /**
     * Related artists
     * 
     * @var Artist
     * @orm has many Artist inverse(exhibitions)
     */
    public $artists; 
    
    /**
     * Related Artist Objects (stored in the artist's gallery)
     * 
     * @var String (comma separated list of g2 image ids)
     * @orm char(255)
     */
    public $artifacts;

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function TableExhibition(& $db) {
        parent::__construct('#__cce_exhibition', 'eoid', $db);
    }
   
    /**
     * A convenience methon that returns the first venue in the venues list.
     *
     * @return Venue
     */
    public function getDefaultVenue()
    {
        if (is_array($this->venues) && count($this->venues) > 0)
           return $this->venues[0];
        return "";
    }
}