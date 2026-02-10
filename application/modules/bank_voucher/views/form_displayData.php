<script>
    while (tblstr.rows.length > 1) {
        tblstr.deleteRow(1);
    }
    document.getElementById('Num').value = 2;
</script>
<!--<script>
alert('<?php //echo $vno->num_rows;            ?>');
</script>-->

<?php
$sn_count = 1;
$sess_array = $this->session->userdata('logged_in');
$company = $sess_array['comp_code'];
$accounting_year = $sess_array['accounting_year'];
// echo $vno->num_rows();
if ($vno->num_rows() == 0) {
    ?>
    <script>
        document.getElementById("voc_num").style.display = "block";
        document.getElementById("btn_refresh").style.display = "none";
        <?php
        $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='BV' and COMPANY='$company' and ACC_YEAR_CODE=$accounting_year");
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
        $book_number = $row->BOOK_NUMBER;
        $transaction_type = $row->TRANS_TYPE;
        if ($transaction_type == "Withdrawal") {
            $query = $this->db->query("SELECT ACC_ID AS acc_id FROM tbl_transaction WHERE BOOK_NAME='BV' AND BOOK_NUMBER='$book_number' and COMPANY='$company' and ACC_YEAR_CODE=$accounting_year AND DEL_FLAG=1 AND CREDIT IS NOT NULL");
            $res = $query->row_array();
            $bank_id = $res['acc_id'];
        }
        if ($transaction_type == "Deposit") {
            $query = $this->db->query("SELECT ACC_ID AS acc_id FROM tbl_transaction WHERE BOOK_NAME='BV' AND BOOK_NUMBER='$book_number' and COMPANY='$company' and ACC_YEAR_CODE=$accounting_year AND DEL_FLAG=1 AND DEBIT IS NOT NULL");
            $res = $query->row_array();
            $bank_id = $res['acc_id'];
        }
        ?>

        <script>
            document.getElementById("sel_acc_type").value = '<?php echo $bank_id; ?>';
            document.getElementById("txt_receipt_date").value = '<?php
            $receipt_date = $row->DATE_OF_TRANSACTION;
            $receipt_date = strtotime($receipt_date);
            echo $receipt_date = date("d-m-Y", $receipt_date);
            ?>';
            document.getElementById("txt_ref_voucher_no").value = '<?php echo $row->REF_VOUCHERNO; ?>';
            document.getElementById("temp_voc_num").value = '<?php echo $row->BOOK_NUMBER; ?>';
            document.getElementById("txt_trans_type").value = '<?php echo $row->TRANS_TYPE; ?>';
            document.getElementById("txt_cash_to").value = '<?php echo $row->CASH_TO; ?>';
            var trans_type = '<?php echo $row->TRANS_TYPE; ?>';
            //alert(trans_type);
            if (trans_type == "Withdrawal")
            {
                this.editaccount('<?php echo $row->ACC_CODE; ?>', '<?php echo $row->ACC_NAME; ?>', '<?php echo $row->SUB_ACC; ?>', '<?php echo $row->ACC_TYPE; ?>', '<?php echo $row->ACC_ID; ?>', '<?php echo $row->DEBIT; ?>', '<?php echo $row->DESCRIPTION; ?>');
            }
            if (trans_type == "Deposit")
            {
                this.editaccount('<?php echo $row->ACC_CODE; ?>', '<?php echo $row->ACC_NAME; ?>', '<?php echo $row->SUB_ACC; ?>', '<?php echo $row->ACC_TYPE; ?>', '<?php echo $row->ACC_ID; ?>', '<?php echo $row->CREDIT; ?>', '<?php echo $row->DESCRIPTION; ?>');
            }
            document.getElementById("bttdelete").style.display = "block";
            document.getElementById("print_btn").style.display = "block";
            document.getElementById("hrefdelete").href = '<?php echo site_url('bank_voucher/delete_data') . $row->BOOK_NUMBER . "/" . $row->ACC_YEAR_CODE; ?>';
        </script>

        <?php
        $sn_count++;
    }
}
?>
        