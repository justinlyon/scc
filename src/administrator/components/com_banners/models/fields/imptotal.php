<?php
/**
 * @version		$Id: imptotal.php 17128 2010-05-17 05:46:33Z severdia $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Impressions Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	com_banners
 * @since		1.6
 */
class JFormFieldImpTotal extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'ImpTotal';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		$class		= ' class="validate-numeric text_area"';
		$onchange	= ' onchange="document.id(\''.$this->id.'_unlimited\').checked=document.id(\''.$this->id.'\').value==\'\';"';
		$onclick	= ' onclick="if (document.id(\''.$this->id.'_unlimited\').checked) document.id(\''.$this->id.'\').value=\'\';"';
		$value		= empty($this->value) ? '' : $this->value;
		$checked	= empty($this->value) ? ' checked="checked"' : '';

		return '<input type="text" name="'.$this->name.'" id="'.$this->id.'" value="'.htmlspecialchars($value, ENT_COMPAT, 'UTF-8').'" '.$class.$onchange.' /><input id="'.$this->id.'_unlimited" type="checkbox"'.$checked.$onclick.' /><input style="border:0;" type="text" value="'.JText::_('COM_BANNERS_UNLIMITED').'" readonly="readonly" id="jform-imp"/>';
	}
}
