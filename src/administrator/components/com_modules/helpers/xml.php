<?php
/**
 * @version		$Id: xml.php 14567 2010-02-04 07:02:10Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	Modules
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	Modules
 */
class ModulesHelperXML
{
	function parseXMLModuleFile(&$rows)
	{
		foreach ($rows as $i => $row)
		{
			if ($row->module == '')
			{
				$rows[$i]->name		= 'custom';
				$rows[$i]->module	= 'custom';
				$rows[$i]->descrip	= 'Custom created module, using Module Manager `New` function';
			}
			else
			{
				$data = JApplicationHelper::parseXMLInstallFile($row->path.DS.$row->file);

				if ($data['type'] == 'module')
				{
					$rows[$i]->name		= $data['name'];
					$rows[$i]->descrip	= $data['description'];
				}
			}
		}
	}
}