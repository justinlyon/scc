<?php
/**
 * Exhibition View for CCEvents Component
 *
 * @package    joomla
 * @subpackage ccevents
 */

jimport( 'joomla.application.component.view');


class CCEventsExhibitionViewExhibition extends JView
{
	function summary($tpl = null)
	{
		$heading = "Exhibitions";
		$document =& JFactory::getDocument();
		$document->setTitle($heading);

		$model =& $this->getModel();
		$this->assignRef('events',$model->getList());
		$this->assignRef('announcement', $model->getAnnouncement());
		$this->assignRef('heading',$heading);

		parent::display($tpl);
	}

	function current($tpl = null)
	{
		$heading = "Current Exhibitions";
		$document =& JFactory::getDocument();
		$document->setTitle($heading);

		$model =& $this->getModel();
		$this->assignRef('events',$model->getList());
		$this->assignRef('announcement', $model->getAnnouncement());
		$this->assignRef('heading',$heading);

		parent::display($tpl);
	}

	function upcoming($tpl = null)
	{
		$heading = "Upcoming Exhibitions";
		$document =& JFactory::getDocument();
		$document->setTitle($heading);

		$model =& $this->getModel();
		$this->assignRef('events',$model->getList());
		$this->assignRef('announcement', $model->getAnnouncement());
		$this->assignRef('heading',$heading);

		parent::display($tpl);
	}

	function past($tpl = null)
	{
		$heading = "Past Exhibitions";
		$document =& JFactory::getDocument();
		$document->setTitle($heading);

		$model =& $this->getModel();
		$modelExhibs = $model->getList();
		$startDates = array();
		foreach($modelExhibs as $exhib)   {
			$startDates[] = $exhib->getSchedule()->getStartTime();
		}
		array_multisort($startDates,SORT_DESC,$modelExhibs);
		$this->assignRef('events',$modelExhibs);
//		$this->assignRef('events',$model->getList());
		$this->assignRef('years',$model->years);
		$this->assignRef('announcement', $model->getAnnouncement());
		$this->assignRef('heading',$heading);

		parent::display($tpl);
	}

	function detail($tpl = null)
	{
		$model =& $this->getModel();
		$event = $model->getDetail();
		$this->assignRef('event',$event);

		$stet = date("F j, Y", $event->getSchedule()->getStartTime()) ." - ";
                if ($event->getSchedule()->getEndTime() > 0)
                   $stet .= date("F j, Y", $event->getSchedule()->getEndTime());
                else
                   $stet .= "Ongoing";
		$schedule = ($event->getScheduleNote()) ? $event->getScheduleNote() : $stet;
		$this->assignRef('schedule',$schedule);

		$gallery = $event->getGallery();
		$images = (count($gallery->getImages() > 0)) ? $gallery->getImages() : null;
		$image = ($images) ? $images[0] : null;
		$this->assignRef('image',$image);

        $heading = $event->getTitle();
		$document =& JFactory::getDocument();
        $document->setTitle("Exhibition Detail: " . $heading);		
        
		parent::display($tpl);
	}

	/**
	 * Renders the pop-up window for the highlight
	 */
	function highlight($tpl = null)
	{
		$model =& $this->getModel();
		$highlight = $model->getDetail();

		$this->assignRef('album',$highlight);
		$images = $highlight->getImages();
		$image = $images[0];
		$this->assignRef('image', $image);
		parent::display($tpl);
	}

	/**
	 * Renders the pop-up window for the artist
	 */
	function artist($tpl = null)
	{
		$model =& $this->getModel();
		$artist = $model->getDetail();

		$this->assignRef('artist',$artist);
		parent::display($tpl);
	}
}
