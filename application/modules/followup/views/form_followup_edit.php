
<div class="row">
    <div class="col-sm-12"> 
        <!-- start: PAGE TITLE & BREADCRUMB -->
        <ol class="breadcrumb">
            <li> <i class="clip-home"></i> <a href="<?php echo site_url('followup'); ?>"> Home </a> </li>
            <li> <i class="clip-users-3"></i> <a href="<?php echo site_url('followup/update_followup_details'); ?>">Enquiry List </a> </li>
            <li class="active"> Items </li>
            <li class="search-box">
                <form class="sidebar-search">
                    <div class="form-group">
                        <input autocomplete="off" type="text" placeholder="Start Searching...">
                        <button class="submit"> <i class="clip-search-3"></i> </button>
                    </div> 
                </form>
            </li>
        </ol>
        <!-- end: PAGE TITLE & BREADCRUMB --> 
    </div>
</div>

<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <!--<div class="panel panel-default">-->
<!--            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Add Call
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>-->
        <div class="tabbable">
            <ul id="myTab4" class="nav nav-tabs tab-padding tab-space-3 tab-blue">
                <li class="active">
                    <a href="#edit_followup" data-toggle="tab">
                        Folloup Edit
                    </a>
                </li>
                <li class="">
                    <a href="#profile" data-toggle="tab">
                        Profile
                    </a>
                </li>
                <li class="">
                    <a href="#folloup_history" data-toggle="tab">
                        Follow up
                    </a>
                </li>
            </ul>
            <div class="tab-content" style="min-height: 450px;">
                <div class="tab-pane active" id="edit_followup">
<!--                    <div class="successHandler alert alert-success <?php // if ($msg == "") {   ?> no-display <?php // }   ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php // echo $msg;   ?> </div>
                    <div class="successHandler alert alert-danger <?php // if ($errmsg == "") {   ?> no-display <?php // }   ?>"> <i class="icon-remove"></i> <?php // echo $errmsg;   ?> </div>
                    <h2><i class="icon-group teal"></i> Edit Followup</h2>-->
                    <?php
                    foreach ($s->result() as $row) {
                        $fid = $row->FID;
                        $enid = $row->EN_ID;
                        $desp = $row->description;
                        $fd = $row->FDATE;
                        if (($fd == "") || ($fd == "0000-00-00") || ( $fd == "1970-01-01")) {
                            $fdate = "";
                        } else {
                            $fdte = strtotime($fd);
                            $fdate = date('d-m-Y', $fdte);
                        }
                        $nfdt = $row->NEXTFDATE;
                        if (($nfdt == "") || ($nfdt == "0000-00-00") || ( $nfdt == "1970-01-01")) {
                            $nfdate = "";
                        } else {
                            $nfdte = strtotime($nfdt);
                            $nfdate = date('d-m-Y', $nfdte);
                        }
                        $stat = $row->STATUS;
                        ?>
                        <form  method="post" name="form" id="form" role="form" action="<?php echo site_url('followup/update_followup_details'); ?>">
                            <div class="panel-body">
                                <h2><i class="icon-edit-sign teal"></i> Followup For</h2>
                                <!--<label  style="font-size:25px;	color:#093" class="control-label"><?php echo $fid; ?></label>-->
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="txtid" value="<?php echo $fid; ?>" />
                                            <input type="hidden" name="txt_eid" value="<?php echo $enid; ?>" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label"> Status</label>
                                                <select class="form-control" id="txt_status" name="txtstatus">

                                                    <?php
                                                    foreach ($status->result() as $s) {
                                                        $sid = $s->id;
                                                        ?>
                                                        <option value="<?php echo $sid ?>" <?php if ($sid == $stat) echo "selected"; ?>><?php echo $s->status; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>   
                                            </div>
                                        </div>
                                        <!--                                    </div>
                                                                            <div class="row">-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Followup Date<span class="symbol required"></span> </label>
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtfdate"  value="<?php echo $fdate; ?>"  id="con" onchange="loadData()">
                                            </div> 
                                        </div>
                                        <!--                                    </div>
                                                                            <div class="row">-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Next Followup Date<span class="symbol required"></span> </label>
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txtnfdate"   value="<?php echo $nfdate; ?>" id="con" onchange="loadData()">
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Description<span class="symbol required"></span> </label>
                                                <!--<input autocomplete="off" type="text" class="form-control" id="txtdesp" name="txtdesp" value="<?php echo $desp; ?>"/>-->
                                                <textarea class="form-control" id="txt_desp" name="txtdesp"><?php echo $desp; ?></textarea>
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
                                            <button class="btn btn-primary btn-block" type="submit"> Save&nbsp;<i class="icon-circle-arrow-right"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
                <div class="tab-pane" id="profile">
                    <?php
                    $query = $this->db->query("SELECT tbl_enquiry.*,tbl_account.ACC_NAME FROM tbl_enquiry join tbl_account ON tbl_account.ACC_ID=tbl_enquiry.ENQTYPE  where EN_ID=$enid");
                    $result = $query->row_array();
                    $address = (($result['ADD1']) ? $result['ADD1'] . ", " : "") . (($result['ADD2']) ? $result['ADD2'] . ", " : "") . (($result['ADD3']) ? $result['ADD3'] . ", " : "");
                    $address = rtrim($address, ", ");
                    $reg_date = $result['REG_DATE'];
                    $reg_date = strtotime($reg_date);
                    $reg_date = date("d-m-Y h:i:s A", $reg_date);
                    $nxtfdte = $result['NEXTFDATE'];
                    $nxtfdte = strtotime($nxtfdte);
                    $nxtfdte = date("d-m-Y h:i:s A", $nxtfdte);
                    $sql = "select * from tbl_followupvia where id=" . $result['FOLLOWUPVIA'];
                    $query = $this->db->query($sql);
                    $val = $query->row_array();
//                    $query = $this->db->query("SELECT ACC_NAME FROM tbl_account where ACC_ID=" . $result['ENQTYPE']);
//                    $entry_for = $query->row_array();
                    $followup_via = $val['methods'];
                    ?>
                    <table class="table table-striped table-bordered table-hover table-full-width">
                        <tr>
                            <td><strong>NAME</strong></td>
                            <td><?php echo $result['NAME'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Address</strong></td>
                            <td><?php echo $address ?></td>
                        </tr>
                        <tr>
                            <td><strong>Phone</strong></td>
                            <td><?php echo $result['PHNO'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td><?php echo $result['EMAIL'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Entry For</strong></td>
                            <td><?php echo $result['ACC_NAME'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Enquiry From</strong></td>
                            <td><?php echo $followup_via ?></td>
                        </tr>
                        <tr>
                            <td><strong>Registration Date</strong></td>
                            <td><?php echo $reg_date ?></td>
                        </tr>
                        <tr>
                            <td><strong>Next Followup Date</strong></td>
                            <td><?php echo $nxtfdte ?></td>
                        </tr>
                    </table>
                </div>
                <div class="tab-pane" id="folloup_history">
                    <table  class="table table-striped table-bordered table-hover">
                        <tr>
                            <th>SL.No</th>
                            <th>En_Id</th>
                            <th>Entry Date</th>
                            <th>Followup Date</th>
                            <th>Status</th> 
                            <th>Description</th>
                        </tr>
                        <?php
                        $sn_count = 1;
                        $query = $this->db->query("SELECT  * FROM tbl_followup where EN_ID=$enid");
                        foreach ($query->result() as $row) {
                            $en_date = $row->FDATE;
                            $ent_date = strtotime($en_date);
                            $entry_date = date('d-m-Y', $ent_date);
                            $n_date = $row->NEXTFDATE;
                            $nf_date = strtotime($n_date);
                            $nextfdate = date('d-m-Y', $nf_date);
                            ?>
                            <tr>
                                <td ><?php echo $sn_count; ?></td>
                                <td><?php echo $row->EN_ID ?></td>
                                <td><?php echo $entry_date; ?></td>
                                <td><?php
                                    if ($n_date == "0000-00-00") {
                                        echo $nf_date = " ";
                                    } else {
                                        echo $nextfdate;
                                    }
                                    ?></td>
                                <td><?php
                                    $stat_id = $row->STATUS;
                                    $query = $this->db->query("SELECT  status FROM tbl_status where id=$stat_id");
                                    $res = $query->row_array();
                                    echo $status = $res['status'];
                                    ?></td>
                                <td><?php echo $row->description; ?></td>
                            </tr>
                            <?php
                            $sn_count++;
                        }
                        ?>   
                    </table>
                </div>
            </div>
            <!--</div>-->
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/followup.js"></script>          
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();

    });
</script>   

