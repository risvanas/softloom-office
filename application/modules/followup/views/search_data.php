<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th style="min-width: 80px">Entry Date</th>
            <th style="min-width: 80px">Next Followup Date</th>
            <th>Description</th>
            <th style="min-width: 110px;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sn_count = $sl_no;
        $cdat = date('d-m-Y');
        foreach ($s->result() as $row) {
            $sn_count++;
            $nxd = $row->NEXTFDATE;
            if (($nxd == "") || ($nxd == "0000-00-00") || ($nxd == "1970-01-01")) {
                $nfdate = "";
            } else {
                $nxdte = strtotime($nxd);
                $nfdate = date('d-m-Y', $nxdte);
            }
            $en = $row->ENTRY_DATE;
            $endte = strtotime($en);
            $endate = date('d-m-Y', $endte);
            ?>
            <tr>
                <td ><?php echo $sn_count; ?></td>
                <td ><?php echo $row->NAME; ?></td>
                <td><?php echo $endate; ?></td>
                <td><?php echo $nfdate; ?></td>
                <td><?php echo $row->description; ?></td>
                <td class=""><div class="btn-group">
                        <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;"> <i class="icon-wrench"></i> Setting </button>
                        <button   data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                        <ul class="dropdown-menu" role="menu">
                            <li> <a href="<?php echo site_url('followup/find_followup_details') . $row->FID; ?>"> <i class="icon-pencil"></i>Edit</a> </li>
                            <!--<li> <a href="#static<?php echo $row->FID; ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>-->
                        </ul>
                    </div>
                </td>
            </tr>
            <!----------------------- start allert box ----------------------------> 
        <div id="static<?php echo $row->FID; ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
            <div class="modal-body">
                <p> Are You sure, that you want to delete selected record? </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                <a type="button"  class="btn btn-primary" href="<?php echo site_url('followup/delete_followup_details'); ?>/<?php echo $row->FID; ?>"> Continue </a>
            </div>
        </div>
        <!----------------------- end allert box ---------------------------->
        <?php
        $s++;
    }
    ?>
    <div id="output">
    </div>
</tbody>

</table>
<div class="row">
    <?php echo $pagination; ?>
</div>
<!-- end: DYNAMIC TABLE PANEL --> 