
<table class="table table-striped table-bordered table-hover table-full-width" border="1" >
            <thead>
              <tr>
                
                <th colspan="2"> Date of entery </th>
                 <th>Voucher No</th>
                 <th>Remark</th>
                 <th>Receipts</th>
       			 <th>Payments</th>
                  <th> Balance </th>
                </tr>
            </thead>
            <tbody>
            
             <?php  
			 $sn_count=1;
			 $opening_balance=0; 
				   $totreceipt=0;
				   $totpayment=0;
				?>   
				 <tr><td colspan="4" align="right"><b>Opening Balance:</b></td>   
                <td colspan="2" align="right"><b><?php  if( $opening_balance > 0)
				 {
					 echo $opening_balance. " Db. ";
				 }
				if($opening_balance < 0)
				 {
					 echo abs($opening_balance). " Cr. "; 
				 }
				 if( $opening_balance == 0)
				 {
					 echo $opening_balance;
				 }?></b></td><td></td>
 				</tr>
				<?php
			  foreach($sel->result() as $row)
                 {
					 $acc_id=$row->ACC_ID;
					 $book_name=$row->BOOK_NAME;
					 $book_num=$row->BOOK_NUMBER;
					 $date_entry=$row->DATE_OF_TRANSACTION;  
				?>
                <tr>
				<td colspan="2"><?php $time1 = strtotime($date_entry);
		            echo  $date_entry1=date("d-m-Y", $time1);?> </td>
                <td><?php echo $book_name ."".$book_num;?></td>
				<td><?php echo $row->REMARKS." ". $acc_id?></td>
                <td align="right"><?php echo $receipt=$row->DEBIT; ?></td>
                <td align="right"><?php echo $payment=$row->CREDIT; ?></td>
                <td align="right"><?php	$opening_balance+=$receipt-$payment;
				 if( $opening_balance > 0)
				 {
					 echo $opening_balance. " Db. ";
				 }
				if($opening_balance < 0)
				 {
					 echo abs($opening_balance). " Cr. "; 
				 }
				 if( $opening_balance == 0)
				 {
					 echo $opening_balance;
				 }
				 ?></td>
				     <?php $totreceipt+=$receipt;
					       $totpayment+=$payment; ?>
                           
                <?php $sn_count++;
			      }
				?>
                
  <tr><td colspan="4" align="right"> <b>TOTAL </b><td align="right"><b><?php echo $totreceipt;?></b></td><td align="right"><b><?php echo $totpayment;?></b></td><td></td></tr>
      <tr> <td colspan="4" align="right"><b>Closing Balance</b></td><td colspan="2" align="right"><b><?php  if( $opening_balance > 0)
				 {
					 echo $opening_balance. " Db. ";
				 }
				if($opening_balance < 0)
				 {
					 echo abs($opening_balance). " Cr. "; 
				 }
				 if( $opening_balance == 0)
				 {
					 echo $opening_balance;
				 }?></b></td><td></td></tr>
            </tbody>
            </table>