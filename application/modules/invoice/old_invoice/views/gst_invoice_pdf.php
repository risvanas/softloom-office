<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice </title>
        <style>
            body{
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
            table.table{
                width: 100%;
                border-collapse: collapse;
            }
            #footer table.footer_clr td{
                height: 30px;
                width: 10%;
            }
            .clearfix table{
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
            #content table.main tr th, #content table.main tr td {
                border: 1px solid #AAAAAA;
            }
            #content table.main tbody tr td, #content table.main tr th {
                padding: 3px 20px !important;
                /*background-color: #EEEEEE;*/
                text-align: center;
            }
            #content table.main tr td, #content table.main tr th {
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
            #content table.main tbody td.total,#content table.main tbody td.no, #content table.main tbody td.desc {
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
            .page{
                text-align: right;
            }
            td.address{
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
            table.tax td, table.tax th{
                padding: 5px 15px !important;
                border: 1px solid #aaaaaa !important;
                text-align: center;
            }
            table.tax td.total{
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
            table#from_to{
                margin: auto;
                margin-bottom: 15px;
            }
            /*            span.rupee {
              content: "\20B9";
            }*/
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
<!--            <table style="">
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
            </table>-->

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
                <h2>GST Invoice List</h2>
<!--                <table id="from_to">
                    <tr>
                        <td>From: <?php // echo $frm ?></td>
                        <td>To: <?php // echo $to ?></td>
                    </tr>
                </table>-->
                <table  cellspacing="0" cellpadding="0" class="main table" style="margin-bottom: 5px;">
                    <thead>
                        <tr>
                            <th colspan="8">From: <?php echo $frm ?> &nbsp;&nbsp;To: <?php echo $to ?></th>
                        </tr>
                        <tr>
                            <th>Number</th>
                            <th style="width: 80px"> Date </th>
                            <th> Customer Name </th>
                            <th> GST No </th>
                            <th>Description</th>
                            <th>Invoice Amount</th>
                            <th>Tax Amount</th>
                            <th> Total Amount </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sn_count = 1;
                        $tot_amt = $gst_amt = $sub_total = 0;
                        foreach ($serch->result() as $row) {

                            $cust_id = $row->CUSTOMER_ID;
                            $query = $this->db->query("SELECT ACC_NAME,TIN_NO FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");
                            $res = $query->row_array();
                            $customer_name = $res['ACC_NAME'];
                            $gst_no = $res['TIN_NO'];
                            $book_number = $row->BOOK_NUMBER;
                            $book_name = $row->BOOK_NAME;
                            $accounting_year = $row->ACC_YEAR_CODE;
                            ?>
                            <tr>
                                <?php
                                $data_id = $row->BOOK_NUMBER;
                                $encrypted_data = $this->encryption->encrypt($data_id);
                                $encrypted_data = str_replace("/", "~", $encrypted_data);
                                $encrypted_data = str_replace("=", "-", $encrypted_data);
                                $encrypted_data = str_replace("+", ".", $encrypted_data);
                                ?>
                                <td><?php echo $book_name . $book_number; ?></td>
                                <td><?php
                                    $invoice_date = $row->INVOICE_DATE;
                                    $invoice_date = strtotime($invoice_date);
                                    echo $invoice_date = date("d-m-Y", $invoice_date);
                                    ?></td>
                                <td><?php echo strtoupper($customer_name); ?></td>
                                <td><?php echo $gst_no; ?></td>
                                <td><?php echo $row->description; ?></td>
                                <td>
                                    <?php echo $row->SUB_TOTAL_PRICE; 
                                    $sub_total +=  $row->SUB_TOTAL_PRICE; ?>
                                </td>
                                <td>
                                    <?php echo $gst = $row->SGST_AMOUNT + $row->CGST_AMOUNT;
                                    $gst_amt += $gst; ?>
                                </td>
                                <td>
                                    <?php echo $row->TOTAL_PRICE;
                                    $tot_amt +=  $row->TOTAL_PRICE; ?>
                                </td>
                            </tr>
                            <?php
                            $sn_count++;
                        }
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: right;">Total</td>
                            <td><?php echo $sub_total ?></td>
                            <td><?php echo $gst_amt ?></td>
                            <td><?php echo $tot_amt ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
