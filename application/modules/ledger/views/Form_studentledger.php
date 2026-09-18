<?php $CI =& get_instance(); ?>
 <div class="row">
        <div class="col-md-12" style="padding: 15px">
            <!-- start: GROUP PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="icon-external-link-sign"></i>&nbsp Student Invoice
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                            href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                    href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                        href="#"><i class="icon-remove"></i></a>
                    </div>
                </div>
                <form id="form" method="post" action="">
                <div class="panel-body">
                    <span class="my-title"><i class="icon-edit-sign teal"></i>&nbsp Invoice Payment </span>
                    <hr />
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- start: ACCORDION PANEL -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="icon-reorder"></i>Invoice Payment
                                </div>
                                <?php $sn_count = 1; foreach($stud_list->result()  as $row)
                                    {
					                   $sid=$row->STUDENT_ID;
									  $sq = $CI->db->select_sum('AMOUNT', 'amt')->where('STUDENT_ID', $sid)->get('tbl_payment');
									  $rs = $sq->row_array();
									  $paid_amt = isset($rs['amt']) ? $rs['amt'] : 0;
									  $tot_fee_amt=$row->FEE_AMOUNT;
									 $balance_amount=$tot_fee_amt-$paid_amt;
                               ?>
                                
                                <div class="panel-body">
                                    <div class="panel-group accordion-custom accordion-teal" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapseTwo"><i class="icon-arrow"></i>Invoice No:- <?php echo $sn_count;?> 
                                                        <?php  $id=$row->STUDENT_ID; ?>
                                                        &nbsp Student Name :- <?php echo $nam= $row->NAME;?>
                                                        &nbsp Gross Amount : <?php echo $row->FEE_AMOUNT; ?> 
                                                        &nbsp Bal_Amount   : <?php echo $balance_amount; ?>
                                                        </a>
                                                        
                                                </h4>
                                                
                                            </div>
                                            
                                            <div id="collapseTwo" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                <div class="row">
                                                
                                                <div class="col-sm-6">
                                                            <div class="form-group">
                                                            
                                                 
                                                            
                                         <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                                   <thead>
                                                      <tr>
                                                         <th> No </th>
                                                         <th> Date </th>
                                                         <th> Transaction</th>
                                                         <th> Credit </th>
                                                         <th> Debit </th>
                                                         <th> Balance </th>
             
                                                     </tr>
                                                 </thead>
                                             <tbody>
                                                <?php
												$query = $CI->db->get_where('tbl_student', array('STUDENT_ID' => $id));
												$r = $query->row_array();
												
												
													?>
                                                 <tr>
												<td></td>
                                                  <td></td>
                                                  <td> Course Fee </td>
                                                  <td></td>
                                                  <td><?php	echo $balance= $r['FEE_AMOUNT']; ?> </td> 
                                                  <td></td>
                                                  </tr>
                                              
                                                <?php
												$i=0;
												$sql = $CI->db->query("SELECT tbl_payment.DATE, tbl_payment.PAY_NUMBER, tbl_payment.AMOUNT, tbl_student.FEE_AMOUNT FROM tbl_payment INNER JOIN tbl_student ON tbl_student.STUDENT_ID = tbl_payment.STUDENT_ID WHERE tbl_student.STUDENT_ID = ?", array($id));
												foreach ($sql->result_array() as $res)
												{
													$i++;
													?>
                                                  
                                                  <tr>
                                                <td><?php	echo $i; ?> </td>
												<td><?php	echo $res['DATE']; ?> </td>
                                                <td><?php	echo $res['PAY_NUMBER'];?>  </td>
                                                <td><?php	echo $amt=$res['AMOUNT']; ?> </td>
                                                <td></td>
                                                <td>
                                                 <?php
												 echo $balance=$balance-$amt;
												 
												?> </td>
                                            
												   </tr>
                                                   <?php
												}
												?> 
                                                   
                                                
											
                                               </tbody>
                                               </table>
      
                                                            </div>
                                                        </div>
                                                
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php $sn_count++;
                                    }
                                ?>
                                
                            </div>
                            <!-- end: ACCORDION PANEL -->
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <span class="symbol required"></span>Required Fields
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- end: COMPANY USER REGISTRATION PANEL -->
    </div>

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/form-validation/enquiry.js"></script>          
       <script>
	
jQuery(document).ready(function() {
	Main.init();
	FormValidator.init();
	TableData.init();
	UIModals.init();
	FormElements.init();
	
});



		</script> 