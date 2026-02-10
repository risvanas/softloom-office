
<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
       <thead>
          <tr>
            <th class="">No</th>
          	<th class="">Acc Code</th>
            <th class="">Acc Name</th>
            <th class="">Credit</th>
            <th class="">DEBIT</th>
          </tr>
        </thead>
                    <?php $n=1;
foreach($cond->result() as $row)
{	

     //$ACC_ID = $row->ACC_ID;
    $ACC_CODE = $row->ACC_CODE;
	$ACC_NAME = $row->ACC_NAME;
	$CREDIT=$row->mycreditsum;
	$DEBIT=$row->mydebitsum;
?>
<tr >
     <td><?php echo $n; ?> </td>
     <td><?php echo $ACC_CODE; ?> </td>
	 <td><?php echo $ACC_NAME; ?> </td>
     <td><?php echo $CREDIT; ?> </td>
     
     <td><?php echo $DEBIT; ?> </td>
        
    
</tr>										
<?Php

}

?>



<?php $n=2;
foreach($cond1->result() as $row)
{	

     //$ACC_ID = $row->ACC_ID;
    $ACC_CODE = $row->ACC_CODE;
	$ACC_NAME = $row->ACC_NAME;
	$CREDIT=$row->mycreditsum;
	$DEBIT=$row->mydebitsum;
?>
<tr >
     <td><?php echo $n; ?> </td>
     <td><?php echo $ACC_CODE; ?> </td>
	 <td><?php echo $ACC_NAME; ?> </td>
     <td><?php echo $CREDIT; ?> </td>
     
     <td><?php echo $DEBIT; ?> </td>
        
    
</tr>										
<?Php

}

?>




<?php $n=3;
foreach($cond2->result() as $row)
{	

     //$ACC_ID = $row->ACC_ID;
    $ACC_CODE = $row->ACC_CODE;
	$ACC_NAME = $row->ACC_NAME;
	$CREDIT=$row->mycreditsum;
	$DEBIT=$row->mydebitsum;
?>
<tr >
     <td><?php echo $n; ?> </td>
     <td><?php echo $ACC_CODE; ?> </td>
	 <td><?php echo $ACC_NAME; ?> </td>
     <td><?php echo $CREDIT; ?> </td>
     
     <td><?php echo $DEBIT; ?> </td>
        
    
</tr>										
<?Php

}

?>



<?php $n=4;
foreach($cond3->result() as $row)
{	

     //$ACC_ID = $row->ACC_ID;
    $ACC_CODE = $row->ACC_CODE;
	$ACC_NAME = $row->ACC_NAME;
	$CREDIT=$row->mycreditsum;
	$DEBIT=$row->mydebitsum;
?>
<tr >
     <td><?php echo $n; ?> </td>
     <td><?php echo $ACC_CODE; ?> </td>
	 <td><?php echo $ACC_NAME; ?> </td>
     <td><?php echo $CREDIT; ?> </td>
     
     <td><?php echo $DEBIT; ?> </td>
        
    
</tr>										
<?Php

}

?>



</table>

<script>
	
jQuery(document).ready(function() {
	Main.init();
	FormElements.init();
	
});
		</script>