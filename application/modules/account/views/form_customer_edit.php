<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Staff Heads
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a> 
                </div>
            </div>
            <?php
            foreach ($cust_edit->result() as $row) {
                $acc_id = $row->ACC_ID;
                $staff_name = $row->ACC_NAME;
                $address1 = $row->ADDRESS_ONE;
                $address2 = $row->ADDRESS_TWO;
                $contact = $row->PHONE;
                $email = $row->ACC_EMAIL;
//                $cust_dob = $row->CUST_DOB;
//                $cust_dob = strtotime($cust_dob);
//                $cust_dob = date("d-m-Y", $cust_dob);
//                $gender = $row->GENDER;
                $designation = $row->DESIGNATION;
                $op_balance = $row->OPENING_BALANCE;
                $contact_person = $row->CONTACT_PERSON;
                $remark = $row->REMARK;

                $gst_no = $row->TIN_NO;
                //$sta_name=$row->STATUS; 
            }
            ?>
            <form  method="post"  id="form"  action="<?php echo site_url('account/customer_update'); ?>">
                <div class="panel-body">
                    <h2><i class="icon-edit-sign teal"></i> </h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="control-label"> Customer Name <span class="symbol required"> </span> </label>
                                        <input type="hidden" name="txt_id" id="txt_acc_id" value="<?php echo $acc_id; ?>">
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cust_name" name="txt_cust_name"
                                               value="<?php echo $staff_name; ?>" />
                                    </div>
                                </div>
                            </div>
<!--                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Date Of Birth</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_staff_dobdate" id="txt_staff_dobdate" value="<?php echo $cust_dob; ?>"  />
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Gender </label>
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" value="male" <?php // if ($gender == 'male') echo "checked"; ?>  name="rad_gender" id="rad_gender" class="square-grey" />
                                                Male </label>
                                            <label class="radio-inline">
                                                <input type="radio" value="female" <?php // if ($gender == 'female') echo "checked"; ?> name="rad_gender" id="rad_gender" class="square-grey" />
                                                Female </label>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Address Line 1 <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_address1" name="txt_address1" 
                                               value="<?php echo $address1; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Address Line 2 </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_address2" name="txt_address2"
                                               value="<?php echo $address2; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Contact Number <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_contact" name="txt_contact" 
                                               value="<?php echo $contact; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Email <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_email" name="txt_email"
                                               value="<?php echo $email; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> GST Number</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_gst_no" name="txt_gst_no" value="<?php echo $gst_no ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Contact Person </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_contactperson" name="txt_contactperson" value="<?php echo $contact_person; ?>"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Openinig Balance </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_balance" name="txt_balance" value="<?php echo $op_balance; ?>"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Status </label>
                                        <span class="symbol required"> </span>
                                        <select class="form-control" id="drp_status" name="status">
                                            <option value="">Select</option>
                                            <option value="ACTIVE"<?php
                                            if ($row->STATUS == "ACTIVE") {
                                                ?> selected="selected"<?php } ?> >ACTIVE</option>
                                            <option value="INACTIVE"<?php
                                            if ($row->STATUS == "INACTIVE") {
                                                ?> selected="selected"<?php } ?>>INACTIVE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Remark <span class="symbol required"> </span> </label>
                                        <textarea class="form-control" id="txt_remark" name="txt_remark" rows="7" ><?php echo $remark; ?></textarea>
                                    </div>
                                </div>
                            </div>
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
                        <button class="btn btn-primary btn-block" type="submit"> UPDATE <i class="icon-circle-arrow-right"></i> </button>
                    </div>
                </div>

                <!-- end: DYNAMIC TABLE PANEL -->

            </form>

        </div>
    </div>
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/customer_registration.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });

</script>