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
        $heading = ($ac_name != "") ? " - " . $ac_name : "" ;
        $heading .= ($sub_name != "") ? " - " . $sub_name : "";
        ?>
        <table class="table table-striped table-bordered table-hover table-full-width" >
            <tr>
                <td colspan="3"><img id='logo_image' src='https://softloom.com/wp-content/uploads/2017/06/logo.png' alt='Softloom ITSolution'></td>
                <td colspan="3">
                    <p>
                        Softloom it solutions,<br>
                        Ist Floor, HA Tower,<br>
                        Providence Road,<br>
                        Kacheripady, Kochi, Ernakulam,<br>
                        Kerala 682018 <br>
                    </p>
                </td>
            </tr>
            <tr><td colspan="6" style="text-align: center;font-weight: 700">Ledger <?php echo $heading; ?></td></tr>
            <tr>
<!--                <td colspan="2"></td>
                <td>From: <?php echo $frm ?></td>
                <td>To: <?php echo $to ?></td>
                <td colspan="2"></td>-->
                <td colspan="6" style="text-align: center;">From: <?php echo $frm ?>&nbsp;&nbsp;To: <?php echo $to ?></td>
            </tr>

            <thead>
                <tr>
                    <th>Date</th>
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
                </tr>
                <?php
                foreach ($sel->result() as $row) {
                    $acc_id = $row->ACC_ID;
                    $book_name = $row->BOOK_NAME;
                    $book_num = $row->BOOK_NUMBER;
                    $date_entry = $row->DATE_OF_TRANSACTION;
                    ?>
                    <tr>
                        <td><?php
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
                </tr>
            </tbody>
        </table>
    </body>
</html>