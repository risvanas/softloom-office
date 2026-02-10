<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/invoice/css/style.css' />
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/invoice/css/print.css' media="print" />
<style>
    .hide_rec_inv,.hide_gst {
        display: none;
    }
    #items textarea {
        height: 30px;
    }
</style>
<div class="row" style="padding-top:20px;">
    <div class="col-sm-12"> 
        <!-- start: INLINE TABS PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-reorder"></i> Temporary Invoice
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> 
                    <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a>
                </div>
            </div>
            <form  role="form" id="form" method="post"  onsubmit="ins_data();"><!--action="<?php // echo site_url('invoice');  ?>"-->
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                        <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                        <h2><i class="icon-group teal"></i> Temporary Invoice</h2>
                        <div><hr /></div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Invoice Type<span class="symbol required"> </span></label>
                                            <select class="form-control" id="invoice_type" name="invoice_type" onchange="show_gst(this); update_gst()">
                                                <option value="">Select</option>
                                                <option value="with_tax">With Tax</option>
                                                <option value="without_tax">Without Tax</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Book Number </label>
                                            <?php
                                            $sess_arr = $this->session->userdata('logged_in');
                                            $accounting_year = $sess_arr['accounting_year'];
                                            $company = $sess_arr['comp_code'];
                                            $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_temp_invoice WHERE ACC_YEAR_CODE=$accounting_year and DEL_FLAG=1 and COMPANY='$company' and INVOICE_TYPE='with_tax'");
                                            $row = $query->row_array();
                                            $book_num = $row['BOOK_NUMBER'];
                                            ?>
                                            <div class="input-group">
                                                <input type="text" name="txt_buk_num" id="txt_buk_num" Class="form-control" value="<?php echo $book_num; ?>" readonly="readonly"/>
                                                <input type="hidden" name="temp_voc_num" id="temp_voc_num" Class="form-control"/>
                                                <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-dark-beige"> GO </a> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label"> Invoice Date <span class="symbol required"> </span> </label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_invoice_date" name="txt_invoice_date" value=""/>
                                                <i class="icon-calendar"></i> 
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" id="h1">
                                            <label class="control-label">Customer Name <span class="symbol required"> </span></label>
                                            <select class="form-control" id="txt_cust_name" name="txt_cust_name" onchange="load_customer_name()">
                                                <option value="">Select</option>
                                                <?php foreach ($cust->result() as $row) { ?>
                                                    <option value="<?php echo $row->ACC_ID ?>"><?php echo $row->ACC_NAME ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Description <span class="symbol required"> </span></label>
                                            <!--<textarea class="form-control" name="txt_des" id="txt_des"></textarea>-->
                                            <select class="form-control" id="txt_des" name="txt_des">
                                                <option value="">Select</option>
                                                <?php foreach ($description->result() as $row) { ?>
                                                    <option value="<?php echo $row->id ?>"><?php echo $row->description ?></option>
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
                                        <tr class="item-row">
                                            <td class="item-name"><div class="delete-wpr">
                                                <textarea id="item[]" name="item[]"></textarea>
                                                <a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
                                                <td class="description"><textarea id="description[]" name="description[]"></textarea></td>
                                                <td><textarea id="cost[]" name="cost[]" class="cost">0.00</textarea></td>
                                                <td><textarea id="qty[]" name="qty[]" class="qty">1</textarea></td>
                                                <td><span class="price">0.00</span></td>
                                            </tr>

                                            <tr id="hiderow">
                                                <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">Subtotal</td>
                                                <td class="total-value"><textarea id="subtotal" name="subtotal" readonly="">0.00</textarea></td>
                                            </tr>
                                            <tr class="hide_gst">
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">SGST Percentage</td>
                                                <td class="total-value"><textarea id="sgst_percent" name="sgst_percent" readonly="">9</textarea></td>
                                            </tr>
                                            <tr class="hide_gst">
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">CGST Percentage</td>
                                                <td class="total-value"><textarea id="cgst_percent" name="cgst_percent" readonly="">9</textarea></td>
                                            </tr>
                                            <tr class="hide_gst">
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">SGST</td>
                                                <td class="total-value"><textarea id="sgst" name="sgst"  readonly="">0.00</textarea></td>
                                            </tr>
                                            <tr class="hide_gst">
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">CGST</td>
                                                <td class="total-value"><textarea id="cgst" name="cgst" readonly="">0.00</textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">Round Off</td>
                                                <td class="total-value"><textarea id="round_off" name="round_off" readonly="">0.00</textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="blank"></td>
                                                <td colspan="2" class="total-line">Total</td>
                                                <td class="total-value"><textarea id="total" name="total" readonly="">0.00</textarea></td>
                                            </tr>
<!--                                    <tr>
                                        <td colspan="2" class="blank"></td>
                                        <td colspan="2" class="total-line">Amount Paid</td>
                                        <td class="total-value"><textarea id="paid" name="paid">o.oo</textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="blank"></td>
                                        <td colspan="2" class="total-line balance">Balance Due</td>
                                        <td class="total-value balance"><div class="due">0.00</div></td>
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
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 hide_rec_inv">
                            <div class="form-group">
                                <label class="control-label">Recurring Type <span class="symbol required"> </span></label>
                                <select class="form-control" id="txt_recrng_type" name="txt_recrng_type" onchange="calculate_next_inv_date(this)">
                                    <option value="">Select</option>
                                    <option value="month">Month</option>
                                    <option value="year">Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 hide_rec_inv">
                            <div class="form-group">
                                <label class="control-label"> Next invoince Date <span class="symbol required"> </span> </label>
                                <span class="input-icon input-icon-right">
                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_nxt_invoice_date" name="txt_nxt_invoice_date" value=""/>
                                    <i class="icon-calendar"></i> 
                                </span> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-5 hide_rec_inv">
                            <div class="form-group">
                                <label class="control-label"> Recurring For <span class="symbol required"> </span> </label>
                                <textarea type="text" class="form-control" id="txt_rec_cmnt" name="txt_rec_cmnt"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div> <span class="symbol required"></span> Required Fields
                                <hr />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-dark-beige btn-block" type="submit" id="sub_reg">Submit &nbsp;<i class="icon-circle-arrow-right"></i> </button>
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
        function ins_data()
        {
            <?php if ($msg != "") { ?>
                document.getElementById('sub_reg').disabled = false;
            <?php } ?>
            if (document.getElementById("form_id").valid()) {
                console.log("aaaaaaaaaaaaaa");
            }
        }
        function confirm_submit(obj = ""){
            console.log(obj)
            console.log(typeof obj)
            if (typeof obj == 'object'){
                $(obj).attr('data_clicked', true);
                $("#form").submit();
            } else {
                $(obj).attr('data_clicked', false);
            }
            console.log(obj)
        }

        function submit_form(){
            if ($("#modal_confirm").attr('data_clicked')) {
                return true;
            } else {
                return false;
            }
        }
    </script>


    <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
    <script src="<?php echo base_url(); ?>assets/js/form-validation/form_invoice.js"></script> 
    <script>

        jQuery(document).ready(function () {
            Main.init();
            FormValidator.init();
            UIModals.init();
            FormElements.init();
        });</script>

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
function addaccount(acc_code, acc_name, acc_id) {
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

        function hiddenFunction() {
            var count = document.getElementById("Num").value;
//        if (Number(count) <= 2)
//        {
//            document.getElementById('table_batch').style.display = 'none';
//        } else
//        {
//            document.getElementById('table_batch').style.display = 'block';
//        }

}

$(window).load(function () {
    hiddenFunction();
});
function loadData() {
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

        function displaydata() {
    //alert("hai");
    $.ajax({
        type: "POST",
        data: {voc_no: $('#txt_buk_num').val()},
        url: "<?php echo site_url('temp_invoice/invoice_details'); ?>",
        success: function (data) {
            $('#output1').html(data);
        }
    });
}



function load_customer_name() {

    $.ajax({
        type: "POST",
        data: {cust_id: $('#txt_cust_name').val()},
        url: "<?php echo site_url('temp_invoice/customer_details'); ?>",
        success: function (data) {
            $('#out_put').html(data);
        }
    });
}


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
    date.setMonth(date.getMonth() + + months);
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


