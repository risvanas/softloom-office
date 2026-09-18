<?php
$ci =& get_instance();
$ci->load->database();
?>
<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
       <thead>
          <tr>
            <th class="">No</th>
          	<th class="">Student Name</th>
            <th class="">Contact Number</th>
            <th class="">Course Fee</th>
            <th class="">Paid Amount</th>
            <th class="">Balance Amount</th>
          </tr>
        </thead>
                    <?php $n=1;
foreach($cond->result() as $row)
{	
     $id=$row->STUDENT_ID;
	$STUD_NAME = $row->NAME;
	$CONTACT_NUMBER = $row->CONTACT_NO;
	$COURSE_FEE=$row->FEE_AMOUNT;
	
	$sel = "SELECT SUM(AMOUNT) AS amt FROM tbl_payment WHERE STUDENT_ID = ?";
	$q = $ci->db->query($sel, array($id));
	$res = $q->row_array();
	$PAID_AMOUNT = $res ? (float) $res['amt'] : 0;
	$bl_amt=$COURSE_FEE-$PAID_AMOUNT;
?>
     <tr>
     <td><?php echo $n; ?> </td>
     
	<td><?php echo $STUD_NAME; ?> </td>
	<td><?php echo $CONTACT_NUMBER; ?> </td>
	<td><?php echo $COURSE_FEE; ?> </td>
	<td><?php  echo $PAID_AMOUNT; ?> </td>
    <td> <?php echo $bl_amt; ?>
</tr>										
<?Php
$n++;
}
?>
</table>
<script>
	
jQuery(document).ready(function() {
	Main.init();
	FormElements.init();
	
});
		</script>