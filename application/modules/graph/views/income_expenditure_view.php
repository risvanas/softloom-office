<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/style.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main-responsive.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme_light.css" id="skin_color">
		<!--[if IE 7]>
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="shortcut icon" href="favicon.ico" />
		<br/>
		
<div class="row">
						<div class="col-md-12">
							<!-- start: BASIC CHART PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-external-link-sign"></i>
									Income and Expenditure Chart
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="icon-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="icon-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="icon-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="icon-remove"></i>
										</a>
									</div>
								</div>
								<br/>
			<div class="col-md-12">
        <h1>Income and Expenditure Chart<small></small></h1>
        <hr />
      </div>
								<div class="row">
      	<div class="col-md-12">
           
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label"> From Date</label>
          <span class="input-icon input-icon-right">
              <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from"/>
          <i class="icon-calendar"></i> </span> </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label"> To Date</label>
          <span class="input-icon input-icon-right">
          <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to"/>
          <i class="icon-calendar"></i> </span> </div>
      </div>
	  
<!-- <div class="col-md-2">
                  <div class="form-group" id="h1">
                    <label class="control-label">Report Type<span class="symbol required"> </span></label>
                    <select class="form-control" id="txt_pay" name="txt_pay">
                      
                      
                      <option value="sal" selected="selected">Sales</option>
					  <option value="pay">Payment</option>
                      
                    </select>
                  </div>
                </div>	-->  
	  
	  <div class="col-md-2">
            <label for="form-field-mask-1"> &nbsp; </label>
            <div class="input-group">
              <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Go! </button>
             </div>
          </div>
	  
			</div></div>					
								<div class="panel-body" id="output">
								 <div class="col-md-12">
									<?php
									$date2=date('Y-M-d');
		                            $date1=date('Y-M-d',strtotime('-6 month'));
									?>
									<center><label>Income and Expenditure ( <?php echo $date1 . ' to ' . $date2; ?> )</label></center>
									</div> 
									<div class="flot-container">
									
										<div id="placeholder3" class="flot-placeholder"></div>
									</div>
								</div>
							</div>
							<!-- end: BASIC CHART PANEL -->
						</div>
					</div>
							
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.resize.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.categories.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.pie.js"></script>
		<script type="text/javascript" src="/assets/script/canvasjs.min.js"></script>
		
		<script>
function search_data()
{
	//alert('hai');
	lode_image_true();
	$.ajax({
	type:"POST",
	data:
	{
		calc:$('#txt_from').val(),
		dat:$('#txt_to').val()
     },
	url:"<?php echo site_url('graph/search_income_graph');?>",
	success: function(data)
	{
		//alert('helo');
	 $('#output').html(data);
	}
	});
}
</script> 
 <script>
			jQuery(document).ready(function() {
				Main.init();
				Charts.init();
				FormElements.init();
			});
		</script>
		
		<script>
			
			
			
			
			var Charts = function () {
    //function to initiate jQRangeSlider
    //There are plenty of options you can set to control the precise looks of your plot. 
    //You can control the ticks on the axes, the legend, the graph type, etc.
    //For more information, please visit http://www.flotcharts.org/
    var runCharts = function () {
        // Basic Chart 
       
        // Toggling Series 
       
        // hard-code color indices to prevent them from shifting as
        // countries are turned on/off
        
        // insert checkboxes

        // Interactivity 
         function randValue() {
            return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
        }
		
        var debit = [
		<?php
		foreach($sal_summary->result() as $row) 
					  {
						  $val_month = $row->MONTH;

switch ($val_month) {
    case "1":
        $pr_month="January";
        break;
    case "2":
        $pr_month="February";
        break;
    case "3":
        $pr_month="March";
        break;
	case "4":
        $pr_month="April";
        break;
    case "5":
        $pr_month="May";
        break;
    case "6":
        $pr_month="June ";
        break;
	case "7":
        $pr_month="July ";
        break;
    case "8":
        $pr_month="August ";
        break;
    case "9":
        $pr_month="September";
        break;
	case "10":
        $pr_month="October ";
        break;
    case "11":
        $pr_month="November";
        break;
    case "12":
        $pr_month="December";
        break;
    default:
        $pr_month="no month";
}
  if($row->acc_type == 'INCOME')
  {
						  ?>
						  
            ['<?php echo $row->YEAR.'-'.$pr_month; ?>', <?php echo $row->income; ?>],
			
					  <?php   }
					  }
					  ?>
            
            
        ];

        var credit = [
		<?php
		foreach($sal_summary->result() as $row) 
					  {
						  $val_month = $row->MONTH;

switch ($val_month) {
    case "1":
        $pr_month="January";
        break;
    case "2":
        $pr_month="February";
        break;
    case "3":
        $pr_month="March";
        break;
	case "4":
        $pr_month="April";
        break;
    case "5":
        $pr_month="May";
        break;
    case "6":
        $pr_month="June ";
        break;
	case "7":
        $pr_month="July ";
        break;
    case "8":
        $pr_month="August ";
        break;
    case "9":
        $pr_month="September";
        break;
	case "10":
        $pr_month="October ";
        break;
    case "11":
        $pr_month="November";
        break;
    case "12":
        $pr_month="December";
        break;
    default:
        $pr_month="no month";
}
  if($row->acc_type == 'EXPENSES')
  {
						  ?>
             ["<?php echo $row->YEAR.'-'.$pr_month; ?>", <?php echo $row->expen; ?>],
			
					  <?php   }
					  }
					  ?>
        ];
	
		
        var plot = $.plot($("#placeholder3"), [{
            data: debit,
            label: "Income"
        }, {
            data: credit,
            label: "Expenses"
        }], {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.10
                        }, {
                            opacity: 0.10
                        }, {
                            opacity: 0.10
                        }]
                    }
                },
                points: {
                    show: true
                },
                shadowSize: 1
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#eee",
                borderWidth: 0
            },
            colors: ["#FB753B", "#D12610", "#37b7f3", "#52e136"],
            xaxis: {
			    mode: "categories",
                //ticks: 20,
				labelAngle: -30,
                tickDecimals: 0
            },
            yaxis: {
                ticks: 11,
                tickDecimals: 0
            }
        });
 
        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 15,
                border: '1px solid #333',
                padding: '4px',
                color: '#fff',
                'border-radius': '3px',
                'background-color': '#333',
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }
        var previousPoint = null;
        $("#placeholder3").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
						//alert(item.series.label);
						
                    showTooltip(item.pageX, item.pageY, item.series.label+ " " + y);
					   
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });        //Real Time 
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        
        // Set up the control widget
        
       
        // Annotations

        // Append it to the placeholder that Flot already uses for positioning
       
        // Draw a little arrow on top of the last label to demonstrate canvas
        // drawing
       
        // Default Pie 
       
        // Label Formatter 
       
        // Label Style 
       
        // Rectangular Pie
        
        // Tilted Pie 
       
        // Interactivity Pie
		
        
    };
    return {
        //main function to initiate template pages
        init: function () {
            runCharts();
        }
    };
}();


		</script>
