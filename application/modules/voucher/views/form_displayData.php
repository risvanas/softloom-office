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
$accounting_year = $sess_array['accounting_year'];
if ($vno->num_rows() == 0) {
    ?>
    <script>
        document.getElementById("voc_num").style.display = "block";
        document.getElementById("btn_refresh").style.display = "none";
        <?php
        $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PV' and COMPANY='$company' and ACC_YEAR_CODE=$accounting_year");
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
            document.getElementById("txt_voucher_date").value = '<?php
            $voucher_date = $row->DATE_OF_TRANSACTION;
            $voucher_date = strtotime($voucher_date);
            echo $voucher_date = date("d-m-Y", $voucher_date);
            ?>';
            document.getElementById("txt_ref_voucher_no").value = '<?php echo $row->REF_VOUCHERNO; ?>';
            document.getElementById("temp_voc_num").value = '<?php echo $row->BOOK_NUMBER; ?>';
            document.getElementById("txt_cash_to").value = '<?php echo $row->CASH_TO; ?>';
            document.getElementById("txt_received_by").value = '<?php echo $row->CASH_RECEIVED_BY; ?>';
            this.editaccount('<?php echo $row->ACC_CODE; ?>', '<?php echo $row->ACC_NAME; ?>', '<?php echo $row->SUB_ACC; ?>', '<?php echo $row->ACC_TYPE; ?>', '<?php echo $row->ACC_ID; ?>', '<?php echo $row->DEBIT; ?>', '<?php echo $row->DESCRIPTION; ?>');
            document.getElementById("bttdelete").style.visibility = "visible";
            document.getElementById("print_btn").style.display = "block";
            document.getElementById("hrefdelete").href = '<?php echo site_url('voucher/delete_data') . $row->BOOK_NUMBER . "/" . $row->ACC_YEAR_CODE; ?>';

            document.getElementById("bttdelete").style.display = "block";
            document.getElementById("hrefdelete").href = '<?php echo site_url('voucher/delete_data') . $row->BOOK_NUMBER . "/" . $row->ACC_YEAR_CODE; ?>';
        </script>
        <?php
        $sn_count++;
    }
}
?>
        