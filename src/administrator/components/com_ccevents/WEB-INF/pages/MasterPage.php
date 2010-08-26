<?php
/**
 *  $Id$: MasterPage.php, Sep 14, 2006 3:41:18 PM nchanda
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
require_once WEB_INF . '/beans/Editor.php';
require_once WEB_INF . '/beans/EventStatus.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once ('tachometry/web/BasePage.php');

/**
 * A page class to be inherited by all application
 * page classes.  This class is used to hold common
 * methods, such as the template factory, etc.
 */
 class MasterPage extends BasePage
 {
 	/**
	 * protected method to create the template object
	 * If no directory ($dir) is secified, the engine
	 * will use the global TEMPLATE_DIR
	 *
	 * @param string $dir The optional template directory
	 * @return object patTemplate
	 */
	protected function &createPatTemplate($dir = null) {
		global $option, $mosConfig_absolute_path;
		require_once( 'patTemplate/patTemplate.php' );

		$pat =& patFactory::createTemplate( $option, true, false );

		if ($dir != null) {
			$pat->setRoot( $dir .'/');
		} else {
			$pat->setRoot( TEMPLATE_DIR .'/');
		}

		$pat->applyInputFilter('ShortModifiers');

		return $pat;
	}

	 protected function bean_in_array($bean, $array) {
	 	foreach ($array as $item) {
	 		if (get_class($bean) == get_class($item) &&
	 			is_a($bean, 'BaseBean') &&
	 			$bean->getOid() == $item->getOid()) {
	 				return true;
	 			}
	 	}
	 	return false;
	 }

	/**
	 * Captures the joomla edior object in a string
	 * that can be rendered by the template engine.
	 *
	 * @param bean Editor configuration
	 * @return string Representation of the editor as a string
	 */
	protected function setEditor($conf)
	{
		// Get the configuration
		$name = ($conf->getName() != "") ? $conf->getName() : 'editor';
		$content = $conf->getContent();
		$handle = ($conf->getValueField() != "") ? $conf->getValueField() : $name .'_editor';
		$width = ($conf->getWidth() != null) ? $conf->getWidth() : '100%';
		$height = ($conf->getHeight() != null) ? $conf->getHeight() : '250';
		$rows = ($conf->getRows() != null) ? $conf->getRows() : '40';
		$cols = ($conf->getCols() != null) ? $conf->getCols() : '20';


		// Store the editor in a string
		ob_start();
		editorArea( $handle, $content, $name, $width, $height, $rows, $cols ) ;
		$editor = ob_get_contents();

		ob_end_clean();
		return $editor;
	}

	/**
	 * A convenience wrapper to create an Editor configuration
	 * bean.  Allows for three sizes of editor, SMALL, MEDIUM, and LARGE.
	 * If no size is given, it will default to MEDIUM.  Also accepts
	 * optional name and content.
	 */
	protected function getEditorConfig($size=null,$name=null,$content=null)
	{
		$size_opts = array(EDITOR::SMALL=>"150",EDITOR::MEDIUM=>"300",EDITOR::LARGE=>"400");
		$editor = new Editor();

		$height = ($size) ? $size_opts[$size] : $size_opts[Editor::MEDIUM];
		$editor->setHeight($height);

		if ($name != null) {
			$editor->setName($name);
		}

		if ($content != null) {
			$editor->setContent($content);
		}

		return $editor;
	}

	/**
	 * This is the driver for the vender specific ticket broker.
	 * This will need modification if the vendor ever changes
	 * formats and should be refactored at some point to support
	 * a better plug-and=play system.
	 *
	 * @param mixed string or int value for the incoming ticket code
	 * @return string The fully qualified url for the vendor site
	 */
	protected function getTicketUrl($code)
	{
		if ($code > 0) {
            $query = "/Event.asp?Event=";
//			$query = "/t3/sale/SaleEventDetail?dispatch=loadSelectionData&eventId=";
		} else {
            $query = "/ActSelection.asp?OrganizationNumber=1563&code=";
//			$query = "/user/?region=socal&query=search&interface=ticketweb&newhps=1&search=";
		}
		return TICKET_VENDOR_URL . $query . $code;
	}


	/**
	 * Returns the appropriate image based on the given event status.
	 * If the event is sold out or cancelled, the proper image will be
	 * returned.  If the event is active and the optional ticket code
	 * is also supplied, it will return the formatted ticket button.
	 *
	 * @param string eventStatus (Active, Sold Out, Cancelled)
	 * @param string ticketCode (optional)
	 * @return string image string to render (or null)
	 */
	protected function getStatusImage($status, $ticket=null)
	{
		$img = null;

		switch ($status) {
			case EventStatus::CANCELLED :
				$img = "<img src='". CANCELLED_BUTTON_IMAGE ."' alt='". EventStatus::CANCELLED ."' align='absmiddle'/>";
				break;

			case EventStatus::SOLDOUT :
				$img = "<img src='". SOLDOUT_BUTTON_IMAGE ."' alt='". EventStatus::SOLDOUT ."' align='absmiddle'/>";
				break;

			case EventStatus::ACTIVE :
				if ($ticket != null) {
					$img = "<a href='". $this->getTicketUrl($ticket) ."' class='tickets' target='_blank'/>";
					$img .= "<img src='". TICKET_BUTTON_IMAGE ."' align='absmiddle'></a>";
				}
				break;
		}

		return $img;
	}





	/**
	 * Returns the appropriate array values for the graphic
	 * publication state of the given publication state
	 * string value.
	 * @param string publication state value
	 * @return array the convenience setting for common image summary and controls
	 */
	protected function getPubControls($pubString)
	{
		$pubwidget = array();
		if($pubString == PublicationState::PUBLISHED) {
			$pubwidget['pubimg'] = 'publish_g.png';
			$pubwidget['pubalt'] = PublicationState::PUBLISHED;
			$pubwidget['pubtask'] = 'unpublish';
			$pubwidget['pubtoggle'] = PublicationState::UNPUBLISHED;
		} else if ($pubString == PublicationState::UNPUBLISHED || $pubString == null) {
			$pubwidget['pubimg'] = 'publish_x.png';
			$pubwidget['pubalt'] = PublicationState::UNPUBLISHED;
			$pubwidget['pubtask'] = 'publish';
			$pubwidget['pubtoggle'] = PublicationState::PUBLISHED;
		}
		return $pubwidget;
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

	// sort the events by title (natural order, case insensitive)
	function sort_by_title($a, $b) {
		return strnatcasecmp($a->get_title(), $b->get_title());
	}

	// sort the events by activity start date (oldest first)
	function sort_by_date($a, $b) {
		$s1 = $a->getChildren();
		$s2 = $b->getChildren();
		if (empty($s1)) {
			return empty($s2) ? 0 : +1;
		} else if (empty($s2)) {
			return -1;
		}

		$act_a = $this->getNextActivity($s1);
		$act_b = $this->getNextActivity($s2);

		$min_a = $act_a ? $act_a->getSchedule()->getStartTime() : null;
		$min_b = $act_b ? $act_b->getSchedule()->getStartTime() : null;

		return (isset($min_a) ? (isset($min_b) ? $min_a - $min_b : -1) : (isset($min_b) ? +1 : 0));
	}

	// sort the events by series (natural order, case insensitive)
	function sort_by_series($a, $b) {
		$c1 = $a->getCategories();
		$c2 = $b->getCategories();
		if (empty($c1) || !isset($c1[Category::SERIES])) {
			return empty($c2) || !isset($c2[Category::SERIES]) ? 0 : +1;
		} else if (empty($c2) || !isset($c2[Category::SERIES])) {
			return -1;
		}
		// only check the first series category
		$s1 = $c1[Category::SERIES][0];
		$s2 = $c2[Category::SERIES][0];
		if ($s1->get_name() != $s2->get_name()) {
        	return strnatcasecmp($s1->get_name(),$s2->get_name());
		} else {
			return $this->sort_by_date($a,$b);
		}
	}

	// sort the events by age group (natural order, case insensitive)
	function sort_by_age($a, $b) {
		$c1 = $a->getCategories();
		$c2 = $b->getCategories();
		if (empty($c1) || !isset($c1[Category::AUDIENCE])) {
			return empty($c2) || !isset($c2[Category::AUDIENCE]) ? 0 : +1;
		} else if (empty($c2) || !isset($c2[Category::AUDIENCE])) {
			return -1;
		}
		// only check the first audience category
		$a1 = $c1[Category::AUDIENCE][0];
		$a2 = $c2[Category::AUDIENCE][0];
		if ($a1->get_name() != $a2->get_name() ) {
			return strnatcasecmp($a1->get_name(),$a2->get_name());
		} else {
			return $this->sort_by_date($a,$b);
		}
	}


	/**
	 * Returns the name for the target category based on the
	 * given sort_order.  If no match can be found, or if
	 * the sort_order does not support groups (e.g. title),
	 * then the method will return an empty string.
	 *
	 * @param Event event
	 * @param string sort_order
	 * @return string $category_name or empty string if none available
	 */
	function getSortName($event, $sort_order=null) {
		$category_name = "";

		if ($sort_order == "series" || $sort_order == "age") {
			$sf = "get_sort_". $sort_order;
			$sort_category = $event->$sf();

			if ($sort_category != null && $sort_category->getName() != NULL) {
				$category_name =  $sort_category->getName();
			} else {
				$category_name = "Other Events";
			}
		}
		return $category_name;
	}

	/**
	 * Appends the ccmenu request var to any given url if it already exists in the request
	 * then converts to the joomla built-in sefRelToAbs method
	 * @param string url
	 * @param string anchor (without the #)
	 * @return string appended sef url
	 */
	 function cceventSefUrl($url, $anchor=null) {

	 	// parse the url for the sef value of ccmenu
	 	if (isset($_REQUEST['ccmenu']) && $_REQUEST['ccmenu']) {
	 		$url = $url . "&ccmenu=". $_REQUEST['ccmenu'];
	 	} if ($anchor) {
	 		$url = $url ."#". $anchor;
	 	}
	 	return sefRelToAbs($url);
	 }


	/**
	 * Formats the date depending on the value of format
	 * @param int a unix timestamp
	 * @param string format (e.g. 'long','short')
	 * @return string the formatted date
	 */
	function formatDate($ts, $format='long') {
		$date = '';
		switch ($format) {
			case 'tiny' :
				$date = date("F j",$ts);
				break;
			case 'short' :
				$date = date("M j, g:i a",$ts);
				break;
			case 'fulldate' :
				$date = date("M j, Y",$ts);
				break;
			case 'long' :
			case 'default' :
				$date = date("l, F j, g:i a",$ts);
				break;
		}
		return $date;
	}

	/**
	 * will determine if the given venue should link to the detail page
	 * for the venuw.  This currently protects against a venue without a
	 * description being rendered as a link
	 *
	 * @param Venue the venue to evaluate
	 * @return string either the venue title, or the title wrapped with a sef link tag
	 */
	function getVenueTitleLink($venue) {
		$title = $venue->getName();
		if ($venue->getDescription() != null) {
			$link = $this->cceventSefUrl('index.php?option=com_ccevents&scope=vnue&task=detail&oid='. $venue->getOid());
			$title = "<a href='". $link ."'>". $venue->getName() ."</a>";
		}
		return $title;
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

 }

?>


