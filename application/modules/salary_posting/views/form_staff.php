<div class="row" style="padding-top:20px;" >
    <div class="col-md-12">
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Staff 
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>

            <!-- end: PAGE TITLE & BREADCRUMB -->

            <div class="col-md-12">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2> Staff </h2>
                        </div>
                    </div>
                    <form  id="form" method="post" action="<?php echo site_url('salary_posting'); ?>">
                        <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> <button class="close" data-dismiss="alert">
                                ×
                            </button>
                            <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                        <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div>
                        <div id="voc_num" class="successHandler alert alert-danger" ><?php echo $errmsg = "Not found"; ?></div>
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label"> Date <span class="symbol required"> </span></label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_date" name="txt_date" value=""/>
                                        <i class="icon-calendar"></i> </span> </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">  Book Number </label>
                                    <?php
                                    $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='SLA'");
                                    $row = $query->row_array();
                                    $book_num = $row['BOOK_NUMBER'];
                                    ?>
                                    <div class="input-group">
                                        <input autocomplete="off" type="text" name="txt_buk_num" id="txt_buk_num" Class="form-control" value="<?php echo $book_num; ?>"/>
                                        <input type="hidden" name="temp_voc_num" id="temp_voc_num" Class="form-control"/>                
                                        <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-primary" onclick="displaydata()"> GO </a> </span></div>
                                </div>
                            </div>
                            <div class="col-md-2" id="btn_refresh" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label"> &nbsp;</label>
                                    <a href="<?php echo site_url('salary_posting'); ?>"><button class="btn btn-dark-beige btn-block" type="button">Refresh&nbsp;<i class="icon-circle-arrow-right"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div id="tbl_salry" >
                                        <table class="table table-striped table-bordered table-hover table-full-width" id="tblstr">
                                            <thead>
                                            <th>Sl No</th>
                                            <th>Name</th>
                                            <th>Salary</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sn_count = 1;
                                                foreach ($staff_list->result() as $row) {
                                                    ?>

                                                    <tr>
                                                        <td><?php echo $sn_count; ?></td>
                                                        <td>
                                                            <input type="hidden" id="txt_staffid" name="txt_staffid<?php echo $sn_count; ?>" value="<?php echo $row->ACC_ID; ?>" /><?php echo $row->ACC_NAME; ?>
                                                            <input type="hidden" id="txt_staffname" name="txt_staffname<?php echo $sn_count; ?>" value="<?php echo $row->ACC_NAME; ?>" />
                                                        </td>
                                                        <td><input autocomplete="off" type="text" id="txt_salary" name="txt_salary<?php echo $sn_count; ?>" value="" /></td>
                                                    </tr>

                                                    <?php
                                                    $sn_count++;
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                        <input autocomplete="off" type="hidden" name="Num" id="Num" value="<?php echo $sn_count; ?>" /> 
                                    </div>    
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <p> </p>
                            </div>
                            <div class="col-md-2">
                                <a id='bttdelete' href="#static"  class="btn btn-dark-beige btn-block" data-toggle="modal"> <i class="icon-trash"></i> Delete </a>

                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-dark-beige btn-block" type="submit"> Submit <i class="icon-circle-arrow-right"></i> </button>
                            </div>
                        </div>

                    </form>
                    <!-- end: DYNAMIC TABLE PANEL --> 
                </div>
            </div>
        </div>  

        <div id="output1">
        </div>

        <div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
            <div class="modal-body">
                <p> Are You sure, that you want to delete selected record? </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                <a id="hrefdelete" name="hrefdelete" type="button"  class="btn btn-primary"> Continue </a> </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("voc_num").style.display = "none";
    document.getElementById("bttdelete").style.display = "none";
    function displaydata()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {voc_no: $('#txt_buk_num').val()},
            url: "<?php echo site_url('salary_posting/details_staff_edit'); ?>",
            success: function (data)
            {
                $('#tbl_salry').html(data);
            }
        });

    }

</script>    

<script src="jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/add_row_account.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/validation_ledger.js"></script> 
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });
</script>