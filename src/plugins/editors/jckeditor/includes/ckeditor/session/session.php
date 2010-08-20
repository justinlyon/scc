<?php 

class JCKSession
{

	
	function & getSessionInstance()
	{
		static $instance;
		
		if($instance)
		{
			return $instance;
		}	
		$client = 'administrator';
		
		//$client = JRequest::getInt('client',1); conflict when using Joomla JRequest
		
		//Lets client directly from $_GET variable
		$client = $_GET['client'];
 		
		$client =   (isset($client) && $client == 1 ? 'administrator' : 'site' );
		
		$mainframe =& JFactory::getApplication($client);		
		$mainframe->initialise();
		$instance =  &JFactory::getSession();		
		
		return 	$instance;
	}
	

}