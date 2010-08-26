<?php
/*
 *  $Id: BatchEmail.php 1234 2008-09-05 23:11:34Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

/**
 * This class defines the basic elements of an email batch job. It is
 * designed to be subclassed as appropriate for a particular notification
 * set. Addressees, data selection, and message formatting are implemented
 * by overriding the default implementation methods defined here.
 *
 */
class BatchEmail
{
	/** An array of beans to be included in this email */
	public $beans;

	/**
	 * Construct a new instance of the batch emailer
	 */
	public function __construct($arg=null) {
		if (is_array($arg)) {
			$this->beans = $arg;
		} else {
			$this->beans = array($arg);
		}
	}

	/**
	 * Returns a plain text message. The message will contain one line per
	 * input bean by calling the toString() method for each instance. Subclasses
	 * may override this method to produce a more specific message as appropriate.
	 *
	 * @return String The formatted text message
	 */
	function getTextMessage()
	{
		$txt = "\n";
		$txt .= "================================\n";
		$txt .= "  Automated Email Notification\n";
		$txt .= "================================\n\n";
		$txt .= "The following items require your attention:\n\n";
		$txt .= "----------------------------------------------------------------------------\n";
		$hdr = true;
		foreach ($this->beans as $bean)
		{
			$txt .= $bean->toString($hdr) . "\n";
			$hdr = false;
		}
		$txt .= "----------------------------------------------------------------------------\n\n";
		$txt .= "This is an automated email notification from an unmonitored email address.\n";
		$txt .= "Please do not reply to this message.\n";

		return $txt;
	}

	/**
	 * Returns a formatted HTML message. The message will contain one line per
	 * input bean by calling the toHtml() method for each instance. Subclasses
	 * may override this method to produce a more specific message as appropriate.
	 *
	 * @param $beans An array of beans (extends BaseBean)
	 * @return String The formatted text message
	 */
	function  getHtmlMessage()
	{
		$html = "<html><head><title>Automated Email Notification</title>" .
				"<style type=\"text/css\">\n";
		$html .= "body { font-family: Tahoma, Arial, Helvetica, sans-serif; margin: 10; padding: 0; font-size: 9pt; }\n";
		$html .= "td { font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 8pt; }\n";
		$html .= "th { font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 8pt; }\n";
		$html .= "fieldset { width: 450px; margin: auto; padding: 0 5px 10px 5px; }\n";
		$html .= "legend { color: #A3001B; font-family: Tahoma, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 9pt; padding: 5px; }\n";
		$html .= "</style></head>\n";
		$html .= "<body><fieldset><legend>Automated Email Notification</legend>\n";
		$html .= "<p>The following items require your attention:</p>\n";
		$html .= "<table border=\"1\">\n";
		$hdr = true;
		foreach ($this->beans as $bean)
		{
			$html .= $bean->toHtml($hdr) . "\n";
			$hdr=false;
		}
		$html .= "</table>\n";
		$html .= "<p>This is an automated email notification from an unmonitored email address.<br>\n";
		$html .= "Please do not reply to this message.</p>\n";
		$html .= "</fieldset></body></html>\n\n";

		return $html;
	}

	/**
	 * Sends an email using the given header arguments. The text and HTML
	 * versions of the message are prepared by calling the corresponding
	 * methods in this class.
	 *
	 * @param $headers An associative array with header info
	 * @return True if sent, otherwise false
	 */

	function sendEmail($headers)
	{
	    // Set up the headers
		$to = $headers['to']; 			// "Department Manager <dm01@mtcorp.com>";
	    $from = $headers['from']; 		// "TTS Application <info@mtcorp.com>";
	    $subject = $headers['subject']; 	// "Building a Multi-part Message";

		// Set Reply-to
		if(isset($headers['reply_to']))
		  $reply_to = $headers['reply_to'];
		else
		{
		  // Extract the From Address from the From Field
		  $from_lt_split = preg_split("/</", $from);
		  if(sizeof($from_lt_split) > 1)
		  {
		    $from_gt_split = preg_split("/>/",$from_lt_split[1]);
			$reply_to = $from_gt_split[0];
		  }
		  else
		    $reply_to = $from;
		}
		$text = $this->getTextMessage();
		$html = $this->getHtmlMessage();

		// Set the boundary if needed
		if(($text != '') || ($html != ''))
	      $boundary = "XYZ-" . date('dmyhms') . "-ZYX"; // Sets a unique string to mark sections

	    // Set the text Section (remove any whitespace from the end that might cause problems)
		if($text != '')
		{
		  if(preg_match("/\n$/",$text))
		    rtrim($text);
	      $textMessage = $text; 		// "This is the Text Message";

	      $textSection = "\n";
		  if($html != '')
		  {
	        $textSection .= "--". $boundary ."\n";
	        $textSection .= "Content-Type: text/plain;charset=\"iso-8859-1\"\n";
		    $textSection .= "Content-Transfer-Encoding: 7bit\n\n";
	      }
		  $textSection .= $textMessage;
	    }

		//Set the HTML Section
	     $htmlSection = "\n";
	    if($html != '')
		{
		  if(preg_match("/\n$/",$html))
		    rtrim($html);
	      $htmlMessage = $html; 		// "This is the HTML Message";

		  if($text != '')
		  {
		    $htmlSection .= "--". $boundary ."\n";
	        $htmlSection .= "Content-Type: text/html;charset=\"iso-8859-1\"\n";
		    $htmlSection .= "Content-Transfer-Encoding: 7bit\n\n";
	      }
		  $htmlSection .= $htmlMessage;
	    }
	    $message = $textSection . $htmlSection;
		if(($text != '') && ($html != ''))
		  $message .="\n--". $boundary ."--\n";

	    $head = "From: ". $from ."\r\n";
	    $head .= "Reply-to: ". $reply_to ."\n";
		if(isset($headers['bcc'])) {
		  $head = "Bcc: ". $headers['bcc'] ."\r\n";
		}
	    $head .= "MIME-Version: 1.0\n";

		// Add the correct Content-Type
		if($text == '')
		  $head .= "Content-type: text/html";
		elseif($html == '')
		  $head .= "Content-type: text/plain";
		else
		  $head .= "Content-type: multipart/alternative;boundary=\"". $boundary ."\"\n";

	    // Send the message
	    $send = mail($to, $subject, $message, $head);

	    return $send;
	 }
}

?>
