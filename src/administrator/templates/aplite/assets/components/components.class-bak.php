<?php
defined('_JEXEC') or die('Direct access is not allowed');

class APclass
{
	function load_components()
	{
		$db   = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$lang = &JFactory::getLanguage();
		
		$editAllComponents	= $user->authorize('com_components', 'manage');
		
		$query = 'SELECT *' .
		         ' FROM #__components' .
		         ' WHERE '.$db->NameQuote( 'option' ).' <> "com_frontpage"' .
		         ' AND '.$db->NameQuote( 'option' ).' <> "com_media"' .
		         ' AND enabled = 1' .
		         ' ORDER BY ordering, name';
		         $db->setQuery($query);
		       
		$comps = $db->loadObjectList(); // component list
		$subs  = array(); // sub menus
		$langs = array(); // additional language files to load
		$rows  = array();

		// first pass to collect sub-menu items
		foreach ($comps as $row)
		{
			if ($row->parent)
			{
				if (!array_key_exists($row->parent, $subs)) {
					$subs[$row->parent] = array ();
				}
				$subs[$row->parent][] = $row;
				$langs[$row->option.'.menu'] = true;
			} elseif (trim($row->admin_menu_link)) {
				$langs[$row->option.'.menu'] = true;
			}
		}

		// Load additional language files
		if (array_key_exists('.menu', $langs)) {
			unset($langs['.menu']);
		}
		foreach ($langs as $lang_name => $nothing) {
			$lang->load($lang_name);
		}

		foreach ($comps as $row)
		{
			if ($editAllComponents || $user->authorize('administration', 'edit', 'components', $row->option))
			{
				if ($row->parent == 0 && (trim($row->admin_menu_link) || array_key_exists($row->id, $subs)))
				{
					$text   = $lang->hasKey($row->option) ? JText::_($row->option) : $row->name;
					$link   = $row->admin_menu_link ? "index.php?$row->admin_menu_link" : "index.php?option=$row->option";
					
					$row->children = array();
					
					if (array_key_exists($row->id, $subs)) {
						foreach ($subs[$row->id] as $sub) {
							$key  = $row->option.'.'.$sub->name;
							$text = $lang->hasKey($key) ? JText::_($key) : $sub->name;
							$link = $sub->admin_menu_link ? "index.php?$sub->admin_menu_link" : null;
							$row->children[] = $sub;
						}
					}
					if($row->parent == 0) {
						$rows[] = $row;
					}
				}
			}
		}
		return $rows;
	}
	
	function loadSearchResults($keyword = null)
	{
		if(is_null($keyword)) {
			return array();
		}
		
		$db = &JFactory::getDBO();
		
		// Search components
		$query = "SELECT name FROM #__components WHERE name LIKE '%$keyword%'";
		       $db->setQuery($query);
		       $rows = $db->loadObjectList();
		       
		echo $keyword;       
	}
}
?>
