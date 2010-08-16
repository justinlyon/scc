<?php
/**
 * @version		$Id: menu.php 17853 2010-06-23 17:41:14Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * JMenu class
 *
 * @package		Joomla.Site
 * @subpackage	Application
 * @since		1.5
 */
class JMenuSite extends JMenu
{
	/**
	 * Loads the entire menu table into memory.
	 *
	 * @return array
	 */
	public function load()
	{
		$cache = JFactory::getCache('mod_menu', '');  // has to be mod_menu or this cache won't get cleaned
		if (!$data = $cache->get('menu_items'.JFactory::getLanguage()->getTag())) {
			// Initialise variables.
			$db		= JFactory::getDbo();
			$app	= JFactory::getApplication();
			$query	= $db->getQuery(true);

			$query->select('m.id, m.menutype, m.title, m.alias, m.path AS route, m.link, m.type, m.level');
			$query->select('m.browserNav, m.access, m.params, m.home, m.img, m.template_style_id, m.component_id, m.parent_id');
			$query->select('m.language');
			$query->select('e.element as component');
			$query->from('#__menu AS m');
			$query->leftJoin('#__extensions AS e ON m.component_id = e.extension_id');
			$query->where('m.published = 1');
			$query->where('m.parent_id > 0');
			$query->order('m.lft');

			$user = JFactory::getUser();
			$groups = implode(',', $user->authorisedLevels());
			$query->where('m.access IN (' . $groups . ')');

			// Filter by language
			if ($app->isSite() && $app->getLanguageFilter()) {
				$query->where('m.language in (' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
			}

			// Set the query
			$db->setQuery($query);
			if (!($menus = $db->loadObjectList('id'))) {
				JError::raiseWarning(500, JText::sprintf('JERROR_LOADING_MENUS', $db->getErrorMsg()));
				return false;
			}

			foreach ($menus as &$menu) {
				// Get parent information.
				$parent_tree = array();
				if (isset($menus[$menu->parent_id])) {
					$parent_tree  = $menus[$menu->parent_id]->tree;
				}

				// Create tree.
				$parent_tree[] = $menu->id;
				$menu->tree = $parent_tree;

				// Create the query array.
				$url = str_replace('index.php?', '', $menu->link);
				$url = str_replace('&amp;','&',$url);

				parse_str($url, $menu->query);
			}

			$cache->store($menus, 'menu_items'.JFactory::getLanguage()->getTag());

			$this->_items = $menus;
		} else {
			$this->_items = $data;
		}
	}
}
