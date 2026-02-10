
<div class="panel-scroll ps-container" style="height: 250px;padding-right: 7px;">
    <table  class="table table-striped table-bordered table-hover table-full-width">
        <tr>
            <th style="min-width: 80px">Date</th>
            <th style="min-width: 75px;">By</th>
            <th>Description</th>
            <th></th>
        </tr>
        <?php
        foreach ($en_id->result() as $result) {
            $en_date = $result->FDATE;
            $ent_date = strtotime($en_date);
            $entry_date = date('d-m-Y', $ent_date);
            $n_date = $result->NEXTFDATE;
            $nf_date = strtotime($n_date);
            $nextfdate = date('d-m-Y', $nf_date);
            ?>
            <tr>
                <td><?php echo $entry_date; ?></td>
    <!--            <td><?php
//                if (($n_date == "0000-00-00") || ($n_date == "") || ($n_date == "1970-01-01")) {
//                    echo $nf_date = "";
//                } else {
//                    echo $nextfdate;
//                }
                ?></td>-->

                <td><?php echo $result->ACC_NAME; ?></td>
                <td><?php echo $result->description; ?></td>
                <td><span class="label <?php echo $result->style_class; ?>"><?php echo $result->status; ?></span></td>
                <td><a type="button"  class="btn btn-xs btn-bricky" href="<?php echo site_url('followup/find_followup_details') . $result->FID . "/" . $result->EN_ID; ?>">Edit</a></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('.panel-scroll').perfectScrollbar({
            wheelSpeed: 50,
            minScrollbarLength: 20,
            wheelPropagation: true
        });
    })

</script>
