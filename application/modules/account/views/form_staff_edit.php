<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Staff Edit
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
<!--                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>-->
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <?php
            //$id=$row->ACC_ID;
            foreach ($staff_edit->result() as $row) {
                $acc_id = $row->ACC_ID;
                $staff_name = $row->ACC_NAME;
                $address1 = $row->ADDRESS_ONE;
                $address2 = $row->ADDRESS_TWO;
                $contact = $row->PHONE;
                $email = $row->ACC_EMAIL;
                $gender = $row->GENDER;
                $cust_dob = $row->CUST_DOB;
                $cust_dob = strtotime($cust_dob);
                $cust_dob = date("d-m-Y", $cust_dob);
                $cust_dob = ($cust_dob != '01-01-1970') ? $cust_dob : "";
                $designation = $row->DESIGNATION;
                $remark = $row->REMARK;
                $salary = $row->SALARY;
                $sta_name = $row->STATUS;
                $username = $row->USER_NAME;
                $password = $row->PASSWORD;
                $exp_yr = $row->YEAR_OF_EXPRIANS;
                $join_date = $row->JOINING_DATE;
                $join_date = strtotime($join_date);
                $join_date = date("d-m-Y", $join_date);
                $join_date = ($join_date != '01-01-1970') ? $join_date : "";
                $inactive_date = $row->INACTIVE_DATE;
                $inactive_date = strtotime($inactive_date);
                $inactive_date = date("d-m-Y", $inactive_date);
                $inactive_date = ($inactive_date != '01-01-1970') ? $inactive_date : "";
                $exp_mnth = $row->MNTH_OF_EXPRIANS;
                $staff_mode = $row->STAFF_MODE;
                $staff_code = $row->ACC_CODE;
                $biometric_code = $row->BIOMETRIC_CODE;
            }
            ?>
            <form  method="post"  id="form"  action="<?php echo site_url('account/staff_update'); ?>" enctype='multipart/form-data'>
                <div class="panel-body">
<!--                    <h2><i class="icon-edit-sign teal"></i> </h2>
                    <div>
                        <hr />
                    </div>-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="control-label"> Staff Name <span class="symbol required"> </span> </label>
                                        <input type="hidden" name="txt_id" id="txt_acc_id" value="<?php echo $acc_id; ?>">
                                        <input autocomplete="off" type="text" class="form-control" id="txt_staff_name" name="txt_staff_name" value="<?php echo $staff_name; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label"> Staff Type <span class="symbol required"> </span> </label>
                                        <select class="form-control" id="staff_mode" name="staff_mode" onchange="show_inactive_date()">
                                            <option value="">Select</option>
                                            <option value="managing_partner" <?php if ($staff_mode == "managing_partner") { echo "selected"; } ?>>Managing Partner</option>
                                            <option value="employee" <?php if ($staff_mode == "employee") { echo "selected"; } ?>>Employee</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Staff Code </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_staff_code" name="txt_staff_code" value="<?php echo $staff_code ?>" />  

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Biometric Code <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_staff_bio" name="txt_staff_bio" value="<?php echo $biometric_code ?>" />  

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Date Of Birth</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_staff_dobdate" id="txt_staff_dobdate" value="<?php echo $cust_dob ?>"  />
                                            <i class="icon-calendar"></i>
                                        </span> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Gender </label>
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" value="male"<?php
                                                if ($gender == "male") {
                                                    echo "checked";
                                                }
                                                ?> name="rad_gender" id="rad_gender" class="square-grey" />
                                                Male </label>
                                            <label class="radio-inline">
                                                <input type="radio" value="female"<?php
                                                if ($gender == "female") {
                                                    echo "checked";
                                                }
                                                ?>  name="rad_gender" id="rad_gender" class="square-grey" />
                                                Female </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Address Line 1 <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_address1" name="txt_address1"  value="<?php echo $address1; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Address Line 2  </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_address2" name="txt_address2" value="<?php echo $address2; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Contact Number <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_contact" name="txt_contact" value="<?php echo $contact; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Email <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_email" name="txt_email" value="<?php echo $email; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> User Name </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_username" name="txt_username" value="<?php echo $username; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Password <span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="password" class="form-control" id="txt_password" name="txt_password"  value="<?php echo $password; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Designation  <span class="symbol required"> </span></label>
                                        <select class="form-control"  id="txt_staff_desi" name="txt_staff_desi">
                                            <?php foreach ($desi->result() as $row) {
                                                ?>
                                                <option value="<?php echo $row->id; ?>"<?php if (($row->id) == $designation) echo "selected"; ?>>
                                                    <?php echo $row->designation; ?> </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Year of experience </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_staff_year" name="txt_year" value="<?php echo $exp_yr ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Month of experience </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_staff_month" name="txt_staff_month" value="<?php echo $exp_mnth ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Joining Date  </label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_staff_jdate" name="txt_staff_jdate"  value="<?php echo $join_date ?>"/>
                                            <i class="icon-calendar"></i> 
                                        </span> 
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="control-label"> Status  <span class="symbol required"> </span> </label>
                                        <select class="form-control" id="drp_status" name="status" onchange="show_inactive_date()">
                                            <option value="">Select</option>
                                            <option value="ACTIVE" <?php
                                            if ($sta_name == "ACTIVE") {
                                                echo "selected";
                                                ?><?php } ?>>ACTIVE</option>
                                            <option value="INACTIVE" <?php
                                            if ($sta_name == "INACTIVE") {
                                                echo "selected";
                                                ?> <?php } ?>>INACTIVE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="display: none">
                                        <label class="control-label"> Date of inactive  </label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_inactive_date" name="txt_inactive_date"  value="<?php echo $inactive_date ?>"/>
                                            <i class="icon-calendar"></i> 
                                        </span> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Remark  </label>
                                        <textarea class="form-control" id="txt_remark" name="txt_remark" rows="7" ><?php echo $remark; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Profile Photo </label>
                                        <input type="file" class="form-control" name="userfile" id="userfile" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Salary</label>
                                        <input autocomplete="off" type="text" class="form-control" name="staff_salary" id="staff_salary" value="<?php echo $salary ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</div>-->
                    <!--                <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label"> Qualification  </label>
                                            <table class="table table-bordered table-hover" id="sample-table-4">
                                                <thead>
                                                    <tr>
                                                        <th>Course Name</th>
                                                        <th>College</th>
                                                        <th>Year</th>
                                                        <th>Mark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_course1" name="txt_course1" value=""/></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_college1" name="txt_college1" value=""/></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_year1" name="txt_year1" value=""></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_mark1" name="txt_mark1" value=""/></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_course2" name="txt_course2"value=""/></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_college2" name="txt_college2" value=""/></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_year2" name="txt_year2" value=""/></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_mark2" name="txt_mark2" value=""/></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_course3" name="txt_course3" value=""/></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_college3" name="txt_college3" value=""/></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_year3" name="txt_year3" value=""/></td>
                                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_mark3" name="txt_mark3" value=""/></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>-->

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
                </div>

            </form>

        </div>
    </div>
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/staff_registration.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });

    function show_inactive_date() {
        if($("#drp_status").val() == 'INACTIVE') {
            $("#txt_inactive_date").closest(".form-group").show();
        } else { 
            $("#txt_inactive_date").closest(".form-group").hide();
            $("#txt_inactive_date").val('');
        }
    }
    
    $(document).ready(function() {
        $("#drp_status").change();
    });
</script>