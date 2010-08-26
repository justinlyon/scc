<?php
/**
 *  $Id$: MasterAction.php, Dec 6, 2006 9:03:13 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/..');
}
require_once WEB_INF . '/base.include.php';
require_once WEB_INF . '/beans/Event.php';
require_once WEB_INF . '/beans/GalleryAlbum.php';
require_once WEB_INF . '/beans/GalleryImage.php';
require_once WEB_INF . '/service/GalleryService.php';
require_once WEB_INF . '/service/AnnouncementService.php';
require_once ('tachometry/web/BaseAction.php');

/**
 * An action class to be inherited by all application
 * action classes.  This class is used to hold common
 * methods, such as common gallery integration points, etc.  
 */
class MasterAction extends BaseAction
{ 
	private $galleryService;
	private $announcementService;
	
	/**
	 * Populates the Gallery object for the given Event.
	 * If the summary flag is set, it will return only the 
	 * summary image.  If no gallery is available in the 
	 * event, the default image will be returned for the event 
	 * type.
	 *  
	 * @param Event (a sub-classed event Program, Exhibition, Course, Promotion)
	 * @param boolean summary (return the summary image only?) optional
	 * @param boolean show_default (return the default image) optional
	 * @return Event the event with a populated Gallery
	 */
	protected function setGallery($event, $summary=false, $show_default=true)
	{	
		$album = new GalleryAlbum();
		$image = null;
		$gs = $this->getGalleryService();

		if ($event->getGallery() > 0) {	
			$album = $gs->getPackagedAlbum($event->getGallery());
		}
		
		if ($show_default && !$album->getImages()) {
			$defaultComposite = $gs->getDefaultComposite(get_class($event));
			$album->setImages(array($defaultComposite));
		}
				
		$event->setGallery($album);
		return $event;
	}


	/**
	 * Retrieves the announcment for the given scope.
	 * If the global flag is set, the global announcment
	 * will be pre-pended to the returned string.
	 * 
	 * @param string the scope of the announcement
	 * @param boolean include the global announcment?
	 * @return string announcement
	 */
	protected function getPublishedAnnouncement($scope, $global=false)
	{
		$ans = $this->getAnnouncementService();
		$annc = $ans->getAnnouncement($scope,true,$global);
		
		$str = null;
		if ($annc->getContent() != null) {
			$str = $annc->getContent();
		}
		if ($annc->getGlobal() != null) {
			$str = $annc->getGlobal() ."<br/><br/>". $str;
		}
		return $str;
	}

	/**
	 * Will return true if a family-friendly audience is found in the given collection
	 * @param array Audience categories
	 * @return boolean isFamily
	 */
	function isFamilyFriendly($auds) {
		$result = false;
		foreach($auds as $aud) {
			if ($aud->getFamily()) {
				$result = true;
				break;	
			}
		}
		return $result;
	}

	/**
	 * Returns the next available activity 
	 * for an array of given activities
	 * 
	 * @param array list of activities
	 * @return Activity -- next activity (or null if not valid)
	 */
	public function getNextActivity($perfs) {
		$time = null;
		$now = time();
		
		$activity = null;
		if ( count($perfs) > 0) {
			foreach($perfs as $act) {
				$schedule = $act->getSchedule();
				$st = $schedule->getStartTime();
				
				// if the start time is in the future
				// AND if it is sooner than the current recorded time
				if ($st > $now && ($st < $time || $time == null)) {
					$time = $st;
					$activity = $act;	
				}	
			}	
		}
		
		return $activity;
	}

	/**
	 * Returns the last activity 
	 * for an array of given activities
	 * 
	 * @param array list of activities
	 * @return Activity -- next activity (or null if not valid)
	 */
	public function getLastActivity($perfs) {
		$time = null;
		
		$activity = null;
		if ( count($perfs) > 0) {
			foreach($perfs as $act) {
				$schedule = $act->getSchedule();
				$st = $schedule->getStartTime();

				// if it is sooner than the current recorded time
				if ($st > $time || $time == null) {
					$time = $st;
					$activity = $act;	
				}	
			}	
		}
		
		return $activity;
	}

	/**
	 * Returns true if the given activity has a start time within the
	 * configured grace period or the future
	 * 
	 * @param Activity
	 * @return boolean true if current
	 */
	public function isCurrent($activity) {
		$result = false;
		$grace_time = time() - intval(GRACE_PERIOD);
		
		if ($activity && $activity->getSchedule()->getStartTime() > $grace_time) {				
			$result = true;
		}
		return $result;
	}



	private function getGalleryService() 
	{
		if ($this->galleryService == null) {
			$this->galleryService = new GalleryService();
		}
		return $this->galleryService;
	}

	private function getAnnouncementService()
	{
		if ($this->announcementService == null) {
			$this->announcementService = new AnnouncementService();
		}
		return $this->announcementService;
	}
}
?>
