
 
			  <label class="control-label"> Name</label>
                    <select class="form-control" id="txt_stud_name" name="txt_stud_name" onchange="load_stud_details()">
                    <option value="">Choose the name here</option>
                      <?php 
					  
			 foreach($name->result() as $row)
			 {
				 
				 ?>
                      <option value="<?php echo $row->STUDENT_ID;?>" <?php echo set_select('txt_stud_name', 'Name Select');?> ><?php echo $row->NAME?></option>
                      <?php
			 }
			 ?>
                    </select>
		
    
    
   <script>
 
function load_stud_details()
{

	$.ajax({
		type:"POST",
		data:{sname:$('#txt_stud_name').val()},
		url: "<?php echo site_url('training_return/student_details');?>",
		success: function(data)
		{
			$('#sdetail').html(data);
		}
		 
		
		
		
		
	});
}
</script>



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