<div class="row">
    <div class="col-md-12">
        <!-- start: PAYMENT VOUCHER PANEL -->
        <form  method="post" name="form"  id="form" role="form" action="<?php echo site_url('receipt'); ?>" onsubmit="ins_data();" >
            <div class="panel panel-default">
                <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbspCash Receipt
                    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a><a class="btn btn-xs btn-link panel-expand"

                                                                                                                      href="#"><i class="icon-resize-full"></i></a><a class="btn btn-xs btn-link panel-close"

                                                                        href="#"><i class="icon-remove"></i></a> </div>
                </div>
                <div class="panel-body">
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                    <div id="voc_num" class="successHandler alert alert-danger" ><?php echo $errmsg = "Not found"; ?></div>
                    <h2><i class="icon-edit-sign teal"></i>&nbsp;Cash Receipt</h2>
                    <div>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Book Name</label>
                                <select name="txt_select" id="txt_select" class="form-control" />

                                <option value="cr">CR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label"> Book Number </label>
                                <?php
                                $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='CR'");
                                $row = $query->row_array();
                                $book_num = $row['BOOK_NUMBER'];
                                ?>
                                <div class="input-group">
                                    <input autocomplete="off" type="text" name="txt_buk_num" id="conn" Class="form-control" value="<?php echo $book_num; ?>"/>
                                    <input type="hidden" name="temp_voc_num" id="temp_voc_num" Class="form-control"/>
                                    <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-dark-beige" onclick="displaydata()"> GO </a> </span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"> Reference Receipt No.</label>
                                <input autocomplete="off" type="text" name="txt_ref_voucher_no" id="txt_ref_voucher_no" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> Receipt Date <span class="symbol required"> </span> </label>
                                <span class="input-icon input-icon-right">
                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_receipt_date" name="txt_receipt_date"/>
                                    <i class="icon-calendar"></i> </span> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Search Account</label>
                                <div class="input-group">
                                    <input type="txt_search_name" name="txt_search_name" id="con" Class="form-control">
                                    <span class="input-group-btn"> <a href="#responsive" data-toggle="modal" class="btn btn-dark-beige" onclick="loadData()">ADD </a> </span> </div>
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
                                                    <th>Select</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div align="right">
                                            <label class="btn btn-xs btn-bricky" onclick="deleteChecked('tblstr');" onkeyup="hiddenFunction();"><i class="icon-trash"></i> Delete Item</label>
                                        </div>
                                    </div>
                                    <!-- end: DYNAMIC TABLE PANEL --> 
                                </div>
                            </div>
                            <!---------------------------------- end  batch  table add ---------------------------- --> 

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
                        <div class="col-md-8">
                            <p> </p>
                        </div>
                        <div class="col-md-2"> <a id='bttdelete' href="#static"  class="btn btn-dark-beige btn-block" data-toggle="modal"> <i class="icon-trash"></i> Delete </a> </div>
                        <div class="col-md-2">
                            <button class="btn btn-dark-beige btn-block" type="submit" id="sub_reg">Submit&nbsp;<i class="icon-circle-arrow-right"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="Num" id="Num" value="2" />
        </form>
    </div>
</div>



<!-- end: ACCOUNT REGISTRATION PANEL -->



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
<div id="output1"> </div>
<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-body">
        <p> Are You sure, that you want to delete selected record? </p>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
        <a id="hrefdelete" name="hrefdelete" type="button"  class="btn btn-primary"> Continue </a> </div>
</div>
<script>
<?php if ($msg != "") { ?>

        function ins_data()
        {
            document.getElementById('sub_reg').disabled = false;

        }


<?php } ?>
</script>
<!-- end: BOOTSTRAP EXTENDED MODAL--> 

<script >
    document.getElementById("bttdelete").style.display = "none";
    document.getElementById("voc_num").style.display = "none";
    function addaccount(acc_code, acc_name, acc_type, acc_id)
    {
        var tbl = document.getElementById("tblstr");
        for (var i = 3; i < tbl.rows.length + 2; i++)
        {
            if (acc_id == document.getElementById("acc_id" + i).value)
            {
                //alert("Item already exist!");
                return false;
            }
        }
        //alert(batch_id="##"+course_name)
        var Numx = document.getElementById('Num').value;
        appendRow();
        //alert("d"+Numx);
        Numx = (Number(Numx) + 1);
        document.getElementById("Num").value = Numx;
        document.getElementById("acc_code" + Numx).value = acc_code;
        document.getElementById("acc_name" + Numx).value = acc_name;
        document.getElementById("acc_id" + Numx).value = acc_id;

        $("#sub_acc" + Numx).append($("<option></option>").val('').html("Select"));
<?php foreach ($sub_acc_list->result() as $row) { ?>
            $("#sub_acc" + Numx).append($("<option></option>").val('<?php echo $row->ACC_ID; ?>').html("<?php echo $row->ACC_NAME; ?>"));
<?php } ?>
        //$("#sub_acc"+Numx).append($("<option></option>").val('').html("Select"));
        hiddenFunction();
    }

    function hiddenFunction()
    {
        var count = document.getElementById("Num").value;
        if (Number(count) <= 2)
        {
            document.getElementById('table_batch').style.display = 'none';
        } else
        {
            document.getElementById('table_batch').style.display = 'block';
        }

    }

    $(window).load(function ()
    {
        hiddenFunction();

    });

    function loadData()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {name: $('#con').val()},
            url: "<?php echo site_url('receipt/account_list'); ?>",
            success: function (data)
            {
                $('#output').html(data);
            }
        });
    }
</script> 
<script>
    function editaccount(acc_code, acc_name, sub_acc, acc_type, acc_id, credit, remarks) {
        //,credit,remarks
        var tbl = document.getElementById("tblstr");
        for (var i = 3; i < tbl.rows.length + 2; i++)
        {
            if (acc_id == document.getElementById("acc_id" + i).value)
            {
                //alert("Item already exist!");
                return false;
            }
        }
        var Numx = document.getElementById('Num').value;
        appendRow();
        Numx = (Number(Numx) + 1);
        $("#sub_acc" + Numx).append($("<option></option>").val('').html("Select"));
<?php foreach ($sub_acc_list->result() as $row) { ?>
            $("#sub_acc" + Numx).append($("<option></option>").val('<?php echo $row->ACC_ID; ?>').html("<?php echo $row->ACC_NAME; ?>"));
<?php } ?>
        document.getElementById("Num").value = Numx;
        document.getElementById("acc_code" + Numx).value = acc_code;
        document.getElementById("acc_name" + Numx).value = acc_name;
        //document.getElementById("sub_acc"+Numx).value=sub_acc; 
        //alert('sub_acc'+sub_acc);
        document.getElementById("acc_id" + Numx).value = acc_id;
        document.getElementById("amount" + Numx).value = credit;
        document.getElementById("remarks" + Numx).value = remarks;



        var tempaccsub = "sub_acc" + Numx;
        //alert(tempaccsub);
        var element = document.getElementById(tempaccsub);
        element.value = sub_acc;

        //document.getElementById('sub_acc3').getElementsByTagName('option')[sub_acc].selected = 'selected';
        hiddenFunction();
    }
</script> 
<script>
    function displaydata()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {voc_no: $('#conn').val(), },
            url: "<?php echo site_url('receipt/select_data'); ?>",
            success: function (data)
            {
                $('#output1').html(data);
            }
        });
    }
</script> 
<script src="jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/add_row_account.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/validation_receipt.js"></script> 
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });
</script>


<script>
    function ins_data()
    {
        document.getElementById('sub_reg').disabled = true;

    }

</script>