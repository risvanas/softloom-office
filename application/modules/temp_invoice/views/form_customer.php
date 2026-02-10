
        <?php 
		foreach($customer->result() as $row)
            {
				
		 ?>
        
     
            	
                
                
                
                <h4>Customer Details</h4>
  <div class="well">
    <address>
    <span class="badge"><?php echo $row->ACC_NAME;?></span>
    <input type="hidden" id="lbl_cust_name" name="lbl_cust_name" value="<?php echo $row->ACC_NAME;?>">
    <br>
    <br><strong>Contact Person:</strong>&nbsp; <?php echo $row->CONTACT_PERSON;?><br><strong>Address:</strong>&nbsp;  <?php echo $row->ADDRESS_ONE;?>  <br>
    </address>
    <address>
    <strong>Contact info</strong> <br>
    <span title="Phone">Phone:<?php echo $row->PHONE;?></span> <br>
    <span title="Email">Email:<?php echo $row->ACC_EMAIL;?></span> <br> 
    </address>
  </div>
                
                
              
 
 
 <?php
			}
			?>