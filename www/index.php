<?php
  # mysql connect
  include 'connect.php';

  $query = mysql_query("SELECT * FROM pressure WHERE DATE_SYSTEM BETWEEN '$date_last' AND '$date_now'");

  // pressure //

  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Zakopane', 'type' => 'number'),
    array('label' => 'Kasprowy Wierch', 'type' => 'number'),
    array('label' => 'Łomnica', 'type' => 'number'),
    array('label' => 'Kraków', 'type' => 'number')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE_SYSTEM']);
    $temp[] = array('v' => $r['ZAKOPANE']);
    $temp[] = array('v' => $r['KASPROWY_WIERCH']);
    $temp[] = array('v' => $r['LOMNICA']);
    $temp[] = array('v' => $r['KRAKOW']);

    $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

  $json_pressure = json_encode($table);

  // temperature //

  $query = mysql_query("SELECT * FROM temperature WHERE DATE_SYSTEM BETWEEN '$date_last' AND '$date_now'");

  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('label' => 'Piec Stawow', 'type' => 'number'),
    array('label' => 'Łomnica', 'type' => 'number'),
    array('label' => 'Kraków', 'type' => 'number')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE_XML']);
    $temp[] = array('v' => $r['GORYCZKOWA']);
    $temp[] = array('v' => $r['MORSKIE_OKO']);
    $temp[] = array('v' => $r['PIEC_STAWOW']);
    $temp[] = array('v' => $r['LOMNICKY_STIT']);
    $temp[] = array('v' => $r['KRAKOW']);

    $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

  $json_temperature = json_encode($table);

  // wind averange //
  $query_wind_averange = mysql_query("SELECT * FROM wind_speed_averange WHERE DATE_SYSTEM BETWEEN '$date_last' AND '$date_now'");

  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('label' => 'Piec Stawow', 'type' => 'number')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query_wind_averange)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE_XML']);
    $temp[] = array('v' => $r['GORYCZKOWA']);
    $temp[] = array('v' => $r['MORSKIE_OKO']);
    $temp[] = array('v' => $r['PIEC_STAWOW']);

    $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

  $json_wind_averange = json_encode($table);

  // wind maximum //

  $query_wind_maximum = mysql_query("SELECT * FROM wind_speed_maximum WHERE DATE_SYSTEM BETWEEN '$date_last' AND '$date_now'");
  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('label' => 'Piec Stawow', 'type' => 'number')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query_wind_maximum)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE_XML']);
    $temp[] = array('v' => $r['GORYCZKOWA']);
    $temp[] = array('v' => $r['MORSKIE_OKO']);
    $temp[] = array('v' => $r['PIEC_STAWOW']);

    $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

  $json_wind_maximum = json_encode($table);
?>

<!doctype html>
<html lang="pl">
<meta charset="UTF-8" />
<head>
  // css
  <link rel="stylesheet" href="main.css" type="text/css">

    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

	<script type="text/javascript">
	  WebFontConfig = {
	    google: { families: [ 'Noto+Sans:400,700:latin' ] }
	  };
	  (function() {
	    var wf = document.createElement('script');
	    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
	      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	    wf.type = 'text/javascript';
	    wf.async = 'true';
	    var s = document.getElementsByTagName('script')[0];
	    s.parentNode.insertBefore(wf, s);
	  })(); </script>


    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChartPressure);
    google.setOnLoadCallback(drawChartTemperature);
    google.setOnLoadCallback(drawChartWindAverange);
    google.setOnLoadCallback(drawChartWindMaximum);

    function drawChartPressure() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_pressure?>);
          var options = {
          title: 'CIŚNIENIE [hPa]',
          fontName: 'Calibri',
          curveType: 'function',
          // explorer: {}, // zoom chart!
          crosshair: { trigger: 'both' },
          // hAxis.gridlines.count: 5,
          //hAxis.textPosition: 'in',
          legend: {position: 'right', textStyle: {color: 'black', fontSize: 14}},
          selectionMode: 'multiple',
          is3D: 'true',
          width: "90%",
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_pressure'));
      chart.draw(data, options);
    }

    function drawChartTemperature() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_temperature?>);
          var options = {
          title: 'TEMPERATURA [°C]',
          fontName: 'Calibri',
          curveType: 'function',
          // explorer: {}, // zoom chart!
          crosshair: { trigger: 'both' },
          // hAxis.gridlines.count: 5,
          //hAxis.textPosition: 'in',
          legend: {position: 'right', textStyle: {color: 'black', fontSize: 14}},
          selectionMode: 'multiple',
          is3D: 'true',
          width: "90%",
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_temperature'));
      chart.draw(data, options);
    }

    function drawChartWindAverange() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_wind_averange?>);
          var options = {
          title: 'ŚREDNIA PRĘDKOŚC WIATRU [m/s]',
          fontName: 'Calibri',
          curveType: 'function',
          // explorer: {}, // zoom chart!
          crosshair: { trigger: 'both' },
          // hAxis.gridlines.count: 5,
          //hAxis.textPosition: 'in',
          legend: {position: 'right', textStyle: {color: 'black', fontSize: 14}},
          selectionMode: 'multiple',
          is3D: 'true',
          width: "90%",
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_wind_averange'));
      chart.draw(data, options);
    }

    function drawChartWindMaximum() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_wind_maximum?>);
          var options = {
          title: 'MAKSYMALNA PRĘDKOŚĆ WIATRU [m/s]',
          fontName: 'Calibri',
          curveType: 'function',
          // explorer: {}, // zoom chart!
          crosshair: { trigger: 'both' },
          // hAxis.gridlines.count: 5,
          //hAxis.textPosition: 'in',
          legend: {position: 'right', textStyle: {color: 'black', fontSize: 14}},
          selectionMode: 'multiple',
          is3D: 'true',
          width: "90%",
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_wind_maximum'));
      chart.draw(data, options);
    }

</script>
</head>
<br>
  <center>
  <h1>INFORMACJE POGODOWE</h1>
  </center>
<p>
  <div id="chart_div_temperature"></div>
  <br>
  <div id="chart_div_pressure"></div>
  <br>
  <div id="chart_div_wind_averange"></div>
  <br>
  <div id="chart_div_wind_maximum"></div>
</p>
