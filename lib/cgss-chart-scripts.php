<script type="text/javascript">
 //overview chart
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 
 function drawChart() {
  var data = google.visualization.arrayToDataTable([
   ['Result', '<?php _e( 'Percentage', 'cgss' ); ?>'],
   ['<?php _e( 'Success', 'cgss' ); ?>', <?php echo $cgss_total_pointer; ?>],
   ['<?php _e( 'Failure', 'cgss' ); ?>', <?php echo ( 1 - $cgss_total_pointer ); ?>],
 ]);
 var options = {
  title: '<?php echo __( 'Web Page Overall SEO Performance', 'cgss' ); ?>',
  colors: ['#8bba30','#ff8787'],
  pieHole: 0.25,
 };
 var chart = new google.visualization.PieChart(document.getElementById('overall_chart'));
 chart.draw(data, options);
}
</script>
<script type="text/javascript">
 //overview chart
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 
 function drawChart() {
  var data = google.visualization.arrayToDataTable([
   ['Result', '<?php _e( 'Percentage', 'cgss' ); ?>'],
   ['<?php _e( 'Success', 'cgss' ); ?>', <?php echo $cgss_total_pointer; ?>],
   ['<?php _e( 'Failure', 'cgss' ); ?>', <?php echo ( 1 - $cgss_total_pointer ); ?>],
 ]);
 var options = {
  title: '<?php echo __( 'Web Page Overall SEO Performance', 'cgss' ); ?>',
  colors: ['#8bba30','#ff8787'],
  pieHole: 0.25,
 };
 var chart = new google.visualization.PieChart(document.getElementById('overall_print_chart'));
 chart.draw(data, options);
}
</script>
<script type="text/javascript">
 //page data chart
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
  var data = google.visualization.arrayToDataTable([
   ['Result', '<?php _e( 'Percentage', 'cgss' ); ?>'],
   ['<?php _e( 'Complete', 'cgss' ); ?>', <?php echo $cgss_page_data_points; ?>],
   ['<?php _e( 'Incomplete', 'cgss' ); ?>', <?php echo ( 6 - $cgss_page_data_points ); ?>],
 ]);
 var options = {
  title: '<?php _e( 'Web Page Optimized Data Overview', 'cgss' ); ?>',
  colors: ['#6495ed','#a0a0a0'],
  pieHole: 0.25,
   height: 300,
   width: 500,
 };
 var chart = new google.visualization.PieChart(document.getElementById('page_data_chart'));
 chart.draw(data, options);
}
</script>
<script type="text/javascript">
 //ogp data chart
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
  var data = google.visualization.arrayToDataTable([
   ['OGP_Data', '<?php echo __( 'Required', 'cgss' ); ?>', '<?php echo __( 'Completed', 'cgss' ); ?>'],
   ['<?php echo __( 'Comparison of social data', 'cgss' ); ?>', 7, <?php echo $cgss_page_social_points; ?>],
  ]);
  var options = {
   title: '<?php _e( 'Social Sharing Data overview', 'cgss' ); ?>',
   vAxis: { ticks: [0,2,4,6,8] },
   colors: ['#ffcc00','#8bba30'],
   height: 300,
   width: 500,
  };
  var chart = new google.visualization.ColumnChart(document.getElementById('ogp_data_chart'));
   chart.draw(data, options);
 }
</script>
<?php
 $scan_script_total = ( $cgss_js_count + $cgss_css_count );
 $scan_script_header = ( $cgss_head_js_src_count + $cgss_head_css_href_count );
 $scan_script_footer = ( $cgss_js_diff + $cgss_css_diff );
 $cgss_hp = round( ( ( $scan_script_header / $scan_script_total ) * 100 ), 2 );
 $cgss_fp = round( ( ( $scan_script_footer / $scan_script_total ) * 100 ), 2 );
?>
<script type="text/javascript">
 //visual complition data chart
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
  var data = google.visualization.arrayToDataTable([
   ['Percentage', '<?php _e( 'Actual', 'cgss' ); ?>', '<?php _e( 'Ideal Case', 'cgss' ); ?>'],
   ['<?php _e( 'none', 'cgss' ); ?>', 0, 0],
   ['<?php _e( 'header', 'cgss' ); ?>', <?php echo ( 100 - $cgss_hp ); ?>, 97],
   ['<?php _e( 'body', 'cgss' ); ?>', <?php echo 100 - ( $cgss_hp / 2 ); ?>, 98.5],
   ['<?php _e( 'full', 'cgss' ); ?>', 100, 100],
  ]);
  var options = {
   title: '<?php _e( 'Approximate Pattern of visual complition Index', 'cgss' ); ?>',
   hAxis: {title: '<?php _e( 'web page loading', 'cgss' ); ?>',  titleTextStyle: {color: '#333'}},
   vAxis: {title: '<?php _e( 'Visual complition percentage', 'cgss' ); ?>', minValue: 0},
   colors: ['#8bba30','#ffcc00'],
   areaOpacity: 0.3,
   height: 300,
   width: 500,
  };
  var chart = new google.visualization.AreaChart(document.getElementById('visual_comp_chart'));
  chart.draw(data, options);
 }
</script>
<script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
  var data = google.visualization.arrayToDataTable([
   ['Properties', 'Size'],
   ['<?php _e( 'JavaScripts', 'cgss' ); ?>', <?php echo $cgss_js_text_length; ?>],
   ['<?php _e( 'Styles', 'cgss' ); ?>', <?php echo $cgss_style_text_length; ?>],
   ['<?php _e( 'Pure Text', 'cgss' ); ?>', <?php echo ( $cgss_only_text_length - $cgss_link_text_length ); ?>],
   ['<?php _e( 'Alt Text', 'cgss' ); ?>', <?php echo $cgss_alt_text_length; ?>],
   ['<?php _e( 'Anchor Text', 'cgss' ); ?>', <?php echo $cgss_link_text_length; ?>],
  ]);
  var options = {
   title: '<?php _e( 'In page content overview', 'cgss' ); ?>',
   colors: ['#be98ed','#ff8787','#6495ed','#ffcc00','#8bba30'],
   height: 300,
   width: 500,
  };
  var chart = new google.visualization.PieChart(document.getElementById('content_data_chart'));
  chart.draw(data, options);
 }
</script>
<script type="text/javascript">
 //server data chart
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
  var data = google.visualization.arrayToDataTable([
   ['SERVER_Data', '<?php echo __( 'Required', 'cgss' ); ?>', '<?php echo __( 'Completed', 'cgss' ); ?>'],
   ['<?php echo __( 'Comparison of server performance', 'cgss' ); ?>', 6, <?php echo $cgss_server_data_points; ?>],
  ]);
  var options = {
   title: '<?php _e( 'Technical Aspects Overview', 'cgss' ); ?>',
   vAxis: { ticks: [0,2,4,6] },
   colors: ['#6495ed','#8bba30'],
   height: 300,
   width: 500,
  };
  var chart = new google.visualization.ColumnChart(document.getElementById('server_data_chart'));
   chart.draw(data, options);
 }
</script>
