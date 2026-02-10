<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
        <tr>
            <th>No</th>
            <?php if ($type == 'enq_rep') { ?>
                <th>Followup Via</th>
                <th>Active</th>
                <th>Registered</th>
                <th>Walkin</th>
                <th>Not Interested</th>
            <?php } else { ?>
                <th>Name</th>
                <th>Enquiry For</th>
                <th>Phone No</th>
                <th style="min-width: 80px;">Reg Date</th>
                <th style="min-width: 80px;">Last Followup Date</th>
                <th style="min-width: 80px;">Next Followup Date</th>
                <th>Status</th>
                <th style="min-width: 110px;">&nbsp;</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $sn = $sl_no;
        $registered = $active = $walkin = $not_interested = 0;
        foreach ($SearchCondition->result() as $row) {
            $sn++;
            ?>
            <tr>
                <td><?php echo $sn; ?></td>
                <?php
                if ($type == 'enq_rep') {
                    $active += $row->active;
                    $registered += $row->registered;
                    $walkin += $row->walkin;
                    $not_interested += $row->not_interested;
                    ?>
                    <td><?php echo $row->methods; ?></td>
                    <td><?php echo $row->active; ?></td>
                    <td><?php echo $row->registered; ?></td>
                    <td><?php echo $row->walkin; ?></td>
                    <td><?php echo $row->not_interested; ?></td>
                <?php } else { ?>
                    <td><?php echo $row->NAME; ?></td>
                    <td><?php echo $row->ACC_NAME; ?></td>
                    <td><?php echo $row->PHNO; ?></td>
                    <td><?php
                        $regdt = $row->REG_DATE;
                        if (($regdt == "") || ($regdt == "0000-00-00") || ($regdt == "1970-01-01")) {
                            echo $reg_date = "";
                        } else {
                            $regdte = strtotime($regdt);
                            echo $reg_date = date('d-m-Y', $regdte);
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $LASTFDATE = $row->LASTFDATE;
                        $LASTFDATE = strtotime($LASTFDATE);
                        $LASTFDATE = date("d-m-Y", $LASTFDATE);
                        if ($LASTFDATE == '01-01-1970') {
                            $LASTFDATE = "";
                        }
                        echo $LASTFDATE;
                        ?>

                    </td>
                    <td>
                        <?php
                        $crnt_date = date('d-m-Y');
                        $NEXTFDATE = $row->NEXTFDATE;
                        $NEXTFDATE = strtotime($NEXTFDATE);
                        $NEXTFDATE = date("d-m-Y", $NEXTFDATE);
                        if (strtotime($crnt_date) == strtotime($NEXTFDATE))
                            echo "<span class='label label-success'>$NEXTFDATE</span>";
                        else if (strtotime($crnt_date) < strtotime($NEXTFDATE))
                            echo "<span class='label label-warning' >$NEXTFDATE</span>";
                        else if (strtotime($crnt_date) > strtotime($NEXTFDATE)) {
                            if ($NEXTFDATE == '01-01-1970') {
                                $NEXTFDATE = "";
                            }
                            echo "<span class='label label-danger'>$NEXTFDATE</span>";
                        }
                        ?>
                    </td>
                    <td><span class="label <?php echo $row->style_class; ?>" ><?php echo $row->status; ?></span></td>
                    <td class=""><div class="btn-group" width="90">
                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick="hiddenFunction()"> <i class="icon-wrench"></i> Setting </button>
                            <button  onclick="hiddenFunction()"  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#addnewfolloup" data-toggle="modal" 
                                       onclick="getFollowupDetails(<?php echo $row->EN_ID; ?>); enquiry_name('<?php echo $row->NAME; ?>'); setStatus('<?php echo "soid" . $row->STATUS; ?>');"> <i class="clip-folder-plus"></i>&nbsp;Add Followup </a> </li>
                                <li> <a href="<?php echo site_url('enquiry/find_enquiry_details'); ?>/<?php echo $row->EN_ID; ?> " onclick="loadDat()"> <i class="icon-pencil"></i>&nbsp;Edit Profile</a> </li>
                                <li> <a href="#static<?php echo $row->EN_ID; ?>" data-toggle="modal"> <i class="icon-trash"></i>&nbsp;Delete Profile</a> </li>
                            </ul>
                        </div>
                    </td>
                <?php } ?>
            </tr>
            <?php if ($type != 'enq_rep') { ?> 
                <!----------------------- start allert box ---------------------------->

                <div id="static<?php echo $row->EN_ID; ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
                    <div class="modal-body">
                        <p> Are You sure, that you want to delete selected record? </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                        <a type="button"  class="btn btn-primary" href="<?php echo site_url('enquiry/delete_enquiry_details') . $row->EN_ID; ?>"> Continue </a> </div>
                </div>
                <!----------------------- end allert box ---------------------------->
                <?php
            }
        } if ($type == 'enq_rep') {
            ?>
            <tr>
                <td></td>
                <td>Total</td>
                <td><?php echo $active; ?></td>
                <td><?php echo $registered; ?></td>
                <td><?php echo $walkin; ?></td>
                <td><?php echo $not_interested; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="row">
    <?php echo $pagination; ?>
</div>