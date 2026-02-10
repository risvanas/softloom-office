<?php
//    echo "<pre>";
//    print_r($en_id->row_array());
//    echo "</pre>";
$result = $en_id->row_array();
$address = (($result['ADD1']) ? $result['ADD1'] . ", " : "") . (($result['ADD2']) ? $result['ADD2'] . ", " : "") . (($result['ADD3']) ? $result['ADD3'] . ", " : "");
$address = rtrim($address, ", ");
$reg_date = $result['REG_DATE'];
$reg_date = strtotime($reg_date);
$reg_date = date("d-m-Y h:i:s A", $reg_date);
$nxtfdte = $result['NEXTFDATE'];
$nxtfdte = strtotime($nxtfdte);
$nxtfdte = date("d-m-Y h:i:s A", $nxtfdte);
$sql = "select * from tbl_followupvia where id=" . $result['FOLLOWUPVIA'];
$query = $this->db->query($sql);
$val = $query->row_array();
$followup_via = $val['methods'];
?>
<table class="table table-striped table-bordered table-hover table-full-width">
    <tr>
        <td><strong>NAME</strong></td>
        <td><?php echo $result['NAME'] ?></td>
    </tr>
    <tr>
        <td><strong>Address</strong></td>
        <td><?php echo $address ?></td>
    </tr>
    <tr>
        <td><strong>Phone</strong></td>
        <td><?php echo $result['PHNO'] ?></td>
    </tr>
    <tr>
        <td><strong>Mobile</strong></td>
        <td><?php echo $result['MOBILENO'] ?></td>
    </tr>
    <tr>
        <td><strong>Email</strong></td>
        <td><?php echo $result['EMAIL'] ?></td>
    </tr>
    <tr>
        <td><strong>Entry For</strong></td>
        <td><?php echo $result['ACC_NAME'] ?></td>
    </tr>
    <tr>
        <td><strong>Enquiry From</strong></td>
        <td><?php echo $followup_via ?></td>
    </tr>
    <tr>
        <td><strong>College</strong></td>
        <td><?php echo $result['COLLEGE'] ?></td>
    </tr>
    <tr>
        <td><strong>Registration Date</strong></td>
        <td><?php echo $reg_date ?></td>
    </tr>
    <tr>
        <td><strong>Next Followup Date</strong></td>
        <td><?php echo $nxtfdte ?></td>
    </tr>
</table>

