<html>
    <head>
        <style>
            body{
                font-size: 10px;
            }
            @page {
                margin: 160px 50px 75px 80px;
            }
            #header {
                position: fixed;
                left: 0px;
                top: -150px;
                right: 0px; 
                height: 100px; 
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
            table#from_to{
                margin: auto;
                margin-bottom: 10px;
                margin-top: 5px;
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
        <?php
        $query = $this->db->query("select ACC_NAME from tbl_account where ACC_ID=$acc");
        $val = $query->row_array();
        $ac_name = $val['ACC_NAME'];
        $sub_name = '';
        if ($sub != '') {
            $query1 = $this->db->query("select ACC_NAME from tbl_account where ACC_ID=$sub");
            $val1 = $query1->row_array();
            $sub_name = $val1['ACC_NAME'];
        }
        $heading = ($ac_name != "") ? " - "  . $ac_name  : "";
        $heading .= ($sub_name != "") ? " - "  . $sub_name  : "" ;
        ?>
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
                    <td colspan="5" class="bottom">Ledger <?php echo $heading ?></td>
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
<!--            <p class="bottom">softloom it solns</p>
            <p class="page">Page </p>-->
        </div>
        <div id="content">
            <h1>Ledger <?php echo $heading; ?></h1>
            <table id="from_to">
                <tr>
                    <td>From: <?php echo $frm ?></td>
                    <td>To: <?php echo $to ?></td>
                </tr>
            </table>
            <table class="table table-striped table-bordered table-hover table-full-width" >
                <thead>
                    <tr>
                        <th colspan="2">Date</th>
                        <th>Voucher No</th>
                        <th>Remark</th>
                        <th>Receipts</th>
                        <th>Payments</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn_count = 1;
                    $totreceipt = 0;
                    $totpayment = 0;
                    ?>
                    <tr>
                        <td colspan="4" align="right"><b>Opening Balance:</b></td>
                        <td colspan="2" align="right"><b>
                                <?php
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
                        <td></td>
                    </tr>
                    <?php
                    foreach ($sel->result() as $row) {
                        $acc_id = $row->ACC_ID;
                        $book_name = $row->BOOK_NAME;
                        $book_num = $row->BOOK_NUMBER;
                        $date_entry = $row->DATE_OF_TRANSACTION;
                        ?>
                        <tr>
                            <td colspan="2"><?php
                                $time1 = strtotime($date_entry);
                                echo $date_entry1 = date("d-m-Y", $time1);
                                ?>
                            </td>
                            <td><?php echo $book_name . "" . $book_num; ?></td>
                            <td><?php echo $row->REMARKS; ?></td>
                            <td align="right"><?php echo $receipt = $row->DEBIT; ?></td>
                            <td align="right"><?php echo $payment = $row->CREDIT; ?></td>
                            <td align="right"><?php
                                $opening_balance += $receipt - $payment;
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
                            </td>
                            <?php
                            $totreceipt += $receipt;
                            $totpayment += $payment;
                            ?>
                            <?php $sn_count++; ?>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td colspan="4" align="right"><b>TOTAL </b>
                        <td align="right"><b><?php echo $totreceipt; ?></b></td>
                        <td align="right"><b><?php echo $totpayment; ?></b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right"><b>Closing Balance</b></td>
                        <td colspan="2" align="right"><b>
                                <?php
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
                            </b></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>