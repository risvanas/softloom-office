



 <div class="row" style="padding-top: 20px;"> 
<div class="col-md-12">
  <!-- start: DYNAMIC TABLE PANEL -->
  <div class="panel panel-default">
  
  
   <div class="panel-heading">
    
     <i class="icon-external-link-sign"></i>
      Menu List
      <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> 
      </div>
    </div>
    <div class="col-md-12">
<div class="page-header" style="margin-bottom:0px;">
<h1>Menu List </h1>
</div>
</div>
	
<!-- end: PAGE TITLE & BREADCRUMB -->
<div class="col-md-12">
  <div id="error_msg" class="errorHandler alert alert-danger no-display"> <i class="icon-remove-sign"></i> You have some form errors. Please check below. </div>
  <div id="succe_msg" class="successHandler alert alert-success no-display "> <i class="icon-ok"></i> </div>
</div>
    
    <div class="panel-body">
    <label></label>
      <table  width="200" class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
        <thead>
            <th>No</th>
            <th>Parent Menu</th>
               <th>Sub Menu</th>
                 <th>URL</th>
				 <th>Icon</th>
				 <th>Status</th>
				 <th>Order</th>
             <th>&nbsp;</th>
         </thead>
       
        <tbody>
        
         <?php $sn_count = 1; foreach($list->result() as $row)
            {
				//		departmentId			
                ?>
          <tr>
		  <td ><?php echo $sn_count;?></td>
            <td ><?php echo $row->pmenu;?></td>
            <td class=""><?php echo $row->SUB_MENU;?></td>
            <td><?php echo $row->URL;?> </td>
           
              <td><?php echo $row->ICON;?> </td>
              <td><?php
                   $status=$row->SOURCE;			  
			    if($status == 'active')
				{
					?>
					<span class="label label-success" style="opacity: 1;"> <?php echo $status; ?></span>
					<?php
				}
				else
				{
					?>
					<span class="label label-danger" style="opacity: 1;"> <?php echo $status; ?></span>
					<?php
				}
			   ?> </td>
			   <td><?php echo $row->order;?></td>
              <td class=""><div class="btn-group">
                <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick="hiddenFunction()"> <i class="icon-wrench"></i> Setting </button>
                <button  onclick="hiddenFunction()"  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                <ul class="dropdown-menu" role="menu">
                  <li> <a href="<?php echo site_url('menu_management/menuedit'); ?>/<?php echo $row->MENU_ID;?> "> <i class="icon-pencil"></i> Edit </a> </li>
                   
                  <li> <a href="#static<?php echo $row->MENU_ID;?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>
                  
                </ul>
              </div></td>
          </tr>
          
          <!----------------------- start allert box ----------------------------> 
<div id="static<?php echo $row->MENU_ID;?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
  <div class="modal-body">
    <p> Are You sure, that you want to delete selected record? </p>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
    <a type="button"  class="btn btn-primary" href="<?php echo site_url('menu_management/menu_delete'); ?>/<?php echo $row->MENU_ID;?>"> Continue </a>
  </div>
</div>
<!----------------------- end allert box ----------------------------> 


          
          
          
          <?php $sn_count++;
            }
            ?>
          </tbody>
        
      </table>
    </div>
  </div>
  </div>
  </div>
  <!-- end: DYNAMIC TABLE PANEL --> 



<!-- end: PAGE HEADER -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/form-validation/account_year_registration.js"></script> 
        
                
       <script>
	
   jQuery(document).ready(function() {
	Main.init();
	FormValidator.init();
	FormElements.init();
	
});
		

		</script> 