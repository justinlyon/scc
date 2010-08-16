<?php
/**
 * @version		$Id:mod_menu.php 2463 2006-02-18 06:05:38Z webImagery $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_menu
 * @since		1.5
 */
abstract class ModMenuHelper
{
	/**
	 * Get a list of the available menus.
	 *
	 * @return	array	An array of the available menus (from the menu types table).
	 * @since	1.6
	 */
	public static function getMenus()
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('a.*, SUM(b.home) AS home');
		$query->from('#__menu_types AS a');
		$query->leftJoin('#__menu AS b ON b.menutype = a.menutype');
		$query->group('a.id');

		$db->setQuery($query);

		$result = $db->loadObjectList();

		return $result;
	}

	/**
	 * Get a list of the authorised, non-special components to display in the components menu.
	 *
	 * @param	boolean	$authCheck	An optional switch to turn off the auth check (to support custom layouts 'grey out' behaviour).
	 *
	 * @return	array	A nest array of component objects and submenus
	 * @since	1.6
	 */
	public static function getComponents($authCheck = true)
	{
		// Initialise variables.
		$lang	= JFactory::getLanguage();
		$user	= JFactory::getUser();
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$result	= array();
		$langs	= array();

		// Prepare the query.
		$query->select('m.id, m.title, m.alias, m.link, m.parent_id, m.img, e.element');
		$query->from('#__menu AS m');

		// Filter on the enabled states.
		$query->leftJoin('#__extensions AS e ON m.component_id = e.extension_id');
		$query->where('m.menutype = '.$db->quote('_adminmenu'));
		$query->where('e.enabled = 1');
		$query->where('m.id > 1');

		// Order by lft.
		$query->order('m.lft');

		$db->setQuery($query);
		// component list
		$components	= $db->loadObjectList();

		// Parse the list of extensions.
		foreach ($components as &$component) {
			// Trim the menu link.
			$component->link = trim($component->link);

			if ($component->parent_id == 1) {
				// Only add this top level if it is authorised and enabled.
				if ($authCheck == false || ($authCheck && $user->authorise('core.manage', $component->element))) {
					// Root level.
					$result[$component->id] = $component;
					if (!isset($result[$component->id]->submenu)) {
						$result[$component->id]->submenu = array();
					}

					// If the root menu link is empty, add it in.
					if (empty($component->link)) {
						$component->link = 'index.php?option='.$component->element;
					}

					if (!empty($component->element)) {
						$langs[$component->element.'.sys'] = true;
					}
				}
			} else {
				// Sub-menu level.
				if (isset($result[$component->parent_id])) {
					// Add the submenu link if it is defined.
					if (isset($result[$component->parent_id]->submenu) && !empty($component->link)) {
						$result[$component->parent_id]->submenu[] = &$component;
					}
				}
			}
		}

		// Load additional language files.
		foreach (array_keys($langs) as $langName) {
			// Load the core file then
			// Load extension-local file.
				$lang->load($langName, JPATH_BASE, null, false, false)
			||	$lang->load($langName, JPATH_ADMINISTRATOR.'/components/'.str_replace('.sys', '', $langName), null, false, false)
			||	$lang->load($langName, JPATH_BASE, $lang->getDefault(), false, false)
			||	$lang->load($langName, JPATH_ADMINISTRATOR.'/components/'.str_replace('.sys', '', $langName), $lang->getDefault(), false, false);
		}

		return $result;
	}
}