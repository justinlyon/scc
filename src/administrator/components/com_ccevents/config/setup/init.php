<?php
/**
 *  $Id: init.php 129 2006-06-29 05:49:07Z tevans $
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
if (!defined('WEB_INF')) {
    @define('WEB_INF', realpath(dirname(__FILE__) . '/../../WEB-INF'));
}
require_once WEB_INF . '/base.include.php'; 
require_once WEB_INF . '/pdo/model.php'; 
require_once WEB_INF . '/beans/PublicationState.php'; 

// Add more initialization functions as needed
initEnumeratedValues();
initVenues();
initCategories();

// TODO: move init functions to each persistent class; called via setup.php or the like 

/**
 * Initialize application enumeration values
 */
function initEnumeratedValues() {
	
	// define initial setup values
	$enum = array(
		"PublicationState" => array(
			array( "value" => PublicationState::UNPUBLISHED,
				"description" => "Content is not available via the live web site"	),
			array( "value" => PublicationState::PUBLISHED,
				"description" => "Content has been approved and published to the live web site"	),
			array( "value" => PublicationState::ARCHIVED,
				"description" => "Content has been removed from the admin web site"	),
		),
		"EventStatus" => array(
			array( "value" => "Active",
				"description" => "Event is active (tickets are still available)"	),
			array( "value" => "Cancelled",
				"description" => "Event has been cancelled"	),
			array( "value" => "Sold Out",
				"description" => "Tickets are no longer availabe for this event"	),
		),
		"ProgramType" => array(
			array( "value" => "General",
				"description" => "Program appeals to the general public"	),
			array( "value" => "Family",
				"description" => "Program content is family-oriented"	),
			array( "value" => "School",
				"description" => "Program content is intended for school/education use"	),
		),
		"ResourceType" => array(
			array( "value" => "Hyperink",
				"description" => "Linked web page (opened in a new window)"	),
			array( "value" => "CMS",
				"description" => "Integrated content management component (Joomla)"	),
		),
	);

	$pdo = epManager::instance();
	
	// cleanup/setup enumerations
	foreach ($enum as $class => $elements) {
		$filter = $pdo->create($class);
		$values = $pdo->find($filter);
		foreach ($values as $item) {
			$pdo->delete($item);
		}
		for ($index = 0; $index < count($elements); $index++){
			$enumValue = $pdo->create($class);
			$enumValue->setValue($elements[$index]["value"]);
			$enumValue->setDescription($elements[$index]["description"]);
			$pdo->commit($enumValue);
		}
	}
}


/**
 * Initialize venues
 */
function initVenues() {
	
	// define initial setup values
	$venues = array(
		"Venue" => array(
			array( "name" => "Milken Gallery",
				"description" => "",
				"address" => "",
				"pubState" => "Published"),
			array( "name" => "Ruby Gallery",
				"description" => "",
				"address" => "",
				"pubState" => "Published"),
			array( "name" => "Hurd Gallery",
				"description" => "",
				"address" => "",
				"pubState" => "Published"),
			array( "name" => "Getty Gallery",
				"description" => "",
				"address" => "",
				"pubState" => "Published"),
			array( "name" => "Main Lobby",
				"description" => "",
				"address" => "",
				"pubState" => "Published"),
			array( "name" => "Campus Garden",
				"description" => "",
				"address" => "",
				"pubState" => "Published"),
		),

	);

	$pdo = epManager::instance();
	
	// cleanup/setup enumerations
	foreach ($venues as $class => $elements) {
		$filter = $pdo->create($class);
		$values = $pdo->find($filter);
		foreach ($values as $item) {
			$pdo->delete($item);
		}
		for ($index = 0; $index < count($elements); $index++){
			$venue = $pdo->create($class);
			$venue->setName($elements[$index]["name"]);
			$venue->setDescription($elements[$index]["description"]);
			$venue->setAddress($elements[$index]["address"]);
			$venue->setPubState($elements[$index]["pubState"]);
			$pdo->commit($venue);
		}
	}
}

/**
 * Initialize categories
 */
function initCategories() {
	
	// define initial setup values
	$categories = array(
		"Genre" => array(
			array( "name" => "Theater",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Readings and Talks",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Cinema's Legacy",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Film",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Comedy",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Food",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
		),
		"Audience" => array(
			array( "name" => "Family",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Teen",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Toddler",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Public",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
		),
		"Series" => array(
			array( "name" => "Sunset Concerts",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
			array( "name" => "Cinema Z",
				"subtitle" => "",
				"description" => "",
				"pubState" => "Published"),
		),

	);

	$pdo = epManager::instance();
	
	// cleanup/setup enumerations
	foreach ($categories as $class => $elements) {
		$filter = $pdo->create($class);
		$values = $pdo->find($filter);
		foreach ($values as $item) {
			$pdo->delete($item);
		}
		for ($index = 0; $index < count($elements); $index++){
			$category = $pdo->create($class);
			$category->setName($elements[$index]["name"]);
			$category->setSubtitle($elements[$index]["subtitle"]);
			$category->setDescription($elements[$index]["description"]);
			$category->setPubState($elements[$index]["pubState"]);
			$pdo->commit($category);
		}
	}
}

?>

