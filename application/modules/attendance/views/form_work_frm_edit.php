<?php foreach ($selected_data->result() as $row) {
    $date = $row->DATE;
    $date = strtotime($date);
    $date = date("d-m-Y", $date);
    $punch_in = $row->punch_in;
    $punch_in_tme = (strtotime($punch_in)) ? date('h:i A', strtotime($punch_in)) : '00:00:00';
    $punch_out = $row->punch_out;
    $punch_out_tme = (strtotime($punch_out)) ? date('h:i A', strtotime($punch_out)) : '00:00:00';
    $staff = $row->tktno;
} ?>

<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Work From Home Edit
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a> 
                </div>
            </div>
            <form  method="post" name="form" action="<?php echo site_url('attendance/wrk_at_hme_edit'); ?>" id="form">
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> <button class="close" data-dismiss="alert">
                            ×
                        </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
<!--                    <h2><i class="icon-edit-sign teal"></i> Work From Home Form</h2>
                    <div>
                        <hr />
                    </div>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Staff <span class="symbol required"> </span> </label>
                                        <input type="hidden" id="txt_id" name="txt_id" value="<?php echo $id ?>">
                                        <select class="form-control" id="txt_staff" name="txt_staff">
                                            <option value="">Select</option>
                                            <?php foreach ($staff_list->result() as $key => $value) { 
                                                $selected = ($value->BIOMETRIC_CODE == $staff) ? "selected" : "" ?>
                                                <option value="<?php echo $value->BIOMETRIC_CODE ?>" <?php echo $selected ?>><?php echo $value->ACC_NAME ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_date" name="txt_date" value="<?php echo $date ?>">
                                            <i class="icon-calendar"></i> 
                                        </span> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> From </label>
                                        <div class="input-group input-append bootstrap-timepicker">
                                            <input autocomplete="off" type="text" class="form-control time-picker" name="txt_from_time" id="txt_from_time" value="<?php echo $punch_in_tme ?>">
                                            <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> To </label>
                                        <div class="input-group input-append bootstrap-timepicker">
                                            <input autocomplete="off" type="text" class="form-control time-picker" name="txt_to_time" id="txt_to_time" value="<?php echo $punch_out_tme ?>">
                                            <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div> <span class="symbol required"></span>Required Fields
                                        <hr />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <p> </p>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-block" type="submit"> Update <i class="icon-circle-arrow-right"></i> </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- end: DYNAMIC TABLE PANEL --> 
                </div>
            </form>
        </div>
    </div>
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
</div>


<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/account_year_registration.js"></script> 


<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });


</script> 