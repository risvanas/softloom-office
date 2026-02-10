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

            <?php
            foreach ($service_edit->result() as $row) {
                $id = $row->ID;
                $nam = $row->D_S_NAME;
                $acc_id = $row->ACC_ID;
                $contact = $row->CONTACT_NO;
                $email = $row->EMAIL;
                $acctype = $row->ACC_TYPE;
                $rdate = $row->REG_DATE;
                $rdate = strtotime($rdate);
                $rdate = date("d-m-Y", $rdate);
                $rew_date = $row->RENEWAL_DATE;
                $rew_date = strtotime($rew_date);
                $rew_date = date("d-m-Y", $rew_date);
                $uname = $row->USERNAME;
                $pass = $row->PASSWORD;
                $domain_uname = $row->DOMAIN_UNAME;
                $domain_pass = $row->DOMAIN_PASSWD;
                $status = $row->STATUS;
                $amt = $row->AMOUNT;
                $info = $row->ACC_INFO;
                $rem = $row->REMARKS;
            }
            ?>


            <form action="<?php echo site_url('service/service_update'); ?>" method="post" name="form" role="form" id="form">
                <div class="panel-body">

                    <h2><i class="clip-network  teal"></i> Domain/Server Registration</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="hidden" name="txt_id" id="txt_service_id" value="<?php echo $id ?>">
                                        <label class="control-label"> Domain/Server Name <span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_dm_name" name="txt_dm_name" value="<?php echo $nam; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Account Type </label>
                                        <select class="form-control" id="drp_acc_type" name="drp_acc_type">
                                            <option value="">Select</option>
                                            <option value="Domain"<?php if (($row->ACC_TYPE) == "Domain") echo "selected"; ?>>Domain</option>
                                            <option value="Server"<?php if (($row->ACC_TYPE) == "Server") echo "selected"; ?>>Server</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Registration date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_reg_date" id="con" onchange="loadData()" value="<?php echo $rdate; ?>">
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Renewal Date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_renewal_date" id="txt_renewal_date" value="<?php echo $rew_date; ?>">
                                            <i class="icon-calendar"></i> </span> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cpanel Username</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cpanel_uname" name="txt_uname" value="<?php echo $uname; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cpanel Password</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cpanel_password" name="txt_pass" value="<?php echo $pass; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Domain Username</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cpanel_uname" name="txt_domain_uname" value="<?php echo $domain_uname; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Domain Password</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cpanel_password" name="txt_domain_pass" value="<?php echo $domain_pass; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Amount</label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount" value="<?php echo $amt; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Status </label>
                                        <select class="form-control" id="drp_acc_status" name="drp_acc_status">
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
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"> Acc Name <span class="symbol required"> </span> </label>
                                        <select class="form-control" id="acc_name" name="txt_acc_name">
                                            <option value="">Select</option>
                                            <?php foreach ($res->result() as $row) { ?>
                                                <option value="<?php echo $row->ACC_ID ?>"<?php if (($row->ACC_ID) == $acc_id) echo "selected"; ?>><?php echo $row->ACC_NAME ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Remarks</label>
                                        <textarea class="form-control" id="txt_remark" name="txt_remark" rows="4"><?php echo $rem; ?></textarea>
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
                            <button class="btn btn-dark-beige btn-block" type="submit"> Update <i class="icon-circle-arrow-right"></i> </button>
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

