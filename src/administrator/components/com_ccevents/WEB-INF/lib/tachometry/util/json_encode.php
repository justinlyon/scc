<?php
/*
 *  $Id: json_encode.php 1290 2008-09-17 00:12:23Z tevans $
 *  Copyright (c) 2006-2008, Tachometry Corporation http://www.tachometry.com/
 *  All Rights Reserved. License granted to Ports America for internal use only.
 */

/**
 * This function is required for older PHP servers to provide equivalent
 * behavior with json_encode($subject) which is not available prior to PHP 5.2
 * (JSON: JavaScript Over Network; used for serialized JS objects)
 *
 * @param $subject mixed; scalar or array (indexed or associative) 
 * @return JSON-encoded string
 */
 function php_json_encode(&$subject)
 {
   $result = "";
   if(is_array($subject))
   {
     $indexed = true;
     $array_length = count($subject);
     for($i=0;$i<$array_length;$i++)
     {
       if(!(array_key_exists($i, $subject))) // check for sequential numeric indexes
       {
         $indexed = false;
         break;
       }
     }
     if($indexed) // "flat" or indexed array
     {
       $result ="[";
       $buffer = array();
       for($i=0;$i<$array_length;$i++)        
       {
         $buffer[] = sprintf("%s", php_json_encode($subject[$i]));
       }
       $result .= implode(",",$buffer);
       $result .="]";
     }
     else // associative array ($key => $value)
     {
       $result ="{";
       $buffer = array();
       foreach($subject as $key => $value)
       {
         $buffer[] = sprintf("\"%s\":%s", $key, php_json_encode($value));
       }
       $result .= implode(",",$buffer);
       $result .="}";
     }
   }
   else // input is not an array
   {
     if(is_numeric($subject)) // numbers need no special handling
     {
       $result = $subject;
     }
     else if(is_object($subject)) 
     {
       $result = php_json_encode(get_object_vars($subject));
     }
     else
     {
       $result = "\"". json_encode_string($subject) . "\"";
     }
   }
   return $result;
 }

/**
 * Special handling for multibyte strings (e.g. Unicode)
 *
 * @param string $in_str
 * @return JSON-encoded string
 */
 function json_encode_string($in_str)
 {
   mb_internal_encoding("UTF-8");
   $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
   $result = "";
   for($i=mb_strlen($in_str)-1; $i>=0; $i--)
   {
     $mb_char = mb_substr($in_str, $i, 1);
     if(mb_ereg("&#(\\d+);", mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match))
     {
       $result = sprintf("\\u%04x", $match[1]) . $result;
     }
     else
     {
       $result = $mb_char . $result;
     }
   }
   return $result;
 }

?>