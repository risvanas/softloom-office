<?php
if ($vno->num_rows() < 1) {
    $errmsg = "Data not Found";
    ?>
    <div id="output">
        <div class="row">
            <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label"> Invoice Number </label>
                    <div class="input-group">
                        <input autocomplete="off" type="text" name="temp_invo_num" id="temp_invo_num" Class="form-control" value=""/>
                        <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-dark-beige" onclick="displaydata()"> GO </a> </span></div>
                </div>
            </div>


        </div>
    </div>
    <script>
        document.getElementById('txt_validation').value = '';
    </script>
    <?php
} else {
    ?>
    <div id="output">
        <div class="panel-body">
            <h2><i class="icon-group teal"></i> Invoice Details</h2>
            <div><hr /></div>
            <?php
            foreach ($vno->result() as $row) {
                $invoice_id = $row->INVOICE_ID;
                $cust_id = $row->CUSTOMER_ID;
                $query = $this->db->query("SELECT  *FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");
                $res = $query->row_array();
                $customer_name = $res['ACC_NAME'];

                $total_price = $row->TOTAL_PRICE;
                $paid_price = $row->PAID_PRICE;
                $due_amt = $total_price - $paid_price;
                ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="hdd_invo_id" id="hdd_invo_id" Class="form-control" value="<?php echo $invoice_id; ?>"/>
                                    <label class="control-label"> Book Number </label>

                                    <div class="input-group">
                                        <input autocomplete="off" type="text" name="temp_invo_num" id="temp_invo_num" Class="form-control" value="<?php echo $row->BOOK_NUMBER; ?>"/>
                                        <input type="hidden" name="hdd_buk_num" id="hdd_buk_num" Class="form-control" value="<?php echo $row->BOOK_NUMBER; ?>">
                                        <input type="hidden" name="temp_voc_num" id="temp_voc_num" Class="form-control"/>
                                        <input type="hidden" id="txt_cust" name="txt_cust" value="<?php echo $cust_id; ?>"/>
                                        <input type="hidden" id="txt_inv_id" name="txt_inv_id" value="<?php echo $invoice_id; ?>"/>
                                        <span class="input-group-btn" onclick="displaydata()"> <a data-toggle="modal" class="demo btn btn-dark-beige" > GO </a> </span></div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label"> Invoice Date <span class="symbol required"> </span> </label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_invoice_date" name="txt_invoice_date" value="<?php
                                        $invoice_date = $row->INVOICE_DATE;
                                        $invoice_date = strtotime($invoice_date);
                                        echo $invoice_date = date("d-m-Y", $invoice_date);
                                        ?>" readonly="readonly"/>
                                        <input type="hidden" id="txt_inv_date" name="txt_inv_date" value="<?php echo $invoice_date; ?>"
                                               <i class="icon-calendar"></i> </span> </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" id="h1">
                                    <label class="control-label">Customer Name <span class="symbol required"> </span> </label>
                                    <select class="form-control" id="txt_cust_name" name="txt_cust_name" readonly="readonly">


                                        <option value="<?php echo $cust_id; ?>"><?php echo $customer_name; ?></option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Description <span class="symbol required"> </span></label>
                                    <textarea class="form-control" name="txt_des" readonly="readonly"><?php echo $row->DESCRIPTION; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="out_put">





                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <div id="page-wrap">




                            <table id="items" class="table table-bordered table-hover">
                                <thead>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Unit Cost</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                </thead>

                                <?php
                                $details = $this->db->query("SELECT  *FROM tbl_invoicedetails WHERE INVOICE_ID='$invoice_id' AND DEL_FLAG='1'");
                                foreach ($details->result() as $items) {

                                    $unit_cost = $items->UNIT_COST;
                                    $quantity = $items->QUANTITY;
                                    $price = $unit_cost * $quantity;
                                    ?>
                                    <tr class="item-row">
                                        <td class="item-name"><div class="delete-wpr"><textarea id="item[]" name="item[]"><?php echo $items->ITEM; ?></textarea><!--<a class="delete" href="javascript:;" title="Remove row">X</a>--></div></td>
                                        <td class="description"><textarea name="description[]"><?php echo $items->DESCRIPTION; ?></textarea></td>
                                        <td><textarea class="cost" name="cost[]"><?php echo $items->UNIT_COST; ?></textarea></td>
                                        <td><textarea class="qty" name="qty[]"><?php echo $items->QUANTITY; ?></textarea></td>
                                        <td><textarea class="price" name="price"><?php echo $price; ?></textarea></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                <tr id="hiderow">
                                  <!--<td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>-->
                                </tr>
                                <tr>
                                    <td colspan="2" class="blank"></td>
                                    <td colspan="2" class="total-line">Subtotal</td>
                                    <td class="total-value"><textarea id="subtotal" name="subtotal"><?php echo $row->TOTAL_PRICE; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="blank"></td>
                                    <td colspan="2" class="total-line">Total</td>
                                    <td class="total-value"><textarea id="total" name="total"><?php echo $ttl_price = $row->TOTAL_PRICE; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="blank"></td>
                                    <td colspan="2" class="total-line">Amount Paid</td>
                                    <td class="total-value"><textarea id="paid" name="paid"><?php echo $row->PAID_PRICE; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="blank"></td>
                                    <td colspan="2" class="total-line balance">Balance Due</td>
                                    <td class="total-value balance"><div class="due"><?php echo $due_amt; ?></div></td>
                                </tr>
                            </table>



                        </div>
                    </div>
                </div>
            <?php }
            ?>

            <input type="hidden" id="txt_total" name="txt_total" value="<?php echo $ttl_price; ?>"/>

        </div>
    </div>
    <script>
        document.getElementById('txt_validation').value = 'y';
    </script>
    <?php
}
?>