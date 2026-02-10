<div class="row">
    <div class="col-md-12"> 
        <!-- start: PAYMENT VOUCHER PANEL -->

        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Bank Voucher
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-config"

                                                                                                                  href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a><a class="btn btn-xs btn-link panel-refresh"

                                                                                               href="#"><i class="icon-refresh"></i></a><a class="btn btn-xs btn-link panel-expand"

                                                                href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"

                                                                    href="#"><i class="icon-remove"></i></a> </div>
            </div>
            <div class="panel-body">
                <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                    <button class="close" data-dismiss="alert"> × </button>
                    <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                <h2><i class="icon-edit-sign teal"></i>&nbsp; Bank Voucher</h2>
                <div>
                    <hr />
                </div>
                <?php
                foreach ($bank_voucher->result() as $row) {
                    $book_name = $row->BOOK_NAME;
                    $book_num = $row->BOOK_NUMBER;

                    $ref_vno = $row->REF_VOUCHERNO;
                    $re_date = $row->DATE_OF_TRANSACTION;
                    if ($re_date != '') {
                        $re_date = strtotime($re_date);
                        $re_date = date('d-m-Y', $re_date);
                    }
                    $t_type = $row->TRANS_TYPE;
                    $created_by = $row->n1 . ' ' . $row->n2;
                    $modified_by = $row->name1 . ' ' . $row->name2;
                    $created_on = $row->CREATED_ON;
                    if ($created_on != '') {
                        $utc_time_zone = "Asia/Calcutta"; //date_default_timezone_get();

                        $utc_time = date("Y-m-d G:i", strtotime($created_on));

                        $utc_date = DateTime::createFromFormat('Y-m-d G:i', $utc_time, new DateTimeZone('UTC'));
                        $nyc_date = $utc_date;
                        $nyc_date->setTimeZone(new DateTimeZone($utc_time_zone));
                        $created_on = $nyc_date->format('j M Y g:i A'); // output: 5 Jan 2017 7:24 PM
                    }
                    $modified_on = $row->MODIFIED_ON;
                    if ($modified_on != '') {
                        $utc_time_zone = "Asia/Calcutta"; //date_default_timezone_get();                
                        $utc_time = date("Y-m-d G:i", strtotime($modified_on));

                        $utc_date = DateTime::createFromFormat('Y-m-d G:i', $utc_time, new DateTimeZone('UTC'));
                        $nyc_date = $utc_date;
                        $nyc_date->setTimeZone(new DateTimeZone($utc_time_zone));
                        $modified_on = $nyc_date->format('j M Y g:i A'); // output: 5 Jan 2017 7:24 PM
                    }
                }
                ?>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Book Name</label>
                            <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $book_name; ?>" readonly/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> Book Number </label>

                            <div class="input-group">
                                <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $book_num; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <?php
                    $query2 = $this->db->query("select tbl_account.ACC_NAME as a_name from tbl_transaction join tbl_account on tbl_transaction.ACC_ID = tbl_account.ACC_ID where tbl_transaction.BOOK_NAME='BV' and tbl_transaction.BOOK_NUMBER=$book_num and CREDIT IS NOT NULL and tbl_transaction.DEL_FLAG=1 limit 1");
                    foreach ($query2->result() as $val) {
                        $bank = $val->a_name;
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> Bank <span class="symbol required"> </span></label>
                                <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $bank; ?>" readonly/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"> Reference Receipt No.</label>
                            <input autocomplete="off" type="text" name="txt_ref_voucher_no" id="txt_ref_voucher_no" class="form-control" value="<?php echo $ref_vno; ?>" readonly/>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"> Receipt Date <span class="symbol required"> </span> </label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_receipt_date" name="txt_receipt_date" value="<?php echo $re_date; ?>" readonly/>
                                <i class="icon-calendar"></i> </span> </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"> Transaction Type <span class="symbol required"> </span> </label>
                            <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $t_type; ?>" readonly/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> Created By </label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $created_by; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"> Created On </label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $created_on; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> Modified By </label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $modified_by; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"> Modified On </label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $modified_on; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"> 

                        <!--------------------------------- start  batch  table add ------------------------------- -->
                        <div class="row" id="table_batch">
                            <div class="col-md-12"> 
                                <!-- start: DYNAMIC TABLE PANEL -->
                                <label class="control-label"></label>
                                <div class="form-group">
                                    <table class="table table-striped table-bordered table-hover table-full-width" id="tblstr">
                                        <thead>
                                            <tr>
                                                <th class="">No</th>
                                                <th class="">Acc Code</th>
                                                <th class="">Acc Name</th>
                                                <th class="">Sub Acc</th>
                                                <th class="">Amount</th>
                                                <th>Remarks</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($bank_voucher->result() as $row) {
                                                ?>
                                                <tr>
                                                    <th><?php echo $count; ?></th>
                                                    <th><?php echo $row->ACC_CODE; ?></th>
                                                    <th><?php echo $row->acc_name; ?></th>
                                                    <th><?php echo $row->subacc_name; ?></th>
                                                    <th><?php echo $row->DEBIT; ?></th>
                                                    <th><?php echo $row->DESCRIPTION; ?></th>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                                <!-- end: DYNAMIC TABLE PANEL --> 
                            </div>
                        </div>
                        <!---------------------------- end  batch  table add --------------------------- --> 

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
                        <a href="<?php echo site_url('bank_voucher'); ?>" target="_blank"><button class="btn btn-dark-beige btn-block" type="button" id="sub_reg" name="sub_reg">Edit &nbsp;<i class="icon-circle-arrow-right"></i> </button></a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="Num" id="Num" value="2" />

    </div>

    <!-- end: ACCOUNT REGISTRATION PANEL --> 

</div>

<!-- start: BOOTSTRAP EXTENDED MODAL -->
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();

    });

</script> 


