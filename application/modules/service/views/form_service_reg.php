<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 

        <!-- start: DYNAMIC TABLE PANEL -->

        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Domain/Server Registration
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"

                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"

                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"

                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"

                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>
            <form action="<?php echo site_url('service'); ?>" method="post" name="form" role="form" id="form">
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> <button class="close" data-dismiss="alert">
                            ×
                        </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <h2><i class="clip-network  teal"></i> Domain/Server Registration</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label"> Domain/Server Name <span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_dm_name" name="txt_dm_name"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Account Type </label>
                                        <select class="form-control" id="drp_acc_type" name="drp_acc_type">
                                            <option value="">Select</option>
                                            <option value="Domain">Domain</option>
                                            <option value="Server">Server</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Registration date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_reg_date" id="con" onchange="loadData()">
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Renewal Date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_renewal_date" id="txt_renewal_date">
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cpanel Username</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cpanel_uname" name="txt_uname"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cpanel Password</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cpanel_password" name="txt_pass"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Domain Username</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cpanel_uname" name="txt_domain_uname"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Domain Password</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cpanel_password" name="txt_domain_pass"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Amount</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Status </label>
                                        <select class="form-control" id="drp_acc_status" name="drp_acc_status">
                                            <option value="">Select</option>
                                            <option value="ACTIVE">ACTIVE</option>
                                            <option value="INACTIVE">INACTIVE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Acc Name <span class="symbol required"> </span> </label>
                                        <select class="form-control" id="acc_name" name="txt_acc_name">
                                            <option value="">Select</option>
                                            <?php foreach ($parent_account->result() as $row) { ?>
                                                <option value="<?php echo $row->ACC_ID ?>"><?php echo $row->ACC_NAME ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Remarks</label>
                                        <textarea class="form-control" id="txt_remark" name="txt_remark" rows="3"></textarea>
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
        </div>
    </div>

    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/service_registration.js"></script> 


<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });
</script>

