<div class="row">
    <div class="col-md-12">
        <!-- start: PAYMENT VOUCHER PANEL --> 
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp  Payment Voucher 
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                </div> 
            </div>  
            <div class="panel-body">
                <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                    <button class="close" data-dismiss="alert"> × </button>
                    <i class="icon-ok-sign"></i> <?php echo $msg; ?>
                </div>
                <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>">
                    <i class="icon-remove"></i> <?php echo $errmsg; ?>
                </div>
                <div id="voc_num" class="successHandler alert alert-danger" style="display:none">
                    <?php echo $errmsg = "Not found"; ?>
                </div>
                <h2><i class="icon-edit-sign teal"></i>&nbsp; Payment Voucher </h2>
                <div><hr /></div>
                <?php
                foreach ($voucher_details->result() as $row) {
                    $book_name = $row->BOOK_NAME;
                    $book_number = $row->BOOK_NUMBER;
                    $ref_no = $row->REF_VOUCHERNO;
                    $v_date = $row->DATE_OF_TRANSACTION;
                    if ($v_date != '') {
                        $v_date = strtotime($v_date);
                        $v_date = date('d-m-Y', $v_date);
                    } $created_by = $row->n1 . ' ' . $row->n2;
                    $modified_by = $row->name1 . ' ' . $row->name2;
                    $created_on = $row->CREATED_ON;
                    if ($created_on != '') {
                        $utc_time_zone = "Asia/Calcutta";
                        //date_default_timezone_get(); 
                        //$utc_time = date("Y-m-d G:i", strtotime($created_on));
                        //$utc_date = DateTime::createFromFormat('Y-m-d G:i', $utc_time, new DateTimeZone('UTC'));
                        //$nyc_date = $utc_date;
                        //$nyc_date->setTimeZone(new DateTimeZone($utc_time_zone));
                        //$created_on = $nyc_date->format('j M Y g:i A'); // output: 5 Jan 2017 7:24 PM
                        // }
                        // $modified_on = $row->MODIFIED_ON;
                        // if ($modified_on != '') {
                        // $utc_time_zone = "Asia/Calcutta";
                        // date_default_timezone_get();
                        // $utc_time = date("Y-m-d G:i", strtotime($modified_on));
                        // $utc_date = DateTime::createFromFormat('Y-m-d G:i', $utc_time, new DateTimeZone('UTC'));
                        // $nyc_date = $utc_date;
                        // $nyc_date->setTimeZone(new DateTimeZone($utc_time_zone));
                        // $modified_on = $nyc_date->format('j M Y g:i A'); // output: 5 Jan 2017 7:24 PM
                    }
                }
                ?> 
                <div class="row"> 
                    <div class="col-md-2"> 
                        <div class="form-group"> 
                            <label class="control-label">Book Name</label> 
                            <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $book_name ?>" readonly/>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> Book Number </label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $book_number; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"> Reference Voucher No.</label>
                            <input autocomplete="off" type="text" name="txt_ref_voucher_no" id="txt_ref_voucher_no" class="form-control" value="<?php echo $ref_no; ?>" readonly/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"> Voucher Date <span class="symbol required"> </span> </label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_voucher_date" name="txt_voucher_date" value="<?php echo $v_date; ?>" readonly/>
                                <i class="icon-calendar"></i> </span> </div>
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
                        <!--------------------------------------------------- start  batch  table add ---------------------------------------------- -->
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
                                            foreach ($voucher_details->result() as $row) {
                                                ?>      
                                                <tr>     
                                                    <td><?php echo $count; ?></td> 
                                                    <td><?php echo $row->code; ?></td> 
                                                    <td><?php echo $row->acc; ?></td> 
                                                    <td><?php echo $row->sub; ?></td>
                                                    <td><?php echo $row->DEBIT; ?></td>
                                                    <td><?php echo $row->DESCRIPTION; ?></td>  
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
                        <!------------------------------- end  batch  table add ------------------------------------ -->
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12"> 
                        <div>
                            <span class="symbol required"></span> Required Fields 
                            <hr /> 
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <p> </p>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo site_url('voucher'); ?>" target="_blank">
                            <button class="btn btn-dark-beige btn-block" type="button" id="sub_reg" name="sub_reg">Edit &nbsp;<i class="icon-circle-arrow-right"></i> </button>
                        </a>
                    </div>
                    <div> </div> 
                </div> 
            </div> 
        </div> 
    </div> 
    <!-- end: ACCOUNT REGISTRATION PANEL --> 
</div>
<!-- start: BOOTSTRAP EXTENDED MODAL -->
<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
    <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>

        <h4 class="modal-title">Account List</h4>

    </div>
    <div class="modal-body"> 
        <div class="row">

            <div class="col-md-12" id="output"> </div>

        </div> 
    </div>

</div>
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();
    });
</script>