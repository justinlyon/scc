<?php
/**
 *  $Id$: FrontVenuePage.php, Nov 2, 2006 11:42:28 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
 
if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/..');
}

require_once WEB_INF . '/pages/MasterPage.php';
require_once WEB_INF . '/beans/Venue.php';
require_once ('tachometry/util/BeanUtil.php');

class FrontVenuePage extends MasterPage
{	 
	/**
	 * The default render method.  Displays the summary list
	 * @param bean $model The exhibition summary model
	 */
	public function render($model)
	{
		global $logger;
		$logger->debug(get_class($this) . '::render()');
		$this->detail($model);	
	} 
	
	/**
	 * Displays the venue detail
	 * @param bean $model The program detail model
	 */
	public function detail($model)
	{
		global $logger, $mainframe;
		$logger->debug(get_class($this) . "::detail($model)");
		
		$venue = $model->getDetail();
		
		$tmpl = $this->createPatTemplate(FRONT_TEMPLATE_DIR);
		$tmpl->readTemplatesFromInput( 'venue_detail.pat.tpl' );
		
		// simple attributes
		$tmpl->addVars('venue', BeanUtil::beanToArray($venue,true)); // scalars only
		
		// page title
		$mainframe->setPageTitle("Facilities Tour | ". $venue->getName() );
		
		// Gallery
		if ($venue->getGallery() != null) {
			$gal = $venue->getGallery();
			$logger->debug("Type of gallery [Gallery]: ". get_class($gal));
			$images = $gal->getImages();
			$tmpl->addVar('photo','gallery',true);
			foreach( $images as $img) {
				$logger->debug('Class of img [Image]: '. get_class($img) . $img);
				$tmpl->addVar('photo','url',$img->getUrl());
				$tmpl->addVar('photo','author',$img->getAuthor());	
				$tmpl->addVar('photo','title',$img->getTitle());	
				$tmpl->parseTemplate('photo',"a");
			}
		}
		
		// address
		if ($venue->getAddress() != null && $venue->getAddress()->getStreet() != "") {
			$logger->debug("Type of address [Address]: ". gettype($venue->getAddress()));
			
			$addr = $venue->getAddress();
			$astr = "";
			if ($addr->getPhone() != null) {
				$astr .= "<strong>". $addr->getPhone() ."</strong><br/>";
			}
			$astr .= $addr->getStreet() ."<br/>";
			if ($addr->getUnit() != null) {
				$astr .= $addr->getUnit() ."<br/>";	
			}
			if ($addr->getCity() != null) {
				$astr .= $addr->getCity() .", ";	
			}
			$astr .= $addr->getState() ." ". $addr->getPostalCode();
			
			$tmpl->addVar('venue','address',$astr);
		}
		$tmpl->displayParsedTemplate('venue');
	}	
}
?>

