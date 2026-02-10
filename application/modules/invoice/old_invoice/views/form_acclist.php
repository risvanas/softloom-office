<table class="table table-condensed table-hover" id="sample_1">
  <thead>
    <tr>
      <th class="">Acc Code</th>
      <th class="">Acc Name</th>
      <th class=""></th>
    </tr>
  </thead>
  <?php 
  $c=intval($_POST['name']);
  foreach($cond->result() as $row)
  {
	  $account_herd = $row->account_herd;
	  $Description = $row->Description;
	  $account_id = $row->account_id; ?>
    <tr onclick="addaccount('<?php echo $account_herd;?>','<?php echo $Description;?>','<?php echo $account_id;?>')" data-dismiss="modal">
        <td><?php echo $account_herd; ?></td>
        <td><?php echo $Description; ?></td>
        <td><button class="btn btn-xs btn-green" ><i class="icon-plus"></i>&nbsp;Add</button></td>
  </tr>
  <?Php } ?>
</table>
