<div class="row"> 
    <div class="col-md-12" style="padding: 15px">
        <!-- start: PAYMENT VOUCHER PANEL --> 
        <div class="panel panel-default">  
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp 
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh"  href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>  
            <div class="panel-body"> 
                <div class="row">
                    <div class="col-md-12">
                        <h2><i class="icon-edit-sign teal"></i>&nbsp;Training Refund</h2> 
                        <div><hr /></div>
                        <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                            <button class="close" data-dismiss="alert"> × </button>
                            <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                        <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>">
                            <i class="icon-remove"></i> <?php echo $errmsg; ?>
                        </div>
                    </div>
                    <?php
                    foreach ($refund->result() as $row) {
                        $rf_date = $row->PAYMENT_DATE;
                        if ($rf_date != '') {
                            $rf_date = strtotime($rf_date);
                            $rf_date = date('d-m-Y', $rf_date);
                        } $amount = $row->AMOUNT;
                        $type = $row->TRANSACTION_TYPE;
                        $stu = $row->st_name;
                        $course = $row->st_course;
                        $ch_number = $row->CHEQUE_NUMBER;
                        $ch_date = $row->CHEQUE_DATE;
                        if ($ch_date != '') {
                            $ch_date = strtotime($ch_date);
                            $ch_date = date('d-m-Y', $ch_date);
                        } $a_number = $row->ACCOUNT_NUMBER;
                        $bank = $row->BANK;
                        $created_by = $row->n1 . ' ' . $row->n2;
                        $modified_by = $row->name1 . ' ' . $row->name2;
                        $created_on = $row->CREATED_ON;
                        if ($created_on != '') {
                            $utc_time_zone = "Asia/Calcutta";
//                            date_default_timezone_get();
//                            $utc_time = date("Y-m-d G:i", strtotime($created_on)); 
//                            $utc_date = DateTime::createFromFormat('Y-m-d G:i', $utc_time, new DateTimeZone('UTC'));
//                            $nyc_date = $utc_date;
//                            $nyc_date->setTimeZone(new DateTimeZone($utc_time_zone));
//                            $created_on = $nyc_date->format('j M Y g:i A'); // output: 5 Jan 2017 7:24 PM 
//                            }
//                            $modified_on = $row->MODIFIED_ON;
//                            if ($modified_on != '') {
//                            $utc_time_zone = "Asia/Calcutta"; //date_default_timezone_get();
//                            $utc_time = date("Y-m-d G:i", strtotime($modified_on));
//                            $utc_date = DateTime::createFromFormat('Y-m-d G:i', $utc_time, new DateTimeZone('UTC'));
//                            $nyc_date = $utc_date; 
//                            $nyc_date->setTimeZone(new DateTimeZone($utc_time_zone));
//                            $modified_on = $nyc_date->format('j M Y g:i A'); // output: 5 Jan 2017 7:24 PM 
                        }
                    }
                    ?>
                    <div class="col-md-6"> 
                        <div class="row"> 
                            <div class="col-md-4">   
                                <div class="form-group"> 
                                    <label class="control-label"> Course</label>  
                                    <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount" value="<?php echo $course; ?>" readonly/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group" id="h1">
                                    <label class="control-label"> Name</label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount" value="<?php echo $stu; ?>" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Refund Date <span class="symbol required"> </span></label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_payment_date" id="txt_payment_date"  value="<?php echo $rf_date; ?>" readonly/>
                                        <i class="icon-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label"> Amount <span class="symbol required"> </span> </label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount" value="<?php echo $amount; ?>" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label"> Transaction Type</label>
                                    <input autocomplete="off" type="text" class="form-control" id="txt_amount" name="txt_amount" value="<?php echo $type; ?>" readonly/>
                                </div>
                            </div>
                        </div>
                        <?php if ($row->TRANSACTION_TYPE == 'bank') { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Cheque Number </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_cheque_no" name="txt_cheque_no" value="<?php echo $ch_number; ?>" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cheque Date </label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_cheque_date" id="txt_cheque_date"  value="<?php echo $ch_date; ?>" readonly/>
                                            <i class="icon-calendar"></i> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Account Number  </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_accnt_no" name="txt_accnt_no" value="<?php echo $a_number; ?>" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Bank <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_accnt_no" name="txt_accnt_no" value="<?php echo $bank; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"> Created By </label>
                                    <div class="input-group">
                                        <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $created_by; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"> Created On </label>
                                    <div class="input-group">
                                        <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $created_on; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"> Modified By </label>
                                    <div class="input-group">
                                        <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $modified_by; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"> Modified On </label>
                                    <div class="input-group">
                                        <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $modified_on; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div id="sdetail"></div>
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
                    <div class="col-md-2 pull-right">
                        <a href="<?php echo site_url('training_refund'); ?>" target="_blank"><button class="btn btn-dark-beige btn-block" type="button" id="sub_reg" name="sub_reg">Edit &nbsp;<i class="icon-circle-arrow-right"></i> </button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: ACCOUNT REGISTRATION PANEL -->
</div>
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();
    });
</script> 