<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Followup History
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a>
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a>
                    <input type="hidden" name="per_page" id="per_page" value="10">
                    <input type="hidden" name="cur_page" id="cur_page" value="1">                
                </div>
            </div>
            <!--            <div class="col-md-12">
                            <h1>Followup List <small></small></h1>
                            <hr />
                        </div>-->
            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">From Date</label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_from_date" id="txt_from_date" onchange="search_data()" onblur="search_data()" autocomplete="off" value="<?php echo date('d-m-Y') ?>">
                                        <i class="icon-calendar"></i> </span> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">To Date</label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_to_date" id="txt_to_date" onchange="search_data()" onblur="search_data()" autocomplete="off" value="<?php echo date('d-m-Y') ?>">
                                        <i class="icon-calendar"></i> </span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <select name="txtdtype" class="form-control" id="txtdtype" >

                                <option value="Entrydate">Entry Date</option>
                                <option value="Nfdate">NF date </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select name="txtstype" class="form-control" id="txtstype">
                                <option value="">Select</option>
                                <?php
                                foreach ($x->result() as $row) {
                                    ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->status; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Sort</label>
                            <select name="txtsorttype" class="form-control" id="txtsorttype">
                                <option value="">Select Sort type......</option>
                                <option value="Date">By Date </option>
                                <option value="Name">By Name </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="form-field-mask-1"> Key Words </label>
                        <div class="input-group">
                            <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txtseracher" id="txtseracher" autocomplete="off">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Go! </button>
                            </span> </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">  
                <div id="outpt">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th style="min-width: 80px;">Entry Date</th>
                                <th style="min-width: 80px;">Next Followup Date</th>
                                <th>Description</th>
                                <th style="min-width: 110px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn_count = 0;
                            foreach ($s->result() as $row) {
                                $sn_count++;
                                ?>
                                <tr>
                                    <td ><?php echo $sn_count; ?></td>
                                    <td><?php echo $row->NAME; ?></td>
                                    <td><?php
                                        $edate = $row->ENTRY_DATE;
                                        $en_date = strtotime($edate);
                                        echo $en_date = date('d-m-Y', $en_date);
                                        ?></td>
                                    <td><?php
                                        $ndat = $row->NEXTFDATE;
                                        if (($ndat == "") || ($ndat == "0000-00-00") || ($ndat == "1970-01-01")) {
                                            $nf_date = "";
                                        } else {
                                            $n_date = strtotime($ndat);
                                            echo $nf_date = date('d-m-Y', $n_date);
                                        }
                                        ?></td>
                                    <td><?php echo $row->description; ?></td>
                                    <td class=""><div class="btn-group">
                                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;"> <i class="icon-wrench"></i> Setting </button>
                                            <button   data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                                            <ul class="dropdown-menu" role="menu">
                                                <li> <a href="<?php echo site_url('followup/find_followup_details') . $row->FID; ?> "> <i class="icon-pencil"></i>Edit</a> </li>
                                                <!--<li> <a href="#static<?php echo $row->FID; ?>" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </li>-->
                                            </ul>
                                        </div></td>
                                </tr>
                                <!----------------------- start allert box ---------------------------->
                            <div id="static<?php echo $row->FID; ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
                                <div class="modal-body">
                                    <p> Are You sure, that you want to delete selected record? </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                                    <a type="button"  class="btn btn-primary" href="<?php echo site_url('followup/delete_followup_details'); ?>/<?php echo $row->FID; ?>"> Continue </a> </div>
                            </div>
                            <!---------------------- end allert box ----------------------------->
                            <?php
                            $s++;
                        }
                        ?>
                        <div id="output"> </div>
                        </tbody>

                    </table>
                    <div class="row">
                        <?php echo $pagination; ?>
                    </div>
                    <!-- end: DYNAMIC TABLE PANEL --> 
                    <!-- end: PAGE HEADER --> 
                </div>
            </div>

        </div>
    </div>
</div>
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
                datefrom: $('#txt_from_date').val(),
                dateto: $('#txt_to_date').val(),
                dtype: $('#txtdtype').val(),
                stype: $('#txtstype').val(),
                sorttype: $('#txtsorttype').val(),
                per_page: per_page,
                cur_page: cur_page,
                searcher: $('#txtseracher').val()
            },
            url: "<?php echo site_url('followup/search_details'); ?>",
            success: function (data)
            {
                $('#outpt').html(data);
                $("#per_page").val(per_page);
                $("#cur_page").val(cur_page);
            }
        }
        );
    }
</script> 
<!-- end: DYNAMIC TABLE PANEL -->

<!-- end: PAGE HEADER --> 
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();
    });
</script>