<?php
/**
 *  $Id$: SeriesAction.php, Oct 13, 2006 5:12:11 PM nchanda
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
require_once WEB_INF . '/beans/Genre.php';
require_once WEB_INF . '/beans/Pagination.php';
require_once WEB_INF . '/actions/CategoryAction.php';

require_once ('tachometry/web/BaseAction.php');
require_once ('tachometry/util/CopyBeanOption.php');

class GenreAction extends CategoryAction
{

	/**
	 * Returns the populated summary page model
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the summary page model bean
	 */
	protected function setSummaryModel($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setSummaryModel()");

		$model = new SummaryPageModel();
		$cs = $this->getCategoryService();

		$pubStates = null;
		if (isset($_REQUEST['archived'])) {
			$pubStates = array(PublicationState::ARCHIVED);
		}
		$logger->debug("Size of pubStates array: ". count($pubStates));

		$pagination = new Pagination();
		$start = ( isset($_REQUEST['start'] && $_REQUEST['start'] > 0 ) ? $_REQUEST['start'] : 0;
		$pagination->setStart($start);
		$limit = ( isset($_REQUEST['limit'] && $_REQUEST['limit'] > 0 ) ? $_REQUEST['limit'] : null;
		$pagination->setLimit($limit);

		$list = $cs->getCategories(Category::GENRE, $pubStates, $pagination);
		$model->setList($list);

		return $model;
	}


	/**
	 * Returns the associative array with all of the lists required to
	 * render the html select elements on the detail page.
	 *
	 * @return array An associative array of option values
	 */
	 protected function getDetailOptions()
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::getDetailOptions()');

	 	$options = array();

	 	$evs = $this->getEnumeratedValueService();
	 	$pub = $evs->fetch('PublicationState');
	 	$logger->debug("Number of PubStates: ". count($pub['PublicationState']));
	 	$options['pubState'] = 	$pub['PublicationState'];
	 	/*
	 	$es = $this->getEventService();
	 	$prgm = $es->getEventsByPubState('Program');
	 	$logger->debug("Number of Programs: ". count($prgm));
	 	$options['program'] = $prgm;
	 	*/

	 	return $options;
	 }



	/**
	 * Populates the Category object from the request
	 * @return bean Category
	 */
	 protected function getBeanFromRequest()
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::getBeanFromRequest()");

	 	$cat = new Genre($_REQUEST);
	 	$cat->setScope($_REQUEST['catscope']);
	 	$logger->debug("incoming category scope: ". $cat->getScope());

	 	$logger->debug("Auto fill of Category bean has name of: ". $cat->getName());

	 	$logger->debug("Incoming image value: ". $cat->getImage());

	 	// TODO add events and gallery if linked
	 	return $cat;
	 }


}
?>

