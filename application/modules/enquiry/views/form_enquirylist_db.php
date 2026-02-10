<!-- start: DYNAMIC TABLE PANEL -->
<style>
    .datepicker {
        z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
<div class="row" style="padding-top:20px;" >
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Enquiry List
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
                            <h1>Enquiry List <small></small></h1>
                            <hr />
                        </div>-->
            <!-- end: PAGE TITLE & BREADCRUMB -->
            <?php 
            $current_date = date('d-m-Y');
            $first_date = date('01-m-Y');
            ?>
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="row">
                           <div class="col-md-6">
                               <!--  <div class="form-group">
                                    <label class="control-label">From Date</label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_from_date" id="txt_from_date" onchange="search_data()" onblur="search_data()" value="<?php echo $first_date ?>">
                                        <i class="icon-calendar"></i> </span> </div>-->
                            </div>
                            <div class="col-md-6">
                              <!--  <div class="form-group">
                                    <label class="control-label">To Date</label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_to_date" id="txt_to_date" onchange="search_data()" onblur="search_data()" value="<?php echo $current_date ?>">
                                        <i class="icon-calendar"></i> </span> </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                       <!-- <div class="form-group">
                            <label class="control-label">Date</label>
                            <select name="txtdtype" class="form-control" id="txtdtype">
                                <option value="NEXTFDATE">NF date </option>
                                <option value="REG_DATE">Reg Date</option>
                                <option value="ENTRYDATE">Entry Date</option>
                                <option value="LASTFDATE" selected>Followup Date</option>
                            </select>
                        </div>-->
                    </div>
                    <div class="col-md-2">
                        <!--<div class="form-group">
                            <label class="control-label">Status</label>
                            <select name="txtstype" class="form-control" id="txtstype" onchange="search_data()">
                                <option value="">Select</option>
                                <?php foreach ($Status->result() as $row) { ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->status; ?></option>
                                <?php } ?>
                            </select>
                        </div>-->
                    </div>
                    <div class="col-md-2">
                       <!-- <div class="form-group">
                            <label class="control-label">Sort by</label>
                            <select name="txtsorttype" class="form-control" id="txtsorttype" onchange="search_data()">
                                <option value="NAME">By Name </option>
                                <option value="REG_DATE">By Reg Date </option>
                                <option value="NEXTFDATE" selected="selected">By NF Date </option>
                            </select>
                        </div>-->
                    </div>
                    <div class="col-md-3">
                     <!--   <label for="form-field-mask-1"> Key Words </label>
                        <div class="input-group">
                            <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_key_words" id="txt_key_words" onkeyup="search_data()">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Go! </button>
                            </span> </div>-->
                    </div>
                </div>
            </div>
            <!-----------------------Start view Enquiry Details ---------------------------->
            <div class="panel-body">
                <div id="out">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Enquiry For</th>
                                <th>PhoneNo</th>
                                <th>Reg Date</th>
                                <th>Last Followup Date</th>
                                <th>Next Followup Date</th>
                                <th>Status</th>
                                <th width="148" style="width:150px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn = 0;
                            $cdat = date('Y-m-d');
                            foreach ($Enquiry->result() as $row) {
                                $sn++;
                                ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
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
                                        ?></td>
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

                                    <td><span class="label <?php echo $row->style_class; ?>"><?php echo $row->status; ?></span></td>
                                    <td class=""><div class="btn-group" width="90">
                                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;"> <i class="icon-wrench"></i> Setting </button>
                                            <button data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                                            <ul class="dropdown-menu" role="menu">
                                                <?php ?>
                                                <li><a href="#addnewfolloup" data-toggle="modal" 
                                                       onclick="getFollowupDetails(<?php echo $row->EN_ID; ?>); enquiry_name('<?php echo $row->NAME; ?>'); setStatus('<?php echo "soid" . $row->STATUS; ?>');"> <i class="clip-folder-plus"></i>&nbsp;Add Followup </a> </li>
                                                <li> <a href="<?php echo site_url('enquiry/find_enquiry_details'); ?>/<?php echo $row->EN_ID; ?>"> <i class="icon-pencil"></i>&nbsp;Edit Profile</a> </li>
                                                <li> <a href="#static<?php echo $row->EN_ID; ?>" data-toggle="modal"> <i class="icon-trash"></i>&nbsp;Delete Profile</a> </li>
                                            </ul>
                                        </div></td>
                                </tr>

                                <!----------------------- start allert box ---------------------------->
                                <div id="static<?php echo $row->EN_ID; ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
                                    <div class="modal-body">
                                        <p> Are You sure, that you want to delete selected record? </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                                        <a type="button"  class="btn btn-primary" href="<?php echo site_url('enquiry/delete_enquiry_details'); ?>/<?php echo $row->EN_ID; ?>"> Continue </a> </div>
                                </div>
                                <!----------------------- end allert box ---------------------------->
                                                            <?php
                            $Enquiry++;
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
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="panel-body">
                <div class="form-group">
                    <div class="form-group">
                     <label class="control-label">From Date</label>
                      <span class="input-icon input-icon-right">
                      <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_from_date" id="txt_from_date" value="<?php echo $first_date ?>">
                      <i class="icon-calendar"></i> </span> </div> 
               
                    <div class="form-group">
                    <label class="control-label">To Date</label>
                    <span class="input-icon input-icon-right">
                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_to_date" id="txt_to_date" value="<?php echo $current_date ?>">
                     <i class="icon-calendar"></i> </span> </div>
                <div class="form-group">
                    <label class="control-label">College</label>
                    <select name="drp_college" class="form-control" id="drp_college">
                        <option value="">Select</option>
                        <?php
                        foreach ($College->result() as $row) { ?>
                            <option value="<?php echo $row->COLLEGE; ?>"><?php echo $row->COLLEGE; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                            <label class="control-label">Course</label>
                            <select name="drp_course" class="form-control" id="drp_course">
                                <option value="">Select</option>
                                <?php
                                foreach ($Course->result() as $row) { ?>
                                    <option value="<?php echo $row->COURSE; ?>"><?php echo $row->COURSE; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                <div class="form-group">
                            <label class="control-label">Semester/Year</label>
                            <select name="drp_sem" class="form-control" id="drp_sem">
                                <option value="">Select</option>
                                <?php
                                foreach ($Semester->result() as $row) { ?>
                                    <option value="<?php echo $row->SEMESTER; ?>"><?php echo $row->SEMESTER; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                <div class="form-group">
                            <label class="control-label">Status</label>
                            <select name="txtstype" class="form-control" id="txtstype">
                                <option value="">Select</option>
                                <?php foreach ($Status->result() as $row) { ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->status; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                <div class="form-group">
                            <label class="control-label">Sort by</label>
                            <select name="txtsorttype" class="form-control" id="txtsorttype">
                                <option value="NAME">By Name </option>
                                <option value="REG_DATE">By Reg Date </option>
                                <option value="NEXTFDATE" selected="selected">By NF Date </option>
                            </select>
                        </div>
                <div class="form-group">
                            <label for="form-field-mask-1"> Key Words </label>
                            <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_key_words" id="txt_key_words">
                        </div>
                
                <input type="button" name="btn_show_folowup_histry" id="btn_show_folowup_histry"  onclick="search_data()" value="Search" class="btn btn-dark-beige btn-block" >
                <!--<input type="button" name="btn_print" id="btn_print" value="PRINT" onclick="printDiv('output', 'Day Book')" class="btn btn-dark-beige"  >-->
            </div>
        </div>
    </div>
</div>
<!-----------------------End view Enquiry Details ----------------------------> 

<!----------------------- start add new followup ---------------------------->
<div id="addnewfolloup" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">New Followup To
                <label id="lbl_equ_name"></label>
            </h4>
        </div>
        <div class="modal-body">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#add_new" aria-controls="add_new" role="tab" data-toggle="tab">Add New</a>
                    </li>
                    <li role="presentation">
                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
                    </li>
                    <li role="presentation">
                        <a href="#follow_up_detail" aria-controls="follow_up_detail" role="tab" data-toggle="tab">Followup</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" >
                    <div role="tabpanel" class="tab-pane active" id="add_new">
                        <form action="<?php echo site_url('followup'); ?>" name="form" id="form" role="form" method="post" >
                            <div calss="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input autocomplete="off" type="hidden" class="form-control" id="txt_en_id" name="txt_en_id"/>
                                            <div class="form-group">
                                                <label class="control-label">Status<span class="symbol required"></span> </label>
                                                <select class="form-control" id="txt_status" name="txtstatus">
                                                    <option value="">Select</option>
                                                    <?php foreach ($Status->result() as $r) { ?>
                                                        <option id="<?php echo "soid" . $r->id; ?>" value="<?php echo $r->id; ?>"><?php echo $r->status; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Followup Date<span class="symbol required"></span> </label>
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtfdate" value="<?php echo date('d-m-Y'); ?>" id="txtfdate" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Next Followup Date<span class="symbol required"></span> </label>
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtnfdate"    id="con" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Description<span class="symbol required"></span> </label>
                                                <textarea class="form-control" id="txt_desp" name="txtdesp"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                <button type="button" data-dismiss="modal" class="btn btn-light-grey"> Close </button>
                                                <button class="btn btn-primary" type="submit" >Save </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile"></div>
                    <div role="tabpanel" class="tab-pane" id="follow_up_detail" > </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!----------------------- end add new followup ----------------------------> 

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/enquiry_pop.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });

    function hiddenFunction()
    {
        //settings click
        $.ajax({
            type: "POST",
            data: {
                datefrom: $('#txt_from_date').val(),
                dateto: $('#txt_to_date').val()
            },
            url: "<?php echo site_url('enquiry/sel_date_details'); ?>",
            success: function (data)
            {
                $('#outpt').html(data);
            }
        }
        );
    }

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
                dtype: 'REG_DATE',
                stype: $('#txtstype').val(),
				college: $('#drp_college').val(),
                course: $('#drp_course').val(),
                sem: $('#drp_sem').val(),
                sorttype: $('#txtsorttype').val(),
                key_words: $('#txt_key_words').val(),
                per_page: per_page,
                cur_page: cur_page,
                type: 'enqry_db_list'
            },
            url: "<?php echo site_url('enquiry/search_enquiry_details'); ?>",
            success: function (data)
            {
                $('#out').html(data);
                $("#per_page").val(per_page);
                $("#cur_page").val(cur_page);
            }
        }
        );
    }

    function getFollowupDetails(en_id)
    {
        console.log(en_id)
        document.getElementById("txt_en_id").value = en_id;
        $.ajax({
            type: "POST",
            data:
            {
                eid: en_id
            },
            url: "<?php echo site_url('enquiry/followup_details'); ?>",
            success: function (data)
            {
                $('#follow_up_detail').html(data);
            }
        });
        get_profile(en_id);
    }

    function get_profile(en_id)
    {
        console.log(en_id)
        $.ajax ({
            type: "POST",
            data:
            {
                eid: en_id
            },
            url: "<?php echo site_url('enquiry/profile_details'); ?>",
            success: function (data)
            {
                $('#profile').html(data);
            }
        });
    }

    function enquiry_name(enquiry_name)
    {
        text = document.getElementById('lbl_equ_name');
        text.innerHTML = enquiry_name;
    }

    function setStatus(status_id)
    {
        var statusOpId = status_id;
        document.getElementById(statusOpId).selected = "true";
    }
</script> 
