<?php
/**
 * @version		$Id: grid.php 17854 2010-06-23 17:43:55Z eddieajau $
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Utility class for creating HTML Grids
 *
 * @static
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @since		1.5
 */
abstract class JHtmlGrid
{
	/**
	 * Display a boolean setting widget.
	 *
	 * @static
	 * @param	integer	The row index.
	 * @param	integer	The value of the boolean field.
	 * @param	string	Task to turn the boolean setting on.
	 * @param	string	Task to turn the boolean setting off.
	 * @return	string	The boolean setting widget.
	 * @since	1.0
	 */
	static function boolean($i, $value, $taskOn = null, $taskOff = null)
	{
		// Load the behavior.
		self::behavior();

		// Build the title.
		$title = ($value) ? JText::_('JYES') : JText::_('JNO');
		$title .= '::'.JText::_('JGLOBAL_CLICK_TO_TOGGLE_STATE');

		// Build the <a> tag.
		$bool	= ($value) ? 'true' : 'false';
		$task	= ($value) ? $taskOff : $taskOn;
		$toggle	= (!$task) ? false : true;

		if ($toggle) {
			$html = '<a class="grid_'.$bool.' hasTip" title="'.$title.'" rel="{id:\'cb'.$i.'\', task:\''.$task.'\'}" href="#toggle"></a>';
		} else {
			$html = '<a class="grid_'.$bool.'" rel="{id:\'cb'.$i.'\', task:\''.$task.'\'}"></a>';
		}

		return $html;
	}

	/**
	 * @param	string	The link title
	 * @param	string	The order field for the column
	 * @param	string	The current direction
	 * @param	string	The selected ordering
	 * @param	string	An optional task override
	 */
	public static function sort($title, $order, $direction = 'asc', $selected = 0, $task=NULL)
	{
		$direction	= strtolower($direction);
		$images		= array('sort_asc.png', 'sort_desc.png');
		$index		= intval($direction == 'desc');
		$direction	= ($direction == 'desc') ? 'asc' : 'desc';

		$html = '<a href="javascript:tableOrdering(\''.$order.'\',\''.$direction.'\',\''.$task.'\');" title="'.JText::_('JGLOBAL_CLICK_TO_SORT_THIS_COLUMN').'">';
		$html .= JText::_($title);
		if ($order == $selected) {
			$html .= JHTML::_('image','system/'.$images[$index], '', NULL, true);
		}
		$html .= '</a>';
		return $html;
	}

	/**
	* @param int The row index
	* @param int The record id
	* @param boolean
	* @param string The name of the form element
	*
	* @return string
	*/
	public static function id($rowNum, $recId, $checkedOut=false, $name='cid')
	{
		if ($checkedOut) {
			return '';
		} else {
			return '<input type="checkbox" id="cb'.$rowNum.'" name="'.$name.'[]" value="'.$recId.'" onclick="isChecked(this.checked);" title="'.JText::sprintf('JGRID_CHECKBOX_ROW_N', ($rowNum + 1)).'" />';
		}
	}

	/**
	 * @deprecated
	 */
	public static function access(&$row, $i, $archived = NULL)
	{
		// TODO: This needs to be reworked to suit the new access levels
		if ($row->access <= 1)  {
			$color_access = 'class="allow"';
			$task_access = 'accessregistered';
		} else if ($row->access == 1) {
			$color_access = 'class="deny"';
			$task_access = 'accessspecial';
		} else {
			$color_access = 'class="none"';
			$task_access = 'accesspublic';
		}

		if ($archived == -1)
		{
			$href = JText::_($row->groupname);
		}
		else
		{
			$href = '
			<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task_access .'\')" '. $color_access .'>
			'. JText::_($row->groupname) .'</a>'
			;
		}

		return $href;
	}

	public static function checkedOut(&$row, $i, $identifier = 'id')
	{
		$user	= JFactory::getUser();
		$userid = $user->get('id');

		$result = false;
		if ($row INSTANCEOF JTable) {
			$result = $row->isCheckedOut($userid);
		} else {
			$result = JTable::isCheckedOut($userid, $row->checked_out);
		}

		$checked = '';
		if ($result) {
			$checked = JHtmlGrid::_checkedOut($row);
		} else {
			if ($identifier == 'id')
				$checked = JHtml::_('grid.id', $i, $row->$identifier);
			else
				$checked = JHtml::_('grid.id', $i, $row->$identifier, $result, $identifier);
		}

		return $checked;
	}

	/**
	 * @param	mixed $value	Either the scalar value, or an object (for backward compatibility, deprecated)
	 * @param	int $i
	 * @param	string $img1	Image for a positive or on value
	 * @param	string $img0	Image for the empty or off value
	 * @param	string $prefix	An optional prefix for the task
	 */
	public static function published($value, $i, $img1 = 'tick.png', $img0 = 'publish_x.png', $prefix='')
	{
		if (is_object($value)) {
			$value = $value->published;
		}
		$img	= $value ? $img1 : $img0;
		$task	= $value ? 'unpublish' : 'publish';
		$alt	= $value ? JText::_('JPUBLISHED') : JText::_('JUNPUBLISHED');
		$action = $value ? JText::_('JLIB_HTML_UNPUBLISH_ITEM') : JText::_('JLIB_HTML_PUBLISH_ITEM');

		$href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $prefix.$task .'\')" title="'. $action .'">'.
		JHTML::_('image','admin/'.$img, $alt, array('border' => 0), true).'</a>'
		;

		return $href;
	}

	public static function state(
		$filter_state = '*',
		$published = 'Published',
		$unpublished = 'Unpublished',
		$archived = null,
		$trashed = null
	) {
		$state = array(
			'' => '- ' . JText::_('JLIB_HTML_SELECT_STATE') . ' -',
			'P' => JText::_($published),
			'U' => JText::_($unpublished)
		);

		if ($archived) {
			$state['A'] = JText::_($archived);
		}

		if ($trashed) {
			$state['T'] = JText::_($trashed);
		}

		return JHtml::_(
			'select.genericlist',
			$state,
			'filter_state',
			array(
				'list.attr' => 'class="inputbox" size="1" onchange="submitform();"',
				'list.select' => $filter_state,
				'option.key' => null
			)
		);
	}

	public static function order($rows, $image = 'filesave.png', $task = 'saveorder')
	{
		// $image = JHTML::_('image','admin/'.$image, JText::_('JLIB_HTML_SAVE_ORDER'), NULL, true);
		$href = '<a href="javascript:saveorder('.(count($rows)-1).', \''.$task.'\')" class="saveorder" title="'.JText::_('JLIB_HTML_SAVE_ORDER').'"></a>';
		return $href;
	}


	protected static function _checkedOut(&$row, $overlib = 1)
	{
		$hover = '';
		if ($overlib)
		{
			$text = addslashes(htmlspecialchars($row->editor, ENT_COMPAT, 'UTF-8'));

			$date	= JHTML::_('date',$row->checked_out_time, JText::_('DATE_FORMAT_LC1'));
			$time	= JHTML::_('date',$row->checked_out_time, 'H:i');

			$hover = '<span class="editlinktip hasTip" title="'. JText::_('JLIB_HTML_CHECKED_OUT') .'::'. $text .'<br />'. $date .'<br />'. $time .'">';
		}
		$checked = $hover .JHTML::_('image','admin/checked_out.png', NULL, NULL, true).'</span>';

		return $checked;
	}

	static function behavior()
	{
		static $loaded;

		if (!$loaded)
		{
			// Build the behavior script.
			$js = '
		window.addEvent(\'domready\', function(){
			actions = $$(\'a.move_up\');
			actions.combine($$(\'a.move_down\'));
			actions.combine($$(\'a.grid_true\'));
			actions.combine($$(\'a.grid_false\'));
			actions.combine($$(\'a.grid_trash\'));
			actions.each(function(a){
				a.addEvent(\'click\', function(){
					args = JSON.decode(this.rel);
					listItemTask(args.id, args.task);
				});
			});
			$$(\'input.check-all-toggle\').each(function(el){
				el.addEvent(\'click\', function(){
					if (el.checked) {
						document.id(this.form).getElements(\'input[type=checkbox]\').each(function(i){
							i.checked = true;
						})
					}
					else {
						document.id(this.form).getElements(\'input[type=checkbox]\').each(function(i){
							i.checked = false;
						})
					}
				});
			});
		});';

			// Add the behavior to the document head.
			$document = JFactory::getDocument();
			$document->addScriptDeclaration($js);

			$loaded = true;
		}
	}
}
