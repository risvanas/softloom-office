<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Login Details
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> 
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> 
<!--                    <form action="<?php // echo site_url('spare/mult_search'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank"> 
                        <input type="hidden" name="type" id="type" value="toner_rep">
                        <input type="hidden" name="ins_statu" id="ins_statu" value="">
                        <input type="hidden" name="fromdate" id="fromdate" value="">
                        <input type="hidden" name="todate" id="todate" value="">
                        <input type="hidden" name="call_statu" id="call_statu" value="">
                        <input type="hidden" name="generate_pdf" value="generate_pdf">
                        <button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value = 'generate_pdf';this.form.target = '_blank';this.form.submit();"><i class="clip-file-pdf"></i></button>
                        <button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value = 'generate_excel';this.form.target = '';this.form.submit();"><i class="clip-file-excel"></i></button>
                    </form>-->
                </div>
            </div>

            <div class="panel-body" >
                <!--                <div class="row">
                                    <div class="col-md-12">
                                        <h1>Leave Application List<small></small></h1>
                                        <hr />
                                    </div>
                                </div>-->
                <div class="row">
                    <?php
//                    $from_date = date('d-m-Y');
//                    $to_date = date('d-m-Y', strtotime('+1 month'));
                    ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="form-field-mask-1">Staff </label>
                            <select class="form-control" id="search_staff" name="search_staff">
                                <option value="">All</option>
                                <?php foreach ($staff_list->result() as $key => $value) { ?>
                                    <option value="<?php echo $value->ACC_ID ?>"><?php echo $value->ACC_NAME ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> From date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from" value="">
                                <i class="icon-calendar"></i> 
                            </span> 
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> To date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to" value="">
                                <i class="icon-calendar"></i> 
                            </span> 
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group"> <br>
                            <button type="button" class="btn btn-green btn-block" onclick="search_data()">search</button>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-scroll ps-container" >
                            <div id="output" class="">
                                <table class="table table-striped table-bordered table-hover table-full-width" style="margin-top: 10px;">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Staff Name</th>
                                            <th>Date & Time</th>
                                            <th>Device</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn_count = 1;
                                        foreach ($cond as $key => $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $sn_count ?></td>
                                                <td><?php echo $value->ACC_NAME ?></td>
                                                <td>
                                                    <?php
                                                    echo date_default_timezone_get() . "<br>";
                                                    $log_date = $value->DATE_TIME;
                                                    $log_date = strtotime($log_date);
                                                    echo $log_date = date("d-m-Y h:i:s a", $log_date); ?>
                                                </td>
                                                <td><?php echo $value->DEVICE ?></td>
                                             </tr>
                                            <?php
                                            $sn_count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <!--
                                <div class="panel-group accordion-custom accordion-teal" id="accordion">
                                    <?php // foreach ($cond as $key => $value) { ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#leave_<?php // echo $value->ID ?>">
                                                        <i class="icon-arrow"></i>
                                                        <?php
//                                                        $appiled_date = $value->CREATED_ON;
//                                                        $appiled_date = strtotime($appiled_date);
//                                                        $appiled_date = date("d-m-Y h:i:s A", $appiled_date);
//                                                        echo $value->ACC_NAME . " - " . $appiled_date; // $ins_date . (($value->created_usr != "") ? (" - " . $value->created_usr) : "") . (($value->COMPLAINED_BY != "") ? " - " . $value->COMPLAINED_BY : "" )
                                                        ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="leave_<?php // echo $value->ID ?>" class="panel-collapse collapse" style="height: 0px;">
                                                <div class="panel-body">
                                                    <a class="btn btn-green" href="<?php // echo site_url('leave/leave_edit') . $value->ID; ?> "> <i class="icon-pencil"></i> Approve </a>
                                                    <a class="btn btn-green" href="#static<?php // echo $value->ID;   ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a>               

                                                    <table class="table table-striped table-bordered table-hover table-full-width" style="margin-top: 10px;">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl No</th>
                                                                <th>Staff Name</th>
                                                                <th>Date</th>
                                                                <th>Type</th>
                                                                <th>Reason</th>
                                                                <th>Project Manager</th>
                                                                <th>HR</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
//                                                            $sn_count = 1;
//                                                            foreach ($value->details as $key1 => $value1) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php // echo $sn_count ?></td>
                                                                    <td><?php // echo $value1->ACC_NAME   ?></td>
                                                                    <td><?php // echo $value1->LEAVE_DATE ?></td>
                                                                    <td><?php // echo (($value1->LEAVE_TYPE == '0.5') ? 'Half' : 'Full' ). ' Day' ?></td>
                                                                    <td><?php // echo $value1->REASON ?></td>
                                                                    <td><?php // echo ($value1->PM_STATUS != "") ? ucfirst(str_replace("_", " ", $value1->PM_STATUS)) . ' (' . $value1->pm . ')' : "" ?></td>
                                                                    <td><?php // echo ($value1->HR_STATUS != "") ? ucfirst(str_replace("_", " ", $value1->HR_STATUS)) . ' (' . $value1->hr . ')' : "" ?></td>
                                                                    <td><?php // echo $value1->REASON   ?></td>
                                                                            <td>
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                                                                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                                                                            <ul class="dropdown-menu" role="menu">
                                                                                <li> <a href="<?php // echo site_url('chellan/print_dc') . $encrypted_data;      ?> " target="_blank"> <i class="icon-print"></i> Print </a> </li>
                                                                                <li> <a href="<?php // echo site_url('leave/leave_edit') . $value->ID;   ?> "> <i class="icon-pencil"></i> Edit </a> </li>
                                                                                <li> <a href="#static<?php // echo $value1->ID;   ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>               
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
//                                                                $sn_count++;
//                                                            }
                                                            ?>
                                                        <div id="static<?php // echo $value->ID; ?>" class="modal fade" tabindex="-1" 
                                                             data-backdrop="static" data-keyboard="false" style="display: none;">
                                                            <div class="modal-body">
                                                                <p> Are You sure, that you want to delete selected record? </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                                                                <a type="button"  class="btn btn-primary" href="<?php // echo site_url('leave/leave_delete') . $value->ID; ?> "> Continue </a> </div>
                                                        </div>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php // } ?>
                                </div>
-->                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end: DYNAMIC TABLE PANEL --> 
    </div>
</div>

<!-- end: PAGE HEADER --> 

<script>
    function search_data()
    {
        console.log($('#sort_by').val())
        $.ajax({
            type: "POST",
            data:
                    {
                        fromdate: $('#txt_from').val(),
                        todate: $('#txt_to').val(),
                        staff: $('#search_staff').val()
                    },
            url: "<?php echo site_url('dashboard/mult_search'); ?>",
            success: function (data)
            {
                $('#output').html(data);
//                $("#ins_statu").val($('#search_ins_status').val())
//                $("#call_statu").val($('#search_call_status').val())
//                $("#fromdate").val($('#txt_from').val())
//                $("#todate").val($('#txt_to').val())
//                $("#sort_by").val($('#order_by').val())
//                $("#per_page").val($('#search_status').val())
//                $("#cur_page").val($('#search_status').val())
            }
        });
    }
</script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();

    });

</script> 
