 <canvas id="salcanvas"></canvas>  
                                        <?php $labels_mts=""; $labels_mts_data ="";  foreach($sal_summary->result() as $row) {
	$labels_mts = $labels_mts.'"'.$row->MONTH.'/ '.$row->YEAR.'",';
	$labels_mts_data = $labels_mts_data.$row->MTAMT.','; }?>
<script>
	sal();
	function sal(){
		
		var barChartDataSal = {
		labels : [<?php echo $labels_mts; ?>],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [<?php echo $labels_mts_data; ?>]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [<?php echo $labels_mts_data; ?>]
			}
		]

	}
	
	var ctx1 = document.getElementById("salcanvas").getContext("2d");
	window.myBar1 = new Chart(ctx1).Bar(barChartDataSal, {
			responsive : true
	});
		
		
	}
	lode_image_false();
	</script>                                                   