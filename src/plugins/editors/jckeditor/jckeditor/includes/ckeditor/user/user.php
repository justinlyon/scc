<?php

//wrapper class for Juser

class JCKUser extends JObject
{
	
		

	function &getInstance()
    {
				
		static $instance;
		
		if($instance)
			return $instance;
		
		$session = JCKUser::getSession(); //get Session incase it has not been set		
		$instance =& $session->get('user'); 
			
		return $instance;
	}
		
	
	function &getSession()
	{
		static $instance;
		if($instance)
			return $instance;
		jckimport('ckeditor.session.session');
		$instance =& JCKSession::getSessionInstance();
		return $instance;
	}
	

}