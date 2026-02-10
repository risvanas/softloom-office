<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            table, td {
                border:thin solid black
            }
            table {
                border-collapse:collapse
            }
        </style>
    </head>
    <body> 
        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
            <tr>
                <td colspan="3"><img id='logo_image' src='https://softloom.com/wp-content/uploads/2017/06/logo.png' alt='Softloom ITSolution'></td>
                <td colspan="2">
                    <p>
                        Softloom it solutions,<br>
                        Ist Floor, HA Tower,<br>
                        Providence Road,<br>
                        Kacheripady, Kochi, Ernakulam,<br>
                        Kerala 682018 <br>
                    </p>
                </td>
            </tr>
            <!--<div class="panel-body">-->
            <tr><td colspan="5" style="text-align: center;font-weight: 700">Day book</td></tr>
            <tr><td colspan="5" style="text-align: center;">From: <?php echo $frm ?>&nbsp;&nbsp;To: <?php echo $to ?></td></tr>
            <thead>
                <th>VOUCHER NO</th>
                <th colspan="2">PARTICULARS</th>
                <th>RECEIPTS</th>
                <th>PAYMENTS</th>
            </thead>      
            <tbody>
                <?php
                if ($list->num_rows() == 0) {
                    ?>
                    <tr>	
                        <td colspan="3" style="text-align: right"><b></b>Opening Balance :</td>

                        <td style="text-align:right"><b><?php
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
                                ?></b>
                        </td>
                        <td></td>
                    </tr>
                    <tr><td colspan="3" style="text-align: right"><b>Closing Balance :</b></td> 
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
                                ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
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
                        <tr>
                            <td style="border-right: 0;"><b><?php echo "DATE : " . $fr_date; ?></b></td>
                            <td colspan="2" style="text-align: right;border-left: 0"><b>Opening Balance :</b></td>
                            <td style="text-align:right"><b><?php
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
                                    ?></b>
                            </td>
                            <td></td>
                        </tr>
                        <?php
                        $query = $this->db->query("Select
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
                                  tbl_transaction.DATE_OF_TRANSACTION = '$date'
                              Order By
                                tbl_transaction.DATE_OF_TRANSACTION");

                        foreach ($query->result() as $rs) {
                            $voucher_no = $rs->BOOK_NAME . $rs->BOOK_NUMBER;
                            ?>
                            <tr>
                                <td><?php echo $voucher_no; ?></td>
                                <td colspan="2"><b><?php echo $rs->ACC_NAME . " - " . $rs->SUB_ACC_NAME . "<br></b>" . $rs->REMARKS; ?></td>
                                <td align="right"><?php echo $receipt = $rs->CREDIT; ?></td>
                                <td align="right"><?php echo $payment = $rs->DEBIT; ?></td>
                            </tr>
                            <?php
                            $sum_receipt += $rs->CREDIT;
                            $totreceipt += $receipt;
                            $totpayment += $payment;

                            $opening_balance += $receipt - $payment;
                        }
                        ?> 
                        <tr>
                        <tr><td colspan="3" style="text-align: right"><b>Closing Balance :</b></td> 
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
                                    ?></b>
                            </td>
                        </tr>
                        <?php
                        $debitsum += $totpayment + $opening_balance;
                        ?>
                        <tr> <td colspan="3"></td> 
                            <td align="right"><b><?php echo $sum_receipt + $temp_opening_balance;
                        $temp_opening_balance = 0;
                        ?></b></td>  
                            <td align="right"><b><?php echo $debitsum; ?> </b></td></tr>
                        <tr><td colspan="5"></td></tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table> 
    </body>
</html>



