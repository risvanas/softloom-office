  
<table class="table table-striped table-bordered table-hover table-full-width" >
    <thead>
        <tr>
             <th colspan="8">From: <?php echo $frm ?> &nbsp;&nbsp;To: <?php echo $to ?></th>
        </tr>
        <tr>
                <th>Number</th>
                <th style="width: 80px"> Date </th>
                <th> Customer Name </th>
                <th> GST No </th>
                
                <th>Invoice Amount</th>
                <th>Tax Amount</th>
                <th>Flood Cess</th>
                <th> Total Amount </th>
                <!--<th  style="width:110px;">&nbsp;</th>-->
        </tr>
    </thead>
    <tbody>
        <?php
        $sn_count = 1;
        $tot_amt = $gst_amt = $sub_total = $cess_amt = 0;
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

                    $accounting_year_id = $row->ACC_YEAR_CODE;
                    $sql = "select * from tbl_accounting_year where AY_ID=$accounting_year_id";
                    $query1 = $this->db->query($sql);
                    $val = $query1->row_array();
                    $from_date = $val['FROM_DATE'];
                    $to_date = $val['TO_DATE'];
                    $from_date = strtotime($from_date);
                    $from_date = date("y", $from_date);
                    $to_date = strtotime($to_date);
                    $to_date = date("y", $to_date);
                    ?>
                    <td><a href="<?php echo site_url('invoice/print_invoice') . $encrypted_data . "/$accounting_year"; ?> " target="_blank"> <?php echo $book_name . $book_number." / ".$from_date."-".$to_date; ?></a></td>
                    <td><?php
                        $invoice_date = $row->INVOICE_DATE;
                        $invoice_date = strtotime($invoice_date);
                        echo $invoice_date = date("d-m-Y", $invoice_date);
                        ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $gst_no; ?></td>
                    
                    <td>
                        <?php echo $row->SUB_TOTAL_PRICE; 
                        $sub_total +=  $row->SUB_TOTAL_PRICE; ?>
                    </td>
                    <td>
                        <?php echo $gst = $row->SGST_AMOUNT + $row->CGST_AMOUNT;
                        $gst_amt += $gst; ?>
                    </td>
                    <td>
                        <?php echo $cess = $row->FLOOD_CESS_AMOUNT;
                        $cess_amt += $cess; ?>
                    </td>
                    <td>
                        <?php echo $row->TOTAL_PRICE;
                        $tot_amt +=  $row->TOTAL_PRICE; ?>
                    </td>
<!--                    <td class="">
                        <div class="btn-group">
                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                            <ul class="dropdown-menu" role="menu">
                                <li> <a href="<?php // echo site_url('invoice/print_invoice') . $encrypted_data . "/$accounting_year"; ?> " target="_blank"> <i class="icon-print"></i> Print </a> </li>
                                <li> <a href="<?php // echo site_url('invoice/invoice_edit') . $encrypted_data . "/$accounting_year"; ?> " target="_blank"> <i class="icon-pencil"></i> Edit </a> </li>
                                <li> <a href="<?php // echo site_url('invoice/invoice_delete') . $encrypted_data . "/$accounting_year"; ?> " target="_blank"> <i class="icon-trash"></i> Delete </a> </li>             
                            </ul>
                        </div>
                    </td>-->
                </tr>
            <?php 
            $sn_count++;
        }
        ?>
        <tr>
            <td colspan="4" style="text-align: right;">Total</td>
            <td><?php echo $sub_total ?></td>
            <td><?php echo $gst_amt ?></td>
            <td><?php echo $cess_amt ?></td>
            <td><?php echo $tot_amt ?></td>
        </tr>
    </tbody>

</table>