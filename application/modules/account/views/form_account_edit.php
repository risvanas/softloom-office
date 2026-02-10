
<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Account Heads
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a> 
                </div>
            </div>
            <?php
            foreach ($account_edit->result() as $row) {
                $id = $row->ACC_ID;
                $acc_code = $row->ACC_CODE;
                $acc_name = $row->ACC_NAME;
                $parent_acc_id = $row->PARENT_ACC_ID;
                $opng_balance = $row->OPENING_BALANCE;
                ?>

                <form  method="post" name="form" action="<?php echo site_url('account/mainaccount_update'); ?>" id="form">
                    <div class="panel-body">
                        <input type="hidden" class="form-control" id="txt_acc_id" name="txt_acc_id" value="<?php echo $id ?>"/>
                        <h2><i class="icon-edit-sign teal"></i> New Account</h2>
                        <div>
                            <hr />
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> Acc Code <span class="symbol required"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_acc_code" name="txt_acc_code" value="<?php echo $acc_code ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Name of Account <span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_acc_name" name="txt_name"  value="<?php echo $acc_name ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> Account Level </label>
                                            <select class="form-control" id="drp_acc_level" name="drp_acc_level">
                                                <option value="0"<?php
                                                if ($row->ACC_LEVEL == "0") {
                                                    ?> selected="selected"<?php } ?>>0</option>
                                                <option value="1"<?php
                                                if ($row->ACC_LEVEL == "1") {
                                                    ?> selected="selected"<?php } ?>>1</option>
                                                <option value="2"<?php
                                                if ($row->ACC_LEVEL == "2") {
                                                    ?> selected="selected"<?php } ?>>2</option>
                                                <option value="3"<?php
                                                if ($row->ACC_LEVEL == "3") {
                                                    ?> selected="selected"<?php } ?>>3</option>
                                                <option value="4"<?php
                                                if ($row->ACC_LEVEL == "4") {
                                                    ?> selected="selected"<?php } ?>>4</option>
                                                <option value="5"<?php
                                                if ($row->ACC_LEVEL == "5") {
                                                    ?> selected="selected"<?php } ?>>5</option>
                                                <option value="6"<?php
                                                if ($row->ACC_LEVEL == "6") {
                                                    ?> selected="selected"<?php } ?>>6</option>
                                                <option value="7"<?php
                                                if ($row->ACC_LEVEL == "7") {
                                                    ?> selected="selected"<?php } ?>>7</option>
                                                <option value="8"<?php
                                                if ($row->ACC_LEVEL == "8") {
                                                    ?> selected="selected"<?php } ?>>8</option>
                                                <option value="9"<?php
                                                if ($row->ACC_LEVEL == "9") {
                                                    ?> selected="selected"<?php } ?>>9</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Parent Account</label>
                                            <select class="form-control" id="drp_acc_parent" name="drp_acc_parent">
                                                <option value="">SELECT</option>
                                                <?php foreach ($accounts->result() as $acc) { ?>

                                                    <option value="<?php echo $acc->ACC_ID ?>"<?php if (($acc->ACC_ID) == $parent_acc_id) echo "selected"; ?>> <?php echo $acc->ACC_NAME ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> Account Group</label>
                                            <select class="form-control"  id="txt_acc_group" name="txt_acc_group">
                                                <option value="BS"<?php
                                                if ($row->ACC_GROUP == "BS") {
                                                    ?> selected="selected"<?php } ?>>BS</option>
                                                <option value="PL"<?php
                                                if ($row->ACC_GROUP == "PL") {
                                                    ?> selected="selected"<?php } ?>>PL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> status</label>
                                            <select class="form-control" id="drp_status" name="drp_status">
                                                <option value="ACTIVE"<?php
                                                if ($row->STATUS == "ACTIVE") {
                                                    ?> selected="selected"<?php } ?> >ACTIVE</option>
                                                <option value="INACTIVE"<?php
                                                if ($row->STATUS == "INACTIVE") {
                                                    ?> selected="selected"<?php } ?>>INACTIVE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> Account Type</label>
                                            <select class="form-control" id="drp_acc_type" name="drp_acc_type">
                                                <option value="ACC"<?php
                                                if ($row->ACC_TYPE == "ACC") {
                                                    ?> selected="selected"<?php } ?>>ACC</option>
                                                <option value="BANK"<?php
                                                if ($row->ACC_TYPE == "BANK") {
                                                    ?> selected="selected"<?php } ?>>BANK</option>
                                                <option value="BP"<?php
                                                if ($row->ACC_TYPE == "BP") {
                                                    ?> selected="selected"<?php } ?>>BP</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"> Openinig Balance <span class="symbol required"></span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_opng_balance" name="txt_opng_balance"  value="<?php echo $opng_balance ?>"/>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-10">
                                    <p> </p>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-block" type="submit"> Update <i class="icon-circle-arrow-right"></i> </button>
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