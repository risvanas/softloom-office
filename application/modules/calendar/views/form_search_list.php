<table class="table table-striped table-bordered table-hover table-full-width" >
    <?php
//    if ($rep_type == 'individual') {
//        $query = $this->db->query("select ACC_NAME from tbl_account where BIOMETRIC_CODE=$staff");
//        $val = $query->row_array();
//        $staff_name = $val['ACC_NAME'];
//    }
//    $condtns = ($rep_type == 'individual') ? ", Year: $year, Month: $month, Staff: $staff_name" : ", Date: $date";
    ?>
    <thead>
<!--        <tr>
            <td colspan="6"><?php // echo "Report Type: " . ucfirst($rep_type) . $condtns ?></td>
        </tr>-->
        <tr>
            <th> No </th>
            <?php // if ($rep_type == 'individual') { ?>
                <!--<th> Date </th>-->
            <?php // } else { ?>
                <th>Staff Name</th>
                <th>Salary</th>
            <?php // } ?>
            <th> Total Working Hours </th>
            <th> Working Hours </th>
            <th> Total Working Days </th>
            <th> Working Days </th>
            <th> Leave Days </th>
            <th> Absent Days </th>
            <th> LOP </th>
            <th> Salary </th>
<!--            <th> Status </th>-->
        </tr>
    </thead>
    <tbody>
        <?php
        $sn_count = 1;
//        $total_hrs = 0;
//        $all_seconds = 0;
        foreach ($cond->result() as $row) {
//            $date = $row->DATE;
//            $date = strtotime($date);
//            $date = date("d-m-Y", $date);
            $tot_workng_hrs = $row->TOT_WRKING ? $row->TOT_WRKING : 0;
            $workng_hrs = $row->WRKING_hrs ? $row->WRKING_hrs : 0;
            ?>
            <tr>
                <td><?php echo $sn_count; ?> </td>
                <?php // if ($rep_type == 'individual') { ?>
                    <!--<td><?php // echo $date; ?></td>-->
                <?php // } else { ?>
                    <td><?php echo $row->STAFF_NAME; ?></td>
                    <td><?php echo $row->SALARY; ?></td>
                <?php // } ?>
                <td><?php echo ($tot_workng_hrs == '00:00:00') ? 0 : $tot_workng_hrs; ?></td>
                <td><?php echo ($workng_hrs == '00:00:00') ? 0 : $workng_hrs; ?></td>
                <td><?php echo $row->TOT_WORKING_DAYS; ?></td>
                <td><?php echo  $row->WORKING_DAYS; ?></td>
                <td><?php echo $row->LEAVE_DAYS; ?></td>
                <td><?php echo  $row->ABSENT_DAYS; ?></td>
                <td><?php echo  $row->LOP; ?></td>
                <td><?php echo  $row->salary_earn; ?></td>
                <!--<td>-->
                    <?php
//                    if (date('h', $wrkng_hrs) < 4 || !strtotime($row->working_hrs)) {
//                        echo 'Absent';
//                    } else if (date('h', $wrkng_hrs) >= 8) {
//                        echo 'Full Day';
//                    } else {
//                        echo 'Half Day';
//                    }
                    ?>
                <!--</td>-->
            </tr>
            <?php
            $sn_count++;
        }
//        $total_minutes = floor($all_seconds / 60);
//        $seconds = $all_seconds % 60;
//        $hours = floor($total_minutes / 60);
//        $minutes = $total_minutes % 60;
//        if ($rep_type == 'individual') {
            ?>
<!--            <tr>
                <td colspan="4">Total Working Hors</td>
                <td><?php // echo sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds); ?></td>
                <td></td>
            </tr>-->
        <?php // } ?>
    </tbody>
</table>