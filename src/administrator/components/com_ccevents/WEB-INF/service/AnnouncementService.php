<?php
/**
 *  $Id$: AnnouncementService.php, Oct 23, 2006 12:20:26 PM nchanda
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
require_once WEB_INF . '/beans/Announcement.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/pdo/model.php'; 

require_once ('tachometry/util/BeanUtil.php');

class AnnouncementService
{
	/**
	 * Return the announcment(s) for the given scope.
	 * If no scope is given, the global announcment will
	 * be returned.  In any case, a published global announcment
	 * will be stored in the "global" attribute in the bean.
	 * If the published flag is set, the method will return the
	 * content value if published or an empty string if not.
	 * 
	 * @param string $scope (e.g. Exhibition, Program, Course, Global)
	 * @param boolean $published Return just the published value? [false]
	 * @param boolean $global Also set and return the published global content? [false]
	 * @return bean The announcment bean for the given scope 
	 */	
	 public function getAnnouncement($scope, $published = false, $global = false) {
	 	global $logger;
		$logger->debug(get_class($this) . "::getAnnouncment($scope)");
		
	 	$notice = new Announcement();
	 	
	 	// get the scoped announcement
	 	if ($scope != null) {
	 		$section = $this->fetch($scope);
	 		$snotice = $section->content;
	 		if ($published &&  !$section->published) {
	 			$snotice = "";
	 		}
	 	}
	 	
	 	// get the global announcement
	 	if ($global) {
		 	$global = $this->fetch('Global');
		 	$gnotice = $global->content;
		 	if ($published &&  !$global->published) {
		 		$gnotice = "";
		 	}
		 	$notice->setGlobal($gnotice);
	 	}
	 	
	 	$notice->setContent($snotice);
	 	$notice->setScope($scope);
        if ($section != null)
        {
            $notice->setPublished($section->getPublished());
            $notice->setOid($section->getOid());
        }
      
	 	return $notice;	
	 }


	/**
	 * Updates the given Anncoument PDO from the bean
	 * 
	 * @param
	 */
	public function update($bean)
	{	 
        global $logger;
		$logger->debug(get_class($this) . "::update($bean)");
		
        $logger->debug("Announcment scope, ". $bean->getScope() ." has oid: ". $bean->getOid());
		
		$epm = epManager::instance();
		$pdo = $epm->get('Announcement', $bean->getOid());
		
		
		$pdo = BeanUtil::CopyBean($bean,$pdo);
		if (!($epm->commit($pdo))) {
			trigger_error("Unable to commit ". $bean->getScope() ." announcement.", E_USER_ERROR);
		}
	}
	 
	 /**
	  * Returns the PDO object for the given scope. 
	  */
	 private function fetch($scope) {
	 	global $logger;
		$logger->debug(get_class($this) . "::fetch($scope)");
		
		$epm = epManager::instance();
		$pdos = $epm->find('from Announcement where scope = ?', $scope);
		
		return $pdos[0];
	 }
}
 
?>
