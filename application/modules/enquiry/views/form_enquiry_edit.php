<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Account Heads
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>
            <?php
            foreach ($edit_data->result() as $dat) {

                $nf_date = $dat->NEXTFDATE;
                $ndate = strtotime($nf_date);
                $nextfdate = date('d-m-Y', $ndate);
                $foll = $dat->FOLLOWUPVIA;
                $enq = $dat->ENQTYPE;
                $sts = $dat->STATUS;
                $reg = $dat->REG_DATE;
                $rg = strtotime($reg);
                $regdate = date('d-m-Y', $rg);
                ?>
                <form  method="post" name="form"  id="form" role="form" action="<?php echo site_url('enquiry/update_enquiry_details'); ?>">
                    <div class="panel-body">
                        <h2><i class="icon-edit-sign teal"></i>&nbsp;Update Enquiry</h2>
                        <div>
                            <hr />
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" name="txtid" value="<?php echo $dat->EN_ID; ?>" />
                                            <label class="control-label"> Name <span class="symbol required"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_name" name="txtname" value="<?php echo $dat->NAME; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Address Line 1</label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_add1" name="txtadd1" value="<?php echo $dat->ADD1; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Address Line 2 </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_add2" name="txtadd2" value="<?php echo $dat->ADD2; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Address Line 3 </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_add3" name="txtadd3" value="<?php echo $dat->ADD3; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Phone No<span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_phno" name="txtphno" value="<?php echo $dat->PHNO; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Mobile No</label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_mobileno" name="txtmobileno" value="<?php echo $dat->MOBILENO; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Email-Id</label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_mail" name="txtemail" value="<?php echo $dat->EMAIL; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">College</label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_college" name="txtcollege" value="<?php echo $dat->COLLEGE; ?>"/>
                                        </div>
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
                                                    <option value="<?php echo $field->id; ?>"<?php if (($field->id) == $foll) echo "selected"; ?>> <?php echo $field->methods; ?>
                                                    <?php } ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Enquiry For<span class="symbol required"> </span></label>
                                            <select class="form-control" id="txt_enqtype" name="txtenqtype">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($enquiry_for->result() as $row) {
                                                    ?>
                                                    <option value="<?php echo $row->ACC_ID; ?>"
                                                            <?php if (($row->ACC_ID) == $enq) echo "selected" ?>> <?php echo $row->ACC_NAME; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                            <?php echo form_error('txtenqtype'); ?> </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Status<span class="symbol required"></span></label>
                                            <select class="form-control" id="txt_status" name="txtstatus">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($data_status->result() as $row) {
                                                    ?>
                                                    <option value="<?php echo $row->id; ?>" <?php if (($row->id) == $sts) echo "selected" ?>><?php echo $row->status; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <?php echo form_error('txtstatus'); ?> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" >Registration Date</span></label>
                                            <?php
                                            if (($reg == "") || ($reg == "0000-00-00") || ($reg == "1970-01-01")) {
                                                ?>
                                                <span class="input-icon input-icon-right">
                                                    <input autocomplete="off" type="text" class="form-control date-picker" name="txtregdate" value="">
                                                    <i class="icon-calendar"></i> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="input-icon input-icon-right">
                                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtregdate" value="<?php echo $regdate; ?>">
                                                    <i class="icon-calendar"></i> </span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Next Followup_Date</label>
                                            <?php
                                            if (($nf_date == "") || ($nf_date == "0000-00-00") || ($nf_date == "1970-01-01")) {
                                                ?>
                                                <span class="input-icon input-icon-right">
                                                    <input autocomplete="off" type="text" class="form-control date-picker" name="txtnfdate" value="<?php echo ""; ?>">
                                                    <i class="icon-calendar"></i> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="input-icon input-icon-right">
                                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" datas-date-viewmode="years" class="form-control date-picker" name="txtnfdate" value="<?php echo $nextfdate; ?>">
                                                    <i class="icon-calendar"></i> </span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Description</label>
                                            <textarea name="txtdesp" rows="11" disabled="disabled" class="form-control" id="txt_desp"><?php echo $dat->DESCRIPTION; ?></textarea>
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
                                <button class="btn btn-primary btn-block" type="submit">Update&nbsp;<i class="icon-circle-arrow-right"></i> </button>
                            </div>
                        </div>
                    </div>

                    <!-- end: DYNAMIC TABLE PANEL -->

                </form>
            <?php } ?>
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
