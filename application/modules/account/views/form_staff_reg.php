<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Staff Registration
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>

            <form  role="form" id="form" method="post" action="<?php echo site_url('account'); ?>">
                <div class="panel-body" >
                    <h2><i class="icon-group teal"></i> Staff Registration</h2>
                    <div>
                        <hr />
                    </div>


                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"> Staff Code <span class="symbol required"> </span> </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_staff_code" name="txt_staff_code" value="" />  

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"> Biometric Code <span class="symbol required"> </span> </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_staff_bio" name="txt_staff_bio" value="" />  

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"> Staff Name <span class="symbol required"> </span> </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_staff_name" name="txt_staff_name" value="" />  

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Date Of Birth <span class="symbol required"> </span></label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_staff_dobdate" id="txt_staff_dobdate"  value="" />
                                        <i class="icon-calendar"></i> </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"> Gender </label>
                                    <div>
                                        <label class="radio-inline">
                                            <input type="radio" name="rad_gender" value="male"     id="rad_gender" class="square-grey" />
                                            Male </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="rad_gender" id="rad_gender" class="square-grey" value="female"  />
                                            Female </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"> Address Line 1 <span class="symbol required"> </span> </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_address1" name="txt_address1" value=""/>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Address Line 2 </span> </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_address2" name="txt_address2" value="" />

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"> Contact Number <span class="symbol required"> </span> </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_contact" name="txt_contact" value=""/>

                                </div>
                            </div>
                            <div class="col-md-6">
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
                                    <label class="control-label"> Designation </label>
                                    <span class="symbol required"> </span>
                                    <select class="form-control"  id="txt_staff_desi" name="txt_staff_desi">
                                        <option value="">Select</option>
                                        <?php
                                        //foreach($desi ->result() as $row)
                                        //{
                                        ?>
                                        <option value="<?php //echo $row->id;   ?>"><?php //echo $row->designation;   ?> </option>
                                        <?php //}
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Year of experience   </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_staff_year" name="txt_year"
                                           value=""       />


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Month of experience   </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_staff_month" name="txt_staff_month"
                                           value=""       />


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Joining Date  <span class="symbol required"> </span></label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years"
                                               class="form-control date-picker" id="txt_staff_jdate" name="txt_staff_jdate" 
                                               value=""/>

                                        <i class="icon-calendar"></i> </span>


                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"> Status </label>
                                    <span class="symbol required"> </span>
                                    <select class="form-control" id="drp_status" name="status">
                                        <option value="">Select</option>
                                        <?php foreach ($status->result() as $row) {
                                            ?>


                                            <option value="<?php echo $row->id; ?>"><?php echo $row->status; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"> Remark <span class="symbol required"> </span> </label>
                                    <textarea class="form-control" id="txt_remark" name="txt_remark" rows="7" ></textarea>

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
                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_course1" name="txt_course1" value="" /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_college1" name="txt_college1" value="" /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_year1" name="txt_year1" value=""  /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_mark1" name="txt_mark1" value=""/></td>

                                </tr>
                                <tr>
                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_course2" name="txt_course2" value="" /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_college2" name="txt_college2" value="" /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_year2" name="txt_year2" value=""  /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_mark2" name="txt_mark2" value=""/></td>
                                </tr>
                                <tr>
                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_course3" name="txt_course3" value="" /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_college3" name="txt_college3" value="" /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_year3" name="txt_year3" value=""  /></td>


                                    <td><input autocomplete="off" type="text" class="form-control" id="txt_mark3" name="txt_mark3" value=""/></td>
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
                        <button class="btn btn-primary btn-block" type="submit"> Register <i class="icon-circle-arrow-right"></i> </button>
                    </div>
                </div>
            </form>



            <!-- end: DYNAMIC TABLE PANEL -->


        </div>
    </div>
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
</div>


<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 


<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/staff_registration.js"></script> 

<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });

</script>