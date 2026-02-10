<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <style>
            address {
                margin-bottom: 5px;
            }
        </style>
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Leave Edit
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
<!--                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>-->
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <?php
            foreach ($leave_edit->result() as $row) {
                $id = $row->ID;
                $staff_id = $row->STAFF_ID;
//                $leave_date = $row->LEAVE_DATE;
//                $leave_date = strtotime($leave_date);
//                $leave_date = date("d-m-Y", $leave_date);
//                $leave_type = $row->LEAVE_TYPE;
//                $reason = $row->REASON;
            }
            ?>
            <form  role="form" id="form" method="post" action="<?php echo site_url('leave/leave_update'); ?>">
                <div class="panel-body" >
                    <input type="hidden" class="form-control" id="txt_id" name="txt_id" value="<?php echo $id ?>"/>
<!--                    <div class="successHandler alert alert-success <?php // if ($msg == "") { ?> no-display <?php // } ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <div class="successHandler alert alert-danger <?php // if ($errmsg == "") { ?> no-display <?php // }     ?>"> <i class="icon-remove"></i> <?php // echo $errmsg; ?> </div>-->
<!--                    <h2><i class="icon-group teal"></i> Apply Leave</h2>
                    <div>
                        <hr />
                    </div>-->
                    <div class="row">
                        <div class="col-md-6">
                           <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="control-label"> Staff Name <span class="symbol required"> </span> </label>
                                        <select name="txt_staff" id="txt_staff" class="form-control" onchange="add_account(this)">
                                            <option value="">Select</option>
                                            <?php foreach ($staff_list->result() as $key => $value) {
                                                $selected = ($value->ACC_ID == $staff_id) ? "selected" : "";
                                                ?>
                                                <option value="<?php echo $value->ACC_ID ?>" <?php echo $selected ?>><?php echo $value->ACC_NAME ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="control-label"> Date <span class="symbol required"> </span> </label>
                                        <span class="input-icon input-icon-right">
                                            <input type="text" autocomplete="off" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_date" name="txt_date" onchange="addleave(this.value)"/>
                                            <i class="icon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div id="staff_details">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row" id="table_batch">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover table-full-width" id="tblstr">
                                <thead>
                                    <tr>
                                        <th class="">No</th>
                                        <th class="">Date</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Project Manager</th>
                                        <th>HR</th>
                                        <th>Select</th>
                                    </tr>
                                    <?php
                                    $leave_details = $this->db->query("SELECT * FROM tbl_leave_details WHERE DEL_FLAG = 1 AND LEAVE_ID=$id")->result();
                                    ?>
                                    
                                    <script>
                                        <?php foreach ($leave_details as $key => $value) { ?>
                                            $(document).ready(function() {
                                                addleave("<?php echo $value->LEAVE_DATE ?>","<?php echo $value->LEAVE_TYPE ?>","<?php echo $value->REASON ?>","<?php echo $value->PM_STATUS ?>","<?php echo $value->HR_STATUS ?>", "<?php echo $value->ID ?>")
                                            })
                                            
                                        <?php } ?>
                                    </script>
                                </thead>
                            </table>
                            <div align="right">
                                <label class="btn btn-xs btn-bricky" onclick="deleteChecked('tblstr', 'Num');" onkeyup="hiddenFunction();"><i class="icon-trash"></i> Delete Item</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div> <span class="symbol required"></span>Required Fields
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <p> </p>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block" type="submit"> Update <i class="icon-circle-arrow-right"></i> </button>
                            <input type="hidden" name="Num" id="Num" value="2" />
                        </div>
                    </div>
                </div>
            </form>

            <!-- end: DYNAMIC TABLE PANEL --> 

        </div>
    </div>
</div>
<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
        <h4 class="modal-title">Spare Parts List</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12" id="output"> </div>
        </div>
    </div>
</div>
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/leave.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form-validation/add_leave.js"></script>
<script>

    function addleave(date, leave_type, reason, pm, hr, id)
    {
//        console.log(obj)
//        return;
//        date = $(obj).val();
//        console.log(cmp_id + ', ' + cmp_name + ', ' + unit_price + ', ' + unit_part_no)
        var tbl = document.getElementById('tblstr');
        for (var i = 3; i < tbl.rows.length + 2; i++)
        {
            if (date == document.getElementById("leave_date" + i).value || date == '') {
                //alert("Item already exist!");
                return false;
            }
        }
        var Numx = document.getElementById('Num').value;
        appendRow('tblstr');
        Numx = (Number(Numx) + 1);
        $("#Num").val(Numx);
        $("#leave_date" + Numx).val(date);
        $("#leave_type" + Numx).append($("<option></option>").val('').html("Select"));
        $("#leave_type" + Numx).append($("<option></option>").val('half').html("Half day"));
        $("#leave_type" + Numx).append($("<option></option>").val('full').html("Full day"));
        $("#pm_aprov" + Numx).append($("<option></option>").val('').html("Select"));
        $("#pm_aprov" + Numx).append($("<option></option>").val('approve').html("Approve"));
        $("#pm_aprov" + Numx).append($("<option></option>").val('not_approve').html("Not Approve"));
        $("#hr_aprov" + Numx).append($("<option></option>").val('').html("Select"));
        $("#hr_aprov" + Numx).append($("<option></option>").val('approve').html("Approve"));
        $("#hr_aprov" + Numx).append($("<option></option>").val('not_approve').html("Not Approve"));
        $("#leave_type" + Numx).val(leave_type);
        $("#leave_reason" + Numx).val(reason);
        $("#pm_aprov" + Numx).val(pm);
        console.log(pm + " **** " +  hr);
        
        if(pm != "") {
            $("#pm_aprov" + Numx).attr("disabled",true)
        }
        $("#hr_aprov" + Numx).val(hr);
        if(hr != "") {
            $("#hr_aprov" + Numx).attr("disabled",true)
        }
        $("#leave_detail_id" + Numx).val(id);
        $("#txt_date").val("");
        hiddenFunction();
    }

    function hiddenFunction()
    {
        var count = document.getElementById('Num').value;
        if (Number(count) <= 2)
        {
            document.getElementById('table_batch').style.display = 'none';
        } else
        {
            document.getElementById('table_batch').style.display = 'block';
        }
    }
    
    function add_account(obj) {
        $.ajax({
            type: "POST",
            data: {staff_id: $(obj).val()},
            url: "<?php echo site_url('leave/staff_details'); ?>",
            success: function (data)
            {
                $("#staff_details").html(data);
            }
        });
    }

    $(window).load(function ()
    {
        hiddenFunction();
        $("#txt_staff").change();
    });

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();
    });
    
</script>