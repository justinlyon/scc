<?php
/**
 * @version		$Id: languages.php 16326 2010-04-22 03:59:51Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Languages Model Class
 *
 * @package		Joomla.Administrator
 * @subpackage	com_languages
 * @version		1.5
 */
class LanguagesModelLanguages extends JModelList
{
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context.'.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// Load the parameters.
		$params		= JComponentHelper::getParams('com_languages');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.title', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.published');

		return parent::getStoreId($id);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select all fields from the users table.
		$query->select($this->getState('list.select', 'a.*'));
		$query->from('`#__languages` AS a');

		// Filter on the published state.
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = '.(int) $published);
		} else if ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$search = $db->Quote('%'.$db->getEscaped($search, true).'%', false);
			$query->where('(a.title LIKE '.$search.')');
		}

		// Add the list ordering clause.
		$query->order($db->getEscaped($this->getState('list.ordering', 'a.ordering')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));

		return $query;
	}

	public function setPublished($cid, $value = 0)
	{
		return JTable::getInstance('Language')->publish($cid, $value);
	}

	/**
	 * Method to delete records.
	 *
	 * @param	array	An array of item primary keys.
	 *
	 * @return	boolean	Returns true on success, false on failure.
	 */
	public function delete($pks)
	{
		// Sanitize the array.
		$pks = (array) $pks;

		// Get a row instance.
		$table = JTable::getInstance('Language');

		// Iterate the items to delete each one.
		foreach ($pks as $itemId)
		{
			if (!$table->delete((int) $itemId))
			{
				$this->setError($table->getError());
				return false;
			}
		}

		return true;
	}
}
