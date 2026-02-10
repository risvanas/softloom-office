<div class="row">
    <div class="col-md-12" style="padding: 15px"> 
        <!-- start: PAYMENT VOUCHER PANEL -->
        <form id="form" runat="server" method="post" action="<?php echo site_url('training_refund') ?>">
            <div class="panel panel-default">       
                <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp
                    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                      href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                                   href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                    href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                        href="#"><i class="icon-remove"></i></a> </div>
                </div>
                <div class="panel-body">




                    <div class="row">
                        <div class="col-md-12">
                            <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                                <button class="close" data-dismiss="alert"> × </button>
                                <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                            <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Course</label>
                                        <select class="form-control" id="txt_course" name="txt_course"  onchange="load_stud_names()">
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
                                <div class="col-md-8">
                                    <div class="form-group" id="h1">
                                        <label class="control-label"> Name</label>
                                        <select class="form-control" id="txt_stud_name" name="txt_stud_name" onchange="load_stud_details()">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Refund Date <span class="symbol required"> </span></label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_payment_date" id="txt_payment_date"  value="" />
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label"> Amount <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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

                        <div class="col-md-2 pull-right">
                            <button class="btn btn-primary btn-block" type="submit">Submit&nbsp;<i class="icon-circle-arrow-right"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end: ACCOUNT REGISTRATION PANEL --> 
</div>
<script>
    function show_bank_details()
    {

        $.ajax({
            type: "POST",
            data: {type: $('#txt_trans_type').val()},
            url: "<?php echo site_url('training_refund/bank_details'); ?>",
            success: function (data)
            {
                $('#display').html(data);
            }


        });
    }

</script> 
<script>
    function load_stud_details()
    {

        $.ajax({
            type: "POST",
            data: {sname: $('#txt_stud_name').val()},
            url: "<?php echo site_url('training_refund/student_details'); ?>",
            success: function (data)
            {
                $('#sdetail').html(data);
            }

        });
    }


    function load_stud_names()
    {

        $.ajax({
            type: "POST",
            data: {cname: $('#txt_course').val()},
            url: "<?php echo site_url('training_refund/student_names'); ?>",
            success: function (data)
            {
                $('#h1').html(data);
            }

        });
    }

</script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/training_refund.js"></script> 
<script>


    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });


</script> 
