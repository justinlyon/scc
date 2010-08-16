<?php
/**
 * @version		$Id: sef.php 17851 2010-06-23 17:39:31Z eddieajau $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
* Joomla! SEF Plugin
*
 * @package		Joomla
 * @subpackage	System
 */
class plgSystemSef extends JPlugin
{
	/**
	 * Converting the site URL to fit to the HTTP request
	 */
	public function onAfterRender()
	{
		$app = JFactory::getApplication();

		if ($app->getName() != 'site') {
			return true;
		}

		//Replace src links
		$base	= JURI::base(true).'/';
		$buffer = JResponse::getBody();

			$regex  = '#href="index.php\?([^"]*)#m';
		$buffer = preg_replace_callback($regex, array('plgSystemSEF', 'route'), $buffer);

			$protocols	= '[a-zA-Z0-9]+:'; //To check for all unknown protocals (a protocol must contain at least one alpahnumeric fillowed by :
		$regex		= '#(src|href)="(?!/|'.$protocols.'|\#|\')([^"]*)"#m';
		$buffer		= preg_replace($regex, "$1=\"$base\$2\"", $buffer);
		$regex		= '#(onclick="window.open\(\')(?!/|'.$protocols.'|\#)([^/]+[^\']*?\')#m';
		$buffer		= preg_replace($regex, '$1'.$base.'$2', $buffer);

		// ONMOUSEOVER / ONMOUSEOUT
		$regex		= '#(onmouseover|onmouseout)="this.src=([\']+)(?!/|'.$protocols.'|\#|\')([^"]+)"#m';
		$buffer	= preg_replace($regex, '$1="this.src=$2'. $base .'$3$4"', $buffer);

		// Background image
		$regex		= '#style\s*=\s*[\'\"](.*):\s*url\s*\([\'\"]?(?!/|'.$protocols.'|\#)([^\)\'\"]+)[\'\"]?\)#m';
		$buffer	= preg_replace($regex, 'style="$1: url(\''. $base .'$2$3\')', $buffer);

		// OBJECT <param name="xx", value="yy"> -- fix it only inside the <param> tag
		$regex		= '#(<param\s+)name\s*=\s*"(movie|src|url)"[^>]\s*value\s*=\s*"(?!/|'.$protocols.'|\#|\')([^"]*)"#m';
		$buffer	= preg_replace($regex, '$1name="$2" value="' . $base . '$3"', $buffer);

		// OBJECT <param value="xx", name="yy"> -- fix it only inside the <param> tag
		$regex		= '#(<param\s+[^>]*)value\s*=\s*"(?!/|'.$protocols.'|\#|\')([^"]*)"\s*name\s*=\s*"(movie|src|url)"#m';
		$buffer	= preg_replace($regex, '<param value="'. $base .'$2" name="$3"', $buffer);

		// OBJECT data="xx" attribute -- fix it only in the object tag
		$regex =	'#(<object\s+[^>]*)data\s*=\s*"(?!/|'.$protocols.'|\#|\')([^"]*)"#m';
		$buffer	= preg_replace($regex, '$1data="' . $base . '$2"$3', $buffer);

		JResponse::setBody($buffer);
		return true;
	}

	/**
	 * Replaces the matched tags
	 *
	 * @param	array	An array of matches (see preg_match_all)
	 * @return	string
	 */
	protected static function route(&$matches)
	{
		$original	= $matches[0];
		$url		= $matches[1];
		$url		= str_replace('&amp;','&',$url);
		$route		= JRoute::_('index.php?'.$url);

		return 'href="'.$route;
	}
}