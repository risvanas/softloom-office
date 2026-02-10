<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Editable Invoice</title>
	
	
    
    <link rel='stylesheet' type='text/css' href='<?php echo base_url();?>assets/invoice/print_css/style.css' />
<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>assets/invoice/print_css/print.css' media="print" />
<script type='text/javascript' src='<?php echo base_url();?>assets/invoice/js/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/invoice/js/example.js'></script>

</head>

<body>
<?php
  foreach($vno->result() as $row)
            {
			  $invoice_id=$row->INVOICE_ID;
				$cust_id=$row->CUSTOMER_ID;
				$query=$this->db->query("SELECT * FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");  
			  $res = $query->row_array();
			  $customer_name=$res['ACC_NAME'];
			   $address_one=$res['ADDRESS_ONE'];
			    $phone=$res['PHONE'];
				 $acc_email=$res['ACC_EMAIL']; 
				
				  
			  $total_price=$row->TOTAL_PRICE;
			  $paid_price=$row->PAID_PRICE;
			  $due_amt=$total_price-$paid_price;
		   ?>
	<div id="page-wrap">

		<textarea id="header">INVOICE</textarea>
		
		<div id="identity">
		
            <textarea id="address">Softloom It Solutions </textarea>

            <div id="logo">

              <div id="logoctr">
                <a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
                <a href="javascript:;" id="save-logo" title="Save changes">Save</a>
                |
                <a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
                <a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
              </div>

              <div id="logohelp">
                <input autocomplete="off" id="imageloc" type="text" size="50" value="" /><br />
                (max width: 540px, max height: 100px)
              </div>
              <img id="image" src="http://wesmosis.softloom.com/assets/images/logo1.png" alt="logo" />
            </div>
		
		</div>
		
		<div style="clear:both"></div>
		
		<div id="customer">

            <textarea id="address"><?php echo $customer_name. $address_one. $phone .$acc_email;
			//echo $address_one;
			//echo $phone;
			//echo $acc_email;?></textarea>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><textarea><?php echo $row->BOOK_NUMBER;?></textarea></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><textarea id=""><?php $invoice_date=$row->INVOICE_DATE;
			   														  $invoice_date = strtotime($invoice_date);
																	echo $invoice_date=date("F d,Y", $invoice_date);?></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due"><?php echo $due_amt;?></div></td>
                </tr>

            </table>
            <?php 
		 $details=$this->db->query("SELECT * FROM tbl_temp_invoicedetails WHERE INVOICE_ID='$invoice_id' AND DEL_FLAG='1'"); 
		
		?>
		</div>
		
		<table id="items">
		
		  <tr>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Quantity</th>
		      <th>Price</th>
		  </tr>
		  <?php foreach($details->result() as $items) {
			  
			  $unit_cost=$items->UNIT_COST; 
		    $quantity= $items->QUANTITY; 
			$price=$unit_cost* $quantity;
			
			  ?>
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea id="item[]" name="item[]"><?php echo $items->ITEM; ?></textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea><?php echo $items->DESCRIPTION; ?></textarea></td>
		      <td><textarea class="cost"><?php echo $items->UNIT_COST; ?></textarea></td>
		      <td><textarea class="qty"><?php echo $items->QUANTITY; ?></textarea></td>
		      <td><span class="price"><?php echo $price; ?></span></td>
		  </tr>
		  <?php
		  }
		  ?>
		  
		  
		  <tr id="hiderow">
		    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
		  </tr>
		  
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line"> Subtotal </td>
		      <td class="total-value"><div id="subtotal"><?php echo $row->TOTAL_PRICE;?></div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total"><?php echo $row->TOTAL_PRICE;?></div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value"><textarea id="paid"><?php echo $row->PAID_PRICE;?></textarea></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due"><?php echo $due_amt;?></div></td>
		  </tr>
		
		</table>
        <?php
			}
		?>
		
		<div id="terms">
		  <h5>Terms</h5>
		  <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
		</div>
	
	</div>
	
</body>

</html>