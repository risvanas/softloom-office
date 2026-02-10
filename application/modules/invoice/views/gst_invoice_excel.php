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
            <tr><td colspan="8" style="text-align: center;font-weight: 700">GST Invoice List</td></tr>
            <!--<tr><td colspan="8" style="text-align: center;">From: <?php // echo $frm ?>&nbsp;&nbsp;To: <?php // echo $to ?></td></tr>-->
            <thead>
                <tr>
                    <th colspan="8">From: <?php echo $frm ?> &nbsp;&nbsp;To: <?php echo $to ?></th>
                </tr>
                <tr>
                    <th>Number</th>
                    <th> Date </th>
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
    </body>
</html>



