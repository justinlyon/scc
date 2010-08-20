<?php

defined('_JEXEC') or die('Direct access is not allowed');

class APhtml
{
	function list_components(&$rows)
	{
	$ap_task = (JRequest::getVar('ap_task'));
	$showChildren  = $this->params->get('showChildren', 0);
		?>
			<ul id="component-list">
			   <?php
			      $k = 0;
			      foreach ($rows AS $i => $row)
			      {
			      	  ?>
			      	  <li class="row<?php echo $k;?> parent">
                         <?php if($row->admin_menu_img) {
                             if(strpos($row->admin_menu_img, 'ThemeOffice'))  {
                                 $ilink = "../includes/".$row->admin_menu_img;
                             }
                             else {
                                 $ilink = $row->admin_menu_img;
                             }
                         ?>
                             <img src="<?php echo $ilink;?>" width="16" height="16" style="float:left;margin-right:5px;"/>
                         <?php } ?>
			      	     <?php if ($row->admin_menu_link) { $ignore_first = false; ?>
			      	        <a href="index.php?<?php echo $row->admin_menu_link;?>" class="parent-link"><?php echo $row->name;?></a>
			      	     <?php } else { $ignore_first = true; ?>
                            <a href="index.php?option=<?php echo $row->option;?>" class="parent-link"><?php echo $row->name;?></a>
			      	     <?php } ?>
			      	        <?php
			      	        if(($showChildren) || ($ap_task == "list_components")) {
				      	        if(count($row->children)) {
	                                echo "<ul class=\"child-list\">";
				      	        	foreach ($row->children AS $i2 => $child)
				      	        	{
	                                    if($i2 == 0 && $ignore_first) {
	                                        continue;
	                                    }
	                                    echo "<li class=\"child\">";
	
	                                    if($child->admin_menu_img) {
	                                        if(strpos($child->admin_menu_img, 'ThemeOffice'))  {
	                                            $ilink = "../includes/".$child->admin_menu_img;
	                                        }
	                                        else {
	                                            $ilink = $child->admin_menu_img;
	                                        }
	                                        ?>
	                                        <img src="<?php echo $ilink;?>" width="16" height="16" style="float:left;margin-right:5px;"/>
	                                        <?php
	                                    }
	                                    else {
	                                        ?>
	                                        <img src="../includes/js/ThemeOffice/component.png" alt="<?php echo htmlspecialchars($child->name);?>" width="16" height="16" style="float:left;margin-right:5px;"/>
	                                        <?php
	                                    }
										$childName = JText::_($child->name);
				      	        		echo "<a href='index.php?$child->admin_menu_link'>$childName</a></li>";
				      	        		$k = 1 - $k;
				      	        	}
	                                echo "</ul>";
				      	        }
			      	        }
			      	     ?>
			      	  </li>
			      	  <?php
			      	  $k = 1 - $k;
			      }
			   ?>
			</ul>
		<?php
	}
	
}
?>
