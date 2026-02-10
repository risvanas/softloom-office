<!-- start: DYNAMIC TABLE PANEL -->
<div class="row" style="padding-top:20px;" >
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="icon-external-link-sign"></i> Enquiry List
        <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
      </div>
      <div class="col-md-12">
        <h1>Enquiry List <small></small></h1>
        <hr />
      </div>
      <!-- end: PAGE TITLE & BREADCRUMB -->
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Select Date</label>
              <span class="input-icon input-icon-right">
              <input type="text" data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-range" name="txt_from_date" id="txt_from_date" onchange="search_data()" onblur="search_data()">
              <i class="icon-calendar"></i> </span> </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Date</label>
              <select name="txtdtype" class="form-control" id="txtdtype">
                <option value="NEXTFDATE">NF date </option>
                <option value="REG_DATE">Reg Date</option>
                <option value="ENTRYDATE">Entry Date</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Status</label>
              <select name="txtstype" class="form-control" id="txtstype" onchange="search_data()">
                <option value="">Select</option>
                <?php foreach($Status->result() as $row) { ?>
                <option value="<?php echo $row->id; ?>"><?php echo $row->status; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Sort by</label>
              <select name="txtsorttype" class="form-control" id="txtsorttype" onchange="search_data()">
                <option value="NAME">By Name </option>
                <option value="REG_DATE">By Reg Date </option>
                <option value="NEXTFDATE" selected="selected">By NF Date </option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <label for="form-field-mask-1"> Key Words </label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search By name" name="txt_key_words" id="txt_key_words" onkeyup="search_data()">
              <span class="input-group-btn">
              <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Go! </button>
              </span> </div>
          </div>
        </div>
      </div>
      <!-----------------------Start view Enquiry Details ---------------------------->
      <div class="panel-body">
        <div id="out">
          <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Enquiry For</th>
                <th>PhoneNo</th>
                <th>Reg Date</th>
                <th>Next Followup Date</th>
                <th>Status</th>
                <th width="148" style="width:150px;">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <?php $sn = 0;
	        $cdat=date('Y-m-d');
			foreach($Enquiry->result() as $row)
			{  $sn++;
            ?>
              <tr>
                <td><?php echo $sn; ?></td>
                <td><?php echo $row->NAME; ?></td>
                <td><?php echo $row->ACC_NAME; ?></td>
                <td><?php echo $row->PHNO;?></td>
                <td><?php $regdt= $row->REG_DATE; 
				if (($regdt=="") || ($regdt=="0000-00-00") || ($regdt=="1970-01-01"))
				{
					echo $reg_date="";
				}
				else
				{
				$regdte=strtotime($regdt);
				echo $reg_date=date('d-m-Y',$regdte);
				}
				?></td>
                <td>
				
				<?php 
				$crnt_date=date('d-m-Y');
			   $NEXTFDATE=$row->NEXTFDATE;
				 $NEXTFDATE = strtotime($NEXTFDATE);
				 $NEXTFDATE=date("d-m-Y", $NEXTFDATE);
				 if($crnt_date==$NEXTFDATE)
				 	echo "<span class='label label-success'>$NEXTFDATE</span>";
					else if($crnt_date < $NEXTFDATE)
						
               		echo "<span class='label label-warning' >$NEXTFDATE</span>";
						
				else if($crnt_date > $NEXTFDATE)
				{
					if($NEXTFDATE=='01-01-1970' )
							{
								
								$NEXTFDATE="";
							}
							
				echo "<span class='label label-danger'>$NEXTFDATE</span>";
				
						}
						
			?>
			
			</td>
              
                 <td><span class="label <?php echo  $row->style_class;?>" ><?php echo $row->status;?></span></td>
                <td class=""><div class="btn-group" width="90">
                    <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick="hiddenFunction()"> <i class="icon-wrench"></i> Setting </button>
                    <button  onclick="hiddenFunction()"  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                    <ul class="dropdown-menu" role="menu">
                      <?php
                ?>
                      <li><a href="#addnewfolloup" data-toggle="modal" 
                      onclick="getFollowupDetails(<?php echo $row->EN_ID;?>); enquiry_name('<?php echo $row->NAME; ?>'); setStatus('<?php echo "soid".$row->STATUS;?>');"> <i class="clip-folder-plus"></i>&nbsp;Add Followup </a> </li>
                      <li> <a href="<?php echo site_url('enquiry/find_enquiry_details'); ?>/<?php echo $row->EN_ID;?>"> <i class="icon-pencil"></i>&nbsp;Edit Profile</a> </li>
                      <li> <a href="#static<?php echo $row->EN_ID;?>" data-toggle="modal"> <i class="icon-trash"></i>&nbsp;Delete Profile</a> </li>
                    </ul>
                  </div></td>
              </tr>
              
              <!----------------------- start allert box ---------------------------->
            <div id="static<?php echo $row->EN_ID;?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
              <div class="modal-body">
                <p> Are You sure, that you want to delete selected record? </p>
              </div>
              <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                <a type="button"  class="btn btn-primary" href="<?php echo site_url('enquiry/delete_enquiry_details'); ?>/<?php echo $row->EN_ID; ?>"> Continue </a> </div>
            </div>
            <!----------------------- end allert box ---------------------------->
            <?php
			
		    $Enquiry++;
            }
            ?>
              </tbody>
            
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-----------------------End view Enquiry Details ----------------------------> 

<!----------------------- start add new followup ---------------------------->
<div id="addnewfolloup" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
  <form action="<?php echo site_url('followup');?>" name="form" id="form" role="form" method="post" >
    <?php    $cdate=date('Y-m-d');
				 ?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
      <h4 class="modal-title">New Followup To
        <label id="lbl_equ_name"></label>
      </h4>
    </div>
    <div class="modal-body">
      <div calss="row">
        <div class="col-md-12">
          <input type="hidden" class="form-control" id="txt_en_id" name="txt_en_id"/>
          <div class="row">
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">Status<span class="symbol required"></span> </label>
                    <select class="form-control" id="txt_status" name="txtstatus">
                      <option value="">Select</option>
                      <?php foreach($Status->result() as $r) { ?>
                      <option id="<?php echo "soid".$r->id;?>" value="<?php echo $r->id;?>"><?php echo $r->status; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">Followup Date<span class="symbol required"></span> </label>
                    <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtfdate" value="<?php echo date('d-m-Y');?>" id="txtfdate" >
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">Next Followup Date<span class="symbol required"></span> </label>
                    <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtnfdate"    id="con" >
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">Description<span class="symbol required"></span> </label>
                    <textarea class="form-control" id="txt_desp" name="txtdesp"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div id="follow_up_detail" > </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-light-grey"> Close </button>
      <button class="btn btn-primary" type="submit" >Save </button>
    </div>
  </form>
</div>
<!----------------------- end add new followup ----------------------------> 

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/enquiry_pop.js"></script> 
<script>
	
jQuery(document).ready(function() {
	Main.init();
	FormValidator.init();
	UIModals.init();
	FormElements.init();
	
});
</script> 
<script>
 function hiddenFunction()
{
 $.ajax({
		type:"POST",
		data:
		{datefrom:$('#txt_from_date').val(),
		dateto:$('#txt_to_date').val()
		},
		url:"<?php echo site_url('enquiry/sel_date_details'); ?>",
		success:function(data)
		{
			$('#outpt').html(data);
		}
	}
	);
} 
  </script> 
<script>
  function search_data()
  {
	  $.ajax({
		type:"POST",
		data:
		{
		datefrom:$('#txt_from_date').val(),
		dtype:$('#txtdtype').val(),
		stype:$('#txtstype').val(),
		sorttype:$('#txtsorttype').val(),
		key_words:$('#txt_key_words').val()
		},
		url:"<?php echo site_url('enquiry/search_enquiry_details'); ?>",
		success:function(data)
		{
			$('#out').html(data);
		}
	}
	);
  }
  </script> 

<!-- end: DYNAMIC TABLE PANEL -->
</div>
</div>
</div>

<!-- end: PAGE HEADER --> 

<script>
 function getFollowupDetails(en_id)
  {
	  document.getElementById("txt_en_id").value =en_id;
	  $.ajax
	  ({
		type:"POST",
		data: 	   
		{
		eid:en_id
		},
		url:"<?php echo site_url('enquiry/followup_details'); ?>",
		success:function(data)
		{
			$('#follow_up_detail').html(data);
		}
	  });
  }
  
  function enquiry_name(enquiry_name)
  {
        text = document.getElementById('lbl_equ_name');
        text.innerHTML=enquiry_name;
  }
  
  function setStatus(status_id)
  {
	  var statusOpId = status_id;
	  document.getElementById(statusOpId).selected = "true";
  }
 </script> 
