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

<!doctype html>
<html lang="en">
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
          width: "50%",
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
          width: "50%",
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
          width: "50%",
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_wind_max'));
      chart.draw(data, options);
    }

    </script>


	<meta charset="utf-8" />
	<style>
	    body { font-family: Helvetica, Arial, sans-serif; line-height: 1.3em; -webkit-font-smoothing: antialiased; }
	    .container {
	        width: 70%;
	        margin: 20px auto;
	        background-color: #FFF;
	        padding: 20px;
	    }
	    pre, code {
        font-family: Monaco, Menlo, Consolas, "Courier New", monospace;
        font-size: 12px;
        color: #333;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
      }
      pre { border: 1px solid #CCC; background-color: #EEE; color: #333; padding: 10px; overflow: scroll; }
      code { padding: 2px 4px; background-color: #F7F7F9; border: 1px solid #E1E1E8; color: #D14; }
	</style>
</head>
<body>
    <div class="container">
        <h1>TOPR</h1>
        <p>
		<div id="chart_div_temp"></div>
		<div id="chart_div_wind_avg"></div>
		<div id="chart_div_wind_max"></div>
	</p>
    </div>
	<script src="libs/jquery/jquery.js"></script>
    <script src="libs/jquery.backstretch.js"></script>
	<script>
        $.backstretch([
          "imgs/1.jpg",
          "imgs/2.jpg",
          "imgs/3.jpg",
	  "imgs/4.jpg"
        ], {
            fade: 750,
            duration: 60000
        });
    </script>
</body>
</html>
