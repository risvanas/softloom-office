<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice List</title>
    <style>
        body {
            font-size: 13px;
            width: 100%;
            position: relative;
            /*font-family: sans-serif;*/
        }

        @page {
            margin: 160px 50px 40px 80px;
        }

        #header {
            position: fixed;
            left: 0px;
            top: -160px;
            right: 0px;
            height: 40px;
            text-align: center;
        }

        #footer {
            position: fixed;
            left: 0px;
            bottom: -40px;
            right: 0px;
            height: 40px;
        }

        #notices {
            /*padding-left: 6px;*/
            /*padding-bottom: 10px;*/
            /*border-left: 6px solid #555555;*/
        }

        .clear_fix {
            padding-bottom: 5px;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
        }

        #footer table.footer_clr td {
            height: 30px;
            width: 10%;
        }

        .clearfix table {
            margin-bottom: 30px !important;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #555555;
        }

        #invoice {
            text-align: right;
        }

        #invoice h1 {
            color: #555555;
            font-size: 16px;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        /*            #content table.main{
                            border: 1px solid #AAAAAA;
                            height: 610px;
                        }*/
        #content table.main tr th,
        #content table.main tr td {
            border: 1px solid #AAAAAA;
        }

        #content table.main tbody tr td,
        #content table.main tr th {
            padding: 3px 20px !important;
            /*background-color: #EEEEEE;*/
        }

        #content table.main tr td,
        #content table.main tr th {
            /*border-right: 1px solid #AAAAAA !important;*/
        }

        #content table.main tr td:first-child {
            /*border-left: 1px solid #AAAAAA !important;*/
        }

        #content table.main .no {
            /*color: #555555;*/
            /*background-color: #DDDDDD;*/
        }

        #content table.main .desc {
            text-align: left;
        }

        #content table.main .unit {
            /*background-color: #DDDDDD;*/
        }

        #content table.main .total {
            /*color: #555555;*/
        }

        #content table.main td h3 {
            margin: 0;
        }

        #content table.main tfoot td {
            padding: 3px 20px !important;
            background-color: #FFFFFF;
            text-align: right;
            /*                border-right: 1px solid #AAAAAA !important;*/
        }

        #content table.main tbody td.total,
        #content table.main tbody td.no,
        #content table.main tbody td.desc {
            vertical-align: top;
        }

        #content table.main td.total {
            text-align: right;
        }

        /*            #notices {
                            padding-left: 6px;
                            margin-bottom: 10px;
                            border-left: 6px solid #555555;
                            position: absolute;
                            bottom: -10px;
                            top: 96%;
                            left: 0px;
                            right: 0;
                            height:100px; 
                        }*/
        .page {
            text-align: right;
        }

        td.address {
            width: 25%;
        }

        h2.name {
            font-size: 13px;
            /*                font-weight: normal;*/
            margin: 0;
            text-transform: uppercase;
        }

        hr {
            border: 0px;
            border-top: 1px solid #ccc;
        }

        table.tax td,
        table.tax th {
            padding: 5px 15px !important;
            border: 1px solid #aaaaaa !important;
            text-align: center;
        }

        table.tax td.total {
            text-align: right !important;
        }

        table {
            border-spacing: 0px;
        }

        #mynewdiv h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px !important;
        }

        table#from_to {
            margin: auto;
            margin-bottom: 15px;
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
        <div class="clear_fix">&nbsp;</div>
        <table class="table footer_clr">
            <tr>
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
        <div id="mynewdiv">
            <h2>Invoice List</h2>
            <table cellspacing="0" cellpadding="0" class="main table" style="margin-bottom: 5px;">
                <thead>
                    <tr>
                        <th colspan="8">From: <?php echo $frm ?> &nbsp;&nbsp;To: <?php echo $to ?></th>
                    </tr>
                    <tr align="center">
                        <th>Number</th>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>GST No</th>
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

                            <td align="center">PAY<?php echo format_book_number($row->BOOK_NUMBER) . "/" . $from_date . "-" . $to_date; ?></td>
                            <td align="center"><?php echo date("d-m-Y", strtotime($row->PAYMENT_DATE)); ?></td>
                            <td align="center"><?php echo $row->NAME; ?></td>
                            <td align="center"></td>
                            <td align="center"><?php echo ucwords(strtolower(str_replace('_', ' ', $row->INVOICE_TYPE))); ?></td>
                            <td align="right">
                                <?php echo $row->SUB_TOTAL_PRICE;
                                $sub_total +=  $row->SUB_TOTAL_PRICE; ?>
                            </td>
                            <td align="right">
                                <?php echo $gst = $row->SGST_AMOUNT + $row->CGST_AMOUNT;
                                $gst_amt += $gst; ?>
                            </td>
                            <td align="right">
                                <?php echo $row->AMOUNT;
                                $tot_amt +=  $row->AMOUNT; ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr align="right">
                        <td colspan="5" style="text-align: right;">Total</td>
                        <td><?php echo number_format($sub_total, 2); ?></td>
                        <td><?php echo number_format($gst_amt, 2); ?></td>
                        <td><?php echo number_format($tot_amt, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>