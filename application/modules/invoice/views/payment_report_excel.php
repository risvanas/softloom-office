<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        table,
        td {
            border: thin solid black
        }

        table {
            border-collapse: collapse
        }
    </style>
</head>

<body>
    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
        <tr>
            <?php $company_details = $company->row(); ?>
            <td colspan="4"><img id='logo_image' src='<?php echo base_url() . $company_details->LOGO ?>' alt='<?php echo $company_details->COMP_NAME ?>'></td>
            <td colspan="4">
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
        <!--<div class="panel-body">-->
        <tr>
            <td colspan="8" style="text-align: center;font-weight: 700">Payment Report</td>
        </tr>
        <thead>
            <tr>
                <th colspan="8">From: <?php echo $frm ?> &nbsp;&nbsp;To: <?php echo $to ?></th>
            </tr>
            <tr>
                <th>Number</th>
                <th>Date</th>
                <th>Name</th>
                <th>Invoice Type</th>
                <th>Amount</th>
                <th>Tax Amount</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tot_amt = $gst_amt = $sub_total = 0;
            foreach ($serch->result() as $row) {
            ?>
                <tr>
                    <?php
                    $from_date = date("y", strtotime($row->year_code_from));
                    $to_date = date("y", strtotime($row->year_code_to));
                    ?>
                    <td>PAY<?php echo format_book_number($row->BOOK_NUMBER) . "/" . $from_date . "-" . $to_date; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row->PAYMENT_DATE)); ?></td>
                    <td><?php echo $row->NAME; ?></td>
                    <td><?php echo ucwords(strtolower(str_replace('_', ' ', $row->INVOICE_TYPE))); ?></td>
                    <td>
                        <?php echo $row->SUB_TOTAL_PRICE;
                        $sub_total +=  $row->SUB_TOTAL_PRICE; ?>
                    </td>
                    <td>
                        <?php echo $gst = $row->SGST_AMOUNT + $row->CGST_AMOUNT;
                        $gst_amt += $gst; ?>
                    </td>
                    <td>
                        <?php echo $row->AMOUNT;
                        $tot_amt +=  $row->AMOUNT; ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="4" style="text-align: right;">Total</td>
                <td><?php echo $sub_total ?></td>
                <td><?php echo $gst_amt ?></td>
                <td><?php echo $tot_amt ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>