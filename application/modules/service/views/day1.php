
<?php
$id = $_POST['name'];
?> 
<input autocomplete="off" type="text" name="txt_renewal_date" value="<?php echo date('d-m-Y', strtotime($id . ' + 365 days')); ?>" />
