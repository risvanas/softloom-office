
<div class="row">
    <div class="col-md-12" style="padding: 15px"> 
        <!-- start: PAYMENT VOUCHER PANEL -->
        <form id="form" runat="server" method="post" action="<?php echo site_url('feecollection/coursecompletion') ?>">
            <div class="panel panel-default">

                <div class="panel-body" >



                    <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Course Completion 
                        <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                          href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                                       href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                        href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                            href="#"><i class="icon-remove"></i></a> </div>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <?php
                                    foreach ($student_account->result() as $res) {
                                        $course_id = $res->COURSE;
                                        ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                foreach ($parent_account->result() as $row) {
                                                    if ($row->ACC_ID == $course_id) {
                                                        $course_name = $row->ACC_NAME;
                                                    }
                                                }
                                                ?>
                                                <label class="control-label"> Course <span class="symbol required"> </span> </label>
                                                <input autocomplete="off" type="text" class="form-control" id="txt_course" name="txt_course" value="<?php echo $course_name; ?>"/>
                                                <input type="hidden" class="form-control" id="hdd_course" name="hdd_course" value="<?php echo $course_id; ?>"/>
                                             <!--<select class="form-control" id="txt_course" name="txt_course"  onchange="load_completed_names()">
                                                -->



                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group" id="h1">
                                                <!--<label class="control-label"> Name</label>
                                                <select class="form-control" id="txt_stud_name" name="txt_stud_name" onchange="load_completion_details()">
                                                 <option value="">Select</option>
                                                </select>-->
                                                <label class="control-label"> Student Name <span class="symbol required"> </span> </label>
                                                <input autocomplete="off" type="text" class="form-control" id="txt_stud_name" name="txt_stud_name" value="<?php echo $res->NAME; ?>"/>
                                                <input type="hidden" class="form-control" id="hdd_stud_name" name="hdd_stud_name" value="<?php echo $res->STUDENT_ID; ?>" />
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Completed Date <span class="symbol required"> </span></label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_completed_date" id="txt_completed_date"  value="<?php echo date('d-m-Y'); ?>" />


                                                <i class="icon-calendar"></i> </span>

                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div id="display"></div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div id="sdetail">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <span class="symbol required"></span>Required Fields
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>
                                    By clicking REGISTER, you are agreeing to the Policy and Terms &amp; Conditions.
                                </p>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block" type="submit">Submit &nbsp;<i class="icon-circle-arrow-right"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>



    </div>
    <!-- end: ACCOUNT REGISTRATION PANEL --> 
</div>

<script>

    function load_completion_details()
    {
        $.ajax({
            type: "POST",
            data: {sname: $('#hdd_stud_name').val()},
            url: "<?php echo site_url('feecollection/completion_details'); ?>",
            success: function (data)
            {
                $('#sdetail').html(data);
            }

        });
    }



</script> 

<script>
    load_completion_details();
</script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/fee_collection.js"></script>          
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });


</script> 
