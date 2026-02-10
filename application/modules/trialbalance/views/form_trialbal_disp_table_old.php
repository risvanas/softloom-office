<img id='logo_image'src='http://office.softloom.com/assets/images/logo.jpg' alt='Softloom ITSolution' style='display:none;'>
<?php $disf_date=date('d-M-Y',strtotime($from_date));
$dist_date=date('d-M-Y',strtotime($next_date)); ?>
<p align="center"><h3 align="center"><b></b></h3></p></br>
<table border="1" class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
	<thead>
	<tr><th colspan="4">Trial Balance &nbsp;[<?php echo $disf_date." "."To"." ".$dist_date; ?>]</th></tr>
    <tr>
			<th>sl no</th>
    		<th>Account Name</th>
           <!-- <th>Opening Balance</th>
            <th>Credit</th>
            <th>Debit</th> -->
			<th>Credit</th>
            <th>Debit</th>
    	
    </tr>
    </thead>
    <tbody>
    <?php
	$i=1;
	$credit_sum=0;
	$debit_sum=0;
	$op_sum=0;
	$spec_credit=0;
	$spec_debit=0;
	$total_opening=0;
	$total_credit=0;
	$total_debit=0;
	$new1_total=0;
	$new2_total=0;
	foreach($data_pass->result() as $res)
	{
		$acc_id=$res->ACC_ID;
		$acc_name=$res->ACC_NAME." "."[".$res->p_name."]";
		$op_balance=$res->OPENING_BALANCE;
		$query=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction 
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc_id'
			  	AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' "); 
		//$row = $query->row_array();
		//$spec_credit=$res->Column1 ;
		//$spec_debit=$res->Column2;
		//$value  =  $spec_debit  -  $spec_credit;
	  $open=$query->row_array();
		?>
        <tr>
        	<td><?php echo $i;?></td>
            <td><?php echo $acc_name;?></td>
           <!-- <td> --> <?php $openings=$open['opening']; //+$op_balance
			$total_opening+=$openings;
			if( $openings > 0)
				 {
					 //echo $openings. " Db. ";
				 }
				if($openings < 0)
				 {
					 //echo abs($openings). " Cr. "; 
				 }
				 if( $openings == 0)
				 {
					 //echo $openings;
				 }
			?> <!-- </td> -->
			<?php
			$query1=$this->db->query("SELECT SUM( DEBIT ) as debit,SUM( CREDIT ) AS credit
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc_id'
			  	AND tbl_transaction.DATE_OF_TRANSACTION >= '$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$next_date'");
				$debit_credit=$query1->row_array();
			?>
            <!-- <td> --> <?php  $my_debit=$debit_credit['credit'];
					/* if($value<0)
						{echo abs($value) ;} */
					?>
             <!-- </td> -->
			 
            <!-- <td> --> <?php  $my_credit=$debit_credit['debit'];
					/* if($value>0)
						{echo $value ;} */
					?>
            <!-- </td> -->
			
        
        <?php
		$i++;
		
	$total_credit+=$my_credit;
	$total_debit+=$my_debit;
	
		/* $debit_sum=$debit_sum+$res->Column1;
		$credit_sum=$credit_sum+$res->Column2;
		$op_sum=$op_sum+$res->op; */
		$new_total=($openings+$my_credit)-$my_debit;
		if($new_total >= 0)
		{
			?>
			<td></td>
			<td><?php echo $new1=$new_total; ?></td>
			
			<?php
			$new2=0;
		}
		else
		{
			?>
			<td><?php echo abs($new2=$new_total); ?></td>
			<td></td>
			<?php
			$new1=0;
		}
		$new1_total+=$new1;
		$new2_total+=$new2;
		?>
			</tr>
			<?php
	}
	?>
	
    <tr>
    	<td colspan="2" align="center">Total</td>
        <!-- <td><b><?php echo $total_opening;?></b></td>
        <td><b><?php echo $total_credit;?></b></td>
        <td><b><?php echo $total_debit;?></b></td> -->
		<td><b><?php echo abs($new2_total);?></b></td>
		<td><b><?php echo $new1_total;?></b></td>
    </tr>
    <?php 
		//$trial_balance=$op_sum+$credit_sum-$debit_sum;
	?>
   
    </tbody>
</table>


<?php
$sub=$from_date." "."To"." ".$next_date;
$html_table = '<table border="1" cellspacing="0" cellpadding="2"><tr><th>sl no</th>
    		<th>Account Name</th>
			<th>Credit</th>
            <th>Debit</th></tr>';
	$i=1;
	$credit_sum=0;
	$debit_sum=0;
	$op_sum=0;
	$spec_credit=0;
	$spec_debit=0;
	$total_opening=0;
	$total_credit=0;
	$total_debit=0;
	$new1_total=0;
	$new2_total=0;
	foreach($data_pass->result() as $res)
	{
		$acc_id=$res->ACC_ID;
		$acc_name=$res->ACC_NAME." "."[".$res->p_name."]";
		$op_balance=$res->OPENING_BALANCE;
		$query=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction 
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc_id'
			  	AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' "); 
	  $open=$query->row_array();
        $html_table .='<tr>
        	<td>'. $i .'</td><td>'. $acc_name .'</td>';

           $openings=$open['opening']+$op_balance; //echo $res->op;
			$total_opening+=$openings;

			$query1=$this->db->query("SELECT SUM( DEBIT ) as debit,SUM( CREDIT ) AS credit
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc_id'
			  	AND tbl_transaction.DATE_OF_TRANSACTION >= '$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$next_date'");
				$debit_credit=$query1->row_array();
			 $my_debit=$debit_credit['credit'];
				  $my_credit=$debit_credit['debit'];
					
        
		$i++;
		
	$total_credit+=$my_credit;
	$total_debit+=$my_debit;
	
		$new_total=($openings+$my_credit)-$my_debit;
		if($new_total >= 0)
		{
			
			$html_table .= '<td></td>
			<td>'. $new1=$new_total .'</td>';
			
			
			$new2=0;
		}
		else
		{
			
			$html_table.='<td>'. abs($new2=$new_total).'</td>
			<td></td>';
			$new1=0;
		}
		$new1_total+=$new1;
		$new2_total+=$new2;
		
			$html_table.='</tr>';
			
	}
	
    $html_table.='<tr><td colspan="2" align="center">Total</td>
		<td><b>'. abs($new2_total).'</b></td>
		<td><b>'. $new1_total.'</b></td>
    </tr></table>';
   

?>
<textarea id="my_sub" name="my_sub" style="display:none;"> <?php echo $sub; ?> </textarea>
<textarea id="my_data" name="my_data" style="display:none;"> <?php echo $html_table; ?> </textarea>
<script>
lode_image_false();
</script>