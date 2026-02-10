
 
			  <label class="control-label">Sub Account</label>
                    <select class="form-control" id="txt_sub_account" name="txt_sub_account" >
                    <option value="">Choose the name here</option>
                      <?php 
					  
			 foreach($acc_name->result() as $row)
			 {
				
				 ?>
                      <option value="<?php echo $row->ACC_ID;?>"><?php echo $row->ACC_NAME;?></option>
                      <?php
			 }
			 ?>
                    </select>
		
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/form-validation/fee_collection.js"></script>          
       <script>
	
jQuery(document).ready(function() {
	Main.init();
	FormValidator.init();
	UIModals.init();
	FormElements.init();
	
});



		</script> 