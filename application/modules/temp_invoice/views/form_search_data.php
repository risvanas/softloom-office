  
<table class="table table-striped table-bordered table-hover table-full-width" >
    <thead>
        <tr>
            <?php if($type == 'recurring') { ?>
                <th>Sl No</th>
                <th>Customer</th>
                <th>Next Invoice Date</th>
                <th>Description</th>
            <?php } else { ?>
                <th>Inv-No</th>
                <th>Number</th>
                <th> Invoice Date </th>
                <th> Customer Name </th>
                <th>Description</th>
                <th>Invoice Value</th>
                <th>Tax Value</th>
                <th>Flood Cess Amount</th>
                <th> Total Price </th>
                <th  style="width:110px;">&nbsp;</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $sn_count = 1;

        foreach ($serch->result() as $row) {
            if($type == 'recurring') { ?>
                <tr>
                    <td><?php echo $sn_count ?></td>
                    <td><?php echo $row->ACC_NAME ?></td>
                    <td>
                        <?php
                        $next_inv_date = $row->NEXT_INVOICE_DATE;
                        $next_inv_date = strtotime($next_inv_date);
                        echo $next_inv_date = date("d-m-Y", $next_inv_date);
                        ?>
                    </td>
                    <td><?php echo $row->INVOICE_RECURRING_COMMENT ?></td>
                </tr>
            <?php } else {
                $cust_id = $row->CUSTOMER_ID;
                $query = $this->db->query("SELECT ACC_NAME FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");
                $res = $query->row_array();
                $customer_name = $res['ACC_NAME'];
                $book_number = $row->BOOK_NUMBER;
                $book_name = $row->BOOK_NAME;
                $accounting_year = $row->ACC_YEAR_CODE;
                $temp_inv_id = $row->INVOICE_ID;
                ?>
                <tr>
                    <?php
                    $encrypted_inv_id = $this->encryption->encrypt($temp_inv_id);
                    $encrypted_inv_id = str_replace("/", "~", $encrypted_inv_id);
                    $encrypted_inv_id = str_replace("=", "-", $encrypted_inv_id);
                    $encrypted_inv_id = str_replace("+", ".", $encrypted_inv_id);
                    ?>
                    <td><?php echo $sn_count; ?></td>
                    <td><a href="<?php echo site_url('temp_invoice/print_invoice') . $encrypted_inv_id . "/$accounting_year"; ?> " target="_blank"> <?php echo $book_name . $book_number; ?></a></td>
                    <td><?php
                        $invoice_date = $row->INVOICE_DATE;
                        $invoice_date = strtotime($invoice_date);
                        echo $invoice_date = date("d-m-Y", $invoice_date);
                        ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $row->description; ?></td>
                    <td><?php echo $row->SUB_TOTAL_PRICE; ?></td>
                    <td><?php echo $row->SGST_AMOUNT + $row->CGST_AMOUNT; ?></td>
                    <td><?php echo $row->FLOOD_CESS_AMOUNT; ?></td>
                    <td><?php echo $row->TOTAL_PRICE; ?></td>
                    <td class="">
                    <?php
                        $temp_inv_id = $row->INVOICE_ID;
                        $encrypted_inv_id = $this->encryption->encrypt($temp_inv_id);
                        $encrypted_inv_id = str_replace("/", "~", $encrypted_inv_id);
                        $encrypted_inv_id = str_replace("=", "-", $encrypted_inv_id);
                        $encrypted_inv_id = str_replace("+", ".", $encrypted_inv_id);
                    ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                            <ul class="dropdown-menu" role="menu">
                                <li> <a href="<?php echo site_url('invoice/create_invoice') . $encrypted_inv_id . "/$accounting_year"; ?> " target="_blank"> <i class="icon-pencil"></i> Create Invoice </a> </li>
                                <li id="set_as_paid"> <a href="#static<?php echo $temp_inv_id; ?>" data-toggle="modal"> <i class="icon-rupee"></i> Set As Paid</a> </li>
                                <li> <a href="<?php echo site_url('temp_invoice/print_invoice') . $encrypted_inv_id . "/$accounting_year"; ?> " target="_blank"> <i class="icon-print"></i> Print </a> </li>
                                <li> <a href="<?php echo site_url('temp_invoice/invoice_edit') . $encrypted_inv_id . "/$accounting_year"; ?> " target="_blank"> <i class="icon-pencil"></i> Edit </a> </li>
                                <li> <a href="<?php echo site_url('temp_invoice/invoice_delete') . $encrypted_inv_id . "/$accounting_year"; ?> " target="_blank"> <i class="icon-trash"></i> Delete </a> </li>               
                            </ul>
                        </div>
                    </td>

        <div id="static<?php echo $temp_inv_id; ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
        <div class="modal-body">
            <p> Are You sure, that you want to set selected invoice as Paid? </p>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
            <a type="button"  class="btn btn-primary" href="<?php echo site_url('temp_invoice/set_invoice_as_paid'); ?><?php echo $temp_inv_id; ?>"> Continue </a> 
        </div>
    </div>
                </tr>
            <?php }
            $sn_count++;
        }
        ?>
    </tbody>

</table>