<table class="table table-striped table-bordered table-hover table-full-width" style="margin-top: 10px;">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Staff Name</th>
            <th>Date & Time</th>
            <th>Device</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sn_count = 1;
        foreach ($cond as $key => $value) {
            ?>
            <tr>
                <td><?php echo $sn_count ?></td>
                <td><?php echo $value->ACC_NAME ?></td>
                <td>
                    <?php
                    echo date_default_timezone_get() . "<br>";
                    $log_date = $value->DATE_TIME;
                    $log_date = strtotime($log_date);
                    echo $log_date = date("d-m-Y h:i:s a", $log_date);
                    ?>
                </td>
                <td><?php echo $value->DEVICE ?></td>
            </tr>
            <?php
            $sn_count++;
        }
        ?>
    </tbody>
</table>