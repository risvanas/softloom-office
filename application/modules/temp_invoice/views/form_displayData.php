 
<?php  $sn_count = 1; 
  if($vno->num_rows()== 0)
 {
	 ?>
	<script>
	document.getElementById("voc_num").style.display = "block";
	
 </script> 
 <?php
 }
 else
 {
  foreach($vno->result() as $row)
            {
		   ?>
           <script>
		    document.getElementById("txt_voucher_date").value ='<?php $voucher_date=$row->DATE_OF_TRANSACTION;
			   														  $voucher_date = strtotime($voucher_date);
																	echo $voucher_date=date("d-m-Y", $voucher_date);?>';	
		    document.getElementById("txt_ref_voucher_no").value ='<?php echo $row->REF_VOUCHERNO;?>';
			document.getElementById("temp_voc_num").value ='<?php echo $row->BOOK_NUMBER;?>';
	 this.editaccount('<?php echo $row->ACC_CODE;?>','<?php echo $row->ACC_NAME;?>','<?php echo $row->SUB_ACC;?>','<?php echo $row->ACC_TYPE;?>','<?php echo $row->ACC_ID;?>','<?php echo $row->DEBIT;?>','<?php echo $row->DESCRIPTION;?>');
		   document.getElementById("bttdelete").style.visibility = "visible"; 
		   document.getElementById("hrefdelete").href ='<?php echo site_url('voucher/delete_data')."/".$row->BOOK_NUMBER;?>';
		 
		   document.getElementById("bttdelete").style.display = "block"; 
		   document.getElementById("hrefdelete").href ='<?php echo site_url('voucher/delete_data')."/".$row->BOOK_NUMBER;?>';
		   </script>
        
        
          <?php  $sn_count++; 
            }
 }
            ?>
        