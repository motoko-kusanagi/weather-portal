<?php

  $con = mysql_connect('localhost', 'ruby', 'github') or die('Error connecting to server');
  mysql_select_db('topr', $con);
  // write your SQL query here (you may use parameters from $_GET or $_POST if you need them)
  $query = mysql_query('SELECT * FROM temperature');
  $query_windAVG = mysql_query('SELECT * FROM wind_speed_averange');
  $query_windMAX = mysql_query('SELECT * FROM wind_speed_maximum');

//*** TEMPERATURE *** //

  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('label' => 'Piec Stawow', 'type' => 'number')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE_XML']);
    $temp[] = array('v' => $r['GORYCZKOWA']);
    $temp[] = array('v' => $r['MORSKIE_OKO']);
    $temp[] = array('v' => $r['PIEC_STAWOW']);

    $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

$jsonTEMP = json_encode($table);


// *** WIND AVG *** //

  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('label' => 'Piec Stawow', 'type' => 'number')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query_windAVG)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE_XML']);
    $temp[] = array('v' => $r['GORYCZKOWA']);
    $temp[] = array('v' => $r['MORSKIE_OKO']);
    $temp[] = array('v' => $r['PIEC_STAWOW']);

    $rows[] = array('c' => $temp);
  }
 
  $table['rows'] = $rows;

$json_windAVG = json_encode($table);


// *** WIND MAX *** //

  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('label' => 'Piec Stawow', 'type' => 'number')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query_windMAX)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE_XML']);
    $temp[] = array('v' => $r['GORYCZKOWA']);
    $temp[] = array('v' => $r['MORSKIE_OKO']);
    $temp[] = array('v' => $r['PIEC_STAWOW']);

    $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

$json_windMAX = json_encode($table);

?>


<html>
    <head>
    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChartTemp);
    google.setOnLoadCallback(drawChartWindAvg);
    google.setOnLoadCallback(drawChartWindMax);

    function drawChartTemp() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$jsonTEMP?>);
          var options = {
          title: 'TEMPERATURA [*C]',
	  fontName: 'Calibri',
	  curveType: 'function',
	  // explorer: {}, // zoom chart!
	  crosshair: { trigger: 'both' },
	  // hAxis.gridlines.count: 5,
	  //hAxis.textPosition: 'in',
	  legend: {position: 'right', textStyle: {color: 'black', fontSize: 16}},
	  selectionMode: 'multiple',
          is3D: 'true',
          width: 1024,
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_temp'));
      chart.draw(data, options);
    }

	// DWA

    function drawChartWindAvg() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_windAVG?>);
          var options = {
          title: 'SREDNIA PREDKOSC WIATRU [m/s]',
	  fontName: 'Calibri',
          curveType: 'function',
	  is3D: 'true',
          width: 1024,
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_wind_avg'));
      chart.draw(data, options);
    }

    function drawChartWindMax() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_windMAX?>);
          var options = {
          title: 'MAKSYMALNA PREDKOSC WIATRU [m/s]',
	  fontName: 'Calibri',
	  curveType: 'function',
          is3D: 'true',
          width: 1024,
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_wind_max'));
      chart.draw(data, options);
    }

    </script>
  </head>
  <body>
    <div id="chart_div_temp"></div>
    <div id="chart_div_wind_avg"></div>
    <div id="chart_div_wind_max"></div>
  </body>
</html>
