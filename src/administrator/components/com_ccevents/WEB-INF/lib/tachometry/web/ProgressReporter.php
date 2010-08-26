<?php
/*
 *  $Id: ProgressReporter.php 1290 2008-09-17 00:12:23Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

require_once('simpletest/reporter.php');

class ProgressReporter extends HtmlReporter {
	
	private $_test_count = 0;
	private $_test_total = 23;
	
	function paintHeader($test_name) {
        $this->sendNoCacheHeaders();
        print "<html>\n<head>\n<title>$test_name</title>\n";
        print "<style type=\"text/css\">\n";
        print $this->_getCss() . "\n";
        print "</style>\n";
        print "</head>\n<body>\n";
        print "<h1>$test_name</h1>\n";
    	echo str_pad('<div class="progress percents">Loading...</div>',4096)."\n";
		ob_start();
	}

    function paintFooter($test_name) {
    	echo '<div class="progress percents" style="z-index:12">Done.</div>';
    	ob_end_flush();
    	parent::paintFooter($test_name);
    }
    
    function paintGroupStart($test_name, $size) {
        parent::paintGroupStart($test_name, $size);
    }
    
    function paintGroupEnd($test_name, $size) {
    	parent::paintGroupEnd($test_name, $size);
    }
    
    function paintMethodStart($test_name) {
        parent::paintMethodStart($test_name);
        $this->_test_count += 1;
    }
    
    function paintMethodEnd($test_name) {
        parent::paintMethodEnd($test_name);
    	echo '<div class="progress percents">' . intval(($this->_test_count/$this->_test_total)*100) . "%&nbsp;complete</div>\n";
        echo '<div class="progress blocks" style="left: '. $this->_test_count*12 .'px">&nbsp;</div>';
    	flush();
   		ob_flush();
   		sleep(1);
    }
    
    function paintPass($message) {
        parent::paintPass($message);
    }
    
    function paintFail($message) {
        parent::paintFail($message);
    }
    
    function _getCss() {
    	$result = parent::_getCss();
		$result .= "\n.progress { margin: 1px; height: 20px; padding: 1px; border: 1px solid #000; width: 275px; " .
					"background: #fff; color: #000; float: left; clear: right; top: 75px; z-index: 9; }";
		$result .= "\n.percents { background: #FFF; border: 1px solid #CCC; margin: 1px; height: 20px; " .
					"position:absolute; width:275px; z-index:10; left: 10px; top: 75px; text-align: center; }";
		$result .= "\n.blocks { background: #EEE; border: 1px solid #CCC; margin: 1px; height: 20px; width: 10px; " .
					"position: absolute; z-index:11; left: 12px; top: 75px; " .
					"filter: alpha(opacity=50); -moz-opacity: 0.5; opacity: 0.5; -khtml-opacity: .5 }";
		return $result;
    }
}
?>