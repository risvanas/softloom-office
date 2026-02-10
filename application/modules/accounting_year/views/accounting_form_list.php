<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Account Year List
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a> 
                </div>
            </div>
            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="col-md-12">
                <h1>Account Year List<small></small></h1>
                <hr />
            </div>
            <div class="panel-body" >
                <div id="output">
                    <table class="table table-striped table-bordered table-hover table-full-width" >
                        <thead>
                            <tr>
                                <th> No</th>
                                <th> Accounting Year Code </th>
                                <th> From Date </th>
                                <th> To Date </th>
                                <th> Status </th>
                                <th style="width:110px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $crnt_date = date('d-m-Y');
                            foreach ($list->result() as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row->YEAR_CODE; ?></td>
                                    <td><?php
                                        $from = $row->FROM_DATE;
                                        if ($from != '') {
                                            $from = strtotime($from);
                                            $from = date('d-m-Y', $from);
                                        }
                                        echo $from;
                                        ?></td>
                                    <td><?php
                                        $to = $row->TO_DATE;
                                        if ($to != '') {
                                            $to = strtotime($to);
                                            $to = date('d-m-Y', $to);
                                        }
                                        echo $to;
                                        ?></td>
                                    <td><?php
                                        $status = $row->STATUS;
                                        if ($status == 'active') {
                                            ?>
                                            <span class="label label-success"><?php echo $status; ?></span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="label label-danger"><?php echo $status; ?></span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class=""><div class="btn-group">
                                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                                            <ul class="dropdown-menu" role="menu">

                                                <li> <a href="<?php echo site_url('accounting_year/account_year_edit') . $row->AY_ID; ?><?php //echo ;     ?> "> <i class="icon-pencil"></i> Edit </a> </li>

                                                <li> <a href="#static<?php echo $row->AY_ID; ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!----------------------- start allert box ---------------------------->
                                <div id="static<?php echo $row->AY_ID; ?>" class="modal fade" tabindex="-1" 
                                     data-backdrop="static" data-keyboard="false" style="display: none;">
                                    <div class="modal-body">
                                        <p> Are You sure, that you want to delete selected record? </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                                        <a type="button"  class="btn btn-primary" href="<?php echo site_url('accounting_year/account_delete'); ?>/<?php echo $row->AY_ID; ?>"> Continue </a> </div>
                                </div>
                                <!----------------------- end allert box ---------------------------->


                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- end: DYNAMIC TABLE PANEL --> 
    </div>
</div>

<!-- end: PAGE HEADER --> 
<script>
    jQuery(document).ready(function () {
        Main.init();
        //FormValidator.init();
        UIModals.init();
        FormElements.init();

    });
</script>
