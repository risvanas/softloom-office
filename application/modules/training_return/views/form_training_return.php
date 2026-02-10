<div style="padding-top:20px;" class="row">
    <div class="col-md-12"> 
        <!-- start: PAYMENT VOUCHER PANEL -->
        <form id="form" runat="server" method="post" action="<?php echo site_url('training_return') ?>">
            <div class="panel panel-default">
                <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp; Training Return
                    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-expand"

                                                                                                                      href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"

                                                                        href="#"><i class="icon-remove"></i></a> </div>
                </div>
                <?php echo validation_errors(); ?>
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                    <div id="voc_num" class="successHandler alert alert-danger" ><?php echo $errmsg = "Not found"; ?></div>     
                    <h2><i class="icon-edit-sign teal"></i>&nbsp;Training Return</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Book Number </label>
                                        <?php
                                        $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='SALRTN'");
                                        $row = $query->row_array();
                                        $book_num = $row['BOOK_NUMBER'];
                                        ?>
                                        <div class="input-group">
                                            <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $book_num; ?>"/>
                                            <input type="hidden" name="temp_voc_num" id="temp_voc_num" Class="form-control"/> 
                                            <input type="hidden" name="temp_name" id="temp_name" Class="form-control"/> 
                                            <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-dark-beige" onclick="displaydata();"> GO </a> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" id="btn_refresh" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label"> &nbsp;</label>
                                        <a href="<?php echo site_url('training_return'); ?>"><button class="btn btn-dark-beige btn-block" type="button">Refresh&nbsp;<i class="icon-circle-arrow-right"></i> </button></a>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label"> Course</label>
                                        <select class="form-control" id="txt_course" name="txt_course"  onchange="load_stud_names()" onfocus="load_stud_names();">
                                            <option value="">Select course </option>
                                            <?php
                                            foreach ($parent_account->result() as $row) {
                                                ?>
                                                <option value="<?php echo $row->ACC_ID ?>"><?php echo $row->ACC_NAME ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group" id="h1">
                                        <label class="control-label"> Name</label>
                                        <input autocomplete="off" type="text" name="text_stud_name" id="text_stud_name" class="form-control" style="display:none;" />
                                        <select class="form-control" id="txt_stud_name" name="txt_stud_name"  onchange="load_stud_details();">
                                            <option value="">Select</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">  


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Return Date <span class="symbol required"> </span></label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_payment_date" id="txt_payment_date"  value="" />
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Amount <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount"/>
                                    </div>
                                </div>
                            </div>


                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Status </label>
                                        <span class="symbol required"> </span>
                                        <select class="form-control" id="drp_status" name="status">
                                            <!-- <option value="9">DISCONTINUE</option>-->
                                            <?php foreach ($status->result() as $row) { ?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->status; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div id="sdetail"></div>
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
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-2">
                            <a id='bttdelete' href="#static"  class="btn btn-dark-beige btn-block" data-toggle="modal"> <i class="icon-trash"></i> Delete </a>

                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-dark-beige btn-block" type="submit">Submit&nbsp;<i class="icon-circle-arrow-right"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end: ACCOUNT REGISTRATION PANEL --> 
</div>


<div id="output1">



</div>

<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-body">
        <p> Are You sure, that you want to delete selected record? </p>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
        <a id="hrefdelete" name="hrefdelete" type="button"  class="btn btn-primary"> Continue </a> </div>
</div>


<script>
    document.getElementById("voc_num").style.display = "none";
    document.getElementById("bttdelete").style.display = "none";
//load_stud_names();
    function load_stud_details()
    {

        $.ajax({
            type: "POST",
            data: {sname: $('#txt_stud_name').val()},
            url: "<?php echo site_url('training_return/student_details'); ?>",
            success: function (data)
            {
                $('#sdetail').html(data);
            }

        });
    }
    function load_stud_details_load()
    {

        $.ajax({
            type: "POST",
            data: {sname: $('#temp_name').val()},
            url: "<?php echo site_url('training_return/student_details'); ?>",
            success: function (data)
            {
                $('#sdetail').html(data);
            }

        });
    }

    function load_stud_names()
    {

        $.ajax({
            type: "POST",
            data: {cname: $('#txt_course').val()},
            url: "<?php echo site_url('training_return/student_names'); ?>",
            success: function (data)
            {
                $('#h1').html(data);
            }

        });
    }


</script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/form_training_return.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        //FormValidator.init();
        UIModals.init();
        FormElements.init();

    });

    /*jQuery(document).ready(function() {
     Main.init();
     FormValidator.init();
     FormElements.init();
     
     });
     */


</script> 
<script>
    function displaydata()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {voc_no: $('#conn').val(), },
            url: "<?php echo site_url('training_return/select_data'); ?>",
            success: function (data)
            {
                $('#output1').html(data);
            }
        });
    }
</script> 