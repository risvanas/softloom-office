<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice </title>
        <style>
            body{
                font-size: 14px;
                width: 100%;
                position: relative;
                /*font-family: sans-serif;*/
            }
            @page {
                margin: 180px 50px 75px 80px;
            }
            #header {
                position: fixed;
                left: 0px;
                top: -180px;
                right: 0px; 
                height: 70px; 
                text-align: center;
            }
            #footer {
                position: fixed; 
                left: 0px;
                bottom: -75px;
                right: 0px;
                height: 20px;
            }
            table.table{
                width: 100%;
                border-collapse: collapse;
            }
            #footer table td{
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
                font-size: 20px;
                line-height: 1em;
                font-weight: normal;
                margin: 0 0 10px 0;
            }
            #content table.main tbody tr td, #content table.main tr th {
                padding: 20px !important;
                background-color: #EEEEEE;
                text-align: center;
                border-bottom: 1px solid #FFFFFF !important;
            }
            #content table.main .no {
                color: #555555;
                background-color: #DDDDDD;
            }
            #content table.main .desc {
                text-align: left;
            }
            #content table.main .unit {
                background-color: #DDDDDD;
            }
            #content table.main .total {
                color: #555555;
            }
            #content table.main td h3 {
                margin: 0;
            }
            #content table.main tfoot td {
                padding: 10px 20px !important;
                background-color: #FFFFFF;
            }
            #notices {
                padding-left: 6px;
                border-left: 6px solid #555555;
                position: absolute;
                /*bottom: -10px;*/
                top: 96%;
                left: 0px;
                right: 0;
                /*height:100px;*/ 
            }
            .page{
                text-align: right;
            }
            .address{
                width: auto;
            }
            h2.name {
                font-size: 20px; 
                font-weight: normal;
                margin: 0;
            }

            hr {
                border: 0px;
                border-top: 1px solid #ccc;
            }
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


            $total_price = $row->TOTAL_PRICE;
            $paid_price = $row->PAID_PRICE;
            $due_amt = $total_price - $paid_price;
            ?>
            <!-- <div class="ui button aligned center teal" id="create_pdf" >Download</div> -->
            <!--<label id="create_pdf" style="position:absolute;  bottom: 98%;right: -20%;">Download</label>-->
            <!--<form class="ui form" id="myform">-->
            <div id="header">
                <table class="table">
                    <tr>
                        <td class="bottom"><img id='logo_image' src='https://softloom.com/wp-content/uploads/2017/06/logo.png' alt='Softloom ITSolution'></td>
                        <td class="address">
                            <p>
                            <h2 class="name">Softloom It Solutions</h2><br>
                            1st Floor, H.A Tower,<br>
                            Providence Road, Kacheripady,<br>
                            Kochi-682018, Kerala, India<br>
                            +91 484 239 6771, +919048484206<br>
                            info@softloom.com
                            </p>
                        </td>
                    </tr>
                </table>
                <hr>
            </div>
            <div id="footer">
                <table class="table">
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
                            </td>
                            <td id="invoice">
                                <h1>INVOICE <?php echo $book_num = $row->BOOK_NUMBER; ?></h1>
                                <div class="date">Date of Invoice: <?php
                                    $invoice_date = $row->INVOICE_DATE;
                                    $invoice_date = strtotime($invoice_date);
                                    echo $invoice_date = date("F d,Y", $invoice_date);
                                    ?></div>
                                <div class="date">Amount Due: <?php echo $due_amt; ?></div>

                            </td>
                        </tr>
                    </table>
                </div>
                <div id="mynewdiv">
                    <table border="0" cellspacing="0" cellpadding="0" class="main table">
                        <thead>
                            <tr>
                                <th class="no">#</th>
                                <th class="desc">DESCRIPTION</th>
                                <th class="unit">UNIT PRICE</th>
                                <th class="qty">QUANTITY</th>
                                <th class="total">TOTAL</th>
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
                                    <td class="unit"><?php echo $items->UNIT_COST; ?></td>
                                    <td class="qty"><?php echo $items->QUANTITY; ?></td>
                                    <td class="total"><?php echo $unit_total = $price; ?></td>
                                </tr>
                                <?php
                                $sub_total += $unit_total;
                                $count++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="border: none"></td>
                                <td colspan="2" style="border-top: 1px solid #AAAAAA">SUBTOTAL</td>
                                <td style="border-top: 1px solid #AAAAAA"><?php echo $sub_total; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border: none"></td>
                                <td colspan="2" style="border-top: 1px solid #AAAAAA">AMOUNT PAID</td>
                                <td style="border-top: 1px solid #AAAAAA"><?php echo $paid_price; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border: none"></td>
                                <td colspan="2" style="border-top: 1px solid #AAAAAA">BALANCE DUE</td>
                                <td style="border-top: 1px solid #AAAAAA"><?php echo $due_amt; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border: none"></td>
                                <td colspan="2" style="border-top: 1px solid #AAAAAA">GRAND TOTAL</td>
                                <td style="border-top: 1px solid #AAAAAA"><?php echo $due_amt; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php
            }
            ?>
        </div>
        <div id="notices">
            <div>NOTICE:</div>
            <div class="notice"><b>Bank Details </b><br/>
                Softloom IT Solutions, Federal Bank
                , Ernakulam / North branch
                ,
                A/C no: 10040200041162,<br/>
                IFS Code: FDRL0001004
            </div>
        </div>
    </body>
</html>
