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
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" />
		<br/>
		
<div class="row">
						<div class="col-md-12">
							<!-- start: BASIC CHART PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-external-link-sign"></i>
									Bussiness Growth 
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
        <h1>Business Growth<small></small></h1>
        <hr />
      </div>
								<div class="row">
      	<div class="col-md-12">
     
	  
			</div></div>					
								<div class="panel-body" id="output">
								 <div class="col-md-12">
									</label></center>
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
		
        var buss_growth = [
		<?php
		$past=0;
		foreach($growth->result() as $row) 
					  {
         $present=$row->income;
	if($past != 0)
	{
	$growth=(($present-$past)/$past)*100;
	}
	else
	{
		$growth=0;
	}
						  ?>
						  
            ['<?php echo $row->code; ?>', <?php echo $growth; ?>],
			
					  <?php   
					  $past=$present;
					  }
					  ?>
            
            
        ];
		
        var plot = $.plot($("#placeholder3"), [{
            data: buss_growth,
            label: "Business Growth"
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
            colors: ["#37b7f3", "#52e136"],
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
