<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
	<thead>
    <tr>
			<th>sl no</th>
    		<th>Account Name</th>
            <th>Opening Balance</th>
            <th>Credit</th>
            <th>Debit</th>
            
    	
    </tr>
    </thead>
    <tbody>
    <?php
	$i=0;
	$cre_sum=0;
	$deb_sum=0;
	foreach($data_pass->result() as $res)
	{
		?>
        <tr>
        	<td><?php echo $i;?></td>
            <td><?php echo $res->ACC_NAME;?></td>
            <td><?php echo $res->BOOK_NAME;?></td>
            <td><?php echo $cr=$res->CREDIT;?></td>
            <td><?php echo $db=$res->DEBIT;?></td>
			<?php
			$cre_sum+=$cr;
	      $deb_sum+=$db;
			?>
        </tr>
        <?php
		$i++;
	}
	?>
    <tr>
    	<td colspan="2" align="center">Total</td>
        <td>gfg</td>
        <td><?php echo $cre_sum; ?></td>
        <td><?php echo $deb_sum; ?></td>
    </tr>
    
    <tr>
    	<td colspan="2" align="center">Trial Balance</td>
        <td colspan="3" align="center">dfgfdg</td>
    </tr>
    </tbody>
</table>
