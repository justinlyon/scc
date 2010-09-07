<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
<table class="adminlist">
    <thead>
        <tr>
            <th width="5"><?php echo JText::_( '#' ); ?></th>
            <th width="20"><input type="checkbox" name="toggle" value=""
                onclick="checkAll(&lt;?php echo count( $this-&gt;items ); ?&gt;);" />
            </th>
            <th><?php echo JText::_( 'Exhibition Title' ); ?></th>
            <th><?php echo JText::_( 'Published' ); ?></th>
            <th><?php echo JText::_( 'Event Status' ); ?></th>
            <th width="5"><?php echo JText::_( 'Order' ); ?></th>
            <th><?php echo JText::_( 'Start Date' ); ?></th>
            <th><?php echo JText::_( 'End Date' ); ?></th>
            <th><?php echo JText::_( '# Venues' ); ?></th>
            <th><?php echo JText::_( '# Programs' ); ?></th>
            <th><?php echo JText::_( '# Courses' ); ?></th>
            <th width="5"><?php echo JText::_( 'ID' ); ?></th>
        </tr>
    </thead>
<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id', $i, $row->eoid );
		$link 		= JRoute::_( 'index.php?option=com_ccevents&scope=exbt&task=edit&cid[]='. $row->eoid );
?>
    <tr class='<?php echo "row$k"; ?>'>
        <td><?php echo $i+1; ?></td>
        <td><?php echo $checked; ?></td>
        <td><a href="<?php echo $link; ?>"><?php echo $row->title; ?></a></td>
        <td></td>
        <td></td>
        <td><?php echo $row->displayOrder; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo $row->eoid; ?></td>
    </tr>
<?php
		$k = 1 - $k;
	}
?>
</table>
</div>

<input type="hidden" name="option" value="com_ccevents" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="exhibition" />
</form>
