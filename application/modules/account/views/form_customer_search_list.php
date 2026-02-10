<table class="table table-striped table-bordered table-hover table-full-width" >
    <thead>
        <tr>
            <th> No</th>
            <th> Name </th>
            <?php if ($acc_mode == "CUSTOMER") { ?>
                <th> Address </th>
            <?php } ?>
            <th> Contact NO  </th>
            <?php if ($acc_mode == "STAFF") { ?>
                <th> Designation </th>
            <?php } ?>
            <th>Status</th>
            <?php if ($type != 'rep') { ?>
                <th style="width:110px;">&nbsp;</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $sn_count = $sl_no;

        foreach ($customer_list->result() as $row) {
            $address = $row->ADDRESS_ONE . ", " . $row->ADDRESS_TWO;
            $address = rtrim($address, ", ");
            ?>
            <tr>
                <td><?php echo $sn_count; ?> </td>
                <td><?php echo $row->ACC_NAME; ?></td>
                <?php if ($acc_mode == "CUSTOMER") { ?>
                    <td><?php echo $address ?></td>
                <?php } ?>
                <td><?php echo (($row->PHONE) ? $row->PHONE : ""); ?></td>
                <?php if ($acc_mode == "STAFF") { ?>
                    <td><?php echo $row->designation; ?></td>
                <?php } ?>
                <td><?php
                    $stat = $row->STATUS;
                    if ($stat == "ACTIVE") {
                        echo "<span class='label label-success'>$stat</span>";
                    } else if ($stat == "INACTIVE") {
                        echo "<span class='label label-danger'>$stat</span>";
                    }
                    ?></td>
                <?php if ($type != 'rep') { ?>
                    <td class=""><div class="btn-group">
                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                            <ul class="dropdown-menu" role="menu">
                                <?php
                                if ($acc_mode == "STAFF") {
                                    $edit_url = site_url('account/staff_edit') . $row->ACC_ID;
                                    $delete_url = site_url('account/account_delete') . $row->ACC_ID . '/stf';
                                } else if ($acc_mode == "CUSTOMER") {
                                    $edit_url = site_url('account/customer_edit') . $row->ACC_ID;
                                    $delete_url = site_url('account/account_delete') . $row->ACC_ID . '/cust';
                                }
                                ?>
                                <li> <a href="<?php echo $edit_url ?> "> <i class="icon-pencil"></i> Edit </a> </li>
                                <li> <a href="#static<?php echo $row->ACC_ID; ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>
                            </ul>
                        </div>
                    </td>
                <?php } ?>
            </tr>
            <?php if ($type != 'rep') { ?>
                <!----------------------- start allert box ---------------------------->
                <div id="static<?php echo $row->ACC_ID; ?>" class="modal fade" tabindex="-1" 
                     data-backdrop="static" data-keyboard="false" style="display: none;">
                    <div class="modal-body">
                        <p> Are You sure, that you want to delete selected record? </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                        <a type="button"  class="btn btn-primary" href="<?php echo $delete_url; ?>"> Continue </a> </div>
                </div>
                <!----------------------- end allert box ---------------------------->

                <div id="responsive<?php echo $row->ACC_ID; ?>" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                        <h4 class="modal-title">Update</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php //echo site_url('account/update_status');         ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php $stat = $row->STATUS; ?>
                                    <input type="hidden" name="txt_id" value="<?php echo $row->ACC_ID; ?>" />
                                    <h1>Update Status</h1>
                                    <div class="row">
                                        <div class="col-md-3"> Status
                                            <select name="sel_status" class="form-control">
                                                <option value="ACTIVE">ACTIVE</option>
                                                <option value="INACTIVE">INACTIVE</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2"> <span style="color:#FFF">hghdh</span>
                                            <input type="Submit"  value="Submit" class="form-control btn btn-green"  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-light-grey"> Close </button>
                        <button type="button" class="btn btn-blue"> Save changes </button>
                    </div>
                </div>
                <?php
            }
            $sn_count++;
        }
        ?>
    </tbody>
</table>
<div class="row">
    <?php echo $pagination; ?>
</div>
