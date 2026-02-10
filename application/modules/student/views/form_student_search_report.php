
  <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
      <tr>
        <th> SlNo</th>
        <th> Name </th>
        <th> Contact No </th>
        <th> Course </th>
		<th style="width: 80px;"> Reg Date </th>
		<th> Last Payment Date </th>
        <th> Course Fee </th>
        <th> Paid Amount </th>
        <th> Due Amount </th>
      </tr>
    </thead>
    
    <tbody>
      <?php $sn_count = 1;
	   $crnt_date=date('d-m-Y');
	   foreach($s->result() as $row)
	   {
			 $stud_id=$row->STUDENT_ID;
			 $query=$this->db->query("SELECT SUM(AMOUNT) AS AMOUNT,MAX(PAYMENT_DATE) AS LAST_PAYMENT FROM tbl_payment WHERE STUDENT_ID=$stud_id AND TYPE='STD' AND DEL_FLAG='1'");  
			 $res = $query->row_array();
			 $totl_amt=$res['AMOUNT'];
			 $last_payment=$res['LAST_PAYMENT'];
			 $fee_amt=$row->FEE_AMOUNT;
                ?>
      <tr>
        <td ><?php if($fee_amt<=$totl_amt)
				{?>
                  <span class="badge badge-success"> <?php echo $sn_count;?></span>
                  <?php
				}
				else
				{?>
                  <span class="badge"> <?php echo $sn_count;?></span>
                  <?php
                }
				?></td>
				
        <td><?php echo $row->NAME;?></td>
        <td><?php echo $row->CONTACT_NO;?></td>
        <td><?php echo $row->ACC_NAME;?></td>
        <td><?php $reg_date=$row->REG_DATE;
				$reg_date = strtotime($reg_date);
		       echo  $reg_date=date("d-m-Y", $reg_date);?></td>
		<td><?php $last_payment;
		 $last_payment = strtotime($last_payment);
		       echo  $last_payment=date("d-m-Y", $last_payment);?></td>
        <td><?php echo $fee_amt;?></td>
		<td><?php echo $totl_amt;?></td>
        <td><?php echo $due_amt=$fee_amt-$totl_amt;
				 
			?></td>
      </tr>
      
      <!----------------------- start allert box ---------------------------->
    <div id="static<?php echo $row->STUDENT_ID;?>" class="modal fade" tabindex="-1" 
data-backdrop="static" data-keyboard="false" style="display: none;">
      <div class="modal-body">
        <p> Are You sure, that you want to delete selected record? </p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
        <a type="button"  class="btn btn-primary" href="<?php echo site_url('student/student_delete'); ?>/<?php echo $row->STUDENT_ID;?>"> Continue </a> </div>
    </div>
    <!----------------------- end allert box ---------------------------->
    
    <?php $sn_count++;
            }
            ?>
    
    
    
   
    </tbody>
  </table>


       <script>
	
//		jQuery(document).ready(function() {
//		Main.init();
//		FormValidator.init();
//		FormElements.init();
//		
//	    });

		</script>