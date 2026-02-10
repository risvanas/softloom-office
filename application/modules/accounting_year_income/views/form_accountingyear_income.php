<div class="row" style="padding-top:20px;" >
<div class="col-md-12"> 
  <!-- start: DYNAMIC TABLE PANEL -->
  <div class="panel panel-default" style="min-height:555px;">
    <div class="panel-heading"> <i class="icon-external-link-sign"></i>Accounting Year Income
      <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
    </div>
    
    <!-- end: PAGE TITLE & BREADCRUMB -->
    
    <div class="col-md-12">
      <div class="page-header">
        <div class="row">
          <div class="col-md-9">
            <h1>Business Growth <small></small></h1>
          </div>
        </div>
        
        <div>
<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
<thead>
    <tr>
			<th>sl no</th>
			<th>Accounting Year Code</th>
    		<th>Income</th>
            <th>Growth</th>
    	
    </tr>
    </thead>
    <tbody>
<?php
$count=1;
$past=0;
foreach($year_data->result() as $row)
{
	$present=$row->income;
	if($past != 0)
	{
	$growth=(($present-$past)/$past)*100;
	}
	else
	{
		$growth=0;
	}
	?>
<tr>
<td><?php echo $count; ?></td>

		<td><?php echo $row->code; ?></td>
		<td><?php echo $row->income; ?></td>
        <td><?php echo round($growth,2); ?></td>
</tr>
<?php
$past=$present;
$count++;
}
?>

</tbody>
</table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	
		jQuery(document).ready(function() {
		Main.init();
		FormElements.init();
		
	    });
		
		
		
</script> 