<!-- start: DYNAMIC TABLE PANEL -->
<style>
    .datepicker {
        z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
<div class="row" style="padding-top:20px;" >
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Enquiry List
                <div class="panel-tools">
                    <!--<a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a>--> 
                    <form action="<?php echo site_url('enquiry/search_enquiry_details'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank"> 
                        <input type="hidden" name="type" id="type" value="enq_rep">
                        <!--<input type="hidden" name="ins_statu" id="ins_statu" value="">-->
                        <input type="hidden" name="fromdate" id="fromdate" value="">
                        <input type="hidden" name="todate" id="todate" value="">
                        <!--<input type="hidden" name="call_statu" id="call_statu" value="">-->
                        <input type="hidden" name="generate_pdf" value="generate_pdf">
                        <button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value = 'generate_pdf';this.form.target = '_blank';this.form.submit();"><i class="clip-file-pdf"></i></button>
                        <button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value = 'generate_excel';this.form.target = '';this.form.submit();"><i class="clip-file-excel"></i></button>
                    </form>
                </div>
            </div>
            <!--            <div class="col-md-12">
                            <h1>Enquiry List <small></small></h1>
                            <hr />
                        </div>-->
            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <!--<div class="row">-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">From Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_from_date" id="txt_from_date">
                                <i class="icon-calendar"></i> </span> </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">To Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="txt_to_date" id="txt_to_date">
                                <i class="icon-calendar"></i> </span> </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group"> <br>
                            <button type="button" class="btn btn-green btn-block" onclick="search_data()">search</button>
                        </div>
                    </div>
                </div>
                <!--</div>-->
            </div>
            <!-----------------------Start view Enquiry Details ---------------------------->
            <div class="panel-body">
                <div id="out">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Followup Via</th>
                                <th>Active</th>
                                <th>Registered</th>
                                <th>Walkin</th>
                                <th>Not Interested</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn = 0;
                            $cdat = date('Y-m-d');
                            $registered = $active = $walkin = $not_interested = 0;
                            foreach ($Enquiry->result() as $row) {
                                $sn++;
                                $active += $row->active;
                                $registered += $row->registered;
                                $walkin += $row->walkin;
                                $not_interested += $row->not_interested;
                                ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $row->methods; ?></td>
                                    <td><?php echo $row->active; ?></td>
                                    <td><?php echo $row->registered; ?></td>
                                    <td><?php echo $row->walkin; ?></td>
                                    <td><?php echo $row->not_interested; ?></td>
                                </tr>                             
                                <?php
//                            $Enquiry++;
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td>Total</td>
                                <td><?php echo $active; ?></td>
                                <td><?php echo $registered; ?></td>
                                <td><?php echo $walkin; ?></td>
                                <td><?php echo $not_interested; ?></td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-----------------------End view Enquiry Details ----------------------------> 

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
            data:
            {
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

    function search_data()
    {
        $.ajax({
            type: "POST",
            data:
            {
                datefrom: $('#txt_from_date').val(),
                dateto: $('#txt_to_date').val(),
                dtype: $('#txtdtype').val(),
                stype: $('#txtstype').val(),
                sorttype: $('#txtsorttype').val(),
                key_words: $('#txt_key_words').val(),
                type: 'enq_rep'
            },
            url: "<?php echo site_url('enquiry/search_enquiry_details'); ?>",
            success: function (data)
            {
                $('#out').html(data);
            }
        }
        );
    }

    function getFollowupDetails(en_id)
    {
        console.log(en_id)
        document.getElementById("txt_en_id").value = en_id;
        $.ajax
        ({
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
        $.ajax
        ({
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
