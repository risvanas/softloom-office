<?php foreach ($staff_list->result() as $row) { ?>   
    <div class="well">
        <?php
        $address = (($row->ADDRESS_ONE) ? $row->ADDRESS_ONE . ", " : "") . (($row->ADDRESS_TWO) ? $row->ADDRESS_TWO : "");
        $address = rtrim($address, ", ");
        $join_date = $row->JOINING_DATE;
        $join_date = strtotime($join_date);
        $join_date = date("d-m-Y", $join_date);
        $experience = (($row->YEAR_OF_EXPRIANS) ? $row->YEAR_OF_EXPRIANS . ' Year ' : '') . (($row->MNTH_OF_EXPRIANS) ? $row->MNTH_OF_EXPRIANS . ' Month' : '')
        ?>
        <address>
            <strong>Staff Name:</strong>&nbsp;<?php echo $row->ACC_NAME ?><br>
            <strong>Designation:</strong>&nbsp;<?php echo $row->designation ?><br>
            <strong>Address:</strong>&nbsp;<?php echo $address ?><br>
            <strong>Phone:</strong>&nbsp;<?php echo $row->PHONE ?><br>
            <strong>Email:</strong>&nbsp;<?php echo $row->ACC_EMAIL ?><br>
            <strong>Experience:</strong>&nbsp;<?php echo $experience ?><br>
            <strong>Joining Date:</strong>&nbsp;<?php echo $join_date ?><br>
        </address>
    </div>
<?php } ?>