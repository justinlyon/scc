<?php
/**
 * @version		$Id: codemirror.php 17694 2010-06-15 08:32:34Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * CodeMirror Editor Plugin.
 *
 * @package		Joomla
 * @subpackage	Editors
 * @since		1.6
 */
class plgEditorCodemirror extends JPlugin
{
	/**
	 * Base path for editor files
	 */
	protected $_basePath = 'media/editors/codemirror/';

	/**
	 * Initialises the Editor.
	 *
	 * @return	string	JavaScript Initialization string.
	 */
	public function onInit()
	{
		JHtml::_('core');
		JHTML::_('script',$this->_basePath . 'js/codemirror.js', false, false, false, false);
		JHTML::_('stylesheet',$this->_basePath . 'css/codemirror.css');

		return '';
	}

	/**
	 * Copy editor content to form field.
	 *
	 * @param	string	$id	The id of the editor field.
	 *
	 * @return string Javascript
	 */
	public function onSave($id)
	{
		return "document.getElementById('$id').value = Joomla.editors.instances['$id'].getCode();\n";
	}

	/**
	 * Get the editor content.
	 *
	 * @param	string	$id	The id of the editor field.
	 *
	 * @return string Javascript
	 */
	public function onGetContent($id)
	{
		return "Joomla.editors.instances['$id'].getCode();\n";
	}

	/**
	 * Set the editor content.
	 *
	 * @param	string	$id			The id of the editor field.
	 * @param	string	$content	The content to set.
	 *
	 * @return string Javascript
	 */
	public function onSetContent($id, $content)
	{
		return "Joomla.editors.instances['$id'].setCode($content);\n";
	}

	/**
	 * Adds the editor specific insert method.
	 *
	 * @return boolean
	 */
	public function onGetInsertMethod()
	{
		static $done = false;

		// Do this only once.
		if (!$done)
		{
			$done = true;
			$doc = JFactory::getDocument();
			$js = "\tfunction jInsertEditorText(text, editor) {
					Joomla.editors.instances[editor].replaceSelection(text);\n
			}";
			$doc->addScriptDeclaration($js);
		}

		return true;
	}

	/**
	 * Display the editor area.
	 *
	 * @param	string	$name		The name of the editor area.
	 * @param	string	$content	The content of the field.
	 * @param	string	$width		The width of the editor area.
	 * @param	string	$height		The height of the editor area.
	 * @param	int		$col		The number of columns for the editor area.
	 * @param	int		$row		The number of rows for the editor area.
	 * @param	mixed	$buttons	[array with button objects | boolean true to display buttons]
	 * @param	string	$id			The ID for the textarea (note: since 1.6). If not supplied the name is used.
	 *
	 * @return string HTML
	 */
	public function onDisplay($name, $content, $width, $height, $col, $row, $buttons = true, $id = null)
	{
		if (empty($id)) {
			$id = $name;
		}

		// Only add "px" to width and height if they are not given as a percentage
		if (is_numeric($width)) {
			$width .= 'px';
		}
		if (is_numeric($height)) {
			$height .= 'px';
		}

		// Must pass the field id to the buttons in this editor.
		$buttons = $this->_displayButtons($id, $buttons);

		$compressed	= JFactory::getApplication()->getCfg('debug') ? '-uncompressed' : '';

		// Default syntax
		$parserFile = 'parsexml.js';
		$styleSheet = 'xmlcolors.css';

		// Look if we need special syntax coloring.
		$syntax = JFactory::getApplication()->getUserState('editor.source.syntax');

		if ($syntax)
		{
			switch($syntax)
			{
				case 'css':
					$parserFile = 'parsecss.js';
					$styleSheet = 'csscolors.css';
					break;

				case 'js':
					// @todo Do we edit javascript ?
					$parserFile = array('tokenizejavascript.js', 'parsejavascript.js');
					$styleSheet = 'jscolors.css';
					break;

				case 'php':
					// @todo CodeMirror comes with a parsephp.js file which has a BSD license - can we include this ?
					break;

				default:
					;
					break;
			}//switch
		}

		$options	= new stdClass;

		$options->basefiles		= array('basefiles'.$compressed.'.js');
		$options->path			= JURI::root(true).'/'.$this->_basePath.'js/';
		$options->parserfile	= $parserFile;
		$options->stylesheet	= JURI::root(true).'/'.$this->_basePath.'css/'.$styleSheet;
		$options->height		= $height;
		$options->width			= $width;
		$options->continuousScanning = 500;
		if ($this->params->get('linenumbers', 0)) {
			$options->lineNumbers	= true;
			$options->textWrapping	= false;
		}
		if ($this->params->get('tabmode', '') == 'shift') {
			$options->tabMode = 'shift';
		}

		$html = array();
		$html[]	= "<textarea name=\"$name\" id=\"$id\" cols=\"$col\" rows=\"$row\">$content</textarea>";
		$html[] = $buttons;
		$html[] = '<script type="text/javascript">';
		$html[] = '(function() {';
		$html[] = 'var editor = CodeMirror.fromTextArea("'.$id.'", '.json_encode($options).');';
		$html[] = 'Joomla.editors.instances[\''.$id.'\'] = editor;';
		$html[] = '})()';
		$html[] = '</script>';
		return implode("\n", $html);
	}

	/**
	 * Displays the editor buttons.
	 *
	 * @param string $name
	 * @param mixed $buttons [array with button objects | boolean true to display buttons]
	 *
	 * @return string HTML
	 */
	protected function _displayButtons($name, $buttons)
	{
		// Load modal popup behavior
		JHtml::_('behavior.modal', 'a.modal-button');

		$args['name'] = $name;
		$args['event'] = 'onGetInsertMethod';

		$html = array();
		$results[] = $this->update($args);
		foreach ($results as $result) {
			if (is_string($result) && trim($result)) {
				$html[] = $result;
			}
		}

		if(is_array($buttons) || (is_bool($buttons) && $buttons))
		{
			$results = $this->_subject->getButtons($name, $buttons);

			// This will allow plugins to attach buttons or change the behavior on the fly using AJAX
			$html[] = '<div id="editor-xtd-buttons">';
			foreach ($results as $button)
			{
				// Results should be an object
				if ($button->get('name')) {
					$modal		= ($button->get('modal')) ? 'class="modal-button"' : null;
					$href		= ($button->get('link')) ? 'href="'.$button->get('link').'"' : null;
					$onclick	= ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : null;
					$html[] = '<div class="button2-left"><div class="'.$button->get('name').'">';
					$html[] = '<a '.$modal.' title="'.$button->get('text').'" '.$href.' '.$onclick.' rel="'.$button->get('options').'">';
					$html[] = $button->get('text').'</a></div></div>';
				}
			}
			$html[] = '</div>';
		}

		return implode("\n", $html);
	}
}
