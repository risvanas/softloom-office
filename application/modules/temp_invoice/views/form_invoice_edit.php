<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/invoice/css/style.css' />
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/invoice/css/print.css' media="print" />
<style>
    #items textarea {
        height: 30px;
    }
</style>
<div class="row" style="padding-top:20px;">
    <div class="col-sm-12"> 
        <!-- start: INLINE TABS PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-reorder"></i> Dashboard
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>
            <form  role="form" id="form" method="post" onsubmit="ins_data();" action="<?php  echo site_url('temp_invoice/invoice_update'); ?>" >
                <div class="panel-body">
                    <h2><i class="icon-group teal"></i> Invoice</h2>
                    <div><hr /></div>
                    <?php
                    foreach ($vno->result() as $row) {                 
                        $invoice_id = $row->INVOICE_ID;
                        $cust_id = $row->CUSTOMER_ID;
                        $query = $this->db->query("SELECT * FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");
                        $res = $query->row_array();
                        $customer_name = $res['ACC_NAME'];
                        $total_price = $row->TOTAL_PRICE;
                        $invoice_type = $row->INVOICE_TYPE;
                        $paid_price = $row->PAID_PRICE;
                        $recurring_inv = $row->INVOICE_RECURRING;
                        $recuring_type = $row->INVOICE_RECURRING_TYPE;
                        $recuring_cmnt = $row->INVOICE_RECURRING_COMMENT;
                        $next_inv_dte = $row->NEXT_INVOICE_DATE;
                        $next_inv_dte = strtotime($next_inv_dte);
                        $next_inv_dte = date("d-m-Y", $next_inv_dte);
                        $next_inv_dte = ($next_inv_dte != '01-01-1970') ? $next_inv_dte : "";
                        $due_amt = $total_price - $paid_price;
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Invoice Type<span class="symbol required"> </span></label>
                                            <select class="form-control" id="invoice_type" name="invoice_type" onchange="show_gst(this); update_gst()" readonly>
                                                <option value="">Select</option>
                                                <option value="with_tax" <?php if($invoice_type == 'with_tax') { echo "selected"; } ?>>With Tax</option>
                                                <option value="without_tax" <?php if($invoice_type == 'without_tax') { echo "selected"; } ?>>Without Tax</option>
                                            </select>
                                            <input type="hidden" name="acc_year" id="acc_year" Class="form-control" value="<?php echo $row->ACC_YEAR_CODE; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="hdd_invo_id" id="hdd_invo_id" Class="form-control" value="<?php echo $invoice_id; ?>"/>
                                            <label class="control-label"> Book Number </label>
                                            <div class="input-group">
                                                <input type="text" name="txt_buk_num" id="txt_buk_num" Class="form-control" value="<?php echo $row->BOOK_NUMBER; ?>" readonly="readonly"/>
                                                <input type="hidden" name="hdd_buk_num" id="hdd_buk_num" Class="form-control" value="<?php echo $row->BOOK_NUMBER; ?>">
                                                <input type="hidden" name="temp_voc_num" id="temp_voc_num" Class="form-control"/>
                                                <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-dark-beige" > GO </a> </span></div>
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
                                                ?>"/>
                                                <i class="icon-calendar"></i> 
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" id="h1">
                                            <label class="control-label">Customer Name <span class="symbol required"> </span> </label>
                                            <select class="form-control" id="txt_cust_name" name="txt_cust_name" onchange="load_customer_name()"  >
                                                <option value="">Select</option>
                                                <?php foreach ($cust->result() as $cst) { ?>
                                                    <option value="<?php echo $cst->ACC_ID ?>"<?php if ($cst->ACC_ID == $cust_id) echo "selected"; ?> ><?php echo $cst->ACC_NAME ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Description <span class="symbol required"> </span></label>
                                            <!--<textarea class="form-control" name="txt_des"><?php // echo $row->DESCRIPTION;  ?></textarea>-->
                                            <select class="form-control" id="txt_des" name="txt_des">
                                                <option value="">Select</option>
                                                <?php foreach ($description->result() as $des) {
                                                    $select_des = ($des->id == $row->DESCRIPTION) ? "selected" : "";
                                                    ?>
                                                    <option value="<?php echo $des->id ?>" <?php echo $select_des ?>><?php echo $des->description ?></option>
                                                <?php } ?>
                                            </select>
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
                                            <tr>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Unit Cost</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $details = $this->db->query("SELECT * FROM tbl_temp_invoicedetails WHERE INVOICE_ID='$invoice_id' AND DEL_FLAG='1'");
                                        foreach ($details->result() as $items) {
                                            $unit_cost = $items->UNIT_COST;
                                            $quantity = $items->QUANTITY;
                                            $price = $unit_cost * $quantity;
                                            ?>
                                            <tr class="item-row">
                                                <td class="item-name"><div class="delete-wpr"><textarea id="item[]" name="item[]"><?php echo $items->ITEM; ?></textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
                                                <td class="description"><textarea name="description[]"><?php echo $items->DESCRIPTION; ?></textarea></td>
                                                <td><textarea class="cost" name="cost[]"><?php echo $items->UNIT_COST; ?></textarea></td>
                                                <td><textarea class="qty" name="qty[]"><?php echo $items->QUANTITY; ?></textarea></td>
                                                <td><textarea class="price" name="price"><?php echo $price; ?></textarea></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr id="hiderow">
                                            <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line">Subtotal</td>
                                            <td class="total-value"><textarea id="subtotal" name="subtotal" readonly=""><?php echo $row->SUB_TOTAL_PRICE; ?></textarea></td>
                                        </tr>
                                        <?php if($invoice_type == 'with_tax') { ?>
                                            <tr class="hide_gst">
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">SGST Percentage</td>
                                                <?php
                                                $sgst_percent = ($row->SGST_PERCENT) ? $row->SGST_PERCENT : 9; 
                                                $cgst_percent = ($row->CGST_PERCENT) ? $row->CGST_PERCENT : 9; 
                                                $flood_cess_percent = ($row->FLOOD_CESS_PERCENT) ? $row->FLOOD_CESS_PERCENT : 1;
                                                ?>
                                                <td class="total-value"><textarea id="sgst_percent" name="sgst_percent" readonly=""><?php echo $sgst_percent; ?></textarea></td>
                                            </tr>
                                            <tr class="hide_gst">
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">CGST Percentage</td>
                                                <td class="total-value"><textarea id="cgst_percent" name="cgst_percent" readonly=""><?php echo $cgst_percent; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">Flood Cess Percentage</td>
                                                <td class="total-value"><textarea id="flood_cess_percent" name="flood_cess_percent"><?php echo $flood_cess_percent; ?></textarea></td>
                                            </tr>
                                            <tr class="hide_gst">
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">SGST</td>
                                                <td class="total-value"><textarea id="sgst" name="sgst"  readonly=""><?php echo $row->SGST_AMOUNT; ?></textarea></td>
                                            </tr>
                                            <tr class="hide_gst">
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">CGST</td>
                                                <td class="total-value"><textarea id="cgst" name="cgst" readonly=""><?php echo $row->CGST_AMOUNT; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">Flood Cess</td>
                                                <td class="total-value"><textarea id="flood_cess" name="flood_cess" readonly=""><?php echo $row->FLOOD_CESS_AMOUNT; ?></textarea></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line">Round Off</td>
                                            <td class="total-value"><textarea id="round_off" name="round_off" readonly=""><?php echo $row->ROUND_OFF; ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line">Total</td>
                                            <td class="total-value"><textarea id="total" name="total" readonly=""><?php echo $row->TOTAL_PRICE; ?></textarea></td>
                                        </tr>
    <!--                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line">Amount Paid</td>
                                            <td class="total-value"><textarea id="paid" name="paid"><?php echo $row->PAID_PRICE; ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line balance">Balance Due</td>
                                            <td class="total-value balance"><div class="due"><?php echo $due_amt; ?></div></td>
                                        </tr>-->
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Recurring Invoice <span class="symbol required"> </span></label>
                                    <select class="form-control" id="txt_recrng_inv" name="txt_recrng_inv" onchange="show_next_inv_date(this)">
                                        <option value="">Select</option>
                                        <option value="yes" <?php if ($recurring_inv == 'yes') {
                                            echo 'selected';
                                        } ?>>Yes</option>
                                        <option value="no" <?php if ($recurring_inv == 'no') {
                                            echo 'selected';
                                        } ?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 hide_rec_inv">
                                <div class="form-group">
                                    <label class="control-label">Recurring Type <span class="symbol required"> </span></label>
                                    <select class="form-control" id="txt_recrng_type" name="txt_recrng_type" onchange="calculate_next_inv_date(this)">
                                        <option value="">Select</option>
                                        <option value="month" <?php if ($recuring_type == 'month') {
                                            echo 'selected';
                                        } ?>>Month</option>
                                        <option value="year" <?php if ($recuring_type == 'year') {
                                            echo 'selected';
                                        } ?>>Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 hide_rec_inv">
                                <div class="form-group">
                                    <label class="control-label"> Next invoince Date <span class="symbol required"> </span> </label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_nxt_invoice_date" name="txt_nxt_invoice_date" value="<?php echo $next_inv_dte ?>"/>
                                        <i class="icon-calendar"></i> 
                                    </span> 
                                </div>
                            </div>
                            <div class="col-md-5 hide_rec_inv">
                                <div class="form-group">
                                    <label class="control-label"> Recurring For <span class="symbol required"> </span> </label>
                                    <textarea type="text" class="form-control" id="txt_rec_cmnt" name="txt_rec_cmnt"><?php echo $recuring_cmnt ?></textarea>
                                </div>
                            </div>
                            <!--$recuring_cmnt-->
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div> <span class="symbol required"></span> Required Fields
                                <hr />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-dark-beige btn-block" type="submit" id="sub_reg">Update &nbsp;<i class="icon-circle-arrow-right"></i> </button>
                            <input type="hidden" name="Num" id="Num" value="2" />
                        </div>
                        <div> </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end: INLINE TABS PANEL --> 
    </div>
</div>
<div id="output1"> </div>
<div id="static161" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="false">
    <div class="modal-body">
        <p> Are You sure, that you want to Submit record? </p>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
        <a type="button" class="btn btn-primary" id="modal_confirm" onclick="confirm_submit(this)"> Continue </a> </div>
</div>
<script>
    <?php if ($msg != "") { ?>

        function ins_data()
        {
//            document.getElementById('sub_reg').disabled = false;
//            if($("#form").valid()) {
//                $("#static161").modal("show");
//                return false;
//            }
        }
        
        function confirm_submit(obj = ""){
            console.log(obj)
            console.log(typeof obj)
            if(typeof obj == 'object'){
                $(obj).attr('data_clicked', true);
                $("#form").submit();
            } else {
                $(obj).attr('data_clicked', false);
            }
            console.log(obj)
        }
        
        function submit_form(){
            if($("#modal_confirm").attr('data_clicked')) {
                return true;
            } else {
                return false;
            }
        }

    <?php } ?>
</script>

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/form_invoice.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });
</script>

<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;


    }

//    document.getElementById("bttdelete").style.display = "none";
//    document.getElementById("voc_num").style.display = "none";
    function addaccount(acc_code, acc_name, acc_id)
    {
        var tbl = document.getElementById("tblstr");

        //alert(batch_id="##"+course_name)
        var Numx = document.getElementById('Num').value;
        appendRow();
        //alert("d"+Numx);
        Numx = (Number(Numx) + 1);
        document.getElementById("Num").value = Numx;
        document.getElementById("item" + Numx).value = acc_code;
        document.getElementById("description" + Numx).value = acc_name;
        document.getElementById("account_id" + Numx).value = acc_id;
        hiddenFunction();
    }

    function hiddenFunction()
    {
        var count = document.getElementById("Num").value;
        if (Number(count) <= 2)
        {
//            document.getElementById('table_batch').style.display = 'none';
        } else
        {
//            document.getElementById('table_batch').style.display = 'block';
        }

    }

    $(window).load(function ()
    {
        hiddenFunction();
        $("#txt_recrng_inv").change();
    });

    function loadData()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {name: $('#con').val()},
            url: "<?php echo site_url('temp_invoice/account_list'); ?>",
            success: function (data)
            {
                $('#output').html(data);
            }
        });
    }

    function displaydata()
    {
        $.ajax({
            type: "POST",
            data: {voc_no: $('#txt_buk_num').val()},
            url: "<?php echo site_url('temp_invoice/invoice_details'); ?>",
            success: function (data)
            {
                $('#output1').html(data);
            }
        });

    }



    function load_customer_name()
    {

        $.ajax({
            type: "POST",
            data: {cust_id: $('#txt_cust_name').val()},
            url: "<?php echo site_url('temp_invoice/customer_details'); ?>",
            success: function (data)
            {
                $('#out_put').html(data);
            }
        });

    }
    load_customer_name();

//    function ins_data()
//    {
//        document.getElementById('sub_reg').disabled = true;
//    }

    function show_next_inv_date(obj) {
        var recrng_inv = $(obj).val();
        console.log(recrng_inv)
        if (recrng_inv != 'yes') {
            $(".hide_rec_inv").hide();
//            document.getElementByClass('table_batch').style.display = 'none';
        } else {
            $(".hide_rec_inv").show();
//            document.getElementById('table_batch').style.display = 'block';
        }

    }

    function calculate_next_inv_date(obj) {
        var recrng_inv = $(obj).val();
        var date = $("#txt_invoice_date").val();
        var dString = date.split('-');
        var dt = new Date(dString[2], dString[1] - 1, dString[0]);
        var pad = function (num) {
            var s = '0' + num;
            return s.substr(s.length - 2);
        }
        if (recrng_inv == 'month') {
            var dte = addMonths(dt, 1);
            var new_dt = pad(dte.getDate()) + '-' + pad(dte.getMonth() + 1) + '-' + dte.getFullYear();
            $("#txt_nxt_invoice_date").val(new_dt)
        } else if (recrng_inv == 'year') {
            var dte = addMonths(dt, 11);
            var new_dt = pad(dte.getDate()) + '-' + pad(dte.getMonth() + 1) + '-' + dte.getFullYear();
            $("#txt_nxt_invoice_date").val(new_dt)
        }
    }

    function addMonths(date, months = 0, year = 0) {
    var d = date.getDate();
    date.setMonth(date.getMonth() + +months);
    date.setFullYear(date.getFullYear() + year);
    if (date.getDate() != d) {
        date.setDate(0);
        }
        return date;
    }

    function show_gst(obj) {
        if($(obj).val() == 'with_tax') {
            $(".hide_gst").find("#cgst_percent").html("9");
            $(".hide_gst").find("#sgst_percent").html("9");
            $(".hide_gst").show();
        } else {
            $(".hide_gst").find("input").html("");
            $(".hide_gst").hide();
        }
    }
</script>