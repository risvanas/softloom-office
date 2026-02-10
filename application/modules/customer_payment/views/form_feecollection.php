 <style>
    .hide_tds_amt {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12"> 
        <!-- start: PAYMENT VOUCHER PANEL -->
        <form id="form"  method="post" action="<?php echo site_url('customer_payment') ?>">
            <div class="panel panel-default">
                <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Customer Payment
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                    </div>
                </div>
                <div class="panel-body" >
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                    <div id="voc_num" class="successHandler alert alert-danger"><?php echo $errmsg = "Not found"; ?></div>
                    <h2><i class="icon-edit-sign teal"></i>&nbsp;Customer Payment</h2>
                    <div>
                        <hr>
                    </div>
                    <div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Book Number </label>
                                            <?php
                                            $sess_array = $this->session->userdata('logged_in');
                                            $year_code = $sess_array['accounting_year'];
                                            $company_code = $sess_array['comp_code'];
                                            $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PAYD' and COMPANY='$company_code' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1");
                                            $row = $query->row_array();
                                            $book_num = $row['BOOK_NUMBER'];
                                            ?>
                                            <div class="input-group">
                                                <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $book_num; ?>"/>
                                                <input type="hidden" name="temp_voc_num" id="temp_voc_num" Class="form-control"/>
                                                <input type="hidden" name="acc_year" id="acc_year" Class="form-control" value="<?php echo $year_code ?>"/>
                                                <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-dark-beige" onclick="displaydata()"> GO </a> </span> </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="h1">
                                            <label class="control-label"> Name <span class="symbol required"> </span></label>
                                            <select class="form-control" id="txt_cust_name" name="txt_cust_name" onchange="load_cust_details()"  onfocus="load_cust_details()">
                                                <option value="">Select</option>
                                                <?php foreach ($cust->result() as $row) { ?>
                                                    <option value="<?php echo $row->ACC_ID ?>"><?php echo $row->ACC_NAME ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="btn_refresh" style="display:none;">
                                        <div class="form-group">
                                            <label class="control-label"> &nbsp;</label>
                                            <a href="<?php echo site_url('customer_payment'); ?>"><button class="btn btn-dark-beige btn-block" type="button">Refresh&nbsp;<i class="icon-circle-arrow-right"></i> </button></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">        
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Payment Date <span class="symbol required"> </span></label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_payment_date" id="txt_payment_date"  value="<?php echo date('d-m-Y'); ?>"/>
                                                <i class="icon-calendar"></i> </span> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Due date</label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_due_date" id="txt_due_date">
                                                <i class="icon-calendar"></i> </span> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Amount <span class="symbol required"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Transaction Type</label>
                                            <select class="form-control"  id="txt_trans_type" name="txt_trans_type" onchange="show_bank_details()" >
                                                <option value="cash" >CASH</option>
                                                <option value="bank">BANK</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="display"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label"> Remark </label>
                                            <textarea class="form-control" id="txt_remark" name="txt_remark" rows="1" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div id="sdetail"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div> <span class="symbol required"></span>Required Fields
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p></p>
                            </div>
                            <div class="col-md-2"> <a id='bttdelete' href="#static"  class="btn btn-dark-beige btn-block" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </div>
                            <div class="col-md-2">
                                <a class="btn btn-dark-beige btn-block" id="print_btn" onclick="generate_pdf();">Print&nbsp;<i class="clip-file-pdf"></i> </a>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-dark-beige btn-block" type="submit" id="submit_btn"> Submit <i class="icon-circle-arrow-right"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="submit_confirm" class="modal fade" tabindex="-1" data-backdrop="submit_confirm" data-keyboard="false" style="display: none;">
                <div class="modal-body">
                    <p> Are You sure, that you want to submit record? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                    <button class="btn btn-primary" type="submit" id="confirm_submit"> Continue </button>
                </div>
            </div>
        </form>
        <div id="output1"> 

        </div>
        <div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
            <div class="modal-body">
                <p> Are You sure, that you want to delete selected record? </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                <a id="hrefdelete" name="hrefdelete" type="button"  class="btn btn-primary"> Continue </a> </div>
        </div>
        <!-- end: ACCOUNT REGISTRATION PANEL --> 
    </div>
</div>

<form id="gen_pdf" name="gen_pdf" target="_blank" method="post" action="<?php echo site_url('customer_payment/select_data'); ?>">
    <input type="hidden" value="generate_pdf" name="generate_pdf">
    <input type="hidden" value="" id="voc_no" name="voc_no">
    <input type="hidden" value="" id="accounting_year" name="accounting_year">
    <input type="submit" value="submit" style="display: none;" id="gen_pdf_submit" />
</form>

<script>
    document.getElementById("bttdelete").style.display = "none";
    document.getElementById("print_btn").style.display = "none";
    document.getElementById("voc_num").style.display = "none";
    function show_bank_details() {

        $.ajax({
            type: "POST",
            data: {type: $('#txt_trans_type').val()},
            url: "<?php echo site_url('customer_payment/bank_details'); ?>",
            success: function (data)
            {
                $('#display').html(data);
            }

        });
    }

    function show_bank_details_edit(TYPE, chq_no, chq_date, acc_no, bank, tds, tds_amt) {
        // alert(TYPE);
        $.ajax({
            type: "POST",
            data: {type: TYPE},
            url: "<?php echo site_url('customer_payment/bank_details'); ?>",
            success: function (data)
            {
                $('#display').html(data);
                if (TYPE == 'bank')
                {
                    document.getElementById("txt_cheque_no").value = chq_no;
                    document.getElementById("txt_cheque_date").value = chq_date;
                    document.getElementById("txt_accnt_no").value = acc_no;
                    document.getElementById("sel_acc_type").value = bank;
                    document.getElementById("sel_tds").value = tds;
                    document.getElementById("txt_tds_amt").value = tds_amt;
                    $("#sel_tds").change();
                }
            }

        });

    }


    function load_cust_details() {
//alert("hi");
        $.ajax({
            type: "POST",
            data: {type: $('#txt_cust_name').val()},
            url: "<?php echo site_url('customer_payment/customer_details'); ?>",
            success: function (data)
            {

                $('#sdetail').html(data);
            }

        });
    }

</script> 
<script>
    function displaydata() {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {
                voc_no: $('#conn').val(),
                accounting_year: $('#acc_year').val(),
            },
            url: "<?php echo site_url('customer_payment/select_data'); ?>",
            success: function (data)
            {
                $('#output1').html(data);
            }
        });
    }

    function generate_pdf() {
        $("#voc_no").val($('#conn').val());
        $("#accounting_year").val($('#acc_year').val());
        var gen_pdf_form = document.forms.gen_pdf;
        gen_pdf_form.submit();
    }

    function show_tds_amt(obj) {
        var tds = $(obj).val();
        console.log(tds)
        if (tds != 'yes') {
            $(".hide_tds_amt").hide();
        } else {
            $(".hide_tds_amt").show();
        }

    }
</script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/fee_collection.js"></script> 
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();
        
        jQuery("#submit_btn").click(function(e) {
            e.preventDefault();
            console.log(jQuery("#form").valid())
            if(jQuery("#form").valid()) {
                jQuery("#submit_confirm").modal("show");
            }
        });
        
        jQuery("#confirm_submit").click(function(e) {
            e.preventDefault();
            console.log(jQuery("#form").valid())
            jQuery("#form").submit() 
        })

    });
</script> 
