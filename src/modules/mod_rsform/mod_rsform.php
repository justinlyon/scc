<?php
/**
* @version 1.2.0
* @package RSform!Pro Into Content 1.2.0
* @copyright (C) 2007-2008 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/terms-and-conditions.html
*/
@session_start();
if(file_exists(dirname(__FILE__).'/../../components/com_rsform/controller/adapter.php')){
	require_once(dirname(__FILE__).'/../../components/com_rsform/controller/adapter.php');
	require_once(dirname(__FILE__).'/../../components/com_rsform/controller/functions.php');
	require_once(dirname(__FILE__).'/../../components/com_rsform/controller/validation.php');
}else{
	require_once(dirname(__FILE__).'/../components/com_rsform/controller/adapter.php');
	require_once(dirname(__FILE__).'/../components/com_rsform/controller/functions.php');
	require_once(dirname(__FILE__).'/../components/com_rsform/controller/validation.php');
}
$RSadapter = new RSadapter();
$GLOBALS['RSadapter'] = $RSadapter;

$GLOBALS['ismodule'] = 'local';

//require backend language file
require_once(_RSFORM_FRONTEND_ABS_PATH.'/languages/'._RSFORM_FRONTEND_LANGUAGE.'.php');

$formId	= intval( $params->def( 'formId', 1 ) );
$moduleclass_sfx = $params->def('moduleclass_sfx','');

echo '<div class="rsform'.$moduleclass_sfx.'">';
	$output = '';
	$RSadapter = $GLOBALS['RSadapter'];

	if(isset($_SESSION['form'][$formId]['thankYouMessage']) && !empty($_SESSION['form'][$formId]['thankYouMessage']))
	{
		$output .= RSshowThankyouMessage($formId);
	}
	else
	{
		if(!empty($_POST['form']['formId']) && $_POST['form']['formId'] == $formId)
		{	
			$invalid = RSprocessForm($formId);		
			if($invalid)
			{
				//the invalid variable is returned
				$output .= RSshowForm($formId, $_POST['form'], $invalid);
			}
		}
		else
		{
			if(isset($_SESSION['form'][$formId]['thankYouMessage']) && empty($_SESSION['form'][$formId]['thankYouMessage']))
			{
				unset($_SESSION['form'][$formId]['thankYouMessage']);
				
				//is there a return url?
				$db = JFactory::getDBO();
				$db->setQuery("SELECT ReturnUrl FROM #__rsform_forms WHERE `formId`='".$formId."'");
				$returnUrl = $db->loadResult();
				if(!empty($returnUrl))
				{
					if(!isset($_SESSION['form'][$formId]['submissionId']))$_SESSION['form'][$formId]['submissionId'] = '';
					$returnUrl = RSprocessField($returnUrl,$_SESSION['form'][$formId]['submissionId']);
					unset($_SESSION['form'][$formId]['submissionId']);
					
					$RSadapter->redirect($returnUrl);
				}
								
				$output .= _RSFORM_FRONTEND_THANKYOU;
			}
			$output .= RSshowForm($formId);
		}
	}
	
	echo $output;
echo '</div>';

?>