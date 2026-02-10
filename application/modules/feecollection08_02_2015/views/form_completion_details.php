<?php
foreach($stud->result() as $row)
{
?>

<div class="col-md-12">
<h4>Student Details</h4>
<div class="well">
  <address>
  <strong><?php echo $row->NAME; ?>
  <input type="hidden" name="lbl_stud_name" id="lbl_stud_name" value="<?php echo $row->NAME;?>"/> </strong> <br>
  <?php echo $row->ADDRESS1.' ,'.$row->ADDRESS2; ?> 
   <br>
  </address>
  <address>
  <strong>Contact info</strong> <br>
  <span title="Phone">Phone:</span> <?php echo $row->CONTACT_NO; ?><br>
  <span title="Email">Email:</span> <?php echo $row->STUD_EMAIL; ?><br>
  </address>
  <address>
  <strong>Course info</strong> <br>
  <span title="Phone">Course Id:</span> <?php echo $row->COURSE; ?><br>
  <span title="Phone">Course Name:</span> <?php echo $row->ACC_NAME; ?><br>
  <span title="Email">Fee:</span> <strong><?php echo $fee_amt=$row->FEE_AMOUNT; ?></strong>
  </address>
</div>
<?php
}
	?>
    
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Payment Date</th>
      <th>Due Date</th>
      <th>Amount</th>
      <th>Mode</th>
      
    </tr>
  </thead>
  <tbody>
    <?php $sn_count = 1;
	$sum=0;
		foreach($res->result() as $row)
		{
			$id=$row->PAY_ID;
		  ?>
    <tr>
    <td><?php echo $sn_count;?></td>
      <td> <?php $pay_date=$row->PAYMENT_DATE;
				$pay_date = strtotime($pay_date);
		      echo  $pay_date=date("d-m-Y", $pay_date);?> </td>
	  <td><?php $due_date=$row->DUE_DATE;
				 $due_date = strtotime($due_date);
		        $due_date=date("d-m-Y", $due_date);
			 if($due_date=='01-01-1970')
			 {
				 $due_date="";
			 }
			 else
			 {
				 echo $due_date;
			 }?> </td>
      <td><span class="badge"> <?php echo $row->AMOUNT;?></span></td>
      <td><code> <?php echo $row->TRANSACTION_TYPE;?> </code></td>
    </tr>
    
     <!----------------------- start allert box ----------------------------> 
 
<!----------------------- end allert box ----------------------------> 
  
  <?php
 
 $sum+= $row->AMOUNT;
  $sn_count++;
		}
		
	$balance=$fee_amt-$sum;
?>
<tr> <td>TOTAL</td><td colspan="6" align="center"><?php echo $sum;?></td></tr>
<tr> <td>BALANCE</td><td colspan="6" align="center"><?php echo $balance;?></td></tr>
   </tbody>
     </table> 
  </div>
  
  
    
  
  
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/form-validation/fee_collection.js"></script>          
       <script>
	
jQuery(document).ready(function() {
	Main.init();
	FormValidator.init();
	UIModals.init();
	FormElements.init();
	
});



		</script> 