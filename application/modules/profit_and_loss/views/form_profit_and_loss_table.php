
<p align="center">Profit And Loss</p></br>
<table border="1" class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
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
	$credit_sum=0;
	$debit_sum=0;
	$op_sum=0;
	$spec_credit=0;
	$spec_debit=0;
	foreach($data_pass->result() as $res)
	{
		$acc_id=$res->acc;
		$query=$this->db->query("select acc_name from tbl_account where acc_id='$acc_id' ");
		$row = $query->row_array();
		$spec_credit=$res->Column1 ;
		$spec_debit=$res->Column2;
		$value  =  $spec_debit  -  $spec_credit;
		?>
        <tr>
        	<td><?php echo $i;?></td>
            <td><?php echo $row['acc_name'];?></td>
            <td> <?php echo $res->op;;?> </td>
            <td> <?php 
					if($value<0)
						{echo abs($value) ;}
					?>
             </td>
            <td> <?php 
					if($value>0)
						{echo $value ;}
					?>
            </td>
        </tr>
        <?php
		$i++;
		$debit_sum=$debit_sum+$res->Column1;
		$credit_sum=$credit_sum+$res->Column2;
		$op_sum=$op_sum+$res->op;
	}
	?>
    <tr>
    	<td colspan="2" align="center">Total</td>
        <td><?php echo $op_sum?></td>
        <td><?php echo $credit_sum?></td>
        <td><?php echo $debit_sum?></td>
    </tr>
    <?php 
		$trial_balance=$op_sum+$credit_sum-$debit_sum;
	?>
    <tr>
    	<td colspan="2" align="center">Trial Balance</td>
        <td colspan="3" align="center"><?php echo $trial_balance?></td>
    </tr>
    </tbody>
</table>
