
<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Account Heads
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>





            <form  method="post" name="form1" action="<?php echo site_url('account'); ?>">
                <div class="panel-body">
                    <h2><i class="icon-edit-sign teal"></i> New Account</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Acc Code <span class="symbol required"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_acc_code" name="txt_acc_code"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Name of Account <span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_acc_name" name="txt_name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Contact Person <span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_contact" name="txt_contact"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> Type</label>
                                            <select class="form-control" id="drp_customer" name="drp_customer">
                                                <option value="C">CUSTOMER</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Address Line 1 <span class="symbol required"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_address1" name="txt_address1"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Phone<span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_ph" name="txt_ph"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Email<span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_ph" name="txt_email"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Address Line 2<span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_address2" name="txt_address2"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Tin_No<span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_tin" name="txt_tin"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Reg_No<span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_reg" name="txt_reg"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Cst_No<span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_cst" name="txt_cst"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> Account Level </label>
                                            <select class="form-control" id="drp_acc_level" name="drp_acc_level">
                                                <option>0</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                                <option>9</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Parent Account</label>
                                            <select class="form-control" id="drp_acc_parent" name="drp_acc_parent">
                                                <?php foreach ($parent_account->result() as $row) { ?>
                                                    <option value="<?php echo $row->ACC_ID ?>"><?php echo $row->ACC_NAME ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> Account Group</label>
                                            <select class="form-control"  id="txt_acc_group" name="txt_acc_group">
                                                <option>BS</option>
                                                <option>PL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> status</label>
                                            <select class="form-control" id="drp_status" name="drp_status">
                                                <?php foreach ($status->result() as $row) { ?>
                                                    <option value="<?php echo $row->status; ?>"><?php echo $row->status; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Account Type</label>
                                            <select class="form-control" id="drp_acc_type" name="drp_acc_type">
                                                <option value="ACC">ACC</option>
                                                <option value="BANK">BANK</option>
                                                <option value="BP">BP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" id="btn_submit" value="Submit"/>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div> <span class="symbol required"></span>Required Fields
                                            <hr />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row"> </div>
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
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });


</script> 