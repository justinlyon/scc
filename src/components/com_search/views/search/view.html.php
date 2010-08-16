<?php
/**
 * @version		$Id: view.html.php 18071 2010-07-11 03:06:56Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	Weblinks
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	Weblinks
 * @since 1.0
 */
class SearchViewSearch extends JView
{
	function display($tpl = null)
	{
		require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'search.php';

		// Initialise some variables
		$app	= JFactory::getApplication();
		$pathway = $app->getPathway();
		$uri	= JFactory::getURI();

		$error	= null;
		$rows	= null;
		$results= null;
		$total	= 0;

		// Get some data from the model
		$areas	= $this->get('areas');
		$state		= $this->get('state');
		$searchword = $state->get('keyword');

		$params = $app->getParams();

		$menus	= $app->getMenu();
		$menu	= $menus->getActive();

		// because the application sets a default page title, we need to get it
		// right from the menu item itself
		if (is_object($menu)) {
			$menu_params = new JRegistry;
			$menu_params->loadJSON($menu->params);
			if (!$menu_params->get('page_title')) {
				$params->set('page_title',	JText::_('COM_SEARCH_SEARCH'));
			}
		} else {
			$params->set('page_title',	JText::_('COM_SEARCH_SEARCH'));
		}

		$title = $params->get('page_title');
		if ($app->getCfg('sitename_pagetitles', 0)) {
			$title = JText::sprintf('JPAGETITLE', htmlspecialchars_decode($app->getCfg('sitename')), $title);
		}
		$this->document->setTitle($title);

		// built select lists
		$orders = array();
		$orders[] = JHtml::_('select.option',  'newest', JText::_('COM_SEARCH_NEWEST_FIRST'));
		$orders[] = JHtml::_('select.option',  'oldest', JText::_('COM_SEARCH_OLDEST_FIRST'));
		$orders[] = JHtml::_('select.option',  'popular', JText::_('COM_SEARCH_MOST_POPULAR'));
		$orders[] = JHtml::_('select.option',  'alpha', JText::_('COM_SEARCH_ALPHABETICAL'));
		$orders[] = JHtml::_('select.option',  'category', JText::_('JCATEGORY'));

		$lists = array();
		$lists['ordering'] = JHtml::_('select.genericlist', $orders, 'ordering', 'class="inputbox"', 'value', 'text', $state->get('ordering'));

		$searchphrases		= array();
		$searchphrases[]	= JHtml::_('select.option',  'all', JText::_('COM_SEARCH_ALL_WORDS'));
		$searchphrases[]	= JHtml::_('select.option',  'any', JText::_('COM_SEARCH_ANY_WORDS'));
		$searchphrases[]	= JHtml::_('select.option',  'exact', JText::_('COM_SEARCH_EXACT_PHRASE'));
		$lists['searchphrase' ]= JHtml::_('select.radiolist',  $searchphrases, 'searchphrase', '', 'value', 'text', $state->get('match'));

		// log the search
		SearchHelper::logSearch($searchword);

		//limit searchword

		if (SearchHelper::limitSearchWord($searchword)) {
			$error = JText::_('COM_SEARCH_ERROR_SEARCH_MESSAGE');
		}

		//sanatise searchword
		if (SearchHelper::santiseSearchWord($searchword, $state->get('match'))) {
			$error = JText::_('COM_SEARCH_ERROR_IGNOREKEYWORD');
		}

		if (!$searchword && count(JRequest::get('post'))) {
			//$error = JText::_('COM_SEARCH_ERROR_ENTERKEYWORD');
		}

		// put the filtered results back into the model
		// for next release, the checks should be done in the model perhaps...
		$state->set('keyword', $searchword);
		if ($error==null)
		{
			$results	= $this->get('data');
			$total		= $this->get('total');
			$pagination	= $this->get('pagination');

			require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';

			for ($i=0; $i < count($results); $i++)
			{
				$row = &$results[$i]->text;

				if ($state->get('match') == 'exact')
				{
					$searchwords = array($searchword);
					$needle = $searchword;
				}
				else
				{
					$searchwords = preg_split("/\s+/u", $searchword);
					$needle = $searchwords[0];
				}

				$row = SearchHelper::prepareSearchContent($row, $needle);
				$searchwords = array_unique($searchwords);
				$searchRegex = '#(';
				$x = 0;
				foreach ($searchwords as $k => $hlword)
				{
					$searchRegex .= ($x == 0 ? '' : '|');
					$searchRegex .= preg_quote($hlword, '#');
					$x++;
				}
				$searchRegex .= ')#iu';

				$row = preg_replace($searchRegex, '<span class="highlight">\0</span>', $row);

				$result = &$results[$i];
				if ($result->created) {
					$created = JHTML::_('date',$result->created, JText::_('DATE_FORMAT_LC3'));
				}
				else {
					$created = '';
				}

				$result->created	= $created;
				$result->count		= $i + 1;
			}
		}

		$this->assignRef('pagination',  $pagination);
		$this->assignRef('results',		$results);
		$this->assignRef('lists',		$lists);
		$this->assignRef('params',		$params);

		$this->assign('ordering',		$state->get('ordering'));
		$this->assign('searchword',		$searchword);
		$this->assign('searchphrase',	$state->get('match'));
		$this->assign('searchareas',	$areas);

		$this->assign('total',			$total);
		$this->assign('error',			$error);
		$this->assign('action',			$uri);

		parent::display($tpl);
	}
}
