<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice </title>
        <style>
            body{
                font-size: 10px;
                width: 100%;
                position: relative;
                /*font-family: sans-serif;*/
            }
            @page {
                margin: 160px 50px 150px 80px;
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
                bottom: -150px;
                right: 0px;
                height: 150px;
            }
            #notices {
                /*padding-left: 6px;*/
                /*padding-bottom: 10px;*/
                /*border-left: 6px solid #555555;*/
            }
            .clear_fix {
                padding-bottom: 5px;
            }
            table.table{
                width: 100%;
                border-collapse: collapse;
            }
            #footer table.footer_clr td{
                height: 30px;
                width: 10%;
            }
            .clearfix table{
                margin-bottom: 10px !important;
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
            #content table.main tr th {
                border: 1px solid #AAAAAA;
            }
            #content table.main tbody tr td, #content table.main tr th {
                padding: 3px 20px !important;
                /*background-color: #EEEEEE;*/
                text-align: center;
            }
            #content table.main tr td, #content table.main tr th {
                border-right: 1px solid #AAAAAA !important;
            }
            #content table.main tr td:first-child {
                border-left: 1px solid #AAAAAA !important;
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
            #content table.main tbody td.total,#content table.main tbody td.no, #content table.main tbody td.desc {
                vertical-align: top;
            }
            #content table.main td.total {
                text-align: right;
            }
            /*#notices {
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
            .page{
                text-align: right;
            }
            td.address{
                width: 35%;
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
            table.tax td, table.tax th{
                padding: 5px 15px !important;
                border: 1px solid #aaaaaa !important;
            }
            .right_align{
                text-align: right;
            }
            table.tax td.total{
                text-align: right !important;
            }
            table {
                border-spacing: 0px;
            }
            #unpaid_head_div {
                padding: 5px !important;
                text-align: right;
                font-family: Arial;
/*                margin-left: auto ;
                margin-right: auto ;*/
                /*background-color: yellow !important;*/
            }
            #unpaid_head{
                font-family: Arial !important;
                width: 65px;
                background-color: red;
                padding: 5px;
                color: #fff !important;
                font-weight: 800 !important;
                text-align: center;
            }

            /*            span.rupee {
              content: "\20B9";
            }*/
        </style>
    </head>
    <body>
        <?php
        foreach ($vno->result() as $row) {
            $invoice_id = $row->INVOICE_ID;
            $cust_id = $row->CUSTOMER_ID;
            $query = $this->db->query("SELECT * FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");
            $res = $query->row_array();
            $customer_name = $res['ACC_NAME'];
            $address_one = $res['ADDRESS_ONE'];
            $address_two = $res['ADDRESS_TWO'];
            $phone = $res['PHONE'];
            $acc_email = $res['ACC_EMAIL'];
            $gst_no = $res['TIN_NO'];

            $total_price = $row->TOTAL_PRICE;
            $paid_price = $row->PAID_PRICE;
            $due_amt = $total_price - $paid_price;
            $subtotal = $row->SUB_TOTAL_PRICE;
            $sgst_percent = $row->SGST_PERCENT;
            $cgst_percent = $row->CGST_PERCENT;
            $flood_cess_percent = $row->FLOOD_CESS_PERCENT;
            $sgst_amt = $row->SGST_AMOUNT;
            $cgst_amt = $row->CGST_AMOUNT;
            $flood_cess_amt = $row->FLOOD_CESS_AMOUNT;
            $round_off = $row->ROUND_OFF;
            $invoice_type = $row->INVOICE_TYPE;
            ?>
            <!-- <div class="ui button aligned center teal" id="create_pdf" >Download</div> -->
            <!--<label id="create_pdf" style="position:absolute;  bottom: 98%;right: -20%;">Download</label>-->
            <!--<form class="ui form" id="myform">-->
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
                            <h2 class="name" style="padding-top: 50px;"><?php echo $company_details->COMP_NAME ?></h2>
                            <?php
                            echo "<p style='margin: 0;'>" . $company_details->ADDRESS1 . "," .
                            $company_details->ADDRESS2 . "," .
                            $company_details->ADDRESS3 . "-" . $company_details->PIN_CODE . ", " . $company_details->STATE . ".<br>" .
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
                <table style="">
                    <tr>
                        <td style="padding: 0px 20px">
                            <div id="notices">
                                <div>Company's PAN &nbsp;:&nbsp; <b>ADFFS7647K</b></div>
                                <div style="padding-top: 10px">Declaration</div>
                                <div class="notice">We declare that  this invoice shows the actual price of the goods described and that all particulars are true and correct.</div>
                            </div>
                        </td>
                        <td style="padding: 0px 20px">
                            <div id="notices">
                                <div class="notice"><b>Bank Details </b><br/>
                                    <table>
                                        <tr>
                                            <td>Bank Name</td>
                                            <td>:</td>
                                            <td><?php echo $company_details->BANK; ?></td>
                                        </tr>
                                        <tr>
                                            <td>A/c No.</td>
                                            <td>:</td>
                                            <td><?php echo $company_details->ACNT_NO; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Branch</td>
                                            <td>:</td>
                                            <td><?php echo $company_details->BANK_BRANCH; ?></td>
                                        </tr>
                                        <tr>
                                            <td>IFS Code</td>
                                            <td>:</td>
                                            <td><?php echo $company_details->IFSC_CODE; ?></td>
                                        </tr>
                                    </table>                        
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center; border-top: 1px solid #AAAAAA;">This is a Computer Generated Invoice</td>
                    </tr>
                </table>

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
                <div id="details" class="clearfix">
                    <table class="table">
                        <tr>
                            <td id="client">
                                <div class="to">INVOICE TO:</div>
                                <h2 class="name"><?php echo $customer_name; ?></h2>
                                <div class="address"><?php echo $address_one; ?></div>
                                <div class="address"><?php echo $address_two; ?></div>
                                <div class="address">Mobile: <?php echo $phone; ?></div>
                                <div class="email">Email: <?php echo $acc_email; ?></div>
                                <?php if ($gst_no != "" || $gst_no != NULL) { ?>
                                    <div class="email">GSTIN: <?php echo $gst_no; ?></div>
                                <?php } ?>
                                Date of Invoice: <?php
                                    $invoice_date = $row->INVOICE_DATE;
                                    $invoice_date = strtotime($invoice_date);
                                    echo $invoice_date = date("F d,Y", $invoice_date);
                                    ?>
                            </td>
                            <td></td>
                            <td id="invoice" style="text-align: right; width: 200px">
                                <div id="unpaid_head_div">
                                    <h1 id="unpaid_head">UNPAID</h1>
                                </div>
                                <!--<div class="date">Amount Due: <?php // echo $due_amt;      ?></div>-->

                            </td>
                        </tr>
                    </table>
                </div>
                <div id="mynewdiv">
                    <table border="0" cellspacing="0" cellpadding="0" class="main table">
                        <thead>
                            <tr bgcolor="rgb(237,242,250)">
                                <th class="no" style="border: 1px solid #AAAAAA; width: 8%; padding: 0px !important; margin: 0px">SL NO</th>
                                <th class="desc" style="border: 1px solid #AAAAAA; width: 70%">DESCRIPTION</th>
    <!--                                <th class="unit">UNIT PRICE</th>
                                <th class="qty">QUANTITY</th>-->
                                <th class="total" style="border: 1px solid #AAAAAA">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $sub_total = 0;
                            $details = $this->db->query("SELECT * FROM tbl_temp_invoicedetails WHERE INVOICE_ID='$invoice_id' AND DEL_FLAG='1'");
                            foreach ($details->result() as $items) {

                                $unit_cost = $items->UNIT_COST;
                                $quantity = $items->QUANTITY;
                                $price = $unit_cost * $quantity;
                                ?>
                                <tr>
                                    <td class="no">0<?php echo $count; ?></td>
                                    <td class="desc"><h3><?php echo $items->ITEM; ?></h3><?php echo $items->DESCRIPTION; ?></td>
        <!--                                    <td class="unit"><?php // echo $items->UNIT_COST;         ?></td>
                                    <td class="qty"><?php // echo $items->QUANTITY;         ?></td>-->
                                    <td class="total"><?php
                                        $unit_total = round($price, 2);
                                        echo number_format($unit_total, 2);
                                        ?></td>
                                </tr>
                                <?php
                                $sub_total += $unit_total;
                                $count++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="total" style="border-top: 1px solid #AAAAAA"><?php echo number_format($sub_total, 2); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php if ($invoice_type == 'with_tax') { ?>
                                <tr>
                                    <td></td>
                                    <td>SGST (<?php echo $sgst_percent . "%" ?>)</td>
                                    <td class="total"><?php echo number_format($sgst_amt, 2); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>CGST (<?php echo $cgst_percent . "%" ?>)</td>
                                    <td class="total"><?php echo number_format($cgst_amt, 2); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Flood Cess (<?php echo $flood_cess_percent . "%" ?>)</td>
                                    <td class="total"><?php echo number_format($flood_cess_amt, 2); ?></td>
                                </tr>
                            <?php } ?>
    <!--                            <tr>
                        <td colspan="2" style="border: none"></td>
                        <td colspan="2" style="border-top: 1px solid #AAAAAA">AMOUNT PAID</td>
                        <td style="border-top: 1px solid #AAAAAA"><?php // echo $paid_price;         ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none"></td>
                        <td colspan="2" style="border-top: 1px solid #AAAAAA">BALANCE DUE</td>
                        <td style="border-top: 1px solid #AAAAAA"><?php // echo $due_amt;         ?></td>
                    </tr>-->
                            <tr>
                                <td ></td>
                                <td >Round Off</td>
                                <td class="total" ><?php echo number_format($round_off, 2); ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #AAAAAA"></td>
                                <td style="border: 1px solid #AAAAAA" height="45px"><b>TOTAL</b></td>
                                <td class="total" style="border: 1px solid #AAAAAA"><b>INR <?php echo number_format($total_price, 2); ?></b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php
            }
            $str = array();
            $hundred = null;
            $words = array(0 => '', 1 => 'one', 2 => 'two',
                3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine',
                10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            $digits_length = strlen($total_price);
            $decimal = round($total_price - ($no = floor($total_price)), 2) * 100;
            $i = 0;
            while ($i < $digits_length) {
                $divider = ($i == 2) ? 10 : 100;
                $tot_amt = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($tot_amt) {
                    $plural = (($counter = count($str)) && $tot_amt > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($tot_amt < 21) ? $words[$tot_amt] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($tot_amt / 10) * 10] . ' ' . $words[$tot_amt % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
                } else
                    $str[] = null;
            }
            $Rupees = implode('', array_reverse($str));
            $paise = ($decimal) ? "and " . ($words[floor($decimal / 10) * 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
            $return = ($Rupees ? $Rupees : '');
            $return .= ($paise ? $paise : "") . " Only";
            echo 'Amount Chargeable (in words) : ';
            echo "<b>" . ucwords($return) . "</b>";
                ?>
        </div>
        <!--        <div id="notices">
                    <div>NOTICE:</div>
                    <div class="notice"><b>Bank Details </b><br/>
                        Softloom IT Solutions, Federal Bank
                        , Ernakulam / North branch
                        ,
                        A/C no: 10040200041162,<br/>
                        IFS Code: FDRL0001004
                    </div>
                </div>-->
    </body>
</html>
