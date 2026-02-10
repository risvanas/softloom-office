<div class="row" style="padding-top:20px;" >
    <div class="col-md-9"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Fee Summary
                <div class="panel-tools"> 
                    <form action="<?php echo site_url('student/mult_search'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank">
                        <input type="hidden" name="fromdate" value="">
						<input type="hidden" name="todate" value="">
						<input type="hidden" name="dat" value="REG_DATE">
                        <input type="hidden" name="key_words" value="">
                        <!---<input type="hidden" name="calc" value="">-->
                        <input type="hidden" name="course" value="">
                        <input type="hidden" name="stat" value="">
						<input type="hidden" name="type" value="rpt">
                        <input type="hidden" name="generate_pdf" value="generate_pdf">
                        <!--<button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_pdf\';this.form.target=\'_blank\';this.form.submit();"><i class="clip-file-pdf"></i></button>-->
                        <button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="submit_form(event, this)"><i class="clip-file-pdf"></i></button>
                        <!--<button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value = \'generate_pdf\';document.form_excel_pdf.target=\'_blank\';document.form_excel_pdf.submit();"><i class="clip-file-pdf"></i></button>-->
                        <!--<button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value = \'generate_excel\';document.form_excel_pdf.target=\'\';document.form_excel_pdf.submit();"><i class="clip-file-excel"></i></button>-->
                        <button class="btn_pdf_excel export_excel" title="export to excel" onclick="submit_form(event, this)"><i class="clip-file-excel"></i></button>
                    </form>
                <!--<a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a>-->
                </div>
            </div>
            <div class="panel-body" style="min-height: 500px;">
			
                <div id="output">
                  		   
                </div>
            </div>
        </div>
    </div>

    <!-- end: PAGE TITLE & BREADCRUMB -->
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-12">
<!--                    <div class="form-group">
                        <label class="control-label">Select Date</label>
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-range" name="txt_calc" id="txt_calc" onblur="search_data()" onchange="search_data()" onkeyup="search_data()">
                    </div>-->
					<?php 
					  $account_year = $accounting_year->row(); 
					  $from_date=$account_year->FROM_DATE;
					  $from_date = strtotime($from_date);
		              $from_date=date("d-m-Y", $from_date);
						  $to_date=$account_year->TO_DATE;
						  $to_date=strtotime($to_date);
						  $to_date=date("d-m-Y", $to_date);
					?>
							
                    <div class="form-group">
                        <label class="control-label"> From Date</label>
                        <span class="input-icon input-icon-right">
                            <input autocomplete="off" type="text" value="<?php echo $from_date;?>" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from"/>
                            <i class="icon-calendar"></i> </span> 							
                    </div>
                    <div class="form-group">
                        <label class="control-label"> To Date</label>
                        <span class="input-icon input-icon-right">
                            <input autocomplete="off" type="text" value="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to"/>
                            <i class="icon-calendar"></i> </span> 
                    </div>
                    <div class="form-group">
                        <label class="control-label"> Course </label>
                        <select class="form-control"  id="txt_search_course" name="txt_search_course">
                            <option value="">Select</option>
                            <?php foreach ($course->result() as $row) { ?>
                                <option value="<?php echo $row->ACC_ID; ?>"> <?php echo $row->ACC_NAME; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"> Status </label>
                        <select class="form-control"  id="search_status" name="search_status">
                            <option value="">Select</option>
                            <?php
                            foreach ($status->result() as $res) {
                                ?>
                                <option value="<?php echo $res->id; ?>"><?php echo $res->status; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
				    <button class="btn btn-dark-beige btn-block" type="button" onclick="search_data()"> Search </button>
                    <!--<label for="form-field-mask-1"> Key Words </label>
                    
                        <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_key_words" id="txt_key_words" onkeyup="search_data()">
                        <span class="input-group-btn">
                        </span> -->
                </div>         
            </div>
        </div>
        <!-- end: DYNAMIC TABLE PANEL --> 
    </div>
</div>

<!-- end: PAGE HEADER --> 
<script>
    function search_data() {
        $.ajax({
            type: "POST",
            data:
                    {
//                        calc: $('#txt_calc').val(),
                        dat: 'REG_DATE',
                        fromdate: $('#txt_from').val(),
                        todate: $('#txt_to').val(),
                        key_words: $('#txt_key_words').val(),
                        course: $('#txt_search_course').val(),
                        stat: $('#search_status').val(),
						type:"rpt",
                        //sort_by: $('#sort_by').val()
                    },
            url: "<?php echo site_url('student/mult_search'); ?>",
            success: function (data) {
                $('#output').html(data);
				$("input[name=fromdate]").val($('#txt_from').val());
				$("input[name=todate]").val($('#txt_to').val());
              //  $("input[name=calc]").val($('#txt_calc').val());
                //$("input[name=dat]").val($('#search_date').val());
                $("input[name=key_words]").val($('#txt_key_words').val());
                $("input[name=course]").val($('#txt_search_course').val());
                $("input[name=stat]").val($('#search_status').val());
            }
        });
    }

    function submit_form(event, obj) {
        event.preventDefault();
        if ($(obj).hasClass('export_pdf')) {
            document.form_excel_pdf.generate_pdf.value = 'generate_pdf';
            document.forms.form_excel_pdf.target = '_blank';
        } else {
            document.form_excel_pdf.generate_pdf.value = 'generate_excel';
            document.forms.form_excel_pdf.target = '';
        }
        document.forms.form_excel_pdf.submit();
    }
</script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();
    });
</script> 
