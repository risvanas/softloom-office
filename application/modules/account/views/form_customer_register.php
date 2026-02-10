<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Customer Registration
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a> 
                </div>
            </div>
            <form  role="form" id="form" method="post" action="<?php echo site_url('account/customer_register'); ?>">
                <div class="panel-body" >
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <h2><i class="icon-group teal"></i> Customer Registration</h2>
                    <div>
                        <hr />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Customer Name <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cust_name" name="txt_cust_name" value="" />
                                    </div>
                                </div>
                            </div>
<!--                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Date Of Birth </span></label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_cust_dobdate" id="txt_cust_dobdate"  value="" />
                                            <i class="icon-calendar"></i> </span> </div>
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
                            </div>-->
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> GST Number</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_gst_no" name="txt_gst_no" value=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Contact Person </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_contactperson" name="txt_contactperson" value=""/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Openinig Balance </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_balance" name="txt_balance" value=""/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Status </label>
                                        <span class="symbol required"> </span>
                                        <select class="form-control" id="drp_status" name="status">
                                            <option value="">Select</option>
                                            <option value="ACTIVE">ACTIVE</option>
                                            <option value="INACTIVE">INACTIVE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Remark  </label>
                                        <textarea class="form-control" id="txt_remark" name="txt_remark" rows="7" ></textarea>
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
                            <button class="btn btn-dark-beige btn-block" type="submit"> Register <i class="icon-circle-arrow-right"></i> </button>
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
<script src="<?php echo base_url(); ?>assets/js/form-validation/customer_registration.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });

</script>