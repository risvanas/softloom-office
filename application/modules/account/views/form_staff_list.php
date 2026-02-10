<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Staff List
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> 
                    <form action="<?php echo site_url('account/mult_search'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank"> 
                        <input type="hidden" name="srname" id="srname" value="">
                        <input type="hidden" name="statu" id="statu" value="">
                        <input type="hidden" name="per_page" id="per_page" value="10">
                        <input type="hidden" name="cur_page" id="cur_page" value="1">
                        <input type="hidden" name="generate_pdf" value="generate_pdf">
<!--                            <button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value='generate_pdf';this.form.target='_blank';this.form.submit();"><i class="clip-file-pdf"></i></button>
                        <button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value='generate_excel';this.form.target='';this.form.submit();"><i class="clip-file-excel"></i></button>-->
                    </form>
                </div>
            </div>

            <!-- end: PAGE TITLE & BREADCRUMB -->
            <!--            <div class="col-md-12">
                            <h1>Staff List<small></small></h1>
                            <hr />
                        </div>-->
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> Designation </label>
                            <select class="form-control"  id="txt_search_desi" name="txt_search_desi" onchange="search_data()">
                                <option value="">Select</option>
                                <?php foreach ($desi->result() as $row) { ?>
                                    <option value="<?php echo $row->id; ?>"> <?php echo $row->designation; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> Status </label>
                            <select class="form-control"  id="search_status" name="search_status" onchange="search_data()">
                                <option value="">Select</option>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="form-field-mask-1">Name </label>
                        <div class="input-group">
                            <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_search_name" id="txt_search_name" onkeyup="search_data()">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Search! </button>
                            </span> </div>
                    </div>         
                </div>
            </div>
            <div class="panel-body" >
                <div id="output">
                    <table class="table table-striped table-bordered table-hover table-full-width" >
                        <thead>
                            <tr>
                                <th> No</th>
                                <th> Name </th>
                                <th> Contact NO  </th>
                                <th> Designation </th>
                                <th>Status</th>
                                <th style="width:110px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn_count = 1;

                            foreach ($staff_list->result() as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $sn_count; ?> </td>
                                    <td><?php echo $row->ACC_NAME; ?></td>
                                    <td><?php echo $row->PHONE; ?></td>
                                    <td><?php
                                        $desi_id = $row->DESIGNATION;
                                        $query = $this->db->query("select * FROM tbl_designation where id=$desi_id");
                                        $r = $query->row_array();
                                        echo $desi_name = $r['designation'];
                                        ?></td>
                                    <td><?php
                                        $stat = $row->STATUS;
                                        if ($stat == "ACTIVE") {
                                            echo "<span class='label label-success'>$stat</span>";
                                        } else if ($stat == "INACTIVE") {
                                            echo "<span class='label label-danger'>$stat</span>";
                                        }
                                        ?></td>

                                    <td class=""><div class="btn-group">
                                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                                            <ul class="dropdown-menu" role="menu">
                                                <li> <a href="<?php echo site_url('account/staff_edit') . $row->ACC_ID; ?> "> <i class="icon-pencil"></i> Edit </a> </li>
                                                <li> <a href="#static<?php echo $row->ACC_ID; ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>
                                            </ul>
                                        </div></td>
                                </tr>

                                <!----------------------- start allert box ---------------------------->
                            <div id="static<?php echo $row->ACC_ID; ?>" class="modal fade" tabindex="-1" 
                                 data-backdrop="static" data-keyboard="false" style="display: none;">
                                <div class="modal-body">
                                    <p> Are You sure, that you want to delete selected record? </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                                    <a type="button"  class="btn btn-primary" href="<?php echo site_url('account/account_delete') . $row->ACC_ID; ?>"> Continue </a> </div>
                            </div>
                            <!----------------------- end allert box ---------------------------->

                            <div id="responsive<?php echo $row->ACC_ID; ?>" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                                    <h4 class="modal-title">Update</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php //echo site_url('account/update_status');     ?>">
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
                            $sn_count++;
                        }
                        ?>
                        </tbody>

                    </table>
                    <div class="row">
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- end: DYNAMIC TABLE PANEL --> 
    </div>
</div>

<!-- end: PAGE HEADER --> 

<script>
    function search_data(e, per_page, cur_page)
    {
        if ((typeof per_page == "undefined") && (typeof cur_page == "undefined")) {
            cur_page = 1;
            per_page = $("#per_page").val();
        }
        $.ajax({
            type: "POST",
            data:
                    {
                        calc: $('#txt_calc').val(),
                        srname: $('#txt_search_name').val(),
                        dename: $('#txt_search_desi').val(),
                        statu: $('#search_status').val(),
                        per_page: per_page,
                        cur_page: cur_page,
                        acc_mode: "STAFF"
                    },
            url: "<?php echo site_url('account/mult_search'); ?>",
            success: function (data)
            {
                $('#output').html(data);
                $("#per_page").val(per_page)
                $("#cur_page").val(cur_page)
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
