<?php
$sn_count = 1;
if ($vno->num_rows() == 0) {
    ?>
    <script>
        document.getElementById("voc_num").style.display = "block";
        document.getElementById("btn_refresh").style.display = "none";
        <?php
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $company_code = $sess_array['comp_code'];
        $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PAYD' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1 and COMPANY='$company_code'");
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
        $chq_date = $row->CHEQUE_DATE;
        $chq_date = strtotime($chq_date);
        $chq_date = date("d-m-Y", $chq_date);
        $acc_year = $row->ACC_YEAR_CODE;
        ?>
        <script>
            document.getElementById("temp_voc_num").value = '<?php echo $num = $row->PAY_NUMBER; ?>';
            document.getElementById("txt_cust_name").value = '<?php echo $row->STUDENT_ID; ?>';
            document.getElementById("txt_payment_date").value = '<?php
            $pay_date = $row->PAYMENT_DATE;
            $pay_date = strtotime($pay_date);
            echo $pay_date = date("d-m-Y", $pay_date);
            ?>';
            document.getElementById("txt_due_date").value = '<?php
            $due_date = $row->DUE_DATE;
            $due_date = strtotime($due_date);
            echo $due_date = date("d-m-Y", $due_date);
            ?>';

            document.getElementById("txt_amount").value = '<?php echo $row->AMOUNT; ?>';
            document.getElementById("txt_remark").value = '<?php echo $row->REMARKS; ?>';
            document.getElementById("txt_trans_type").value = '<?php echo $row->TRANSACTION_TYPE; ?>';
            //alert('<?php //echo $row->TRANSACTION_TYPE; ?>');

            show_bank_details_edit('<?php echo $row->TRANSACTION_TYPE; ?>', '<?php echo $row->CHEQUE_NUMBER; ?>', '<?php echo $chq_date ?>', '<?php echo $row->ACCOUNT_NUMBER; ?>', '<?php echo $row->BANK; ?>', '<?php echo $row->TDS_APPLICABLE; ?>', '<?php echo $row->TDS_AMOUNT; ?>');


            document.getElementById("bttdelete").style.visibility = "visible";
            document.getElementById("print_btn").style.display = "block";
            document.getElementById("hrefdelete").href = '<?php echo site_url('customer_payment/fee_delete') . $row->PAY_NUMBER . "/$acc_year"; ?>';
            load_cust_details();
        </script>


        <?php
        $sn_count++;
    }
    ?>
    <script>
        document.getElementById("bttdelete").style.display = "block";
    </script> 
    <div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
        <div class="modal-body">
            <p> Are You sure, that you want to delete selected record? </p>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
            <a type="button"  class="btn btn-primary" href="<?php echo site_url('customer_payment/cust_payment_delete') . "$num/$acc_year" ; ?>"> Continue </a> </div>
    </div>
    <?php
}
?>
	
