<?php
/* File Name: suggest.class.php
 * 	dbLink Plugin.
 *      for phpnuke CMS and equivalents
 *        Select URL using title of contents from tables pages, stories, FAQ, Encyclopia, Download, WebLink,  Ephemerids
 * File Authors:
 * 		Gustavo G. Vilchez B. (ggvilchez@gmail.com)
 * */

//Cause browser to reload page every time
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// load error handling module
//require_once('error_handler.php');
// load configuration file
 $PHP_SELF=$HTTP_SERVER_VARS['PHP_SELF'];
require_once('config.php');
// require_once("../../../../includes/sql_layer.php");
// defines database connection data



// class supports server-side suggest & autocomplete functionality
class Suggest
{
  // database handler   private $mMysqli;
  var $msql;
  

 function getSuggestions($keyword)
   {

    //get DB
	if(defined('_JEXEC'))
	{
    	$dbi =  &  JDatabase::getInstance(array('driver'=>DB_DRIVER,'host'=>DB_HOST,'user'=>DB_USER,'password'=>DB_PASSWORD,
								'database'=>DB_DATABASE,'prefix'=>DB_PREFIX));
	}
	else
	{
		$dbi =	new database( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PREFIX, DB_OFFLINE );
	}
    // escape the keyword string     
    
    if (get_magic_quotes_gpc())  //Addded by AW
    $keyword  = stripslashes($keyword);
    $keyword = addcslashes(mysql_real_escape_string($keyword), "%_");

     
    //$patterns = array('/\s+/', '/"+/', '/%+/');
    //$replace = array('');
    //$keyword = preg_replace($patterns, $replace, $keyword);

    //set SQL BIG SELECT option to ensure it is set to true
    $dbi->setQuery("SET OPTION SQL_BIG_SELECTS=1");
    $dbi->query();



    // build the SQL query that gets the matching functions from the database
	

    $tit ="title";
	$id  ="id";
	$link = "link";
	
    // execute the SQL query
   

  	$output  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
  	$output .= '<response>';  
	
	$filter =  '=""';
	 
	if($keyword != '')
    		  $filter = ' LIKE "' . $keyword . '%"';
    
	
		
	// if the keyword is empty build a SQL query that will return no results
    
	$query =   '';
	
	
	if(defined('_JEXEC'))
	{
	
		$query = 
			'SELECT ' . $tit . ',' . $link . ',' . $id . '
			 FROM
			(SELECT c.'. $tit .' ,m.' . $link . ',m.id,c.created
			FROM #__content c
			JOIN
			(
			 SELECT  ' . $link . ',' . $id . ' 
			 FROM #__menu
			 WHERE ' . $link . ' like "index.php?option=com_content&view=article&id=%"
			 AND published = 1
			
			) as m on m.' . $link . ' = concat("index.php?option=com_content&view=article&id=",c.' . $id . ')
			WHERE  c.' . $tit . $filter . '
					
			UNION 
			
			SELECT c.'. $tit .' ,concat("index.php?option=com_content&amp;view=article&amp;id=",cast(c.' . $id . ' as char(11))) as link ,0 as id,c.created
			FROM #__content c
			LEFT JOIN
			(
			 SELECT  ' . $link . ',' . $id . ' 
			 FROM #__menu
			 WHERE ' . $link . ' like "index.php?option=com_content&view=article&id=%"
			 AND published = 1
			
			) as m on m.' . $link . ' = concat("index.php?option=com_content&view=article&id=",c.' . $id . ')
			WHERE  c.' . $tit . $filter . '
			AND m.' . $id  . ' is null
			AND c.sectionid = 0
			AND c.catid = 0
			AND c.state = 1
			
			UNION 
		
			SELECT i.' . $tit . ' as title,concat("index.php?option=com_content&amp;view=article&amp;id=",cast(i.' . $id . ' as char(11)))
			 as link, IFNULL(ms.' . $id . ' ,mc.' . $id . ' ) as id,i.created
			 FROM #__content AS i
			 JOIN #__sections AS s ON i.sectionid = s.' . $id . '
			 LEFT JOIN #__menu AS ms ON 
			 ms.' . $link . ' = concat("index.php?option=com_content&view=section&layout=blog&id=",s.' . $id . ')
			OR ms.' . $link . ' =  concat("index.php?option=com_content&view=section&id=",s.' . $id . ')
			 JOIN #__categories AS c ON i.catid = c.' . $id . '
			 LEFT JOIN #__menu AS mc ON
			 mc.' . $link . ' = concat("index.php?option=com_content&view=category&layout=blog&id=",c.' . $id . ')
			OR mc.' . $link . ' =  concat("index.php?option=com_content&view=category&id=",c.' . $id . ')
			 
			 WHERE (ms.id is not null or mc.id is not null)
			AND (ms.published = 1 or mc.published=1)
			 AND i.' . $tit . $filter . '
					 
			UNION   
			
			select i.' . $tit .',concat("index.php?option=com_content&amp;view=article&amp;id=",cast(i.' . $id . ' as char(11))) as link, 0 as id,i.created
			 FROM #__content i
			 LEFT join #__menu  m on m.link = concat("index.php?option=com_content&view=article&id=",i.' . $id . ')
			 JOIN #__sections AS s ON i.sectionid = s.' . $id .'
			 LEFT JOIN #__menu AS ms ON 
			 ms.' . $link . ' = concat("index.php?option=com_content&view=section&layout=blog&id=",s.' . $id . ')
				OR ms.' . $link . ' =  concat("index.php?option=com_content&view=section&id=",s.' . $id . ')
			 JOIN #__categories AS c ON i.catid = c.' . $id . '
			 LEFT JOIN #__menu AS mc ON
			 mc.' . $link . ' = concat("index.php?option=com_content&view=category&layout=blog&id=",c.' . $id . ')
			 OR mc.' . $link . ' =  concat("index.php?option=com_content&view=category&id=",c.' . $id . ')
			 
			 WHERE m.' . $id  . ' is null
			 AND ms.' . $id . ' is null 
			 AND mc.' . $id . ' is null
			 AND state = 1
			 AND i.' . $tit . $filter . '
			 
			UNION
			 
			SELECT IFNULL(s.' . $tit . ',c.' . $tit . '),m.link,m.id,"0000-00-00 00:00:00" as created
			 FROM #__menu AS m 
			 LEFT JOIN #__sections AS s ON
			 m.' . $link . ' = concat("index.php?option=com_content&view=section&layout=blog&id=",s.' . $id . ')
				OR m.' . $link . ' =  concat("index.php?option=com_content&view=section&id=",s.' . $id . ')
		 
			 LEFT JOIN #__categories AS c ON
			 m.' . $link . ' = concat("index.php?option=com_content&view=category&layout=blog&id=",c.' . $id . ')
			OR m.' . $link . ' =  concat("iindex.php?option=com_content&view=category&id=",c.' . $id . ')
					 
			 WHERE (s.id is not null or c.id is not null)
			AND m.published = 1
			AND IFNULL(s.' . $tit . ',c.' . $tit . ') ' . $filter . '
		 
			 UNION 
		 
		 
			 SELECT s.' . $tit . ',concat("index.php?option=com_content&amp;view=section&amp;id=",cast(s.' . $id . ' as char(11))) as link,0 as id,"0000-00-00 00:00:00" as created
			 FROM #__sections AS s 
			 LEFT JOIN #__menu AS m ON
			 m.' . $link . ' = concat("index.php?option=com_content&view=section&layout=blog&id=",s.' . $id . ')
			 OR m.' . $link . ' =  concat("index.php?option=com_content&view=section&id=",s.' . $id . ')
		 
				WHERE m.id is null
			   AND s.published = 1
			   AND s.' . $tit . $filter . '
		 
			   UNION
		 
			SELECT c.title,concat("index.php?option=com_content&amp;view=category&amp;id=",cast(c.' . $id . ' as char(11))) as link,0 as id,"0000-00-00 00:00:00" as created
			 FROM #__categories AS c 
			 LEFT JOIN #__menu AS m ON
			 m.' . $link . ' = concat("index.php?option=com_content&view=category&layout=blog&id=",c.' . $id . ')
			OR m.' . $link . ' =  concat("index.php?option=com_content&view=category&id=",c.' . $id . ')
					 
			WHERE m.id is null
				AND c.published = 1
			AND c.section REGEXP "^[0-9]+$"
			AND c.' . $tit . $filter . '
	
			 ORDER BY created desc) a
			 WHERE ' . $tit . $filter;
	}
	else
	{
	
		$query = 
	    'SELECT ' . $tit . ',' . $link . ',' . $id . '
		 FROM
		(SELECT c.'. $tit .' ,m.' . $link . ',m.id,c.created
		FROM #__content c
		JOIN
		(
		 SELECT componentid,' . $link . ',' . $id . ' 
		 FROM #__menu
		 WHERE type in ("content_item_link","content_typed")
		 AND published = 1
		
		) as m on m.' . $link . ' = concat("index.php?option=com_content&task=view&id=",c.' . $id . ')
		WHERE  c.' . $tit . $filter . '
		
		union
		
		SELECT c.'. $tit .' ,concat("index.php?option=com_content&amp;task=view&amp;id=",cast(c.' . $id . ' as char(11))) as link ,0 as id,c.created
		FROM #__content c
		LEFT JOIN
		(
		 SELECT  ' . $link . ',' . $id . ' 
		 FROM #__menu
		 WHERE type in ("content_item_link","content_typed")
		 AND published = 1
		
		) as m on m.' . $link . ' = concat("index.php?option=com_content&task=view&id=",c.' . $id . ')
		WHERE  m.' . $id  . ' is null
		AND c.sectionid = 0
		AND c.catid = 0
		AND	c.' . $tit . $filter . '
		
		union
		
		SELECT i.' . $tit . ' as title,concat("index.php?option=com_content&amp;task=view&amp;id=",cast(i.' . $id . ' as char(11)))
		 as link, IFNULL(ms.' . $id . ' ,mc.' . $id . ' ) as id,i.created
		 FROM #__content i
		 LEFT JOIN #__sections AS s ON i.sectionid = s.' . $id . '
		 LEFT JOIN #__menu AS ms ON ms.componentid = s.' . $id . '
		 LEFT JOIN #__categories AS c ON i.catid = c.' . $id . '
		 LEFT JOIN #__menu AS mc ON mc.componentid = c.' . $id . '
		 WHERE ( ms.type IN ( "content_section", "content_blog_section" ) OR mc.type IN ( "content_blog_category", "content_category" ) )
		 AND ms.published = 1 or mc.published=1
		 AND  i.' . $tit . $filter . '
		
		union
		
		select uc.' . $tit . ',concat("index.php?option=com_content&amp;task=view&amp;id=",cast(uc.' . $id . ' as char(11))) as link,um.' . $id . ',uc.created
		FROM #__content uc
		JOIN #__menu um on um.componentid = uc.' . $id . '
		WHERE type = "url"
		AND um.published = 1
		AND ' . $link . ' LIKE "index.php?%"
		AND  uc.' . $tit . $filter . '
		
		union
		
		select i.' . $tit .',concat("index.php?option=com_content&amp;task=view&amp;id=",cast(i.' . $id . ' as char(11))) as link, 0 as id,i.created
		from #__content i
		LEFT join #__menu  m on m.link = concat("index.php?option=com_content&task=view&id=",i.' . $id . ')
		LEFT join #__menu um on um.componentid = i.' . $id . '
		LEFT JOIN #__sections AS s ON i.sectionid = s.' . $id .'
		LEFT JOIN #__menu AS ms ON ms.componentid = s.' . $id . '
		AND ms.type IN ( "content_section", "content_blog_section" )
		LEFT JOIN #__categories AS c ON i.catid = c.' . $id . '
		LEFT JOIN #__menu AS mc ON mc.componentid = c.' . $id . '
		AND mc.type IN ( "content_blog_category", "content_category" )
		WHERE m.' . $id  . ' is null
		AND um.' . $id . ' is null
		AND ms.' . $id . ' is null and mc.id is null
		AND state = 1
		AND  i.' . $tit . $filter . '
		 
		union
		 
		SELECT IFNULL(s.' . $tit . ',c.' . $tit . '),m.link,m.id,"0000-00-00 00:00:00" as created
		FROM #__menu AS m 
		LEFT JOIN #__sections AS s ON m.componentid = s.' . $id . '
		LEFT JOIN #__categories AS c ON m.componentid = c.' . $id . '
	 	WHERE m.type IN ( "content_section", "content_blog_section" ,"content_blog_category", "content_category" ) 
     	AND m.published = 1
     	AND IFNULL(s.' . $tit . ',c.' . $tit . ') ' . $filter . '
	    
	    union
	    
	
	    SELECT s.' . $tit . ',concat("index.php?option=com_content&amp;view=section&amp;id=",cast(s.' . $id . ' as char(11))) as link,0 as id,"0000-00-00 00:00:00" as created
		FROM #__sections AS s 
		LEFT JOIN #__menu AS m ON m.componentid = s.' . $id . '
		AND m.type IN ( "content_section", "content_blog_section" )
    	WHERE m.id is null
    	AND s.published = 1
     	AND s.' . $tit . $filter . '
     
    	union
     
    	SELECT c.title,concat("index.php?option=com_content&amp;view=category&amp;id=",cast(c.' . $id . ' as char(11))) as link,0 as id,"0000-00-00 00:00:00" as created
		FROM #__categories AS c 
		LEFT JOIN #__menu AS m ON m.componentid = c.' . $id . '
		AND m.type IN ( "content_blog_category", "content_category" )
		WHERE m.id is null
     	AND c.published = 1
		AND c.section REGEXP "^[0-9]+$"
     	AND c.' . $tit . $filter . '
		ORDER BY created desc) a
		WHERE ' . $tit . $filter;
	
	}
    	
	// execute the SQL query
        
  	 //get DB intstance

     
		 $dbi->setQuery($query);
		 $rows = $dbi->loadAssocList();
	
		 
	    
   	 // if we have results, loop through them and add them to the output
   	 if($rows)
    	foreach ($rows as $row) 	
		{      
      		//$output .= '<name>' . '<![CDATA[' . htmlentities($row[$tit], ENT_QUOTES) . ']]>' . '</name>';
			$output .= '<name>' . '<![CDATA[' . $row[$tit] . ']]>' . '</name>';
			$output .= '<pid>' . $row[$id]  . '</pid>';
			$output .= '<link>' . '<![CDATA[' . $row[$link] .']]>' . '</link>';
		}
         		
		 // add debug information
		// $output .= '<query>' . 	 $query . '</query>';
		 $output .= '<error>' . 	$dbi->getErrorMsg() . '</error>';
	
	// add the final closing tag	 
    $output .= '</response>';  
   	 // return the results
    return $output;  
  }
//end class Suggest
}
?>
