<img id='logo_image' src='https://softloom.com/wp-content/uploads/2017/06/logo.png' alt='Softloom ITSolution' style='display:none;'>
<table class="table table-striped table-bordered table-hover table-full-width" >
    <thead>
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
        ?>
        <tr><td colspan="7"><?php echo "Ledger from " . $frm . " to " . $to . "( Account :" . $ac_name . " , Sub Account:" . $sub_name . " ) "; ?></th></tr>
        <tr>
            <th colspan="2"> Date of entery </th>
            <th>Voucher No</th>
            <th>Remark</th>
            <th>Receipts</th>
            <th>Payments</th>
            <th style="min-width: 100px;"> Balance </th>
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
                </b></td>
            <td></td>
        </tr>
        <?php

        foreach ($sel->result() as $row) {
            $acc_id = $row->ACC_ID;
            $book_name = $row->BOOK_NAME;
            $book_num = $row->BOOK_NUMBER;
            $date_entry = $row->DATE_OF_TRANSACTION;
            $ACC_YEAR_CODE = $row->ACC_YEAR_CODE;
            ?>
            <tr>
                <td colspan="2"><?php
                    $time1 = strtotime($date_entry);
                    echo $date_entry1 = date("d-m-Y", $time1);
                    ?>
                </td>
                <td><a href="<?php echo site_url('ledger/view_details') . $book_num . "/" . $book_name . "/" . $ACC_YEAR_CODE; ?> " target="_blank"><?php echo $book_name . "" . $book_num; ?></a></td>
                <td><?php echo $row->REMARKS; ?></td>
                <td align="right"><?php echo $receipt = $row->DEBIT; ?></td>
                <td align="right"><?php echo $payment = $row->CREDIT; ?></td>
                <td align="right"><?php
                    $opening_balance += (round($receipt,2) - round($payment,2));
                    if (number_format($opening_balance,2) > 0) {
                        echo round($opening_balance,2) . " Db. ";
                    }
                    if (number_format($opening_balance,2) < 0) {
                        echo abs($opening_balance) . " Cr. ";
                    }
                    if (number_format($opening_balance,2) == 0) {
                        echo abs(number_format($opening_balance));
                    }
                    ?>
                </td>
            </tr>
            <?php
            $totreceipt += $receipt;
            $totpayment += $payment;
            ?>
            <?php
            $sn_count++;
        } ?>
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
                    if (number_format($opening_balance,2) > 0) {
                        echo round($opening_balance,2) . " Db. ";
                    }
                    if (number_format($opening_balance,2) < 0) {
                        echo abs($opening_balance) . " Cr. ";
                    }
                    if (number_format($opening_balance,2) == 0) {
                        echo abs(number_format($opening_balance,2));
                    }
                    ?>
                </b></td>
            <td></td>
        </tr>
    </tbody>
</table>
<script>
    lode_image_false();
</script>