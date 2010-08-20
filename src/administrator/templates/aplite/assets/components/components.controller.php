<?php
defined('_JEXEC') or die('Direct access is not allowed');

class APcontroller
{
	function list_components()
	{
		$rows = &APclass::load_components();
		
		APhtml::list_components($rows);
	}
	
	function list_search()
	{
		$keyword = urldecode(JRequest::getVar('gsearch'));
		
		$rows = &APclass::loadSearchResults($keyword);
	}
}
?>