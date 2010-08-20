<?php // Extension params save file for sh404sef
//    
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');
$shConfig = array (
  'name' => 'sh404sef similar urls plugin',
  'element' => 'sh404sefsimilarurls',
  'folder' => 'sh404sefcore',
  'access' => '0',
  'ordering' => '10',
  'published' => '1',
  'iscore' => '0',
  'client_id' => '0',
  'checked_out' => '0',
  'checked_out_time' => '0000-00-00 00:00:00',
  'params' => 'plugin_element=sh404sefsimilarurls
plugin_folder=sh404sefcore
plugin_event=onPrepareContent
plugin_functions=plgSh404sefsimilarurls
max_number_of_urls=5
min_segment_length=3
',
);
