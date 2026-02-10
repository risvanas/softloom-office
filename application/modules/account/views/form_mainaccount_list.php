<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/DataTables/media/css/DT_bootstrap.css" />

<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 

        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Account List
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>
            <div class="col-md-12"> 
                <div class="page-header" style="margin-bottom:0px;">
                    <h1>Account List </h1>
                </div>

            </div>
            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="row">
                <div class="col-md-12">
                    <div id="error_msg" class="errorHandler alert alert-danger no-display"> <i class="icon-remove-sign"></i> You have some form errors. Please check below. </div>
                    <div id="succe_msg" class="successHandler alert alert-success no-display "> <i class="icon-ok"></i> </div>
                </div>
            </div>
            <div class="panel-body">
                <label></label>
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>
                    <th>Account Code</th>
                    <th>Name</th>
                    <th>Account Type</th>
                    <th>Parent Account</th>
                    <th>Opening Balance</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        <?php
                        $sn_count = 1;
                        foreach ($cond->result() as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row->ACC_CODE; ?></td>
                                <td><?php echo $row->ACC_NAME; ?></td>
                                <td><?php echo $row->ACC_TYPE; ?></td>
                                <td><?php
                                    $parnt_accid = $row->PARENT_ACC_ID;
                                    $query = $this->db->query("SELECT ACC_NAME AS ACC_NAME FROM tbl_account WHERE ACC_ID=$parnt_accid");
                                    $res = $query->row_array();
                                    echo $parnt_accid = $res['ACC_NAME'];
                                    ?></td>
                                <td><?php
                                    $opening_balance = $row->OPENING_BALANCE;
                                    if ($opening_balance == 0) {
                                        echo "";
                                    } else {
                                        echo $opening_balance;
                                    }
                                    ?> </td>
                                <td><?php
                                    $stat = $row->STATUS;
                                    if ($stat == "ACTIVE") {
                                        echo "<span class='label label-success'>$stat</span>";
                                    } else if ($stat == "INACTIVE") {
                                        echo "<span class='label label-danger'>$stat</span>";
                                    }
                                    ?></td>

                                <td class=""><div class="btn-group">
                                        <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                                        <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
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
                                    <a type="button"  class="btn btn-primary" href="<?php echo site_url('account/account_delete'); ?>/<?php echo $row->ACC_ID; ?>"> Continue </a> </div>
                            </div>
                            <!----------------------- end allert box ---------------------------->

                            <?php
                            $sn_count++;
                        }
                        ?>
                    </tbody>

                </table>
            </div>


            <!-- end: DYNAMIC TABLE PANEL --> 

        </div>
    </div>
</div>

<!-- end: PAGE HEADER --> 

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-data.js"></script>       
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
    });
</script>	