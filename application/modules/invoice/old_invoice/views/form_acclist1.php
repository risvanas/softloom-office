
 <?php
  foreach($vno->result() as $row)
            {
		   ?>
           <script>
		    document.getElementById("txt_invoice_date").value ='<?php $invoice_date=$row->INVOICE_DATE;
			   														  $invoice_date = strtotime($invoice_date);
																	echo $invoice_date=date("d-m-Y", $invoice_date);?>';
			document.getElementById("txt_cust_name").value ='<?php echo $row->CUSTOMER_ID;?>';
	</script>
	<?php
																	
	  echo $ACC_CODE = $row->CUSTOMER_ID;
	  echo  $ACC_NAME = $row->BOOK_NUMBER;
	  echo  $ACC_TYPE = $row->BOOK_NUMBER;
	  echo $ACC_ID = $row->ITEM; ?>
   
  <?Php } ?>
