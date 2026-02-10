  
<table class="table table-striped table-bordered table-hover table-full-width" id="tblstr">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Name</th>
            <th>Salary</th>
        </tr>
    </thead>

    <?php
    $sn_count = 1;
    if ($vno->num_rows() == 0) {
        ?>
        <script>
            document.getElementById("voc_num").style.display = "block";
            document.getElementById("btn_refresh").style.display = "none";
    <?php
    $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='SLA'");
    $row = $query->row_array();
    $book_num = $row['BOOK_NUMBER'];
    ?>
            document.getElementById("txt_buk_num").value =<?php echo $book_num; ?>;
        </script> 
        <?php
    } else {
        ?>
        <script>
            document.getElementById("voc_num").style.display = "none";
            document.getElementById("btn_refresh").style.display = "block";
        </script>
        <?php
        foreach ($vno->result() as $row) {
            ?>
            <script>
                document.getElementById("txt_date").value = '<?php
        $voucher_date = $row->DATE_OF_TRANSACTION;
        $voucher_date = strtotime($voucher_date);
        echo $voucher_date = date("d-m-Y", $voucher_date);
        ?>';
                document.getElementById("temp_voc_num").value = '<?php echo $row->BOOK_NUMBER; ?>';
            </script> 
            <tbody>     
                <tr>
                    <td><?php echo $sn_count; ?></td>
                    <td>
                        <input type="hidden" id="txt_staffid" name="txt_staffid<?php echo $sn_count; ?>" value="<?php echo $row->SUB_ACC; ?>" /><?php echo $row->ACC_NAME; ?>
                        <input type="hidden" id="txt_staffname" name="txt_staffname<?php echo $sn_count; ?>" value="<?php echo $row->ACC_NAME; ?>"/>
                    </td>
                    <td><input autocomplete="off" type="text" id="txt_salary" name="txt_salary<?php echo $sn_count; ?>" value="<?php echo $row->CREDIT; ?>" /></td>
                </tr>

                <?php
                $sn_count++;
            }
        }
        ?>

    </tbody>
</table>

<input autocomplete="off" type="hidden" name="Num" id="Num" value="<?php echo $sn_count; ?>" />  

<script>
    document.getElementById("bttdelete").style.display = "block";
    document.getElementById("hrefdelete").href = '<?php echo site_url('salary_posting/del_data') . "/" . $row->BOOK_NUMBER; ?>';
</script>
