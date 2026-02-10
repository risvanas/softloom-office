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
   
      <th>No</th>
        <th>Payment Date</th>
        <th>Book Name</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Mode</th>
      
  
  </thead>
  <tbody>
   <?php $sn_count = 1;
	$sum=0;
	$dbsum=0;
		foreach($res->result() as $row)
		{
			 $id=$row->PAYMENT_ID;
		  ?>
      <tr>
        <td><?php echo $sn_count;?></td>
        <td><?php $pay_date=$row->DATE_OF_TRANSACTION;
				  $pay_date = strtotime($pay_date);
		          echo  $pay_date=date("d-m-Y", $pay_date);?></td>
        <td><?php echo $row->BOOK_NAME ;?></td>
        <td><?php if($row->DEBIT=="") {echo "";} else { ?><span class="badge badge-success"><?php echo $row->DEBIT; }?></span></td>
        <td><?php if($row->CREDIT=="") {echo "";} else { ?><span class="badge badge-success"><?php echo $row->CREDIT; }?></span></td>
        <td><?php if($row->TRANS_TYPE=="") { echo ""; } else { ?><code><?php echo $row->TRANS_TYPE; }?></code></td>
    </tr>
    
     <?php
 
 $sum+= $row->CREDIT;
 $dbsum+=$row->DEBIT;
  $sn_count++;
 
		}
	
	//$balance=$fee_amt-$sum;
	$balance= $dbsum-$sum;
	
?>
    <tr>
      <td colspan="3" align="right">TOTAL</td>
      <td  align="center"><span class="badge badge-info"><?php echo  $dbsum;?></span> </td>
     <td> <span class="badge badge-info"><?php echo $sum;?></span></td>
     <td colspan="3"></td>
    </tr>
    <tr>
      <td colspan="3" align="right">BALANCE</td>
      <td colspan="5" style="word-spacing:10px">&nbsp;&nbsp;
      <span class="badge badge-danger"><?php  echo $balance;?></span></td>
    </tr>
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