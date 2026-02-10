<?php
foreach($details->result() as $row)
{
	
?>

<div class="col-md-12">
  <h4>Customer Details</h4>
  <div class="well">
    <address>
    <span class="badge"><?php echo $row->ACC_NAME;?></span>
    <input type="hidden" name="lbl_cust_name" id="lbl_cust_name" value="<?php echo $row->ACC_NAME;?>"/>
    </strong><br />
    <br /><strong>Contact Person:</strong>&nbsp;<?php echo $row->CONTACT_PERSON;?>
    <br /><strong>Address:</strong>&nbsp;<?php echo $row->ADDRESS_ONE.' ,';?>
    <?php echo $row->ADDRESS_TWO;?><br>
    </address>
    <address>
    <strong>Contact info</strong> <br>
    <span title="Phone">Phone:</span> <?php echo $row->PHONE; ?><br>
    <span title="Email">Email:</span> <?php echo $row->ACC_EMAIL; ?><br>
    </address>
  </div>
  <?php
}
	?>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/fee_collection.js"></script> 
<script>
	
//jQuery(document).ready(function() {
//	Main.init();
//	FormValidator.init();
//	UIModals.init();
//	FormElements.init();
//	
//});



		</script> 