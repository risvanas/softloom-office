 <canvas id="salcanvas"></canvas>  
                                        <?php $labels_mts=""; $development_sal =""; $training_sal =""; foreach($sal_summary->result() as $row) {
	$labels_mts = $labels_mts.'"'.$row->MONTH.'/ '.$row->YEAR.'",';
	$training_sal = $training_sal.$row->T_SAL.',';
	$development_sal = $development_sal.$row->D_SAL.',';
	 }?>
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
				data : [<?php echo $training_sal; ?>]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [<?php echo $development_sal; ?>]
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