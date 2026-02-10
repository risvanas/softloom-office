

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
                <form name="form" method="post" action="<?php echo site_url('Trialbalance/account_list')?>">
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
                                                        href="#collapseFive"><i class="icon-arrow"></i>Trial Balance</a>
                                                </h4>
                                            </div>
                                            <div id="collapseFive" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    From Date<span class="symbol required">
                                                                    <input type="date" id="txt_date" name="txt_date" class="form-control tcal">
</span>
                                                                </label>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    To Date
                                                                </label>
                                                                <input type="date" name="txt_date1" id="txt_date1" class="form-control tcal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="submit" name="btn_trial_bal" id="btn_trial_bal"  class="form-control btn btn-primary" value="Show">
                                                                    
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
<script>
	
jQuery(document).ready(function() {
	Main.init();
	FormElements.init();
	
});
		</script>