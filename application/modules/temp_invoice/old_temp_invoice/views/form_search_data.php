  
<table class="table table-striped table-bordered table-hover table-full-width" >
    <thead>
        <tr>
            <?php if($type == 'recurring') { ?>
                <th>Sl No</th>
                <th>Customer</th>
                <th>Next Invoice Date</th>
                <th>Description</th>
            <?php } else { ?>
                <th>Number</th>
                <th> Invoice Date </th>
                <th> Customer Name </th>
                <th>Description</th>
                <th>Invoice Value</th>
                <th>Tax Value</th>
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
                ?>
                <tr>
                    <?php
                    $data_id = $row->BOOK_NUMBER;
                    $encrypted_data = $this->encryption->encrypt($data_id);
                    $encrypted_data = str_replace("/", "~", $encrypted_data);
                    $encrypted_data = str_replace("=", "-", $encrypted_data);
                    $encrypted_data = str_replace("+", ".", $encrypted_data);
                    ?>
                    <td><a href="<?php echo site_url('temp_invoice/print_invoice') . $encrypted_data . "/$accounting_year"; ?> " target="_blank"> <?php echo $book_name . $book_number; ?></a></td>
                    <td><?php
                        $invoice_date = $row->INVOICE_DATE;
                        $invoice_date = strtotime($invoice_date);
                        echo $invoice_date = date("d-m-Y", $invoice_date);
                        ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $row->description; ?></td>
                    <td><?php echo $row->SUB_TOTAL_PRICE; ?></td>
                    <td><?php echo $row->SGST_AMOUNT + $row->CGST_AMOUNT; ?></td>
                    <td><?php echo $row->TOTAL_PRICE; ?></td>
                    <td class="">
                        <div class="btn-group">
                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                            <ul class="dropdown-menu" role="menu">
                                <li> <a href="<?php echo site_url('temp_invoice/print_invoice') . $encrypted_data . "/$accounting_year"; ?> " target="_blank"> <i class="icon-print"></i> Print </a> </li>
                                <li> <a href="<?php echo site_url('temp_invoice/invoice_edit') . $encrypted_data . "/$accounting_year"; ?> " target="_blank"> <i class="icon-pencil"></i> Edit </a> </li>
                                <li> <a href="<?php echo site_url('temp_invoice/invoice_delete') . $encrypted_data . "/$accounting_year"; ?> " target="_blank"> <i class="icon-trash"></i> Delete </a> </li>             
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php }
            $sn_count++;
        }
        ?>
    </tbody>

</table>