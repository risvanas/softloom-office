<table class="table table-condensed table-hover" id="sample_1">
  <thead>
    <tr>
      <th>Acc Code</th>
      <th>Acc Name</th>
      <th>Acc Type</th>
      <th></th>
    </tr>
  </thead>
  <?php 
  $c=intval($_POST['name']);
  foreach($cond->result() as $row)
  {
	  $ACC_CODE = $row->ACC_CODE;
	  $ACC_NAME = $row->ACC_NAME;
	  $ACC_TYPE = $row->ACC_TYPE;
	  $ACC_ID = $row->ACC_ID; ?>
    <tr onclick="addaccount('<?php echo $ACC_CODE;?>','<?php echo $ACC_NAME;?>','<?php echo $ACC_TYPE;?>','<?php echo $ACC_ID;?>')" data-dismiss="modal">
    <td><?php echo $ACC_CODE;?></td>
    <td><?php echo $ACC_NAME;?></td>
    <td><?php echo $ACC_TYPE;?></td>
    
    <td><button class="btn btn-xs btn-green" ><i class="icon-plus"></i>&nbsp;Add</button></td>
  </tr>
  <?Php } ?>
</table>
