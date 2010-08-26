<?php
/*
 *  $Id: BaseAction.php 501 2008-12-11 20:08:24Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

abstract class BaseAction
{
	/**
	 * Executes and action using the given framework parameter
	 * (provided via the ActionDispatcher)
	 *
	 * Default implementation simply returns the given parameter. Subclasses
	 * should implement appropriate business logic or use the "task"
	 * request variable to invoke one of several alternative methods.
	 *
	 * @param mixed $arg Optional framework parameter passed via the caller
	 */
	public function execute($arg=null)
	{
		return $arg;
	}
}



?>
