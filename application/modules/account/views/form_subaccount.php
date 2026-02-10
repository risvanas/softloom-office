<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Subaccount Heads
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>
            <form  method="post" name="form" action="<?php echo site_url('account/subaccount'); ?>" id="form">
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> <button class="close" data-dismiss="alert">
                            ×
                        </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?></div>
                    <h2><i class="icon-edit-sign teal"></i> New Subaccount</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">               
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"> Acc Code <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_acc_code" name="txt_acc_code" value=""/>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Name of Account <span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_acc_name" name="txt_name"  value=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">status</label>
                                        <select class="form-control" id="drp_status" name="drp_status">
                                            <option value="ACTIVE">ACTIVE</option>
                                            <option value="INACTIVE">INACTIVE</option>
                                        </select>
                                    </div>
                                </div>     
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Account <span class="symbol required"> </span> </label>
                                        <select class="form-control" id="drp_account" name="drp_account">
                                            <option value="">Select Parent Account</option>
                                            <?php foreach ($accounts->result() as $acc) { ?>
                                                <option value="<?php echo $acc->ACC_ID ?>"><?php echo $acc->ACC_NAME ?></option>
                                            <?php } ?>
                                        </select>
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
                                    <button class="btn btn-dark-beige btn-block" type="submit"> Register <i class="icon-circle-arrow-right"></i> </button>
                                </div>
                            </div>
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
<script src="<?php echo base_url(); ?>assets/js/form-validation/account_year_registration.js"></script> 


<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });


</script> 