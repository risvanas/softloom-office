<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Leave Edit
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
<!--                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>-->
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <?php
            foreach ($leave_edit->result() as $row) {
                $id = $row->ID;
                $staff_id = $row->STAFF_ID;
                $leave_date = $row->LEAVE_DATE;
                $leave_date = strtotime($leave_date);
                $leave_date = date("d-m-Y", $leave_date);
                $leave_type = $row->LEAVE_TYPE;
                $reason = $row->REASON;
            }
            ?>
            <form  role="form" id="form" method="post" action="<?php echo site_url('leave/leave_update'); ?>">
                <div class="panel-body" >
                    <h2><i class="icon-edit-sign teal"></i> Model Edit</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <!--<label class="control-label"> MODEL <span class="symbol required"> </span> </label>-->
                                <input type="hidden" name="txt_id" id="txt_id" value="<?php echo $id; ?>">
                                <label class="control-label"> Staff Name <span class="symbol required"> </span> </label>
                                <select name="txt_staff" id="txt_staff" class="form-control">
                                    <option value="">Select</option>
                                    <?php foreach ($staff_list->result() as $key => $value) {
                                        $selected = ($value->ACC_ID == $staff_id) ? 'selected' : ''?>
                                        <option value="<?php echo $value->ACC_ID ?>" <?php echo $selected ?>><?php echo $value->ACC_NAME ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
<!--                    </div>
                    <div class="row">-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"> Date <span class="symbol required"> </span> </label>
                                <span class="input-icon input-icon-right">
                                    <input type="text" autocomplete="off" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="leave_date" name="leave_date" value="<?php echo $leave_date ?>"/>
                                    <i class="icon-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"> Leave Type <span class="symbol required"> </span> </label>
                                <select id="leave_type" name="leave_type" value="" class="form-control">
                                    <option value="">Select</option>
                                    <option value="half" <?php if($leave_type=='0.5'){echo "selected";} ?>>Half day</option>
                                    <option value="full" <?php if($leave_type=='1'){echo "selected";} ?>>Full day</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"> Reason <span class="symbol required"> </span> </label>
                                <textarea name="leave_reason" id="leave_reason" class="form-control"><?php echo $reason ?></textarea>
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
                            <p> </p>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block" type="submit"> Update <i class="icon-circle-arrow-right"></i> </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- end: DYNAMIC TABLE PANEL --> 

        </div>
    </div>
</div>
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/staff_registration.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });

    function change_district()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {state: $('#txt_state').val()},
            url: "<?php echo site_url('account/change_district'); ?>",
            success: function (data)
            {
                data = jQuery.parseJSON(data);
                var option = '<option value="">Select</option>';
                $.each(data, function (index, value) {
                    option += '<option value="' + value['DIS_ID'] + '">' + value['DISTRICT'] + '</option>';
                });
                $("#txt_district").html(option);
            }
        });
    }
</script>