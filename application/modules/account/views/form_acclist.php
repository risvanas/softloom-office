<div class="col-md-12"> 

    <!-- start: DYNAMIC TABLE PANEL -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="icon-external-link-sign"></i>
            Account List
            <div class="panel-tools"> 
                <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a> 
            </div>
        </div>
        <div class="page-header" style="float:left; width:50%">
            <h1>Account List </h1>
        </div>
        <div class="page-header" align="right" style="float:left; width:50%; margin-top:25px; padding-bottom:25px !important;"> <a class="btn btn-yellow btn-block" style="width:150px;" href="<?php echo site_url('account/index'); ?>" onclick="hiddenFunction()"> New Account <i class="icon-circle-arrow-right"></i> </a> </div>
        <!-- end: PAGE TITLE & BREADCRUMB -->
        <div class="col-md-12">
            <div id="error_msg" class="errorHandler alert alert-danger no-display"> <i class="icon-remove-sign"></i> You have some form errors. Please check below. </div>
            <div id="succe_msg" class="successHandler alert alert-success no-display "> <i class="icon-ok"></i> </div>
        </div>
        <div class="panel-body">
            <label></label>
            <table  width="200" class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account Code</th>
                        <th>Account Type</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $sn_count = 1;
                    foreach ($cond->result() as $row) {
                        //		departmentId			
                        ?>
                        <tr>
                            <td ><?php echo $row->ACC_NAME; ?></td>
                            <td class=""><?php echo $row->ACC_CODE; ?></td>
                            <td><?php echo $row->ACC_TYPE; ?> </td>

                            <?php
                            $stat = $row->status;

                            if ($stat == "ACTIVE") {
                                ?>

                                <td><span class="label label-success" > <?php echo $stat ?> </span></td>
                                <?php
                            } else if ($stat == "BLOCKED") {
                                ?>

                                <td><span class="label label-danger" > <?php echo $stat; ?> </span></td>

                                <?php
                            } else {
                                ?>
                                <td><span class="label label-warning" > <?php echo $stat; ?> </span></td>
                                <?php
                            }
                            ?>
                            <td class=""><div class="btn-group">
                                    <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick="hiddenFunction()"> <i class="icon-wrench"></i> Setting </button>
                                    <button  onclick="hiddenFunction()"  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                                    <ul class="dropdown-menu" role="menu">
                                        <li> <a href="<?php echo site_url('account/account_edit'); ?>/<?php echo $row->ACC_ID; ?> "> <i class="icon-pencil"></i> Edit </a> </li>
                                        <li> <a href="#static<?php echo $row->ACC_ID; ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!----------------------- start allert box ----------------------------> 
                        <div id="static<?php echo $row->ACC_ID; ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
                            <div class="modal-body">
                                <p> Are You sure, that you want to delete selected record? </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                                <a type="button"  class="btn btn-primary" href="<?php echo site_url('account/account_delete'); ?>/<?php echo $row->ACC_ID; ?>"> Continue </a>
                            </div>
                        </div>
                        <!----------------------- end allert box ----------------------------> 
                        <?php
                        $sn_count++;
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>

    <!-- end: DYNAMIC TABLE PANEL --> 
</div>

<!-- end: PAGE HEADER -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/account_year_registration.js"></script> 


<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });


</script> 