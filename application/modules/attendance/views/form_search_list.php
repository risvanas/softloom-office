<table class="table table-striped table-bordered table-hover table-full-width" >
    <?php
    if ($rep_type == 'individual') {
        $query = $this->db->query("select ACC_NAME from tbl_account where BIOMETRIC_CODE=$staff");
        $val = $query->row_array();
        $staff_name = $val['ACC_NAME'];
    }
    $condtns = ($rep_type == 'individual') ? ", Year: $year, Month: $month, Staff: $staff_name" : ", Date: $date";
    ?>
    <thead>
        <?php if ($type != 'hme') { ?>
            <tr>
                <td colspan="6"><?php echo "Report Type: " . ucfirst($rep_type) . $condtns ?></td>
            </tr>
        <?php } ?>
        <tr>
            <?php if ($type == 'hme') { ?>
                <th> Date </th>
                <th>Staff Name</th>
                <?php
            } else {
                if ($rep_type == 'individual') {
                    ?>
                    <th> Date </th>
                <?php } else { ?>
                    <th>Staff Name</th>
                    <?php
                }
            }
            ?>
            <th> <?php echo ($type == 'hme') ? "From" : "Punch In Time" ?> </th>
            <th> <?php echo ($type == 'hme') ? "To" : "Punch Out Time" ?> </th>
            <?php if ($type == 'hme') { ?>
                <th></th>
            <?php } else { ?>
                <th> Total Working Hours </th>
                <th> Worked Hours </th>
                <th> Status </th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $sn_count = 1;
        $total_hrs = 0;
        $all_seconds = 0;
        $tot_seconds = 0;
        $grand_total_working_hrs = 0;
        foreach ($cond->result() as $row) {
            $date = $row->DATE;
            $date = strtotime($date);
            $date = date("d-m-Y", $date);
            $punch_in = $row->punch_in;
            $punch_in_tme = (strtotime($punch_in)) ? date('h:i:s a', strtotime($punch_in)) : '00:00:00';
            $punch_out = $row->punch_out;
            $punch_out_tme = (strtotime($punch_out)) ? date('h:i:s a', strtotime($punch_out)) : '00:00:00';
            if ($type != 'hme') {
                $wrkng_hrs = (strtotime($row->working_hrs)) ? strtotime($row->working_hrs) : 0;
                $workng_hrs = (date('H', $wrkng_hrs) >= 4 && strtotime($row->working_hrs)) ? date('H:i:s', $wrkng_hrs) : '00:00:00';
                $total_hrs += $wrkng_hrs;
                list($hour, $minute, $second) = explode(':', $workng_hrs);
                $all_seconds += $hour * 3600;
                $all_seconds += $minute * 60;
                $all_seconds += $second;
                foreach ($calendar->result() as $key => $value) {
                    if ($row->DATE == $value->CAL_DATE) {
                        $tot_wrkng_hrs = strtotime($value->WORKING_HOURS);
                        $total_wrkng_hrs = date('h:i:s', $tot_wrkng_hrs);
                        $grand_total_working_hrs += $tot_wrkng_hrs;
                        list($hour, $minute, $second) = explode(':', $total_wrkng_hrs);
                        $tot_seconds += $hour * 3600;
                        $tot_seconds += $minute * 60;
                        $tot_seconds += $second;
                        break;
                    }
                }
            }
            ?>
            <tr>
                <?php if ($type == 'hme') { ?>
                    <td><?php echo $date; ?></td>
                    <td><?php
                        $query = $this->db->query("select ACC_NAME from tbl_account where BIOMETRIC_CODE=" . $row->tktno);
                        $val = $query->row_array();
                        echo $val['ACC_NAME'];
                        ?></td>
                    <?php
                } else {
                    if ($rep_type == 'individual') {
                        ?>
                        <td><?php echo $date; ?></td>
                    <?php } else { ?>
                        <td><?php echo $row->STAFF_NAME; ?></td>
                        <?php
                    }
                }
                ?>
                <td><?php echo ($punch_in_tme == '00:00:00') ? 0 : $punch_in_tme; ?></td>
                <td><?php echo ($punch_out_tme == '00:00:00') ? 0 : $punch_out_tme; ?></td>
                <?php if ($type != 'hme') { ?>
                    <td><?php echo $total_wrkng_hrs; ?></td>
                    <td><?php echo ($workng_hrs == '00:00:00') ? 0 : $workng_hrs; ?></td>
                    <td>
                        <?php
                        if ($wrkng_hrs == 0) {
                            echo 'Absent';
                        } else if ($wrkng_hrs >= $tot_wrkng_hrs) {
                            echo 'Full Day';
                        } else {
                            echo 'Half Day';
                        }
                        ?>
                    </td>
                <?php } else { ?>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick="hiddenFunction()"> <i class="icon-wrench"></i> Setting </button>
                            <button  onclick="hiddenFunction()"  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                            <ul class="dropdown-menu" role="menu">
                                <li> <a href="#static<?php echo $row->work_hme_id; ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>
                            </ul>
                        </div>
                    </td>
                <?php } ?>
            </tr>
            <?php if ($type == 'hme') { ?>
                <div id="static<?php echo $row->work_hme_id; ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
                    <div class="modal-body">
                        <p> Are You sure, that you want to delete selected record? </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                        <a type="button"  class="btn btn-primary" href="<?php echo site_url('attendance/wrk_at_hme_delete') . $row->work_hme_id; ?>"> Continue </a>
                    </div>
                </div>
                <?php
            }
            $sn_count++;
        }
        $total_minutes = floor($all_seconds / 60);
        $seconds = $all_seconds % 60;
        $hours = floor($total_minutes / 60);
        $minutes = $total_minutes % 60;
        $total_wrkng_minutes = floor($tot_seconds / 60);
        $tot_seconds = $tot_seconds % 60;
        $tot_hours = floor($total_wrkng_minutes / 60);
        $tot_minutes = $total_wrkng_minutes % 60;
        if ($rep_type == 'individual') {
            ?>
            <tr>
                <td colspan="3">Total Working Hours</td>
                <td><?php echo sprintf("%02d:%02d:%02d", $tot_hours, $tot_minutes, $tot_seconds); ?></td>
                <td><?php echo sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds); ?></td>
                <td></td>
            </tr>
        <?php } ?>
    </tbody>
</table>