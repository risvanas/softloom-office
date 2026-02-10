<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Account Heads
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a> 
                </div>
            </div>
            <form  method="post" name="form"  id="form" role="form" action="<?php echo site_url('enquiry'); ?>">
                <div class="panel-body"> 
                    <!---------------------------- Start msg display --------------------------------------->
                    <div class="errorHandler alert alert-danger no-display"> <i class="icon-remove-sign"></i> You have some form errors. Please check below. </div>
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> <i class="icon-ok"></i> <?php echo $msg; ?> 

                        <!-- -------------------------- End msg display ---------------------------------------> 
                    </div>
                    <h2><i class="icon-edit-sign teal"></i>&nbsp;Enquiry</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Name <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_name" name="txtname"/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Address Line 1 </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_add1" name="txtadd1" value=""/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Address Line 2 </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_add2" name="txtadd2" value=""/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Address Line 3 </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_add3" name="txtadd3" value=""/>
                                        <?php echo form_error('txtadd3'); ?> </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Phone No<span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_phno" name="txtphno" value=""/>
                                        <?php echo form_error('txtphno'); ?> </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Mobile No</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_mobileno" name="txtmobileno" value=""/>
                                        <?php echo form_error('txtmobileno'); ?> </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Email-Id</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_mail" name="txtemail" value=""/>
                                        <?php echo form_error('txtemail'); ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Enquiry From<span class="symbol required"></span> </label>
                                        <?php echo form_error('txtfollowupvia'); ?>
                                        <select class="form-control" id="txt_followupvia" name="txtfollowupvia">
                                            <option value="">Select</option>
                                            <?php foreach ($followup->result() as $field) { ?>
                                                <option value="<?php echo $field->id; ?>"><?php echo $field->methods; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Enquiry For<span class="symbol required"> </span></label>
                                        <select class="form-control" id="txt_enqtype" name="txtenqtype">
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($enquiry_for->result() as $row) {
                                                ?>
                                                <option value="<?php echo $row->ACC_ID; ?>"><?php echo $row->ACC_NAME; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('txtenqtype'); ?> </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Status<span class="symbol required"> </span> </label>
                                        <select class="form-control" id="txt_status" name="txtstatus">
                                            <?php
                                            foreach ($data_status->result() as $row) {
                                                ?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->status; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('txtstatus'); ?> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Next Followup_Date </label>
                                        <?php echo form_error('txtnfdate'); ?> <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtnfdate" value=""id="con" onchange="loadData()">
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" > Registration Date</label>
                                        <?php echo form_error('txtregdate'); ?> <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtregdate" value="<?php echo date('d-m-Y'); ?>">
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" id="txt_desp" name="txtdesp" rows="11"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <button class="btn btn-primary btn-block" type="submit">Register&nbsp;<i class="icon-circle-arrow-right"></i> </button>
                        </div>
                    </div>
                </div>

                <!-- end: DYNAMIC TABLE PANEL -->

            </form>
        </div>
    </div>
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/enquiry.js"></script> 
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });
</script> 
