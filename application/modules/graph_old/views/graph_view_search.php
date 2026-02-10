
<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/style.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main-responsive.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme_light.css" id="skin_color">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datepicker/css/datepicker.css">


<div class="panel-body">
									<div class="flot-container">
									<div class="col-md-12">
									<center><label><?php echo $rtyp; ?>(<?php echo $from. ' to ' .$to; ?>)</label></center>
									</div>
										<div id="placeholder3" class="flot-placeholder"></div>
									</div>
								</div>
								<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="<?php echo base_url();?>assets/js/main.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.resize.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.categories.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.pie.js"></script>

<script>
			 jQuery(document).ready(function() {
				//Main.init();
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
		
        var pageviews = [
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
						  ?>
						  
            ['<?php echo $row->YEAR.'-'.$pr_month; ?>', <?php echo $row->T_SAL; ?>],
			
					  <?php   }
					  ?>
            
            
        ];
<?php
if($rtyp == 'SALES')
{
?>		
var sales_return = [
		<?php
		foreach($sal_return->result() as $row) 
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
						  ?>
						  
            ['<?php echo $row->YEAR.'-'.$pr_month; ?>', <?php echo $row->T_RTN; ?>],
			
					  <?php   }
					  ?>
            
            
        ];
<?php
}
?>		

        var visitors = [
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
						  ?>
             ["<?php echo $row->YEAR.'-'.$pr_month; ?>", <?php echo $row->D_SAL; ?>],
			
					  <?php   }
					  ?>
        ];
        var plot = $.plot($("#placeholder3"), [{
            data: pageviews,
            label: "Training"
        }
		<?php
		if($rtyp == 'SALES')
          {
		?>
		, {
            data: sales_return,
            label: "return"
        }
		<?php
	     }
		?>
		, {
            data: visitors,
            label: "Development"
        }], {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.05
                        }, {
                            opacity: 0.04
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
			
			<?php
			if($rtyp == 'SALES')
          {
			?>
			colors: ["#FB753B", "#D12610", "#37b7f3"],
          
		   <?php
	     }
		 else
		 {
		?>
		  colors: ["#FB753B", "#37b7f3"],
		   <?php
		 }
		 ?>
            xaxis: {
			    mode: "categories",
                //ticks: 20,
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
                    showTooltip(item.pageX, item.pageY, item.series.label + " " + y);
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
lode_image_false();
		</script>
