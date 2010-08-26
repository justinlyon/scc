<?php
/*
 *  $Id: BasePage.php 501 2008-12-11 20:08:24Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

abstract class BasePage
{
	/**
	 * Renders a page using the given model bean
	 * (returned from a successful Action)
	 *
	 * Default implementation simply dumps the model. Subclasses
	 * should implement a more useful presentation or use the "task"
	 * request variable to invoke one of several alternative methods.
	 *
	 * @param mixed $bean Post-action values for the resulting page
	 */
	public function render($bean) {
		print_r($bean);
	}

	/**
	 * Redirects the browser to a given location. The given argument
	 * is expeted to be a fully-qualified URL. Subclasses may wish to
	 * override to provide more robust redirection logic.
	 *
	 * @param $url the redirection target
	 */
	public function redirect($url) {
		header('Location: ' . $url);
		exit;
	}
}
?>
