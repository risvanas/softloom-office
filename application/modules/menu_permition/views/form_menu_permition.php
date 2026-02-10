
<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Menu Permission
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"
                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"
                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"
                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"
                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>
            <form  method="post" name="form" action="<?php echo site_url('menu_permition'); ?>" id="form">
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> <button class="close" data-dismiss="alert">
                            ×
                        </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
<!--                    <h2><i class="icon-edit-sign teal"></i> Menu Permition</h2>
                    <div>
                        <hr />
                    </div>-->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> User </label>
                                        <select class="form-control" id="drp_user" name="drp_user" onchange="search_data()">
                                            <option value="">select</option>
                                            <?php
                                            foreach ($user->result() as $row) {
                                                ?>
                                                <option value="<?php echo $row->ACC_ID; ?>"><?php echo $row->ACC_NAME; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="output">
                                        <table  width="200" class="table table-full-width" id="sample_1">
                                            <thead>
                                            <th>No</th>
                                            <th>Menu Name</th>
                                            <th>Add</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            <th>View</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($menu->result() as $row1) {
                                                    ?>
                                                    <tr bgcolor="#BBD749">
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo $row1->SUB_MENU; ?> 
                                                            <input type="hidden" id="txt_menu[<?php echo $count; ?>]" name="txt_menu[<?php echo $count; ?>]" value="<?php echo $id = $row1->MENU_ID; ?>"></td>
                                                        <td><input type="checkbox" value="1" id='add[<?php echo $count; ?>]' name='add[<?php echo $count; ?>]'/></td>
                                                        <td><input type="checkbox" value="1" id='edit[<?php echo $count; ?>]' name='edit[<?php echo $count; ?>]'/></td>
                                                        <td><input type="checkbox" value="1" id='delete[<?php echo $count; ?>]' name='delete[<?php echo $count; ?>]'/></td>
                                                        <td><input type="checkbox" value="1" id='view[<?php echo $count; ?>]' name='view[<?php echo $count; ?>]'/></td>
                                                    </tr>
                                                    <?php
                                                    $sql = "select * from tbl_menu where P_MENU_ID=$id AND DEL_FLAG=1";
                                                    $query = $this->db->query($sql);
                                                    foreach ($query->result() as $val) {
                                                        $count++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $count; ?></td>
                                                            <td><?php echo $val->SUB_MENU; ?> 
                                                                <input type="hidden" id="txt_menu[<?php echo $count; ?>]" name="txt_menu[<?php echo $count; ?>]" value="<?php echo $val->MENU_ID; ?>"></td>
                                                            <td><input type="checkbox" value="1" id='add[<?php echo $count; ?>]' name='add[<?php echo $count; ?>]'/></td>
                                                            <td><input type="checkbox" value="1" id='edit[<?php echo $count; ?>]' name='edit[<?php echo $count; ?>]'/></td>
                                                            <td><input type="checkbox" value="1" id='delete[<?php echo $count; ?>]' name='delete[<?php echo $count; ?>]'/></td>
                                                            <td><input type="checkbox" value="1" id='view[<?php echo $count; ?>]' name='view[<?php echo $count; ?>]'/></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    $count++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" id="count" name="count" value="<?php echo $count - 1; ?>">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div> <span class="symbol required"></span>Required Fields
                                        <hr />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <p> </p>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-block" type="submit"> Register <i class="icon-circle-arrow-right"></i> </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end: DYNAMIC TABLE PANEL --> 
                </div>
            </form>
        </div>
    </div>
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
</div>

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/account_year_registration.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });

</script> 
<script>
    function search_data()
    {
        //alert('hai');
        $.ajax({
            type: "POST",
            data:
            {
                user: $('#drp_user').val()
            },
            url: "<?php echo site_url('menu_permition/select_permition'); ?>",
            success: function (data)
            {
                //alert('hello');
                $('#output').html(data);
            }
        }
        );
    }
</script> 