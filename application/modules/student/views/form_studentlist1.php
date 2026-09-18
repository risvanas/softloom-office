<div class="row" style="padding-top:20px;" >
  <div class="col-md-12"> 
    <!-- start: DYNAMIC TABLE PANEL -->
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="icon-external-link-sign"></i> Student List
        <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
      </div>
      
      <!-- end: PAGE TITLE & BREADCRUMB -->
      <div class="col-md-12">
        <h1>Student List<small></small></h1>
        <hr />
      </div>
      <div class="row">
      	<div class="col-md-12">
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Select Date</label>
              <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-range" name="txt_calc" id="txt_calc" onblur="search_data()" onchange="search_data()" onkeyup="search_data()">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Choose Date </label>
              <select class="form-control"  id="search_date" name="search_date" >
                <option value="DUE_DATE" selected="selected">Due Date</option>
                <option value="REG_DATE">Reg Date</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label"> Course </label>
              <select class="form-control"  id="txt_search_course" name="txt_search_course" onchange="search_data()">
                <option value="">Select</option>
                <?php foreach($course->result() as $row) { ?>
                <option value="<?php echo $row->ACC_ID;?>"> <?php echo $row->ACC_NAME;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label"> Status </label>
              <select class="form-control"  id="search_status" name="search_status" onchange="search_data()">
                <option value="">Select</option>
                <?php
                  foreach($status->result() as $res)
              
                  {
                      ?>
                <option value="<?php echo $res->id; ?>"><?php echo  $res->status; ?></option>
                <?php
                  }
                  ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <label for="form-field-mask-1"> Key Words </label>
            <div class="input-group">
              <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_key_words" id="txt_key_words" onkeyup="search_data()">
              <span class="input-group-btn">
              <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Go! </button>
              </span> </div>
          </div>         
        </div>
      </div>
      <div class="panel-body" >
        <div id="output">
          <table class="table table-striped table-bordered table-hover table-full-width" >
            <thead>
              <tr>
                <th> No</th>
                <th> Name </th>
                <th> Contact No </th>
                <th> Course </th>
                <th> Course Fee </th>
                <th> Reg Date </th>
                <th> Due Date </th>
                <th> Status</th>
                <th style="width:110px;">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <?php $sn_count = 1; 
			     $crnt_date=date('d-m-Y');
			  foreach($course_list->result() as $row)
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
                <td><?php echo $row->NAME;?><?php echo "&nbsp;(SIS".$row->STUDENT_ID.")";?></td>
                <td><?php echo $row->CONTACT_NO;?></td>
                <td><?php echo $row->ACC_NAME; ?></td>
                <td><?php echo $row->FEE_AMOUNT;?></td>
                <td><?php $reg_date=$row->REG_DATE;
				$reg_date = strtotime($reg_date);
		        echo $reg_date=date("d-m-Y", $reg_date);?></td>
                <td><?php 
			   $due_date=$row->DUE_DATE;
				 $due_date = strtotime($due_date);
				 $due_date=date("d-m-Y", $due_date);
				 if($crnt_date==$due_date)
				 	echo "<span class='label label-success'>$due_date</span>";
					else if($crnt_date < $due_date)
               		echo "<span class='label label-warning' >$due_date</span>";
				else if($crnt_date > $due_date)
				{
					if($due_date=='01-01-1970' )
							{
								$due_date="";
							}
				echo "<span class='label label-danger'>$due_date</span>";
				
						}
						
			?></td>
                <td><span class="label <?php echo  $row->style_class;?>" ><?php echo $row->status;?></span></td>
                <td class=""><div class="btn-group">
                    <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                    <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                    <ul class="dropdown-menu" role="menu">
                    
                      <li> <a href="<?php echo site_url('student/student_edit'); ?>/<?php echo $row->STUDENT_ID;?> "> <i class="icon-pencil"></i> Edit </a> </li>
                      <li> <a href="<?php echo site_url('feecollection/coursecompletion');?>/<?php echo $row->STUDENT_ID;?> "> <i class="icon-pencil"></i> completion </a> </li>
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
            
            <div id="responsive<?php echo $row->STUDENT_ID;?>" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title">Update</h4>
              </div>
              <div class="modal-body">
                <form method="post" action="<?php echo site_url('student/update_status');?>">
                  <div class="row">
                    <div class="col-md-12">
                      <?php $stat= $row->STATUS;?>
                      <input type="hidden" name="txt_id" value="<?php echo $row->STUDENT_ID; ?>" />
                      <h1>Update Status</h1>
                      <div class="row">
                        <div class="col-md-3"> Status
                          <select name="sel_status" class="form-control">
                            <?php
			 $sel="select * from tbl_status";
			 $sql=mysql_query($sel);
			 while($res=mysql_fetch_array($sql))
			 {
				 ?>
                            <option value="<?php echo $res['status']; ?>" <?php if($res['status']==$stat) echo "selected"; ?>><?php echo $res['status']; ?></option>
                            <?php
			 }
			 ?>
                          </select>
                        </div>
                        <div class="col-md-2"> <span style="color:#FFF">hghdh</span>
                          <input type="Submit"  value="Submit" class="form-control btn btn-green"  />
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-light-grey"> Close </button>
                <button type="button" class="btn btn-blue"> Save changes </button>
              </div>
            </div>
            <?php $sn_count++;
            }
            ?>
            </tbody>
            
          </table>
        </div>
      </div>
    </div>
    
    <!-- end: DYNAMIC TABLE PANEL --> 
  </div>
</div>

<!-- end: PAGE HEADER --> 
<script>
function search_data()
{
	$.ajax({
	type:"POST",
	data:
	{
		calc:$('#txt_calc').val(),
		dat:$('#search_date').val(),
		key_words:$('#txt_key_words').val(),
		course:$('#txt_search_course').val(),
		stat:$('#search_status').val()		
		
     },
	url:"<?php echo site_url('student/mult_search');?>",
	success: function(data)
	{
	 $('#output').html(data);
	}
	});
}
</script> 
<script>
	
		jQuery(document).ready(function() {
		Main.init();
		FormElements.init();
		
	    });

		</script> 
