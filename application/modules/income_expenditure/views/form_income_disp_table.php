<label><?php echo $from.' to '.$to; ?></label>
<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
<thead>
    <tr>
			<th>sl no</th>
    		<th>Income/Expenses</th>
            <th>Amount</th>
            
    	
    </tr>
    </thead>
    <tbody>
<?php
$count=1;
foreach($data_pass->result() as $row)
{
	if($row->id==3)
	{
		$val="INCOME";
	}
	elseif($row->id==4)
	{
		$val="EXPENSES";
	}
	?>
<tr>
<td><?php echo $count; ?></td>
<td><?php echo $val; ?></td>
<td><?php echo abs($row->income); ?></td>
</tr>
<?php
$count++;
}
?>
</tbody>
</table>