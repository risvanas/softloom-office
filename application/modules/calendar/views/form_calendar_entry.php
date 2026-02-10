<div class="row" style="padding-top:20px;">
    <div class="col-md-12"> 
        <style>
            address {
                margin-bottom: 5px;
            }
        </style>
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Calendar
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
<!--                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>-->
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <form  role="form" id="form" method="post" action="<?php echo site_url('calendar'); ?>">
                <div class="panel-body" >
                    <div class="successHandler alert alert-success <?php if ($msg == "") {  ?> no-display <?php }  ?>">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> </div>
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") {  ?> no-display <?php }      ?>"> <i class="icon-remove"></i> <?php echo $errmsg;  ?> </div>
<!--                    <h2><i class="icon-group teal"></i> Apply Leave</h2>
                    <div>
                        <hr />
                    </div>-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Year <span class="symbol required"> </span> </label>
                                        <select name="txt_cal_year" id="txt_cal_year" class="form-control" onchange="getdates()">
                                            <option value="">Select</option>
                                            <option value="<?php echo date('Y') - 1 ?>"><?php echo date('Y') - 1 ?></option>
                                            <option value="<?php echo date('Y') ?>"><?php echo date('Y') ?></option>
                                            <option value="<?php echo date('Y') + 1 ?>"><?php echo date('Y') + 1 ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Month <span class="symbol required"> </span> </label>
                                        <select name="txt_cal_month" id="txt_cal_month" class="form-control" onchange="getdates()">
                                            <option value="">Select</option>
                                            <option value="0">January</option>
                                            <option value="1">February</option>
                                            <option value="2">March</option>
                                            <option value="3">April</option>
                                            <option value="4">May</option>
                                            <option value="5">June</option>
                                            <option value="6">July</option>
                                            <option value="7">August</option>
                                            <option value="8">September</option>
                                            <option value="9">October</option>
                                            <option value="10">November</option>
                                            <option value="11">December</option>
                                        </select>
                                    </div>
                                </div>
                            </div> 
                        </div>
<!--                        <div class="col-md-6">
                            <div id="staff_details">

                            </div>
                        </div>-->
                    </div>
                    <div class="row" id="table_batch">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover table-full-width" id="tblstr">
                                <thead>
                                    <tr>
                                        <th class="">No</th>
                                        <th class="">Date</th>
                                        <th>Day</th>
                                        <th>Off Day</th>
                                        <th>Total Working Hours</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                            </table>
                            <!--                            <div align="right">
                                                            <label class="btn btn-xs btn-bricky" onclick="deleteChecked('tblstr', 'Num');" onkeyup="hiddenFunction();"><i class="icon-trash"></i> Delete Item</label>
                                                        </div>-->
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
                            <button class="btn btn-primary btn-block" type="submit"> Register <i class="icon-circle-arrow-right"></i> </button>
                            <input type="hidden" name="Num" id="Num" value="2" />
                        </div>
                    </div>
                </div>
            </form>

            <!-- end: DYNAMIC TABLE PANEL --> 

        </div>
    </div>
</div>
<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
        <h4 class="modal-title">Spare Parts List</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12" id="output"> </div>
        </div>
    </div>
</div>
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/calendar.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form-validation/add_calendar.js"></script>
<script>

    function addcalendar(date, day, off, hours, description)
    {
//        console.log(obj)
//        return;
//        date = $(obj).val();
//        console.log(cmp_id + ', ' + cmp_name + ', ' + unit_price + ', ' + unit_part_no)
        var tbl = document.getElementById('tblstr');
        for (var i = 3; i < tbl.rows.length + 2; i++)
        {
            if (date == document.getElementById("calendar_date" + i).value || date == '') {
                //alert("Item already exist!");
                return false;
            }
        }
        var Numx = document.getElementById('Num').value;
        appendRow('tblstr');
        Numx = (Number(Numx) + 1);
        $("#Num").val(Numx);
        $("#calendar_date" + Numx).val(date);
        $("#calendar_day" + Numx).val(day);
        $("#working_hrs" + Numx).val(hours);
        if(off == 1) {
            $("#calendar_off-" + Numx).prop("checked", true);
            $("#calendar_off-" + Numx).closest("tr").addClass("alert-warning");
            $("#working_hrs" + Numx).attr("disabled",true);
        }
        $("#description" + Numx).val(description);
        hiddenFunction();
    }
//
    function hiddenFunction()
    {
        var count = document.getElementById('Num').value;
        if (Number(count) <= 2)
        {
            document.getElementById('table_batch').style.display = 'none';
        } else
        {
            document.getElementById('table_batch').style.display = 'block';
        }
    }

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();
    });

    function getdates() {
//        var d = new Date();
        $("#tblstr").find("tr:gt(0)").remove();
        $("#Num").val(2);
        var year = parseInt($("#txt_cal_year").val());
        var month = parseInt($("#txt_cal_month").val());
        $.ajax({
            type: "POST",
            data: {
                year: year,
                month: parseInt(month)+1,
            },
            url: "<?php echo site_url('calendar/get_calendar'); ?>",
            success: function (data)
            {
                data = jQuery.parseJSON(data);
                if(data.length > 0) {
                    $.each(data,function(key,value) {
                        var newDate = new Date(value['CAL_DATE'])
                        var date = ("0"+ newDate.getDate()).slice(-2)+ "-" + ("0" + (newDate.getMonth() + 1)).slice(-2) + '-' + newDate.getFullYear();
                        addcalendar(date, value['CAL_DAY'], value['CAL_OFF'], value['WORKING_HOURS'], value['CAL_DESCRIPTION'])
                    });
                } else {
                    var days = [];
                    days = getDaysInMonth(month, year); //Get total days in a month
                    var weekDay = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    $.each(days,function(key,val){
                        var dte = ("0"+ val.getDate()).slice(-2)+ "-" + ("0" + (val.getMonth() + 1)).slice(-2) + '-' + val.getFullYear();
                        var off = 0;
                        var wrkng_hur = '8:00';
                        var description = "";
                        if (val.getDay() == 0) {   //if Sunday
                            off = 1;
                            wrkng_hur = 0;
                            description = 'Sunday';
                        }
                        addcalendar(dte, weekDay[val.getDay()], off, wrkng_hur, description)
                    })
                }
            }
        });
    }
    
    function getDaysInMonth(month, year) {
        var date = new Date(year, month, 1);
        var days = [];
        while (date.getMonth() === month) {
        days.push(new Date(date));
        date.setDate(date.getDate() + 1);
     }
     return days;
}

    function update_working_hr(obj) {
        var id = $(obj).attr('id');
        var num = id.split("-")[1];
        console.log(num)
        if($(obj).is(":checked")){
            $("#working_hrs" + num).val(0).attr("disabled", true);
            $(obj).closest("tr").addClass("alert-warning");
//            $(obj).closest("tr").find("input").addClass("alert-warning");
        } else {
            $("#working_hrs" + num).val('8:00').attr("disabled", false);
            $(obj).closest("tr").removeClass("alert-warning");
//            $(obj).closest("tr").find("input").removeClass("alert-warning");
        }
        calculate_total_hours();
    }
    
    function calculate_total_hours() {
        var total_hours = 0;
        $(".cal_working_hrs").each(function(){
            console.log($(this).val());
            var hrs = parseFloat($(this).val()).toFixed(2);
            console.log("hrs *** " + hrs)
            total_hours =  total_hours + hrs;
            console.log("total_hours ** " +total_hours)
        })
        console.log(total_hours)
    }


</script>
<?php // echo "<br><br>year        " . $year;