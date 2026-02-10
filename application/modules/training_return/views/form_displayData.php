
<?php  $sn_count = 1; 
 $vno->num_rows();
  if($vno->num_rows()== 0)
 {
	 ?>
	<script>
	document.getElementById("voc_num").style.display = "block";
	document.getElementById("btn_refresh").style.display = "none";
	 <?php $query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='SALRTN'");
					  $row=$query->row_array(); 
					 $book_num=$row['BOOK_NUMBER']; ?>
		document.getElementById("conn").value =<?php echo $book_num; ?>;
 </script> 
 <?php
 }
 else
 {
      ?>
	 <script>
	 document.getElementById("voc_num").style.display = "none";
	document.getElementById("btn_refresh").style.display = "block";
	</script>
	<?php
  foreach($vno->result() as $row)
            {
				  
				   echo $std_id=$row->SRC_ID;
				   echo $name=$row->NAME;
				   
		   ?>
           <script>
		   document.getElementById("text_stud_name").style.display = "block";
		    document.getElementById("txt_stud_name").style.display = "none";
			document.getElementById("txt_course").disabled = true;
			
		    document.getElementById("temp_voc_num").value ='<?php echo $sub_id=$row->BOOK_NUMBER;?>';
		    document.getElementById("txt_course").value ='<?php echo $sub_id=$row->SUB_ACC;?>';
			document.getElementById("text_stud_name").value ='<?php echo $row->NAME;?>';
			//load_stud_names();
			
			var name= '<?php echo $row->NAME;?>';
			//alert(name);
			
			//document.getElementById("txt_stud_name").value='<?php //echo $row->NAME;?>';
			document.getElementById("temp_name").value='<?php echo $row->SRC_ID;?>';
			load_stud_details_load();
		    document.getElementById("txt_payment_date").value ='<?php $payment_date=$row->DATE_OF_TRANSACTION;
			   														  $payment_date = strtotime($payment_date);
																	  echo $payment_date=date("d-m-Y", $payment_date);?>';	
		    document.getElementById("txt_amount").value ='<?php echo $row->DEBIT;?>';
			document.getElementById("temp_voc_num").value ='<?php echo $row->BOOK_NUMBER;?>';
			document.getElementById("drp_status").value ='<?php echo $row->STATUS;?>';
			
		    document.getElementById("bttdelete").style.display = "block"; 
		    document.getElementById("hrefdelete").href ='<?php echo site_url('training_return/delete_data').$row->BOOK_NUMBER;?>';
		   </script>
        
    
          <?php  $sn_count++; 
            }
 }
            ?>
        