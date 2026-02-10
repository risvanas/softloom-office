		
<div class="col-md-6">
    <div class="form-group">
        <label class="control-label"> Cheque Number </label>
        <input autocomplete="off" type="text" class="form-control" id="txt_cheque_no" name="txt_cheque_no"/>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="control-label">Cheque Date </label>
        <span class="input-icon input-icon-right">
            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_cheque_date" id="txt_cheque_date"  value="" />
            <i class="icon-calendar"></i> </span>

    </div>
</div>




<div class="col-md-6">
    <div class="form-group">
        <label class="control-label"> Account Number  </label>
        <input autocomplete="off" type="text" class="form-control" id="txt_accnt_no" name="txt_accnt_no"/>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label class="control-label"> Bank <span class="symbol required"> </span> </label>
        <select class="form-control" id="sel_acc_type" name="sel_bank">
            <option value="">select</option>
            <?php
            foreach ($bank->result() as $row) {
                ?>
                <option value="<?php echo $row->ACC_ID; ?>"><?php echo $row->ACC_NAME ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/training_refund.js"></script>          
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });


</script> 

