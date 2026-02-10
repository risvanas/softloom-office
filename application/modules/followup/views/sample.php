<table  width="200" class="table table-striped table-bordered table-hover table-full-width" id="sample_1" bordercolor="#333399" bgcolor="#996666">
      <thead>
      
        <tr>
            <th width="60">FID</th>
            <th  width="60">ENID</th>
            <th  width="60">Status</th>   
            <th  width="60">Followup Date</th>
            <th  width="60">Next Followup Date</th> 
            <th  width="60">Description</th>
            <th  width="60">Entry Date</th>
            <th width="148" style="width:150px;">&nbsp;</th>
        </tr>
        </thead>
        <tbody> 
       <?php
			foreach($s->result() as $row)
			{
			$fd=$row->FDATE;
			$fdt=strtotime($fd);
			$fdate=date('d-m-Y',$fdt);
			
			$nxd= $row->NEXTFDATE;
			$nxdte=strtotime($nxd);
			$nfdate=date('d-m-Y',$nxdte);
			
			$en=$row->ENTRY_DATE;
			$endte=strtotime($en);
			$endate=date('d-m-Y',$endte);
            ?>
          <tr>
            <td ><?php echo $id= $row->FID;?></td>
            <td ><?php echo $id= $row->EN_ID;?></td>
            <td class=""><?php echo $row->STATUS; ?></td>
            <td class=""><?php echo $fdate; ?></td>
            <td class=""><?php echo $nfdate;?></td>
            <td class=""><?php echo $row->DESCRIPTION;?></td>
            <td width="100"class=""><?php echo $endate;?></td>
            <td class=""><div class="btn-group">
                <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick="hiddenFunction()"> <i class="icon-wrench"></i> Setting </button>
                <button  onclick="hiddenFunction()"  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                <ul class="dropdown-menu" role="menu">
                <li> <a href="<?php echo site_url('followup/find_followup_details'); ?>/<?php echo $row->FID;?> " onclick="loadDat()"> <i class="icon-pencil"></i>VIEW & EDIT </a> </li>  
                <li> <a href="#static<?php echo $row->FID;?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li> 
                </ul>
              </div></td>
          </tr>
<!----------------------- start allert box ----------------------------> 
<div id="static<?php echo $row->FID;?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
  <div class="modal-body">
    <p> Are You sure, that you want to delete selected record? </p>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
    <a type="button"  class="btn btn-primary" href="<?php echo site_url('followup/delete_followup_details'); ?>/<?php echo $row->FID; ?>"> Continue </a>
  </div>
</div>
<!----------------------- end allert box ----------------------------> 
          <?php $s++;
            }
            ?>
            <div id="output">
            </div>
          </tbody>
      </table>
      <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
      <script src="<?php echo base_url(); ?>assets/js/form-validation/enquiry.js"></script>          
<script>	
jQuery(document).ready(function() {
	Main.init();
	FormValidator.init();
	TableData.init();
	UIModals.init();
	FormElements.init();
	
});
</script> 