<img id='logo_image' src='http://office.softloom.com/assets/images/logo.jpg' alt='Softloom ITSolution' style='display:none;'>  
<div class="panel-body">

    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1" style="width: 100%;">
        <thead>
        <th>VOUCHER NO</th>
        <th colspan="2">PARTICULARS</th>
        <th>RECEIPTS</th>
        <th>PAYMENTS</th>
        </thead>          
        <?php
        if ($list->num_rows() == 0) {
            ?>
            <thead>
                <tr>
                    <th colspan="3"><b></b><span style="float:right">Opening Balance :</span></th>

                    <th style="text-align:right"><b><?php
                            $temp_opening_balance = $opening_balance;
                            if ($opening_balance > 0) {
                                echo $opening_balance . " Db. ";
                            }
                            if ($opening_balance < 0) {
                                echo abs($opening_balance) . " Cr. ";
                            }
                            if ($opening_balance == 0) {
                                echo $opening_balance;
                            }
                            ?></b></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6"></td>
                </tr>
            <thead>
                <tr>
                    <td colspan="3"><b><span style="float:right">Closing Balance : </span></b></td> 
                    <td></td>
                    <td align="right"><b><?php
                            if ($opening_balance > 0) {
                                echo $opening_balance . " Db. ";
                            }
                            if ($opening_balance < 0) {
                                echo abs($opening_balance) . " Cr. ";
                            }
                            if ($opening_balance == 0) {
                                echo $opening_balance;
                            }
                            ?></b></td>
                </tr>
            </thead> 
            <tr><td colspan="5"></td></tr>
            <?php
        } else {
//start 
//echo  $opening_balance;
            foreach ($list->result() as $row) {
                $totreceipt = 0.0;
                $totpayment = 0.0;
                $debitsum = 0.0;
                $sum_receipt = 0;
                $date = $row->DATE_OF_TRANSACTION;
                $fr_date = strtotime($date);
                $fr_date = date("d-m-Y", $fr_date);
                ?> 

                <thead><th colspan="3"><b><?php echo "DATE : " . $fr_date; ?></b><span style="float:right">Opening Balance :</span></th>

                <th style="text-align:right"><b><?php
                        $temp_opening_balance = $opening_balance;
                        if ($opening_balance > 0) {
                            echo $opening_balance . " Db. ";
                        }
                        if ($opening_balance < 0) {
                            echo abs($opening_balance) . " Cr. ";
                        }
                        if ($opening_balance == 0) {
                            echo $opening_balance;
                        }
                        ?></b></th>
                <th></th></thead>
                <tbody>
                    <?php
                    $sql = "Select
                        tbl_transaction.BOOK_NAME,
                        tbl_transaction.BOOK_NUMBER,
                        tbl_transaction.ACC_ID,
                        tbl_account.ACC_NAME,
                        tbl_account.ACC_CODE,
                        tbl_transaction.SUB_ACC,
                        tbl_account1.ACC_NAME As SUB_ACC_NAME,
                        tbl_transaction.CREDIT,
                        tbl_transaction.DEBIT,
                        tbl_transaction.FIN_YEAR_ID,
                        tbl_transaction.REMARKS,
                        tbl_transaction.TRANS_TYPE,
                        tbl_transaction.DEL_FLAG,
                        tbl_transaction.SRC_ID,
                        tbl_transaction.REF_VOUCHERNO,
                        tbl_transaction.PAYMENT_ID,
                        tbl_transaction.ACC_YEAR_CODE,
                        tbl_transaction.DATE_OF_TRANSACTION
                      From
                        tbl_transaction Left Join
                        tbl_account On tbl_transaction.ACC_ID =
                          tbl_account.ACC_ID Left Join
                        tbl_account tbl_account1
                          On tbl_transaction.SUB_ACC = tbl_account1.ACC_ID
                      Where
                        tbl_transaction.DEL_FLAG = '1' And
                        tbl_transaction.ACC_ID != 39 And
                          tbl_transaction.DATE_OF_TRANSACTION = '$date'";
                    if ($company_code != "") {
                        $sql .= " and COMPANY=$company_code";
                    }
                    $sql .= " Order By
  tbl_transaction.DATE_OF_TRANSACTION";
                    $query = $this->db->query($sql);

                    foreach ($query->result() as $rs) {
                        $voucher_no = $rs->BOOK_NAME . $rs->BOOK_NUMBER;
                        ?>

                        <tr>
                            <td><a href="<?php echo site_url('ledger/view_details') . $rs->BOOK_NUMBER . "/" . $rs->BOOK_NAME . "/" . $rs->ACC_YEAR_CODE; ?> " target="_blank"><?php echo $voucher_no; ?></a></td>

                            <td colspan="2"><b><?php echo $rs->ACC_NAME . " - " . $rs->SUB_ACC_NAME . "<br></b>" . $rs->REMARKS; ?></td>
                            <td align="right"><?php echo $receipt = $rs->CREDIT; ?></td>
                            <td align="right"><?php echo $payment = $rs->DEBIT; ?></td>
                        </tr>
                        <?php
                        $sum_receipt+=$rs->CREDIT;
                        $totreceipt+=$receipt;
                        $totpayment+=$payment;

                        $opening_balance+=$receipt - $payment;
                    }
                    ?> 
                <thead>
                    <tr>
                    <tr><td colspan="3"><b><span style="float:right">Closing Balance : </span></b></td> 
                        <td></td>
                        <td align="right">
                            <b><?php
                                if ($opening_balance > 0) {
                                    echo $opening_balance . " Db. ";
                                }
                                if ($opening_balance < 0) {
                                    echo abs($opening_balance) . " Cr. ";
                                }
                                if ($opening_balance == 0) {
                                    echo $opening_balance;
                                }
                                ?>
                            </b>
                        </td>
                    </tr>
                    <?php
                    $debitsum+=$totpayment + $opening_balance;
                    ?>
                    <tr> <td colspan="3"></td> 
                        <td align="right"><b><?php
                                echo $sum_receipt + $temp_opening_balance;
                                $temp_opening_balance = 0;
                                ?></b></td>  
                        <td align="right"><b><?php echo $debitsum; ?> </b></td></tr>



                </thead> 
                <tr><td colspan="5"></td></tr>
                <?php
            }
        }
        ?>

        </tbody>
    </table> 
</div>
<script> lode_image_false();</script>





