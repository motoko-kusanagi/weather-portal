<?php

  $con = mysql_connect('localhost', 'ruby', 'github') or die('Error connecting to server');
  mysql_select_db('topr', $con);
  // write your SQL query here (you may use parameters from $_GET or $_POST if you need them)
  $query = mysql_query('SELECT * FROM temperature');

  $table = array();
  $table['cols'] = array(
    array('label' => 'DATE', 'type' => 'string'),
    array('label' => 'GORYCZKOWA', 'type' => 'number'),
    array('label' => 'MORSKIE OKO', 'type' => 'number'),
    array('label' => 'PIEC STAWOW', 'type' => 'number')
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

$json = json_encode($table);

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
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json?>);
          var options = {
          title: 'TEMPERATURA',
          is3D: 'true',
          width: 1024,
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
  </head>
  <body>
    <div id="chart_div"></div>
  </body>
</html>
