<?php


defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.event.plugin');


class plgDefaultUser extends JPlugin 
{
		
  	function plgDefaultUser(& $subject, $config) 
	{
		parent::__construct($subject, $config);
	}
	
	//default method that is called
	function intialize(&$params) // Editor's params passed in
	{
		//To be implemented	
		//Get user
		$user =& JFactory::getUser();
		
		if($user->gid == 25) //Super Aministrators see everything
			return;
		
		//check editor parameters
		$useUserFolder =  $params->get('useUserFolders',0);
		$userFolderType =  $params->get('userFolderType','username');
		
		
		if(!$useUserFolder)
			return;
				
		//Get user id
		if($userFolderType == 'username')
		{
			$id =  $user->username;
		}	
		else
		{ 	
			$id  = $user->id;	
		}

		//Now set media paths
		//Get current value set in DB
		$imagePath = $params->get('imagePath','images') . DS . $id;
		$params->set('imagePath',$imagePath);
		
		
		$flashPath = $params->get('flashPath','flash')  . DS . $id;
		$params->set('flashPath',$flashPath);
		
		
		//Now set media paths
		//Get current value set in DB
		$filePath = $params->get('filePath','files')  . DS . $id;
		$params->set('filePath',$filePath);
		
	}
	
}