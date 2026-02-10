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
	foreach($data_pass->result() as $res)
	{
		?>
        <tr>
        	<td><?php echo $i;?></td>
            <td><?php echo $res->ACC_NAME;?></td>
            <td><?php echo $res->BOOK_NAME;?></td>
            <td><?php echo $res->CREDIT;?></td>
            <td><?php echo $res->DEBIT;?></td>
        </tr>
        <?php
		$i++;
	}
	?>
    <tr>
    	<td colspan="2" align="center">Total</td>
        <td>gfg</td>
        <td>fgf</td>
        <td>fgf</td>
    </tr>
    
    <tr>
    	<td colspan="2" align="center">Trial Balance</td>
        <td colspan="3" align="center">dfgfdg</td>
    </tr>
    </tbody>
</table>
