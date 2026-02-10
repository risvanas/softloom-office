<div class="row">
    <div class="col-md-12">
        <!-- start: PAYMENT VOUCHER PANEL -->
        <form id="form" method="post" action="<?php echo site_url('feecollection') ?>" onsubmit="ins_data();">
            <div class="panel panel-default m-t-2">
                <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbspFee Collection
                    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-expand"

                            href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"

                            href="#"><i class="icon-remove"></i></a> </div>
                </div>
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?>
                    </div>
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                    <h2><i class="icon-edit-sign teal"></i>&nbsp;Fee Collection</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Invoice Type<span class="symbol required"> </span></label>
                                        <select class="form-control" id="invoice_type" name="invoice_type">
                                            <option value="">Select</option>
                                            <option value="with_tax">With Tax</option>
                                            <option value="without_tax">Without Tax</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Course</label>
                                        <select class="form-control" id="txt_course" name="txt_course" onchange="load_stud_names();load_stud_details();">
                                            <option value="">Select course </option>
                                            <?php
                                            foreach ($parent_account->result() as $row) {
                                            ?>
                                                <option value="<?php echo $row->ACC_ID ?>"><?php echo $row->ACC_NAME ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group" id="h1">
                                        <label class="control-label"> Name</label>
                                        <select class="form-control" id="txt_stud_name" name="txt_stud_name" onchange="load_stud_details()">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Payment Date <span class="symbol required"> </span></label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_payment_date" id="txt_payment_date" value="<?php echo date('d-m-Y'); ?>" />
                                            <i class="icon-calendar"></i> </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Due date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_due_date" id="txt_due_date">
                                            <i class="icon-calendar"></i> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Amount <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"> Transaction Type</label>
                                        <select class="form-control" id="txt_trans_type" name="txt_trans_type" onchange="show_bank_details()">
                                            <option value="cash">CASH</option>
                                            <option value="bank">BANK</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"> Payment Type</label>
                                        <select class="form-control" id="txt_payment_type" name="txt_payment_type">
                                            <option value="single">Single</option>
                                            <option value="installment">Installment</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="display"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div id="sdetail"></div>
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
                        <div class="col-md-10">

                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-dark-beige btn-block" type="submit" id="sub_reg">Submit&nbsp;<i class="icon-circle-arrow-right"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end: ACCOUNT REGISTRATION PANEL -->
</div>

<script>
    <?php if ($msg != "") { ?>

        function ins_data() {
            document.getElementById('sub_reg').disabled = false;

        }


    <?php } ?>
</script>



<script>
    function show_bank_details() {

        $.ajax({
            type: "POST",
            data: {
                type: $('#txt_trans_type').val()
            },
            url: "<?php echo site_url('feecollection/bank_details'); ?>",
            success: function(data) {
                $('#display').html(data);
            }





        });
    }
</script>
<script>
    function load_stud_details() {
        //alert('hi');
        $.ajax({
            type: "POST",
            data: {
                sname: $('#txt_stud_name').val()
            },
            url: "<?php echo site_url('feecollection/student_details'); ?>",
            success: function(data) {
                $('#sdetail').html(data);
            }

        });
    }


    function load_stud_names() {

        $.ajax({
            type: "POST",
            data: {
                cname: $('#txt_course').val()
            },
            url: "<?php echo site_url('feecollection/student_names'); ?>",
            success: function(data) {
                $('#h1').html(data);
            }

        });
    }
</script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form-validation/fee_collection.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });

    /*jQuery(document).ready(function() {
     Main.init();
     FormValidator.init();
     FormElements.init();
     
     });
     */
</script>



<script>
    function ins_data() {
        document.getElementById('sub_reg').disabled = true;

    }
</script>