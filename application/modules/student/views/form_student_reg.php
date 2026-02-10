<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Student Registration
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>
            <form  role="form" id="form" method="post" action="<?php echo site_url('student'); ?>" onsubmit="ins_data();">
                <div class="panel-body" >
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                    <h2><i class="icon-group teal"></i> Student Registration</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Student Name <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_stud_name" name="txt_stud_name" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Date Of Birth <span class="symbol required"> </span></label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_stud_dobdate" id="txt_stud_dobdate"  value="" />
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Gender </label>
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" name="rad_gender" value="male" <?php echo set_radio('rad_gender', 'male', TRUE); ?>  id="rad_gender" class="square-grey" />
                                                Male </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="rad_gender" id="rad_gender" class="square-grey" value="female"  <?php echo set_radio('rad_gender', 'female'); ?> />
                                                Female </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Address Line 1 </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_address1" name="txt_address1" value=""/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Address Line 2 </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_address2" name="txt_address2" value="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Address Line 3 </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_address3" name="txt_address3" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> District </label>
                                        <select class="form-control"  id="txt_district" name="txt_district">
                                            <option value="<?php //echo set_select('txt_district');    ?>">Select</option>
                                            <?php foreach ($district->result() as $row) { ?>
                                                <option value="<?php echo $row->DIS_ID; ?>"> <?php echo $row->DISTRICT; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Pin Number </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_pinnum" name="txt_pinnum" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Contact Number 1 <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_contact" name="txt_contact" value=""/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Contact Number 2 </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_contact2" name="txt_contact2" value=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Email <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_email" name="txt_email" value="" />
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
                                        <select class="form-control"  id="txt_stud_course" name="txt_stud_course" onchange="">
                                            <option value="<?php echo set_select('txt_stud_course'); ?>" >Select</option>
                                            <?php foreach ($course->result() as $row) { ?>
                                                <option value="<?php echo $row->ACC_ID; ?>"> <?php echo $row->ACC_NAME; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="txt_studcourse_name" id="txt_studcourse_name" value="" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Total Fee <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_stud_feeamt" name="txt_feeamt"
                                               value=""       />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Registration Date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years"
                                                   class="form-control date-picker" id="txt_stud_regdate" name="txt_stud_regdate" 
                                                   value="<?php echo date('d-m-Y'); ?>	"/>
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Status </label>
                                        <span class="symbol required"> </span>
                                        <select class="form-control" id="drp_status" name="status">
                                            <option value="">Select</option>
                                            <!--<option value="6">REGISTERED</option>
                                            <option value="7">CLASS STARTED</option>-->

                                            <?php foreach($status ->result() as $row)  {     ?>
                                            <option value="<?php echo $row->id;     ?>"><?php echo $row->status; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Advance <span class="symbol"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_advance" name="txt_advance" value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Due Date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_stud_duedate" id="txt_stud_duedate"  value="">
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Remark </label>
                                        <textarea class="form-control" id="txt_remark" name="txt_remark" rows="7" ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label"> Qualification </span> </label>
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
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_course1" name="txt_course1" value="" /></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_college1" name="txt_college1" value="" /></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_year1" name="txt_year1" value=""  /></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_marks1" name="txt_marks1" value=""  /></td>
                                    </tr>
                                    <tr>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_course2" name="txt_course2" value=""/></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_college2" name="txt_college2" value="" /></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_year2" name="txt_year2" value="" /></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_marks2" name="txt_marks2" value=""  /></td>
                                    </tr>
                                    <tr>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_course3" name="txt_course3"  value="" /></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_college3" name="txt_college3" value="" /></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_year3" name="txt_year3" value="" /></td>
                                        <td><input autocomplete="off" type="text" class="form-control" id="txt_marks3" name="txt_marks3" value=""/></td>
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
                            <button class="btn btn-dark-beige btn-block" type="submit" id="sub_reg" name="sub_reg"> Register <i class="icon-circle-arrow-right"></i> </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <!-- end: DYNAMIC TABLE PANEL --> 

    </div>
</div>


<script>
<?php if ($msg != "") { ?>

        function ins_data()
        {
            document.getElementById('sub_reg').disabled = false;

        }


<?php } ?>
</script>
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/student_registration.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();


    });

</script>


<script>
    function ins_data()
    {
        document.getElementById('sub_reg').disabled = true;

    }

</script>