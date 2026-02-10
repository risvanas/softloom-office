
  <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
      <tr>
        <th> No</th>
        <th> Name </th>
        <th> Contact No </th>
        <th> Course </th>
        <th> Course Fee </th>
        <th style="width: 80px;"> Reg Date </th>
        <th> Due Date </th>
         <th> Status </th>
        <th style="width:110px;">&nbsp;</th>
      </tr>
    </thead>
    
    <tbody>
      <?php $sn_count = 1;
	   $crnt_date=date('d-m-Y');
	   foreach($s->result() as $row)
            {
				$stud_id=$row->STUDENT_ID;
			 $query=$this->db->query("SELECT SUM(AMOUNT) AS AMOUNT FROM tbl_payment WHERE STUDENT_ID=$stud_id AND TYPE='STD' AND DEL_FLAG='1'");  
			  $res = $query->row_array();
			  $totl_amt=$res['AMOUNT'];
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
        <td><?php echo $row->FEE_AMOUNT;?></td>
        <td><?php $reg_date=$row->REG_DATE;
				$reg_date = strtotime($reg_date);
		       echo  $reg_date=date("d-m-Y", $reg_date);?></td>
               
        <td><?php $due_date=$row->DUE_DATE;
				 $due_date = strtotime($due_date);
				 $due_date=date("d-m-Y", $due_date);
				 if($crnt_date==$due_date)
				 	echo "<span class='label label-success'>$due_date</span>";
					if($due_date=='01-01-1970' || $due_date=="" || $due_date==NULL )
			  		echo $due_date="";
				    if($crnt_date > $due_date)
               		echo "<span class='label label-danger'>$due_date</span>";
				if($crnt_date < $due_date)
               		echo "<span class='label label-warning' >$due_date</span>";
			?></td>
			
       
         <?php $stat=$row->status; 
                
                  if($stat=="REGISTERED")
			  {
				 
				  ?>
                <td><span class="label label-info"> <?php echo  $stat?> </span></td>
                <?php
			  }
			  
			  else if($stat=="CLASS STARTED")
			  {
				  ?>
                <td><span class="label label-success" > <?php echo  $stat;?> </span></td>
                <?php
			  }
			  
			  else if($stat=="DISCONTINUE")
			  {
				  ?>
                <td><span class="label label-danger" > <?php echo  $stat;?> </span></td>
                <?php
			  }
			  
			  else
			   {
				  ?>
                <td><span class="label label-warning" > <?php echo  $stat;?> </span></td>
                <?php
			  }
			  
			  ?>
              
        <td class=""><div class="btn-group">
            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
            <ul class="dropdown-menu" role="menu">
              <li> <a href="<?php echo site_url('student/student_edit'); ?>/<?php echo $row->STUDENT_ID;?> "> <i class="icon-pencil"></i> Edit </a> </li>
               <li> <a href="<?php echo site_url('feecollection/course_completion');?>/<?php echo $row->STUDENT_ID;?> "> <i class="icon-pencil"></i> completion </a> </li>
              <li> <a href="#static<?php echo $row->STUDENT_ID;?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>
            </ul>
          </div></td>
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