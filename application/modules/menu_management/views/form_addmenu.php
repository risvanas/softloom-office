<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Menu Management
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>
            <form  method="post" name="form" action="<?php echo site_url('menu_management'); ?>" id="form">
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> <button class="close" data-dismiss="alert">
                            ×
                        </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                    <h2><i class="icon-edit-sign teal"></i> New Menu</h2>
                    <div>
                        <hr />
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Parent Menu </label>
                                        <select class="form-control" id="drp_prt_menu" name="drp_prt_menu">
                                            <option value="">select</option>
                                            <?php
                                            foreach ($pmenu->result() as $row) {
                                                ?>
                                                <option value="<?php echo $row->MENU_ID; ?>"><?php echo $row->SUB_MENU; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Sub Menu <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_sub_menu" name="txt_sub_menu" value=""/>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> URL <span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_url" name="txt_url"  value=""/>

                                    </div>
                                </div>
                            </div>


                            <div class="row"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"> Icon <span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_icon" name="txt_icon"  value=""/>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"> Status </label>
                                        <select class="form-control" id="txt_source" name="txt_source">
                                            <option value="">select</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"> Menu Order <span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_order" name="txt_order"  value=""/>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"> Mobile view <span class="symbol required"></span> </label>
                                        <select class="form-control" name="drp_mobile_view" id="drp_mobile_view">
                                            <option value="1">On</option>
                                            <option value="0">Off</option>
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
                                    <button class="btn btn-primary btn-block" type="submit"> Register <i class="icon-circle-arrow-right"></i> </button>
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
<script src="<?php echo base_url(); ?>assets/js/form-validation/add_menu.js"></script> 


<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });


</script> 