
<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Student head
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>

            <?php
            //$id=$row->ACC_ID;
            foreach ($student_edit->result() as $row) {
                $stud_id = $row->STUDENT_ID;
                $stud_name = $row->NAME;
                $address1 = $row->ADDRESS1;
                $address2 = $row->ADDRESS2;
                $address3 = $row->ADDRESS3;
                $contact = $row->CONTACT_NO;
                $contact2 = $row->CONTACT_NO2;
                $email = $row->STUD_EMAIL;
                $district = $row->DISTRICT;
                $pinnum = $row->PIN_NUM;
                $gender = $row->GENDER;
                $stud_dob = $row->STUDENT_DOB;
                $course = $row->COURSE;
                $status = $row->STATUS;
                $reg_date = $row->REG_DATE;
                $time1 = strtotime($reg_date);
                $reg_date1 = date("d-m-Y", $time1);
                $due_date = $row->DUE_DATE;
                $time1 = strtotime($due_date);
                $due_date1 = date("d-m-Y", $time1);
                $fee_amount = $row->FEE_AMOUNT;
                $ad_amount = $row->ADVANCE_AMT;
                $remark = $row->REMARK;

                $course_name = $row->COURSE_NAME;
                $college_name = $row->COLLEGE_NAME;
                $year = $row->YEAR;
                $mark = $row->MARKS;

                $course_name1 = $row->COURSE_NAME1;
                $college_name1 = $row->COLLEGE_NAME1;
                $year1 = $row->YEAR1;
                $mark1 = $row->MARKS1;

                $course_name2 = $row->COURSE_NAME2;
                $college_name2 = $row->COLLEGE_NAME2;
                $year2 = $row->YEAR2;
                $mark2 = $row->MARKS2;
                ?>

                <form  role="form" id="form" method="post" action="<?php echo site_url('student/student_update'); ?>">
                    <div class="panel-body">
                        <h2><i class="icon-edit-sign teal"></i> Edit Student</h2>
                        <div>
                            <hr />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label"> Student Name <span class="symbol required"> </span> </label>
                                            <input type="hidden" name="txt_id" id="txt_acc_id" value="<?php echo $stud_id ?>">

                                            <input autocomplete="off" type="text" class="form-control" id="txt_stud_name" name="txt_stud_name"
                                                   value="<?php echo $stud_name; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label">Date Of Birth <span class="symbol required"> </span> </label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_stud_dobdate" id="txt_stud_dobdate" value="<?php echo $stud_dob; ?>"  />
                                                <i class="icon-calendar"></i> </span>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Gender </label>
                                            <div>
                                                <label class="radio-inline">
                                                    <input type="radio" value="male" <?php if ($gender == 'male') echo "checked"; ?>  name="rad_gender" id="rad_gender" class="square-grey" />
                                                    Male </label>
                                                <label class="radio-inline">
                                                    <input type="radio" value="female" <?php if ($gender == 'female') echo "checked"; ?> name="rad_gender" id="rad_gender" class="square-grey" />
                                                    Female </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label"> Address Line 1 </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_address1" name="txt_address1" 
                                                   value="<?php echo $address1; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Address Line 2 </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_address2" name="txt_address2"
                                                   value="<?php echo $address2; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Address Line 3 </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_address3" name="txt_address3" value="<?php echo $address3; ?>" />
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> District </label>
                                            <select class="form-control" id="txt_district" name="txt_district">
                                                <?php foreach ($dis->result() as $row) { ?>
                                                    <option value="<?php echo $row->DIS_ID ?>"<?php if (($row->DIS_ID) == $district) echo "selected"; ?>><?php echo $row->DISTRICT ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Pin Number </span></label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_pinnum" name="txt_pinnum" value="<?php echo $pinnum; ?>" />

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Contact Number <span class="symbol required"> </span> 
                                            </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_contact" name="txt_contact" 
                                                   value="<?php echo $contact; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Contact Number 2 </span> 
                                            </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_contact2" name="txt_contact2" 
                                                   value="<?php
                                                   if ($contact2 == 0) {
                                                       $contact2 == "";
                                                   } else {
                                                       echo $contact2;
                                                   };
                                                   ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label"> Email <span class="symbol required"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_email" name="txt_email"
                                                   value="<?php echo $email; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Course </label>
                                            <span class="symbol required"> </span>

                                            <select class="form-control" id="acc_name" name="txt_acc_name">
                                                <?php foreach ($res->result() as $row) { ?>
                                                    <option value="<?php echo $row->ACC_ID ?>"<?php if (($row->ACC_ID) == $course) echo "selected"; ?>><?php echo $row->ACC_NAME ?></option>
                                                <?php } ?>
                                            </select>

                                            <input type="hidden" name="hidden_acc_name" value="<?php echo $course; ?>"  />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Total Fee <span class="symbol required"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_stud_feeamt" name="txt_feeamt"
                                                   value="<?php echo $fee_amount; ?>"/>
                                            <input type="hidden" class="form-control" id="hidden_stud_feeamt" name="hidden_stud_feeamt"
                                                   value="<?php echo $fee_amount; ?>"/>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Registration Date</label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years"
                                                       class="form-control date-picker" id="txt_stud_regdate" name="txt_stud_regdate" 
                                                       value="<?php echo $reg_date1; ?>	"/>

                                                <input type="hidden" name="hdd_stud_regdate" value="<?php echo $reg_date1; ?>"  />

                                                <i class="icon-calendar"></i> </span>


                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Status </label>
                                            <span class="symbol required"> </span>

                                            <select class="form-control" id="drp_status" name="status">
                                                <option value="">Select</option>
                                                <!--<option value="6"<?php if ($status == 6) echo "selected"; ?>>REGISTERED</option>
                                                <option value="7"<?php if ($status == 7) echo "selected"; ?>>CLASS STARTED</option>-->

                                                <?php foreach($stat->result() as $row) {   ?>
                                                  <option value="<?php echo $row->id  ?>"<?php if( ($row->id)==$status) echo "selected";    ?>><?php echo $row->status  ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Advance <span class="symbol"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_advance" name="txt_advance"
                                                   value="<?php
                                                   if ($ad_amount == 0) {
                                                       $ad_amount == "";
                                                   } else {
                                                       echo $ad_amount;
                                                   }
                                                   ?>" readonly="readonly" />

                                            <input type="hidden" class="form-control" id="hidden_advance_amt" name="hidden_advance_amt"
                                                   value="<?php
                                                   if ($ad_amount == 0) {
                                                       $ad_amount == "";
                                                   } else {
                                                       echo $ad_amount;
                                                   }
                                                   ?>"  />

                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Due Date</label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_stud_duedate" id="txt_stud_duedate"  value="<?php
                                                if ($due_date1 == "01-01-1970") {
                                                    $due_date1 == "";
                                                } else {
                                                    echo $due_date1;
                                                }
                                                ?>">

                                                <i class="icon-calendar"></i> </span> </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label"> Remark  </label>
                                            <textarea class="form-control" id="txt_remark" name="txt_remark"
                                                      rows="7"><?php echo $remark; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label"> Qualification </label>
                                <table class="table table-bordered table-hover" id="sample-table-4">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>College</th>
                                            <th>Year</th>
                                            <th>Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_course1" name="txt_course1"  
                                                       value="<?php echo $course_name; ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_college1" name="txt_college1"
                                                       value="<?php echo $college_name; ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_year1" name="txt_year1"
                                                       value="<?php
                                                       if ($year == 0) {
                                                           $year == "";
                                                       } else {
                                                           echo $year;
                                                       }
                                                       ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_marks1" name="txt_marks1"
                                                       value="<?php
                                                       if ($mark == 0) {
                                                           $mark == "";
                                                       } else {
                                                           echo $mark;
                                                       }
                                                       ?>"/></td>
                                        </tr>
                                        <tr>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_course2" name="txt_course2"
                                                       value="<?php echo $course_name1; ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_college2" name="txt_college2"
                                                       value="<?php echo $college_name1; ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_year2" name="txt_year2"
                                                       value="<?php
                                                       if ($year1 == 0) {
                                                           $year1 == "";
                                                       } else {
                                                           echo $year1;
                                                       }
                                                       ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_marks2" name="txt_marks2"
                                                       value="<?php
                                                       if ($mark1 == 0) {
                                                           $mark1 == "";
                                                       } else {
                                                           echo $mark1;
                                                       }
                                                       ?>"/></td>
                                        </tr>
                                        <tr>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_course3" name="txt_course3"
                                                       value="<?php echo $course_name2; ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_college3" name="txt_college3"
                                                       value="<?php echo $college_name2; ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_year3" name="txt_year3"
                                                       value="<?php
                                                       if ($year2 == 0) {
                                                           $year2 == "";
                                                       } else {
                                                           echo $year2;
                                                       }
                                                       ?>"/></td>
                                            <td><input autocomplete="off" type="text" class="form-control" id="txt_marks3" name="txt_marks3"
                                                       value="<?php
                                                       if ($mark2 == 0) {
                                                           $mark2 == "";
                                                       } else {
                                                           echo $mark2;
                                                       }
                                                       ?>"/></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                <button class="btn btn-dark-beige btn-block" type="submit"> UPDATE <i class="icon-circle-arrow-right"></i> </button>
                            </div>
                        </div>
                    </div>
                    <!-- end: DYNAMIC TABLE PANEL -->

                </form>
                <?php
            }
            ?>
        </div>
    </div>
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

</div>


<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/student_registration.js"></script> 

<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });

</script>