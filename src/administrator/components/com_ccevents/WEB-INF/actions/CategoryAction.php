<?php
/**
 *  $Id$: CategoryAction.php, Oct 31, 2006 11:10:12 AM nchanda
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
require_once WEB_INF . '/service/CategoryService.php';
require_once WEB_INF . '/service/EnumeratedValueService.php';
require_once WEB_INF . '/beans/Series.php';
require_once WEB_INF . '/beans/Category.php';
require_once WEB_INF . '/beans/PageModel.php';
require_once WEB_INF . '/beans/PublicationState.php';

require_once ('tachometry/web/BaseAction.php');
require_once ('tachometry/util/CopyBeanOption.php');

abstract class CategoryAction extends BaseAction
{
	private $categoryService;
	private $enumeratedValueService;

	/**
	 * The default method if no task is given. Will return an initialized
	 * summary page model bean.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean summary page model bean
	 */
	function execute($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::execute()");
		return $this->summary($mainframe);
	}

	/**
	 * A public wrapper for the private setSummaryModel() method
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the summary page model bean
	 */
	function summary($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::summary()');
		return $this->setSummaryModel($mainframe);
	}

	/**
	 * A public wrapper for the private setSummaryModel() method
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the summary page model bean
	 */
	function delete($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::delete()');

		$service = $this->getCategoryService();
		$oids = $this->getFormOids();

		for($i=0; $i<count($oids); $i++)
		{
			$service->delete($oids[$i]);
		}
		return $this->setSummaryModel($mainframe);
	}



	/**
	 * A public wrapper for the private setDetailModel() method
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the detail page model bean
	 */
	function read($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::read()');
		return $this->setDetailModel($mainframe);
	}

	 /**
	 * Takes no action, but returns an detail page model
	 * @param Array $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	 function setup($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::setup()');

		$model = new DetailPageModel();
		$cat = new Category();
		$model->setDetail($cat);
		$model->setOptions($this->getDetailOptions());
		return $model;
	 }

	/**
	 * Updates a category identified by the oid
	 * If the oid is null, the method will invoke
	 * the create() method.
	 * @see save()
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	function apply($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::apply()');
		return $this->update($mainframe);
	}

	/**
	 * A public wrapper for the update() method.  Will prepare and
	 * return a list of summaries.
	 * @see apply() Updates then returns the details page
	 * @see update() Updates the category
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	function save($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . '::save()');

		// invoke the update
		$this->update($mainframe);

		// return the summaries
		return $this->setSummaryModel($mainframe);
	}

	 /**
	 * Sets the publication state of the given categories(s) to "Archived"
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function archive($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::archive()');

		$oids = $this->getFormOids();
		$logger->debug("Size of incoming oids: ". count($oids));
		$this->changePubState($oids, PublicationState::ARCHIVED);

		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }

	/**
	 * Sets the archived request variable, then calls the setSummaryModel method
	 * in the sub-class
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function viewArchive($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::viewArchive()');

		$_REQUEST['archived'] = true;
		return $this->setSummaryModel($mainframe);
	 }

	/**
	 * Creates a new series
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	protected function create($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::create()");

		$service = $this->getCategoryService();
		$bean = $this->getBeanFromRequest();
		$model = new DetailPageModel();

		$model->setDetail($service->setup($bean));
		$model->setOptions($this->getDetailOptions());

		return $model;
	}


	/**
	 * Updates a category by given oid. If there is no oid
	 * it will invoke the create method.
	 * @param object $mainframe The Joomla specific page object
	 * @return bean DetailPageModel
	 */
	private function update($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::update()");

		$bean = $this->getBeanFromRequest();

		// is this a new event
		if($bean->getOid() == null) {
			$logger->debug("No event id found.");
			return $this->create($mainframe);
		}

		$cs = $this->getCategoryService();
		$model = new DetailPageModel();

		// Update the venue
		$updated = $cs->update($bean);

		// Populate the page model
		$model->setDetail($updated);
		$model->setOptions($this->getDetailOptions());

		return $model;
	}


	 /**
	  * Returns an array of oids from the request
	  * @return array oids
	  */
	 protected function getFormOids()
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::getFormOids()');

	 	$logger->debug('oids: '. $_REQUEST['oids']);
		if(!isset($_REQUEST['oids'])) {
			trigger_error("Required oids are missing", E_USER_ERROR);
		}
		$oid_array = split(",",$_REQUEST['oids']);
		$logger->debug('length of oid_array: '. count($oid_array));
		return $oid_array;
	 }


	/**
	 * Changes the PublicationState for each category identified by the
	 * list of oids to the value passed by the calling method.
	 *
	 * @access private
	 * @param array A list of oids
	 * @param string the target publication state value
	 */
	 private function changePubState($oids, $state)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . "::changePubState($oids, $state)");

	 	$cs = $this->getCategoryService();
	 	for($i=0; $i<count($oids); $i++)
		{
			$logger->debug("Changing pubState for category oid: ". $oids[$i]);
			$cat = $cs->getCategoryById($oids[$i]);
			$logger->debug("Name of category to change pubState: ". $cat->getName());
			$logger->debug("Name of state to change pubState: ". $state);
			$logger->debug("Class of category: ". get_class($cat));
			$cat->setPubState($state);
			$cs->update($cat);
		}
	 }


	/**
	 * Sets the publication state of the given category(ies) to "Published"
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function publish($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::publish()');

		$oids = $this->getFormOids();
		$this->changePubState($oids, PublicationState::PUBLISHED);

		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }

	/**
	 * Sets the publication state of the given category(ies) to "Unpublished"
	 * @param object $mainframe The Joomla specific page object
	 * @return bean SummaryPageModel
	 */
	 function unpublish($mainframe)
	 {
	 	global $logger;
		$logger->debug(get_class($this) . '::unpublish()');

		$oids = $this->getFormOids();
		$this->changePubState($oids, PublicationState::UNPUBLISHED);

		// return the summaries
		return $this->setSummaryModel($mainframe);
	 }

	/**
	 * Returns the populated detail page model
	 * @param object $mainframe The Joomla specific page object
	 * @return bean the detail page model bean
	 */
	protected function setDetailModel($mainframe)
	{
		global $logger;
		$logger->debug(get_class($this) . "::setDetailModel()");

		$model = new DetailPageModel();
		$cs = $this->getCategoryService();

		if (!isset($_REQUEST['oid'])) {
			return $this->setSummaryModel($mainframe);
		}

		$detail = $cs->getCategoryById($_REQUEST['oid']);
		$model->setDetail($detail);
		$model->setOptions($this->getDetailOptions());

		return $model;
	}


	/**
	 * The interface for the getBeanFromRequest method
	 * @return a scoped bean
	 */
	protected abstract function getBeanFromRequest();

	/**
	 * The interface for the getDetailOptions method
	 * @return an associative array of all necessary
	 * options required to render the page
	 */
	protected abstract function getDetailOptions();

	/**
	 * The interface for the setSummaryModel method
	 * @param object the Joomla specific object
	 * @return a SummaryPageModel bean
	 */
	protected abstract function setSummaryModel($mainframe);



	protected function getCategoryService()
	{
		if ($this->categoryService == null) {
			$this->categoryService = new CategoryService();
		}
		return $this->categoryService;
	}

	protected function getEnumeratedValueService()
	{
		if ($this->enumeratedValueService == null) {
			$this->enumeratedValueService = new EnumeratedValueService();
		}
		return $this->enumeratedValueService;
	}
}
?>

