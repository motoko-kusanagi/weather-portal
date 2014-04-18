<?php
  # mysql connect
  include 'connect.php';

  // goryczkowa //
  $query_goryczkowa = mysql_query("SELECT DATE, AVG_GORYCZKOWA, DIR_GORYCZKOWA FROM WIND_AVERANGE WHERE DATE BETWEEN '$date_last' AND '$date_now';");
  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('type' => 'string', 'role' => 'annotation')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query_goryczkowa)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE']);
    $temp[] = array('v' => $r['AVG_GORYCZKOWA']);
    $temp[] = array('v' => $r['DIR_GORYCZKOWA']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;

  $json_goryczkowa = json_encode($table);

  // piec stawow //
  $query_piec_stawow = mysql_query("SELECT DATE, AVG_PIEC_STAWOW, DIR_PIEC_STAWOW FROM WIND_AVERANGE WHERE DATE BETWEEN '$date_last' AND '$date_now';");
  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Pięć Stawów', 'type' => 'number'),
    array('type' => 'string', 'role' => 'annotation')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query_piec_stawow)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE']);
    $temp[] = array('v' => $r['AVG_PIEC_STAWOW']);
    $temp[] = array('v' => $r['DIR_PIEC_STAWOW']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;

  $json_piec_stawow = json_encode($table);

  // morskie oko //
  $query_morskie_oko = mysql_query("SELECT DATE, AVG_MORSKIE_OKO, DIR_MORSKIE_OKO FROM WIND_AVERANGE WHERE DATE BETWEEN '$date_last' AND '$date_now';");
  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('type' => 'string', 'role' => 'annotation')
  );

  $rows = array();
  while($r = mysql_fetch_assoc($query_morskie_oko)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE']);
    $temp[] = array('v' => $r['AVG_MORSKIE_OKO']);
    $temp[] = array('v' => $r['DIR_MORSKIE_OKO']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;

  $json_morskie_oko = json_encode($table);
?>

<!doctype html>
<html lang="pl">
<meta charset="UTF-8" />
<head>
  <title>informacje pogodowe dla tatr</title>
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
      })();
  </script>


    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChartWindGoryczkowa);
    google.setOnLoadCallback(drawChartWindPiecStawow);
    google.setOnLoadCallback(drawChartWindMorskieOko);

    function drawChartWindGoryczkowa() {
    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(<?=$json_goryczkowa?>);
    var options = {
      // title: 'AKTUALNA TEMPERATURA [°C]',
      fontName: 'Calibri',
      curveType: 'function',
      // explorer: {}, // zoom chart!
      crosshair: { trigger: 'both' },
      // lineWidth: 5,
      // hAxis.gridlines.count: 5,
      // hAxis.textPosition: 'in',
      // series: [{color: '#dc3912', visibleInLegend: true}],
      vAxis: { title: "[m/s]", titleTextStyle: {italic: true}},
      legend: {position: 'top', textStyle: {color: 'black', fontSize: 14}},
      selectionMode: 'multiple',
      // seriesType: "bars",
      // series: {4: {type: "line"}},
      is3D: 'true',
      width: "90%",
      height: 400
    };
    // Instantiate and draw our chart, passing in some options.
    // Do not forget to check your div ID
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_goryczkowa'));
    chart.draw(data, options);
    }

    function drawChartWindPiecStawow() {
    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(<?=$json_piec_stawow?>);
    var options = {
      // title: 'AKTUALNA TEMPERATURA [°C]',
      fontName: 'Calibri',
      curveType: 'function',
      // explorer: {}, // zoom chart!
      crosshair: { trigger: 'both' },
      // lineWidth: 5,
      // hAxis.gridlines.count: 5,
      // hAxis.textPosition: 'in',
      series: [{color: '#dc3912', visibleInLegend: true}],
      vAxis: { title: "[m/s]", titleTextStyle: {italic: true}},
      legend: {position: 'top', textStyle: {color: 'black', fontSize: 14}},
      selectionMode: 'multiple',
      // seriesType: "bars",
      // series: {4: {type: "line"}},
      is3D: 'true',
      width: "90%",
      height: 400
    };
    // Instantiate and draw our chart, passing in some options.
    // Do not forget to check your div ID
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_piec_stawow'));
    chart.draw(data, options);
    }

    function drawChartWindMorskieOko() {
    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(<?=$json_morskie_oko?>);
    var options = {
      // title: 'AKTUALNA TEMPERATURA [°C]',
      fontName: 'Calibri',
      curveType: 'function',
      // explorer: {}, // zoom chart!
      crosshair: { trigger: 'both' },
      // lineWidth: 5,
      // hAxis.gridlines.count: 5,
      // hAxis.textPosition: 'in',
      series: [{color: '#ff9900', visibleInLegend: true}],
      vAxis: { title: "[m/s]", titleTextStyle: {italic: true}},
      legend: {position: 'top', textStyle: {color: 'black', fontSize: 14}},
      selectionMode: 'multiple',
      // seriesType: "bars",
      // series: {4: {type: "line"}},
      is3D: 'true',
      width: "90%",
      height: 400
    };
    // Instantiate and draw our chart, passing in some options.
    // Do not forget to check your div ID
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_morskie_oko'));
    chart.draw(data, options);
    }



</script>
</head>
<br>
  <center>
  <h1>informacje pogodowe dla tatr</h1>
	<a href="">temperatura</a>
	<a href="">wiatr</a>
  </center>
<p>
  <div id="chart_goryczkowa"></div>
  <br>
  <div id="chart_piec_stawow"></div>
  <br>
  <div id="chart_morskie_oko"></div>
</p>

<?php include('footer.html'); ?>
