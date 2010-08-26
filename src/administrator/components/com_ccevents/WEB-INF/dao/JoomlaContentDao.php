<?php
/**
 *  $Id$:
 *  Copyright (c) 2008, Tachometry Corporation
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
require_once WEB_INF . '/beans/JoomlaContent.php';

require_once ('tachometry/web/ListBean.php');
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A class to serve as data access facilitator
 */
class JoomlaContentDao
{
	private $dbo;

	function __construct() {
		global $logger;
		$logger->debug("JoomlaContentDao::construct()");
	}

	/**
	 * Returns a section
	 * @param int id
	 * @return JoomlaSection bean
	 */
	function getSection($id)
	{
		$db	= $this->getDbo();
		$query = "SELECT * FROM #__sections where id = ". $id;
		$db->setQuery($query);
		return new JoomlaSection($db->loadAssoc());
	}

	/**
	 * Returns a ListBean of Categories
	 * @param int id
	 * @param boolean show published categories only?
	 * @return array of beans
	 */
	function getCategoriesBySection($id, $publishedOnly=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getCategoriesBySection($id, $publishedOnly)");

		$db = $this->getDbo();
		$query = "SELECT * FROM #__categories where section = ". $id;
		if ($publishedOnly) {
			// TODO: implement state and time check
		}
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		$beans = array();
		foreach ($rows as $row) {
			$beans[] = $this->setJoomlaCategory($row);
		}
		return $beans;
	}

	/**
	 * Returns the list of articles for the given category id
	 * @param int categoryId
	 * @param boolean include only published articles
	 * @return array of beans
	 */
	function getArticlesByCategory($id, $publishedOnly=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getArticlesByCategory($id, $publishedOnly)");

		$db = $this->getDbo();
		$query = "SELECT * FROM #__content where catid = ". $id;
		if ($publishedOnly) {
			// TODO: implement state and time check
		}
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		$beans = array();
		foreach ($rows as $row) {
			$beans[] = $this->setJoomlaArticle($row);
		}
		return $beans;
	}

	/**
	 * Returns the comments for the given article.  If the
	 * featured flag is also given, only the comments that have been
	 * marked as featured will be returned. NOTE: This method assumes
	 * the comments are being managed through the JomComment component
	 * and the featured comments are being managed by a 5 star ranking.
	 *
	 * @param int articleId
	 * @param boolean featured (optional)
	 * @return array of JoomlaComment
	 */
	function getComments($articleId, $featured=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getComments($articleId, $featured)");

		$db = $this->getDbo();

		$query = "SELECT id, contentid as article, title, comment, name, date FROM #__jomcomment where published = 1 and contentid = ". $articleId;
		if ($featured) {
			$query .= " and featured = 1";
		}
		$query .= " order by date desc";

		$db->setQuery($query);
		$rows = $db->loadAssocList();
		$beans = array();
		foreach ($rows as $row) {
			$beans[] = $this->setJoomlaComment($row);
		}
		return $beans;
	}

	/**
	 * Returns a JoomlaArticle bean populated from the given array
	 * @param asscoiative array representing the database row
	 * @return populated JoomlaArticle bean
	 */
	private function setJoomlaArticle($source)
	{
		$bean = new JoomlaArticle();
		foreach($source as $key => $value) {
			$setter = 'set_' . strtolower($key);
			$bean->$setter($value);
		}
		return $bean;
	}

	/**
	 * Returns a JoomlaComment bean populated from the given array
	 * @param asscoiative array representing the database row
	 * @return populated JoomlaComment bean
	 */
	private function setJoomlaComment($source)
	{
		$bean = new JoomlaComment();
		foreach($source as $key => $value) {
			$setter = 'set_' . strtolower($key);
			$bean->$setter($value);
		}
		return $bean;
	}

	/**
	 * Returns a JoomlaCategory bean populated from the given array
	 * @param asscoiative array representing the database row
	 * @return populated JoomlaCategory bean
	 */
	private function setJoomlaCategory($source)
	{
		$bean = new JoomlaCategory();
		foreach($source as $key => $value) {
			$setter = 'set_' . strtolower($key);
			$bean->$setter($value);
		}
		return $bean;
	}

	/**
	 * Returns a JoomlaArticle bean populated from the given array
	 * @param asscoiative array representing the database row
	 * @return populated JoomlaSection bean
	 */
	private function setJoomlaSection($source)
	{
		$bean = new JoomlaArticle();
		foreach($source as $key => $value) {
			$setter = 'set_' . strtolower($key);
			$bean->$setter($value);
		}
		return $bean;
	}
	/**
	 * Returns the JoomlaDatabaseObject.
	 * @return DBO
	 */
	private function getDbo()
	{
		if ($this->dbo == null) {
			$this->dbo =& JFactory::getDBO();
		}
		return $this->dbo;
	}
}
?>