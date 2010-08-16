<?php
/**
 * @version		$Id: calendar.php 17620 2010-06-12 09:45:04Z infograf768 $
 * @package		Joomla.Framework
 * @subpackage	Form
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldCalendar extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'Calendar';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Initialize some field attributes.
		$format = $this->element['format'] ? (string) $this->element['format'] : '%Y-%m-%d';

		// Build the attributes array.
		$attributes = array();
		if ($this->element['size']) {
			$attributes['size'] = (int) $this->element['size'];
		}
		if ($this->element['maxlength']) {
			$attributes['maxlength'] = (int) $this->element['maxlength'];
		}
		if ($this->element['class']) {
			$attributes['class'] = (string) $this->element['class'];
		}
		if ((string) $this->element['readonly'] == 'true') {
			$attributes['readonly'] = 'readonly';
		}
		if ((string) $this->element['disabled'] == 'true') {
			$attributes['disabled'] = 'disabled';
		}
		if ($this->element['onchange']) {
			$attributes['onchange'] = (string) $this->element['onchange'];
		}

		// Handle the special case for "now".
		if (strtoupper($this->value) == 'NOW') {
			$this->value = strftime($format);
		}

		// Get some system objects.
		$config = JFactory::getConfig();
		$user	= JFactory::getUser();

		// If a known filter is given use it.
		switch (strtoupper((string) $this->element['filter']))
		{
			case 'SERVER_UTC':
				// Convert a date to UTC based on the server timezone.
				if (intval($this->value)) {
					// Get a date object based on the correct timezone.
					$date = JFactory::getDate($this->value, 'UTC');
					$date->setTimezone(new DateTimeZone($config->get('offset')));

					// Transform the date string.
					$this->value = $date->toMySQL(true);
				}
				break;

			case 'USER_UTC':
				// Convert a date to UTC based on the user timezone.
				if (intval($this->value)) {
					// Get a date object based on the correct timezone.
					$date = JFactory::getDate($this->value, 'UTC');
					$date->setTimezone(new DateTimeZone($user->getParam('timezone', $config->get('offset'))));

					// Transform the date string.
					$this->value = $date->toMySQL(true);
				}
				break;
		}

		return JHtml::_('calendar', $this->value, $this->name, $this->id, $format, $attributes);
	}
}
