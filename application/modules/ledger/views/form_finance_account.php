<div class="row">
    <div class="col-md-12" style="padding: 15px">
        <!-- start: GROUP PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="icon-external-link-sign"></i>&nbsp Finance Report
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                            href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <form id="form" method="post" action="<?php echo site_url('ledger/student_details'); ?>">
                <div class="panel-body">
                    <span class="my-title"><i class="icon-edit-sign teal"></i>&nbsp Finance Report </span>
                    <hr />
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- start: ACCORDION PANEL -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="icon-reorder"></i>Type Of Reports
                                </div>
                                <div class="panel-body">
                                    <div class="panel-group accordion-custom accordion-teal" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseTwo"><i class="icon-arrow"></i>Ledger</a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    From Date
                                                                </label>
                                                                <span class="input-icon input-icon-right">
                                                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_from_date_ledger"
                                                                           id="txt_from_date_ledger"   />
                                                                    <i class="icon-calendar"></i> </span>  
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    To Date
                                                                </label>
                                                                <span class="input-icon input-icon-right">
                                                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy"  data-date-viewmode="years" 
                                                                           class="form-control date-picker" name="txt_to_date_ledger" 
                                                                           id="txt_to_date_ledger"         value="<?php echo date('d-m-Y'); ?>" />
                                                                    <i class="icon-calendar"></i> </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    Student
                                                                </label>
                                                                <select class="form-control"  id= "drp_account_ledger" name="drp_account_ledger">
                                                                    <option value="select">Select</option>

                                                                    <?php foreach ($cond->result() as $row) { ?>
                                                                        <option value="<?php echo $row->STUDENT_ID; ?>" > <?php echo $row->NAME; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <button class="btn btn-primary btn-block" type="submit"> SHOW  </button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end: ACCORDION PANEL -->
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <span class="symbol required"></span>Required Fields
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end: COMPANY USER REGISTRATION PANEL -->
</div>

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/enquiry.js"></script>          
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        TableData.init();
        UIModals.init();
        FormElements.init();

    });



</script> 