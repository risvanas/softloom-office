<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
        <tr>
            <th>No</th>
            <th>Student Name</th>
            <th>Contact Number</th>
            <th>Course Fee</th>
            <th>Paid Amount</th>
            <th>Balance Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $n = 1; foreach ($cond->result() as $row) {
            $id              = $row->STUDENT_ID;
            $stud_name       = $row->NAME;
            $contact_number  = $row->CONTACT_NO;
            $course_fee      = $row->FEE_AMOUNT;
            $paid_amount     = isset($paid_amounts[$id]) ? $paid_amounts[$id] : 0;
            $balance_amount  = $course_fee - $paid_amount;
        ?>
        <tr>
            <td><?php echo $n; ?></td>
            <td><?php echo $stud_name; ?></td>
            <td><?php echo $contact_number; ?></td>
            <td><?php echo $course_fee; ?></td>
            <td><?php echo $paid_amount; ?></td>
            <td><?php echo $balance_amount; ?></td>
        </tr>
        <?php $n++; } ?>
    </tbody>
</table>
<script>
jQuery(document).ready(function() {
    Main.init();
    FormElements.init();
});
</script>
