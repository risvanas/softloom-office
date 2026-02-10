<html>
    <head>
        <style>
            body{
                font-size: 10px;
            }
            @page {
                margin: 150px 50px 75px 80px;
            }
            #header {
                position: fixed;
                left: 0px;
                top: -150px;
                right: 0px; 
                height: 70px; 
                text-align: center;
            }
            #footer {
                position: fixed; 
                left: 0px;
                bottom: -75px;
                right: 0px;
                height: 40px;
            }
            #footer .pattern td {
                height: 20px;
                width: 10%;
            }
            table.table{
                width: 100%;
                border-collapse: collapse;
            }
            .page{
                text-align: right;
                padding-bottom: 10px;
            }
            .address{
                width: auto;
            }
            #footer .page:after {
                content: counter(page);
            }
            #content table{
                border-collapse: collapse;
            }
            #content table tr th,#content table tr td{
                border: 1px solid #ddd;
                padding: 5px;
            }
            hr {
                border: 0px;
                border-top: 1px solid #ccc;
            }
            #content h1 {
                text-align: center;
                margin-top: 0;
            }
            #content #sample_1{
                /*margin-top: 10px;*/
            }
            table#from_to{
                margin: auto;
                margin-bottom: 10px;
            }
            h2.name {
                font-size: 13px; 
                /*                font-weight: normal;*/
                margin: 0;
                text-transform: uppercase;
            }
            #content table#from_to tr td {
                border: none !important;
            }
        </style>
    </head>
    <body>
        <div id="header">
            <table class="table">
                <tr>
                    <?php $company_details = $company->row(); 
                    $type = pathinfo(base_url() . $company_details->LOGO, PATHINFO_EXTENSION);
                    $data = file_get_contents(base_url() . $company_details->LOGO);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    ?>
                    
                    <td class="bottom"><img id='logo_image' src='<?php echo $base64 ?>' alt='<?php echo $company_details->COMP_NAME ?>'></td>
                    <td class="address">
                        <p>
                        <h2 class="name" style="padding-top: 25px;"><?php echo $company_details->COMP_NAME ?></h2>
                        <?php
                        echo "<p style='margin: 0;'>" . $company_details->ADDRESS1 . ",<br>" .
                        $company_details->ADDRESS2 . ",<br>" .
                        $company_details->ADDRESS3 . "-" . $company_details->PIN_CODE . ", " . $company_details->STATE . "<br>" .
                        $company_details->PHONE_NO . ", " . $company_details->MOBILE_NO1 . "<br>" .
                        $company_details->EMAIL . ", " . $company_details->EMAIL1 . "</p>";
                        echo ($company_details->GSTNO) ? "<p style='margin: 0;'>GSTIN: " . $company_details->GSTNO . "</p>" : "";
                        ?>
                        </p>
                    </td>
                </tr>
            </table>
            <hr>
        </div>
        <div id="footer">
            <table class="table">
                <tr>
                    <td colspan="5" class="bottom">Day book</td>
                    <td colspan="5" class="page">Page </td>
                </tr>
                <tr class="pattern">
                    <td></td>
                    <td style="background-color: #00aeef;"></td>
                    <td style="background-color: #00aeef;"></td>
                    <td style="background-color: #00aeef;"></td>
                    <td></td>
                    <td style="background-color: #b3d335"></td>
                    <td style="background-color: #b3d335"></td>
                    <td></td>
                    <td style="background-color: #00aeef"></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div id="content">
            <h1>Daybook</h1>
            <table id="from_to">
                <tr>
                    <td>From: <?php echo $frm ?></td>
                    <td>To: <?php echo $to ?></td>
                </tr>
            </table>
            <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1" style="width: 100%;">
                <thead>
                    <tr>
                        <th>VOUCHER NO</th>
                        <th colspan="2">PARTICULARS</th>
                        <th>RECEIPTS</th>
                        <th>PAYMENTS</th>
                    </tr>
                </thead>  
                <tbody>
                    <?php if ($list->num_rows() == 0) { ?>
                        <tr>
                            <td colspan="3" style="text-align: right"><b></b>Opening Balance :</td>
                            <td style="text-align:right">
                                <b><?php
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
                        <tr>
                            <td colspan="3" style="text-align: right"><b>Closing Balance : </b></td> 
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
                                <td style="text-align:right">
                                    <b><?php
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
                                <td colspan="3" style="text-align: right"><b>Closing Balance :</b></td> 
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
                            <tr> 
                                <td colspan="3"></td> 
                                <td align="right">
                                    <b><?php
                                        echo $sum_receipt + $temp_opening_balance;
                                        $temp_opening_balance = 0;
                                        ?></b>
                                </td>  
                                <td align="right"><b><?php echo $debitsum; ?> </b></td>
                            </tr>
                            </thead> 
                            <tr><td colspan="5"></td></tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table> 
        </div>
    </body>
</html>