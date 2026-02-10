
<?php
$id = $_POST['name'];
$e_date = date('d-m-Y', strtotime($id . ' + 365 days'));
?> 
<input autocomplete="off" type="text" name="txt_renewal_date" value="<?php echo date('d-m-Y', strtotime($id . ' + 365 days')); ?>"  />


<?php
/*
  $current_date=date("d-m-Y");

  if($current_date<$e_date)
  {
  ?>
  <script>
  //alert('expired');
  </script>
  <?php
  }
  else
  {
  ?>
  <script>
  alert('ok');
  </script>
  <?php
  }
 */
?>
  





