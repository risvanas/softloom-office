
<div class="row">
    <div class="col-md-12" style="padding: 15px"> 
        <!-- start: PAYMENT VOUCHER PANEL -->
        <form id="form" method="post" action="<?php echo site_url('feecollection/fee_update') ?>">
            <div class="panel panel-default">

                <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Fee Collection
                    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                      href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                                   href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                    href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                        href="#"><i class="icon-remove"></i></a> </div>
                </div>
                <div class="panel-body">
                    <?php
                    foreach ($trans_edit->result() as $row) {
                        ?>
                        <input type="hidden" name="hdd_book_num" value="<?php echo $row->BOOK_NUMBER; ?>"/>
                        <input type="hidden" name="hdd_sub_acc" value="<?php echo $row->SUB_ACC; ?>"/>
                        <input type="hidden" name="hdd_src_id" value="<?php echo $row->SRC_ID; ?>"/>
                        <?php
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            foreach ($fee_edit->result() as $row) {
                                ?>
                                <input type="hidden" name="txt_pay_id" value="<?php echo $row->PAY_ID; ?>"/>
                                <input type="hidden" name="txt_pay_number" value="<?php echo $row->PAY_NUMBER; ?>"/>
                                <input type="hidden" name="txt_student_id" value="<?php echo $row->STUDENT_ID; ?>"/>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Course</label>
                                            <?php
                                            $course = $row->COURSE;
                                            $query = $this->db->query("SELECT ACC_NAME FROM tbl_account where ACC_ID=$course");
                                            $res = $query->row_array();
                                            ?>
                                            <input autocomplete="off" type="text" name="txt_course" id="txt_course" value="<?php echo $res['ACC_NAME']; ?>" readonly="readonly"  />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Name</label>
                                            <input autocomplete="off" type="text" name="txt_stud_name" id="txt_stud_name" value="<?php echo $row->NAME; ?>" readonly="readonly" />


                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Payment Date <span class="symbol required"> </span></label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_payment_date" id="txt_payment_date"  value="<?php
                                                $pay_date = $row->PAYMENT_DATE;
                                                $pay_date = strtotime($pay_date);
                                                echo $pay_date = date("d-m-Y", $pay_date);
                                                ?>" />
                                                       <?php echo form_error('txt_payment_date'); ?> 

                                                <i class="icon-calendar"></i> </span>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" name="hdd_due_date" value="<?php echo $row->DUE_DATE; ?>"  />
                                            <label class="control-label">Due date</label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_due_date" id="txt_due_date" value="<?php
                                                $due_date = $row->DUE_DATE;
                                                $due_date = strtotime($due_date);
                                                echo $due_date = date("d-m-Y", $due_date);
                                                ?>">
                                                <i class="icon-calendar"></i> </span>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Amount <span class="symbol required"> </span> </label>
                                            <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount" value="<?php echo $row->AMOUNT; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label class="control-label"> Transaction Type</label>
                                            <select class="form-control"  id="txt_trans_type" name="txt_trans_type" onchange="show_bank_details()" >
                                                <option value="cash" <?php
                                                if ($row->TRANSACTION_TYPE == "cash") {
                                                    ?> selected="selected"<?php } ?> >CASH</option>
                                                <option value="bank" <?php
                                                if ($row->TRANSACTION_TYPE == "bank") {
                                                    ?> selected="selected"<?php } ?> >BANK</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div id="display">
                                        <div <?php
                                        if ($row->TRANSACTION_TYPE == "cash") {
                                            ?>style="display:none"<?php } ?>>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Cheque Number  </label>
                                                    <input autocomplete="off" type="text" class="form-control" id="txt_cheque_no" name="txt_cheque_no" value="<?php echo $row->CHEQUE_NUMBER; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Cheque Date</label>
                                                    <div class="input-group">
                                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_cheque_date" name="txt_cheque_date" value="<?php
                                                        $cheque_date = $row->CHEQUE_DATE;
                                                        $cheque_date = strtotime($cheque_date);
                                                        echo $cheque_date = date("d-m-Y", $cheque_date);
                                                        ?>">
                                                        <span class="input-group-addon"> <i class="icon-calendar"></i> </span> </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Account Number</label>
                                                    <input autocomplete="off" type="text" class="form-control" id="txt_accnt_no" name="txt_accnt_no" value="<?php echo $row->ACCOUNT_NUMBER; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    $bank = $row->BANK;
                                                    $query = $this->db->query("SELECT * FROM tbl_account where ACC_TYPE='BANK'");
                                                    ?>
                                                    <label class="control-label"> Bank <span class="symbol required"> </span> </label>
                                                    <select class="form-control" id="sel_acc_type" name="sel_bank">
                                                        <?php
                                                        foreach ($query->result() as $acc) {
                                                            ?>
                                                            <option value="<?php echo $acc->ACC_CODE ?>"<?php
                                                            if ($acc->ACC_CODE == $bank) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $acc->ACC_NAME; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                    </select>
                                                </div>
                                            </div>
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
                        <?php
                    }
                    ?>
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
                        <div class="col-md-4">
                            <input type="submit" id="sub_update" name="sub_update" value="Update" class="btn btn-yellow btn-block" />
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
    <!-- end: ACCOUNT REGISTRATION PANEL --> 
</div>
<script>
    function show_bank_details()
    {

        $.ajax({
            type: "POST",
            data: {type: $('#txt_trans_type').val()},
            url: "<?php echo site_url('feecollection/bank_details'); ?>",
            success: function (data)
            {
                $('#display').html(data);
            }

        });
    }

</script> 
<script>
    function load_stud_details()
    {

        $.ajax({
            type: "POST",
            data: {sname: $('#txt_stud_name').val()},
            url: "<?php echo site_url('feecollection/student_details'); ?>",
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
            url: "<?php echo site_url('feecollection/student_names'); ?>",
            success: function (data)
            {
                $('#h1').html(data);
            }





        });
    }

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
