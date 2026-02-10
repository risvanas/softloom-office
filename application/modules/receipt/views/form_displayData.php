 
<script>
    while (tblstr.rows.length > 1) {
        tblstr.deleteRow(1);
    }
    document.getElementById('Num').value = 2;
</script>
<?php
$sn_count = 1;
$sess_array = $this->session->userdata('logged_in');
$company = $sess_array['comp_code'];
$year_code = $sess_array['accounting_year'];
if ($vno->num_rows() == 0) {
    ?>
    <script>
        document.getElementById("voc_num").style.display = "block";
        document.getElementById("btn_refresh").style.display = "none";
        <?php
        
        $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='CR' and COMPANY='$company' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1");
        $row = $query->row_array();
        $book_num = $row['BOOK_NUMBER'];
        ?>
        document.getElementById("conn").value =<?php echo $book_num; ?>;
    </script> 
    <?php
} else {
    ?>
    <script>
        document.getElementById("voc_num").style.display = "none";
        document.getElementById("btn_refresh").style.display = "block";
    </script>
    <?php
    foreach ($vno->result() as $row) {
        ?>
        <script>
            document.getElementById("txt_receipt_date").value = '<?php
            $receipt_date = $row->DATE_OF_TRANSACTION;
            $receipt_date = strtotime($receipt_date);
            echo $receipt_date = date("d-m-Y", $receipt_date);
            ?>';
            document.getElementById("txt_ref_voucher_no").value = '<?php echo $row->REF_VOUCHERNO; ?>';
            document.getElementById("temp_voc_num").value = '<?php echo $row->BOOK_NUMBER; ?>';
            //alert('<?php //echo $row->BOOK_NUMBER;         ?>');
            this.editaccount('<?php echo $row->ACC_CODE; ?>', '<?php echo $row->ACC_NAME; ?>', '<?php echo $row->SUB_ACC; ?>', '<?php echo $row->ACC_TYPE; ?>', '<?php echo $row->ACC_ID; ?>', '<?php echo $row->CREDIT; ?>', '<?php echo $row->DESCRIPTION; ?>');

            document.getElementById("bttdelete").style.display = "block";
            document.getElementById("print_btn").style.display = "block";
            document.getElementById("hrefdelete").href = '<?php echo site_url('receipt/delete_data') . "/" . $row->BOOK_NUMBER. "/" .$year_code; ?>';
        </script>


        <?php
        $sn_count++;
    }
}
?>
        