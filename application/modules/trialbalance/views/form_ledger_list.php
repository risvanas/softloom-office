<?php
$fdate=date('d-m-Y',strtotime($frm));
$tdate=date('d-m-Y',strtotime($to));
?>
<input type="hidden" id="txt_from" name="txt_from" value="<?php echo $fdate; ?>">
<input type="hidden" id="txt_to" name="txt_to" value="<?php echo $tdate; ?>">
<div class="row" style="padding-top:20px;">
  <div class="col-md-12"> 
    <!-- start: DYNAMIC TABLE PANEL -->
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Ledger
        <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                            href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                    href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                        href="#"><i class="icon-remove"></i></a> </div>
      </div>
 
        <div class="panel-body">
       
         <h2><i class="icon-edit-sign teal"></i> Ledger</h2>
          <div>
            <hr />
          </div>
		  <div class="row" style="padding-bottom: 6px;">
		  <div class="col-md-12">
		  <input type="button" name="btn_print" id="btn_print" value="PRINT" onclick="printDiv('table','Ledger')" class="btn btn-green"  >
		  </div>
		  </div>
<img id='logo_image'src='http://office.softloom.com/assets/images/logo.jpg' alt='Softloom ITSolution' style='display:none;'>
<div id="table">
<table class="table table-striped table-bordered table-hover table-full-width">
  <thead>
  <?php
  $query=$this->db->query("select ACC_NAME from tbl_account where ACC_ID=$acc");
  $val=$query->row_array();
  $ac_name=$val['ACC_NAME'];
  $sub_name='';
  if($sub != '')
  {
	  $query1=$this->db->query("select ACC_NAME from tbl_account where ACC_ID=$sub");
  $val1=$query1->row_array();
  $sub_name=$val1['ACC_NAME'];
  }
  ?>
  <tr><th colspan="7"><h4><?php echo "Ledger from ".$frm." to " .$to. "( Account :".$ac_name." ) "; ?></h4></th></tr>
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
				   $totreceipt=0;
				   $totpayment=0;
				?>
    <tr>
      <td colspan="4" align="right"><b>Opening Balance:</b></td>
      <td colspan="2" align="right"><b>
        <?php  if( $opening_balance > 0)
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
				 }?>
        </b></td>
      <td></td>
    </tr>
    <?php
			  foreach($sel->result() as $row)
                 {
					 $acc_id=$row->ACC_ID;
					 $book_name=$row->BOOK_NAME;
					 $book_num=$row->BOOK_NUMBER;
					 $date_entry=$row->DATE_OF_TRANSACTION;  
					 $acc_year=$row->$ACC_YEAR_CODE;  
				?>
    <tr>
      <td colspan="2"><?php $time1 = strtotime($date_entry);
		            echo  $date_entry1=date("d-m-Y", $time1);?></td>
      <td><a href="<?php echo site_url('ledger/view_details') . "$book_num/$book_name/$acc_year";?> " target="_blank"><?php echo $book_name ."".$book_num;?><a></td>
      <td><?php echo $row->REMARKS; ?></td>
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
    <tr>
      <td colspan="4" align="right"><b>TOTAL </b>
      <td align="right"><b><?php echo $totreceipt;?></b></td>
      <td align="right"><b><?php echo $totpayment;?></b></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="4" align="right"><b>Closing Balance</b></td>
      <td colspan="2" align="right"><b>
        <?php  if( $opening_balance > 0)
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
				 }?>
        </b></td>
      <td></td>
    </tr>
  </tbody>
</table>
</div>
</div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/print.js"></script>
<script>
	
		jQuery(document).ready(function() {
		Main.init();
		FormElements.init();
		
	    });
		
		
		
</script>