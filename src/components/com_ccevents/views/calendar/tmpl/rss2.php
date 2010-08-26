<?php
defined('_JEXEC') or die('Restricted access');

$feedDoc =& JDocument::getInstance( 'feed' );
$feedDoc->syndicationURL = 'http://www.autrynationalcenter.org';
$feedDoc->copyright = 'Copyright (C) Autry National Center';
$feedDoc->editor = 'Autry National Center';
$feedDoc->title = 'Autry National Center Schedule of Events';
//$feedDoc->subtitle = 'Feed sub title';

foreach($this->events as $day) {
    foreach ($day['schedules'] as $event) {
    $sitename = substr_replace(JURI::base(),"",-1);
    if ($event->scope == 'Exhibition') {
        $time = date("M j, Y",$event->startTime);
        $link = JRoute::_('index.php?option=com_ccevents&scope=exbt&task=detail&oid='. $event->oid);
        $title = $time . " " . $event->genre .": ". $event->title;
    } else {
        $time = date("M j, Y g:iA",$event->startTime);
        $link = JRoute::_('index.php?option=com_ccevents&scope=prgm&task=detail&fid='. $event->fid .'&oid='. $event->oid);
        $title = $time . " " . $event->genre . ": " . $event->title;
    }

    $item = new JFeedItem();
    $item->title = $title;
    $item->link = $link;
    $item->description = $event->getSummary();
    $item->date = date("r",$event->startTime);
    $item->category = $event->genre;

    $feedDoc->addItem( $item );
    }
}

require_once(JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'document'.DS.'renderer.php' );
require_once( JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'document'.DS.'feed'.DS.'renderer'.DS.'rss.php' );
$renderer = new JDocumentRendererRSS( $feedDoc );
echo $renderer->render();


?>
