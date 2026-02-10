<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/invoice/css/style.css' />
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>invoice/css/print.css' media="print" />


<div id="output1">
    <div class="row" style="padding-top:20px;">
        <div class="col-sm-12"> 
            <!-- start: INLINE TABS PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading"> <i class="icon-reorder"></i> Invoice
                    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                        <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
                </div>
                <form  role="form" id="form" method="post" action="<?php echo site_url('invoice_cancelation/add_cancelation'); ?>" onsubmit="ins_data();">
                    <div class="panel-body">
                        <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                            <button class="close" data-dismiss="alert"> × </button>
                            <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                        <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                        <h2><i class="icon-group teal"></i> Invoice Cancelation</h2>
                        <div><hr /></div>


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> Cancelation Number </label>
                                            <?php
                                            $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUM), 100)+1 AS BOOK_NUMBER FROM tbl_invoice_cancelation");
                                            $row = $query->row_array();
                                            $book_num = $row['BOOK_NUMBER'];
                                            ?>
                                            <div class="input-group">
                                                <input autocomplete="off" type="text" name="txt_buk_num" id="txt_buk_num" Class="form-control" value="<?php echo $book_num; ?>"/>
                                                <input type="hidden" name="temp_cancel_num" id="temp_cancel_num" Class="form-control" value=""/>
                                                <span class="input-group-btn" onclick="displaycancel()"> <a data-toggle="modal" class="demo btn btn-dark-beige" > GO </a> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label"> Cancelation Date <span class="symbol required"> </span> </label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_cancel_date" name="txt_cancel_date" value=""/>
                                                <i class="icon-calendar"></i> </span> </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" id="h1">
                                            <label class="control-label">Cancelation Amount <span class="symbol required"> </span></label>
                                            <input autocomplete="off" type="text" name="txt_can_amount" id="txt_can_amount" Class="form-control" value=""/>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Remarks <span class="symbol required"> </span></label>
                                            <textarea class="form-control" name="txt_descri" id="txt_descri"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="txt_validation" name="txt_validation"/>
                            <div class="col-sm-6">
                                <div id="output">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label"> Invoice Number </label>
                                                <div class="input-group">
                                                    <input autocomplete="off" type="text" name="temp_invo_num" id="temp_invo_num" Class="form-control" value=""/>
                                                    <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-dark-beige" onclick="displaydata()"> GO </a> </span></div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">

                                <div id="page-wrap">








                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div> <span class="symbol required"></span> Required Fields
                                    <hr />
                                </div>
                            </div>
                        </div>


                        <div class="row">



                            <div class="col-md-2 pull-right">
                                <button class="btn btn-dark-beige btn-block" type="submit" id="sub_reg">Submit &nbsp;<i class="icon-circle-arrow-right"></i> </button>
                                <input type="hidden" name="Num" id="Num" value="2" />
                            </div>
                            <div> </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end: INLINE TABS PANEL --> 
        </div>
    </div>
</div>





<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/form_invoice_cancel.js"></script> 
<script>

                                                        jQuery(document).ready(function () {
                                                            Main.init();
                                                            FormValidator.init();
                                                            UIModals.init();
                                                            FormElements.init();

                                                        });
</script>

<script>
    function displaydata()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {invoice_no: $('#temp_invo_num').val()},
            url: "<?php echo site_url('invoice_cancelation/invoice_details'); ?>",
            success: function (data)
            {
                //alert(data);
                $('#output').html(data);
            }
        });

    }


</script> 
<script>
    function displaycancel()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {cancel_no: $('#txt_buk_num').val()},
            url: "<?php echo site_url('invoice_cancelation/invoice_cancel_details'); ?>",
            success: function (data)
            {
                //alert(data);
                $('#output1').html(data);
            }
        });

    }


</script> 

