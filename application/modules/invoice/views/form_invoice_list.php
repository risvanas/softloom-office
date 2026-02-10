<div class="row" style="padding-top:20px;">
    <div class="col-md-12">
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Invoice List
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>

            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="col-md-12">
                <h1>Invoice List<small></small></h1>
                <hr />
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> From Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from" />
                                <i class="icon-calendar"></i> </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> To Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to" />
                                <i class="icon-calendar"></i> </span>
                        </div>
                    </div>
                    <?php
                    $sess_array = $this->session->userdata('logged_in');
                    $user_type = $sess_array['user_type'];
                    $company_code = $sess_array['comp_code'];
                    if ($user_type == 'ADMIN') {
                    ?>
                        <!--                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> Company</label>
                            <select name="company_code" id="company_code" class="form-control">
                                <option value="">Select</option>
                                <?php
                                //                                foreach ($company->result() as $key => $value) {
                                //                                    echo "<option value='" . $value->ID . "'>" . $value->COMP_NAME . "</option>";
                                //                                }
                                ?>
                            </select>
                        </div>
                    </div>-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label"> Invoice Type</label>
                                <select name="invoice_type" id="invoice_type" class="form-control">
                                    <option value="">All</option>
                                    <option value="with_tax" selected="">With Tax</option>
                                    <option value="without_tax">Without Tax</option>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="invoice_type" id="invoice_type" value="with_tax">
                    <?php } ?>

                    <div class="col-md-3">
                        <label for="form-field-mask-1"> Key Words </label>
                        <!-- <div class="input-group"> -->
                        <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_key_words" id="txt_key_words">
                        <!-- < span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Go! </button>
                            </span> < /div>-->
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button class="btn btn-primary btn-block" type="button" onclick="search_data()"> Search </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div id="output">
                    <table class="table table-striped table-bordered table-hover table-full-width">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th style="min-width: 80px"> Invoice Date </th>
                                <th> Customer Name </th>
                                <th>Temporary Invoice No</th>
                                <th>Invoice Value</th>
                                <th>Tax Value</th>
                                <th>Flood Cess Amount</th>
                                <th>Total Price </th>
                                <th style="width:110px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn_count = 1;
                            $this->load->library('encryption');
                            foreach ($list->result() as $row) {
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

                                    $encryptedInvoiceId = encrypt($row->INVOICE_ID);
                                    ?>
                                    <td><a href="<?php echo site_url('invoice/print_invoice') . $encrypted_data . "/$accounting_year" . "/$encryptedInvoiceId"; ?> " target="_blank"> <?php echo $book_name . $book_number . "/" . $from_date . "-" . $to_date; ?></a></td>
                                    <td><?php
                                        $invoice_date = $row->INVOICE_DATE;
                                        $invoice_date = strtotime($invoice_date);
                                        echo $invoice_date = date("d-m-Y", $invoice_date);
                                        ?></td>
                                    <td><?php echo $customer_name; ?></td>
                                    <td><?php echo ($row->TEMP_INVOICE_ID != "") ? 'TEMP' . $row->TEMP_INVOICE_ID : ""; ?></td>
                                    <td><?php echo $row->SUB_TOTAL_PRICE; ?></td>
                                    <td><?php echo $row->SGST_AMOUNT + $row->CGST_AMOUNT; ?></td>
                                    <td><?php echo $row->FLOOD_CESS_AMOUNT; ?></td>
                                    <td><?php echo $row->TOTAL_PRICE; ?></td>
                                    <td class="">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                                            <button onclick="" data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li> <a href="<?php echo site_url('invoice/print_invoice') . $encrypted_data . "/$accounting_year" . "/$encryptedInvoiceId"; ?> " target="_blank"> <i class="icon-print"></i> Print </a> </li>
                                                <li> <a href="<?php echo site_url('invoice/invoice_edit') . $encrypted_data . "/$accounting_year" . "/$encryptedInvoiceId"; ?> " target="_blank"> <i class="icon-pencil"></i> Edit </a> </li>
                                                <li> <a href="<?php echo site_url('invoice/invoice_delete') . $encrypted_data . "/$accounting_year" . "/$encryptedInvoiceId"; ?> " target="_blank"> <i class="icon-trash"></i> Delete </a> </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>



                            <?php
                                $sn_count++;
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- end: DYNAMIC TABLE PANEL -->
    </div>
</div>

<!-- end: PAGE HEADER -->
<script>
    function search_data() {
        $.ajax({
            type: "POST",
            data: {
                calc: $('#txt_from').val(),
                dat: $('#txt_to').val(),
                key_words: $('#txt_key_words').val(),
                inv_type: $('#invoice_type').val(),
            },
            url: "<?php echo site_url('invoice/mult_search'); ?>",
            success: function(data) {
                $('#output').html(data);
            }
        });
    }
</script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        FormElements.init();

    });
</script>