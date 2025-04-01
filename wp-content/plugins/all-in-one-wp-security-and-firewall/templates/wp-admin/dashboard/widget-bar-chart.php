<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>
<div class="aiowps_feature_status_container">
	<?php
	$day_wise_chart_data = array();
	for ($i = 0; $i < $chart_data['last_days']; $i++) {
		$day_wise_chart_data[date("Y-m-d", strtotime($i." days ago"))] = 0;
	}
	$day_wise_chart_data = array_reverse($day_wise_chart_data); // bar chart to show date ascending 7-Nov to 13-Nov
	foreach ($chart_data['data'] as $data) {
		$created_date = date("Y-m-d", $data['created']);
		if (isset($day_wise_chart_data[$created_date])) $day_wise_chart_data[$created_date]++; // only last 7 days including today to consider not the 8th day.
	}
	
	// Prepare chart columns
	$chart_columns = array(
		$chart_data['columns'][0],
		$chart_data['columns'][1],
	);
	// Prepare chart rows
	$chart_rows = array();
	foreach ($day_wise_chart_data as $date => $total) {
		$chart_rows[] = array(
			date("d-M", strtotime($date)), // Format the date
			(int) $total,                    // Ensure the total is an integer
		);
	}
	// Combine columns and rows for chart data
	$xdays_chart_data = array_merge(array($chart_columns), $chart_rows);
	?>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['bar','corechart']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable(<?php echo wp_json_encode($xdays_chart_data); ?>);
			var options = {
				height: '300',
				legend: {position:'none'},
				backgroundColor: 'F6F6F6',
				colors: ['#563C82']
			};
			var chart = new google.charts.Bar(document.getElementById('<?php echo esc_html($chart_data['id']); ?>_chart_div'));
			chart.draw(data, options);
		}
	</script>
	<div id='<?php echo esc_html($chart_data['id']); ?>_chart_div'></div>
</div>
<div class="aio_clear_float"></div>