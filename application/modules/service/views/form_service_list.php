<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<div class="row" style="padding-top:20px;" >
  <div class="col-md-12"> 
    
    <!-- start: DYNAMIC TABLE PANEL -->
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="icon-external-link-sign"></i> Service List
        <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
      </div>
      
      <!-- end: PAGE TITLE & BREADCRUMB -->
      <div class="col-md-12">
        <div id="error_msg" class="errorHandler alert alert-danger no-display"> <i class="icon-remove-sign"></i> You have some form errors. Please check below. </div>
        <div id="succe_msg" class="successHandler alert alert-success no-display "> <i class="icon-ok"></i> </div>
      </div>
      <div class="col-md-12">
        <div class="page-header">
          <h1>Service List </h1>
        </div>
      </div>
      <div class="panel-body"  >
        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
          <thead>
          <th> No</th>
            <th>Domain Name</th>
            <th>Account Type</th>
            <th>Phone Number</th>
            <th>Registration Date </th>
            <th>Renewal Date </th>
            <th>Amount</th>
            <th>Status</th>
            <th>&nbsp;</th>
            </thead>
          <tbody>
            <tr>
              <?php $sn_count = 1; foreach($service_list->result() as $row)
            {
			  /*$remark=$row->REMARKS;
			  $cusername=$row->USERNAME;
			  $cpasswrd=$row->PASSWORD;
			  $dusername=$row->DOMAIN_UNAME;
			  $dpasswrd=$row->DOMAIN_PASSWD;*/	
		   ?>
              <td><?php echo $sn_count;?></td>
              <td><?php echo $d_s_name=$row->D_S_NAME;?></td>
              <td><?php echo $acc_type=$row->ACC_TYPE;?></td>
              <td><?php echo $phone_num=$row->PHONE;?></td>
              <td><?php $reg_date=$row->REG_DATE;
			       $reg_date = strtotime($reg_date);
		           echo $reg_date=date("d-m-Y", $reg_date);?></td>
              <td><?php
			  $rdate=$row->RENEWAL_DATE;
			  $rdate = strtotime($rdate);
		      $rdate=date("d-m-Y", $rdate);
			   
			 $cdate=  date("d-m-Y");
             $date1=date_create($cdate);
             $date2=date_create($rdate);
             $diff=date_diff($date1,$date2);
			 $res= $diff->format("%R%a ");
			 if($res<0)
			 {
				echo "<span class='label label-danger'>$rdate</span>";
			 }
			 else if($res==0)
	           {
                 echo "<span class='label label-success'>$rdate</span>";
	           }
			  else if($res>0 && $res<=30)
	           {
                 echo "<span class='label label-warning'>$rdate</span>";
	           }
	          else
	          {
                  echo "$rdate";
	           }
			 ?></td>
              <td><?php echo $amount=$row->AMOUNT;?></td>
              <td><?php $stat=$row->STATUS; 
                  if($stat=="ACTIVE")
			        {
				 echo "<span class='label label-success'>$stat</span>";
			      }
			  else if($stat=="INACTIVE")
			  {
             echo "<span class='label label-danger'>$stat</span>";
			  }?></td>
              <td class=""><div class="btn-group">
                  <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick="hiddenFunction()"> <i class="icon-wrench"></i> Setting </button>
                  <button  onclick="hiddenFunction()"  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                  <ul class="dropdown-menu" role="menu">
                    <li> <a href="#service<?php echo $row->ID;?>" data-toggle="modal"> <i class="icon-pencil"></i> View </a> </li>
                    <li> <a href="<?php echo site_url('service/service_edit'); ?>/<?php echo $row->ID;?> "> <i class="icon-pencil"></i> Edit </a> </li>
                    <li> <a href="#static<?php echo $row->ID;?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>
                  </ul>
                </div></td>
            </tr>
            
            <!----------------------- start allert box ---------------------------->
          <div id="service<?php echo $acc_id=$row->ID;?>" class="modal fade" tabindex="-1" data-backdrop="service" data-keyboard="false" style="display: none;">
          <div class="modal-header">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button"> × </button>
      <h4 class="modal-title">Domain Details 
      </h4>
    </div>
            <div class="modal-body">
            
            	<div class="tabbable">
												<ul id="myTab" class="nav nav-tabs tab-bricky">
													<li class="active">
														<a href="#panel_tab<?php echo $row->ID;?>" data-toggle="tab">
															<i class="green clip-network"></i>&nbsp;Domain Details
														</a>
													</li>
													<li>
														<a href="#panel_tab2<?php echo $row->ID;?>" data-toggle="tab">
															<i class="green clip-network"></i>&nbsp;Remark
														</a>
													</li>
													
												</ul>
												<div class="tab-content">
													<div class="tab-pane in active" id="panel_tab<?php echo $row->ID;?>">
														<!--<p>
															Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent.
														</p>
														<div class="alert alert-info">
															<p>
																Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.
															</p>
															<p>
																<a href="#panel_tab2_example2" class="btn btn-teal show-tab">
																	Go to tab 2
																</a>
															</p>
														</div>-->
                                                        
                                                        <address>
                  <span style="width:200px;">Domain Name:</span><?php echo $d_s_name;?><br>
                  <strong>Account Type:</strong><?php echo $acc_type;?><br>
                  <strong>Phone Number:</strong><?php echo $phone_num;?><br>
                  <strong>Registration Date:</strong><?php echo $reg_date;?><br>
                  <strong>Renewal Date :</strong><?php echo $rdate;?><br>
                  <strong>Cpanel Username :</strong><?php echo $row->USERNAME;?><br>
                  <strong>Cpanel Password:</strong><?php echo $row->PASSWORD;?><br>
                  <strong>Domain Username:</strong><?php echo $row->DOMAIN_UNAME;?><br>
                  <strong>Domain Password:</strong><?php echo $row->DOMAIN_PASSWD;?><br>
                  <strong>Amount:</strong><?php echo $amount;?><br>
                  <strong>Status :</strong><?php echo $stat;?><br>
                  <strong>Remark:</strong><?php echo $row->REMARKS;?><br>
                  </address>
													</div>
													<div class="tab-pane" id="panel_tab2<?php echo $row->ID;?>">
														<!--<p>
															Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo.
														</p>
														<p>
															<a href="#panel_tab2_example3" class="btn btn-red show-tab">
																Go to Dropdown 1
															</a>
														</p>-->
                                                        
                                                        <div class="well">
                  
                </div>
													</div>
													
													
												</div>
											</div>
                                            
                
            </div>
            <!--<div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
            </div>-->
          </div>
          <!----------------------- end allert box ----------------------------> 
          
          <!----------------------- start allert box delete ---------------------------->
          <div id="static<?php echo $row->ID;?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
            <div class="modal-body">
              <p> Are You sure, that you want to delete selected record? </p>
            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
              <a type="button"  class="btn btn-primary" href="<?php echo site_url('service/service_delete'); ?>/<?php echo $row->ID;?>"> Continue </a> </div>
          </div>
          <!----------------------- end allert box ---------------------------->
          
          <?php $sn_count++;
            }
            ?>
          </tbody>
          
        </table>
      </div>
    </div>
    
    <!-- end: DYNAMIC TABLE PANEL --> 
  </div>
</div>

<!-- end: PAGE HEADER --> 

	
		
		
		
        
        	

        
        

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-data.js"></script>       
<script>
	jQuery(document).ready(function() {
		Main.init();
		TableData.init();
	});
</script>	