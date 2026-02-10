<div class="panel-group accordion-custom accordion-teal" id="accordion">
    <?php
    foreach ($cond as $key => $value) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#leave_<?php echo $value->ID ?>">
                        <i class="icon-arrow"></i>
                        <?php
                        $appiled_date = $value->CREATED_ON;
                        $appiled_date = strtotime($appiled_date);
                        $appiled_date = date("d-m-Y h:i:s A", $appiled_date);
                        echo $value->ACC_NAME . " - ". $appiled_date ; //. (($value->created_usr != "") ? (" - " . $value->created_usr) : "") . (($value->COMPLAINED_BY != "") ? " - " . $value->COMPLAINED_BY : "" )
                        ?>
                    </a>
                </h4>
            </div>
            <div id="leave_<?php echo $value->ID ?>" class="panel-collapse collapse" style="height: 0px;">
                <div class="panel-body">
                    <a class="btn btn-green" href="<?php echo site_url('leave/leave_edit') . $value->ID; ?> "> <i class="icon-pencil"></i> Approve </a>
                    <table class="table table-striped table-bordered table-hover table-full-width" style="margin-top: 10px;">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <!--<th>Staff Name</th>-->
                                <th>Date</th>
                                <th>Type</th>
                                <th>Reason</th>
                                <th>Project Manager</th>
                                <th>PM Comment</th>
                                <th>HR</th>
                                <th>HR Comment</th>
                                <!--<th></th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn_count = 1;
                            foreach ($value->details as $key1 => $value1) {
                                $leave_date = $value1->LEAVE_DATE;
                                $leave_date = strtotime($leave_date);
                                $leave_date = date("d-m-Y", $leave_date);
                                ?>
                                <tr>
                                    <td><?php echo $sn_count ?></td>
                                    <!--<td><?php // echo $value1->ACC_NAME      ?></td>-->
                                    <td><?php echo $leave_date ?></td>
                                    <td><?php echo (($value1->LEAVE_TYPE == '0.5') ? 'Half' : 'Full' ) . ' Day' ?></td>
                                    <td><?php echo $value1->REASON ?></td>
                                    <td><?php echo ($value1->PM_STATUS != "") ? ucfirst(str_replace("_", " ", $value1->PM_STATUS)) . ' (' . $value1->pm . ')' : "" ?></td>
                                    <td><?php echo ($value1->PM_COMMENT ? "$value1->PM_COMMENT" : "") ?></td>
                                    <td><?php echo ($value1->HR_STATUS != "") ? ucfirst(str_replace("_", " ", $value1->HR_STATUS)) . ' (' . $value1->hr . ')' : "" ?></td>
                                    <td><?php echo ($value1->HR_COMMENT ? "$value1->HR_COMMENT" : "") ?></td>
                                    <!--<td><?php // echo $value1->REASON      ?></td>-->
<!--                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                                            <ul class="dropdown-menu" role="menu">
                                                <li> <a href="<?php // echo site_url('chellan/print_dc') . $encrypted_data;         ?> " target="_blank"> <i class="icon-print"></i> Print </a> </li>
                                                <li> <a href="<?php // echo site_url('leave/leave_edit') . $value->ID;      ?> "> <i class="icon-pencil"></i> Edit </a> </li>
                                                <li> <a href="#static<?php // echo $value1->ID;      ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>               
                                            </ul>
                                        </div>
                                    </td>-->
                                </tr>
                                <?php
                                $sn_count++;
                            }
                            ?>
                        <div id="static<?php echo $value->ID; ?>" class="modal fade" tabindex="-1" 
                             data-backdrop="static" data-keyboard="false" style="display: none;">
                            <div class="modal-body">
                                <p> Are You sure, that you want to delete selected record? </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                                <a type="button"  class="btn btn-primary" href="<?php echo site_url('leave/leave_delete') . $value->ID; ?> "> Continue </a> </div>
                        </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
</div>