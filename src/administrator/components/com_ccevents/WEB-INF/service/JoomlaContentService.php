<?php
/**
 *  $Id$: CategoryService.php, Oct 13, 2006 5:22:21 PM nchanda
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
require_once WEB_INF . '/dao/JoomlaContentDao.php';
require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

/**
 * A service class to serve both as data access facilitator and
 * API contract.  This is an helper service to wrap access to
 * Joomla content elements and package them in bean objects.
 */
class JoomlaContentService
{
	public $dao;

	/**
	 * Returns the section bean for the given section id
	 * @param int id
	 * @param boolean include categories
	 * @param boolean include articles
	 * @return JoomlaSection bean
	 */
	function getSection($id, $categories=false, $articles=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getSection($id, $categories, $articles)");
		$dao = new JoomlaContentDao();
		$section = $dao->getSection($id);
		return $section;
	}

	/**
	 * Returns the list of categories for the given section id
	 * @param int sectionId
	 * @param boolean include articles
	 * @return JoomlaSection bean
	 */
	function getCategoriesBySection($sectionId, $articles=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getCategoriesBySection($sectionId, $articles)");
		$dao = $this->getDao();
		$categories = $dao->getCategoriesBySection($sectionId);
		return $categories;
	}

	/**
	 * Returns the list of articles for the given category id
	 * @param int categoryId
	 * @param boolean include only published articles
	 * @return array JoomlaArticles
	 */
	function getArticlesByCategory($categoryId, $publishedOnly=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getArticlesByCategory($categoryId, $publishedOnly)");
		$dao = $this->getDao();
		$articles = $dao->getArticlesByCategory($categoryId, $publishedOnly);
		$logger->debug("Articles: ". $articles);
		return $articles;
	}

	/**
	 * Returns the comments for the given article
	 * @param int articleId
	 * @param boolean featured
	 * @return array JoomlaComments
	 */
	function getComments($articleId, $featured=false)
	{
		global $logger;
		$logger->debug(get_class($this) . "::getComments($articleId, $featured)");
		$dao = $this->getDao();
		$comments = $dao->getComments($articleId, $featured);
		$logger->debug("Comments: ". $comments);
		return $comments;
	}

	/**
	 * A convenience method to return  only the
	 * "featured" comments for the given article
	 * @param int articleId
	 * @return array JoomlaComments
	 */
	function getFeaturedComments($articleId)
	{
		return $this->getComments($articleId,true);
	}


	/**
	 * Returns the JoomlaContentDao or instantiates it.
	 * @return JoomlaContentDao
	 */
	private function getDao()
	{
		if ($this->dao == null) {
			$this->dao = new JoomlaContentDao();
		}
		return $this->dao;
	}
}