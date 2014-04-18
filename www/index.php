<?php
  # mysql connect
  include 'connect.php';
  include 'get_data.php';

  // temperature //
  $query = mysql_query("SELECT GORYCZKOWA, MORSKIE_OKO, PIEC_STAWOW, LOMNICKY_STIT, DATE_FORMAT(DATE_SYSTEM, '%Y-%m-%d %h') AS DATE FROM temperature WHERE DATE_SYSTEM BETWEEN '$date_last' AND '$date_now'");
  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('label' => 'Piec Stawow', 'type' => 'number'),
    array('label' => 'Łomnica', 'type' => 'number')
  );
  $rows = array();
  while($r = mysql_fetch_assoc($query)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE']);
    $temp[] = array('v' => $r['GORYCZKOWA']);
    $temp[] = array('v' => $r['MORSKIE_OKO']);
    $temp[] = array('v' => $r['PIEC_STAWOW']);
    $temp[] = array('v' => $r['LOMNICKY_STIT']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;
  $json_temperature = json_encode($table);

  // pressure //
  $query = mysql_query("SELECT KASPROWY_WIERCH, LOMNICA, ROUND((ZAKOPANE + KASPROWY_WIERCH + LOMNICA)/3) AS AVERANGE, DATE_FORMAT(DATE_SYSTEM, '%Y-%m-%d') AS DATE FROM pressure WHERE DATE_SYSTEM BETWEEN '$date_last' AND '$date_now'");
  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Kasprowy Wierch', 'type' => 'number'),
    array('label' => 'Łomnica', 'type' => 'number'),
    array('label' => 'Średnia', 'type' => 'number')
  );
  $rows = array();
  while($r = mysql_fetch_assoc($query)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE']);
    $temp[] = array('v' => $r['KASPROWY_WIERCH']);
    $temp[] = array('v' => $r['LOMNICA']);
    $temp[] = array('v' => $r['AVERANGE']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;
  $json_pressure = json_encode($table);

  // wind averange //
  $query_wind_averange = mysql_query("SELECT DATE_FORMAT(DATE_SYSTEM, '%Y-%m-%d') AS DATE, ROUND(AVG(GORYCZKOWA)) AS AVG_GORYCZKOWA, ROUND(AVG(PIEC_STAWOW)) AS AVG_PIEC_STAWOW, ROUND(AVG(MORSKIE_OKO)) AS AVG_MORSKIE_OKO, ROUND((AVG(GORYCZKOWA)+AVG(PIEC_STAWOW)+AVG(MORSKIE_OKO))/3) AS AVERANGE FROM wind_speed_averange WHERE DATE_SYSTEM BETWEEN '$date_last' AND '$date_now' GROUP BY (DATE);");
  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Goryczkowa', 'type' => 'number'),
    array('label' => 'Morskie Oko', 'type' => 'number'),
    array('label' => 'Piec Stawow', 'type' => 'number'),
    array('label' => 'Średnia', 'type' => 'number')
  );
  $rows = array();
  while($r = mysql_fetch_assoc($query_wind_averange)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE']);
    $temp[] = array('v' => $r['AVG_GORYCZKOWA']);
    $temp[] = array('v' => $r['AVG_MORSKIE_OKO']);
    $temp[] = array('v' => $r['AVG_PIEC_STAWOW']);
    $temp[] = array('v' => $r['AVERANGE']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;
  $json_wind_averange = json_encode($table);

  // wind maximum //
  $query_wind_maximum = mysql_query("SELECT DATE_FORMAT(DATE_SYSTEM, '%Y-%m-%d') AS DATE, ROUND(MAX(GORYCZKOWA)) AS AVG_GORYCZKOWA, ROUND(MAX(PIEC_STAWOW)) AS AVG_PIEC_STAWOW, ROUND(MAX(MORSKIE_OKO)) AS AVG_MORSKIE_OKO FROM wind_speed_maximum WHERE DATE_SYSTEM BETWEEN '$date_month' AND '$date_now' GROUP BY (DATE)");
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
    $temp[] = array('v' => $r['DATE']);
    $temp[] = array('v' => $r['AVG_GORYCZKOWA']);
    $temp[] = array('v' => $r['AVG_MORSKIE_OKO']);
    $temp[] = array('v' => $r['AVG_PIEC_STAWOW']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;
  $json_wind_maximum = json_encode($table);

  // avalanche level
  $query_avalanche_level = mysql_query("SELECT LEVEL, TEND, DATE_FORMAT(DATE_SYSTEM, '%Y-%m-%d') AS DATE FROM avalanche_level WHERE DATE_SYSTEM BETWEEN '$date_last' AND '$date_now'");
  $table = array();
  $table['cols'] = array(
    array('label' => 'Date', 'type' => 'string'),
    array('label' => 'Tatry Polskie', 'type' => 'number'),
    array('type' => 'string', 'role' => 'annotation')
  );
  $rows = array();
  while($r = mysql_fetch_assoc($query_avalanche_level)) {
    $temp = array();
    $temp[] = array('v' => $r['DATE']);
    $temp[] = array('v' => $r['LEVEL']);
    $temp[] = array('v' => $r['TEND']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;
  $json_avalanche_level = json_encode($table);
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
    google.setOnLoadCallback(drawChartTemperature);
    google.setOnLoadCallback(drawChartPressure);
    google.setOnLoadCallback(drawChartWindAverange);
    google.setOnLoadCallback(drawChartWindGoryczkowa);
    google.setOnLoadCallback(drawChartWindPiecStawow);
    google.setOnLoadCallback(drawChartWindMorskieOko);
    google.setOnLoadCallback(drawChartWindMaximum);
    google.setOnLoadCallback(drawChartAvalanche);

    function drawChartTemperature() {
    // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_temperature?>);
          var options = {
          // title: 'AKTUALNA TEMPERATURA [°C]',
          fontName: 'Calibri',
          curveType: 'function',
          // explorer: {}, // zoom chart!
          crosshair: { trigger: 'both' },
		  // lineWidth: 5,
          // hAxis.gridlines.count: 5,
          // hAxis.textPosition: 'in',
		  vAxis: { title: "temperatura (°C)", titleTextStyle: {italic: true}},
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
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_temperature'));
      chart.draw(data, options);
    }

    function drawChartPressure() {
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_pressure?>);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1, 2, 3,
			{ calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
			]);

	  var options = {
          // title: 'CIŚNIENIE [hPa]',
          fontName: 'Calibri',
	  series: {0:{color: '#ff9900', visibleInLegend: true},1:{color: '#ff9900', visibleInLegend: false}},
          // curveType: 'function',
          // explorer: {}, // zoom chart!
          crosshair: { trigger: 'both' },
          // hAxis.gridlines.count: 5,
          // hAxis.textPosition: 'in',
	  vAxis: { title: "ciśnienie (hPa)", titleTextStyle: {italic: true}},
          legend: {position: 'top', textStyle: {color: 'black', fontSize: 14}},
          selectionMode: 'multiple',
		  seriesType: "bars",
		  series: { 0: {color: '#3366cc', visibleInLegend: true},
			    1: {color: '#109618', visibleInLegend: true},
			    2: {type: "line", visibleInLegend: false}},
          is3D: 'true',
          width: "90%",
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.ComboChart(document.getElementById('pressure'));
      chart.draw(view, options);
    }

    function drawChartWindAverange() {
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$json_wind_averange?>);
      var options = {
        // title: 'ŚREDNIA PRĘDKOŚC WIATRU [m/s]',
        fontName: 'Calibri',
        // curveType: 'function',
        // explorer: {}, // zoom chart!
        // crosshair: { trigger: 'both' },
        // hAxis.gridlines.count: 5,
        // hAxis.textPosition: 'in',
	vAxis: { title: "średnia prędkość wiatru (m/s)", titleTextStyle: {italic: true}},
        legend: {position: 'top', textStyle: {color: 'black', fontSize: 14}},
        //selectionMode: 'multiple',
        //is3D: 'true',
	seriesType: "bars",
	series: {3: {type: "line", visibleInLegend: false}},
        width: "90%",
        height: 400
      };

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1, 2, 3, 4,
		{ calc: "stringify",
                sourceColumn: 4,
                type: "string",
                role: "annotation" }
		]);
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_wind_averange'));
      chart.draw(view, options);
    }

    function drawChartWindGoryczkowa() {
    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(<?=$json_wind_goryczkowa?>);
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
      vAxis: { title: "średnia prędkośc wiatru (m/s)", titleTextStyle: {italic: true}},
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
    var chart = new google.visualization.ColumnChart(document.getElementById('wind_goryczkowa'));
    chart.draw(data, options);
    }

    function drawChartWindPiecStawow() {
    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(<?=$json_wind_piec_stawow?>);
    var options = {
      // title: 'AKTUALNA TEMPERATURA [Â°C]',
      fontName: 'Calibri',
      curveType: 'function',
      // explorer: {}, // zoom chart!
      crosshair: { trigger: 'both' },
      // lineWidth: 5,
      // hAxis.gridlines.count: 5,
      // hAxis.textPosition: 'in',
      series: [{color: '#dc3912', visibleInLegend: true}],
      vAxis: { title: "średnia prędkośc wiatru (m/s)", titleTextStyle: {italic: true}},
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
    var chart = new google.visualization.ColumnChart(document.getElementById('wind_piec_stawow'));
    chart.draw(data, options);
    }

    function drawChartWindMorskieOko() {
    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(<?=$json_wind_morskie_oko?>);
    var options = {
      // title: 'AKTUALNA TEMPERATURA [Â°C]',
      fontName: 'Calibri',
      curveType: 'function',
      // explorer: {}, // zoom chart!
      crosshair: { trigger: 'both' },
      // lineWidth: 5,
      // hAxis.gridlines.count: 5,
      // hAxis.textPosition: 'in',
      series: [{color: '#ff9900', visibleInLegend: true}],
      vAxis: { title: "średnia prędkość wiatru (m/s)", titleTextStyle: {italic: true}},
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
    var chart = new google.visualization.ColumnChart(document.getElementById('wind_morskie_oko'));
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
          // hAxis.textPosition: 'in',
          legend: {position: 'top', textStyle: {color: 'black', fontSize: 14}},
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

    function drawChartAvalanche() {
      var data = new google.visualization.DataTable(<?=$json_avalanche_level?>);
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
		{ calc: "stringify",
		  sourceColumn: 2,
                  type: "string",
                  role: "annotation" }
		]);

      var options = {
	      	//title: 'ZAGROŻENIE LAWINOWE',
		fontName: 'Calibri',
		colors: ['#4374E0'],
		tooltip: { isHtml: true },
		vAxis: { title: "stopień zagrożenia lawinowego", titleTextStyle: {italic: true}, ticks: [0,1,2,3,4,5] },
		legend: {position: 'top', textStyle: {color: 'black', fontSize: 14}}, width: "90%", height: 400 };

      var chart = new google.visualization.ColumnChart(document.getElementById('avalanche_level'));
      chart.draw(view, options);
    }


</script>
</head>
  <center>
  <h1>informacje pogodowe dla tatr</h1>
	<a href="">temperatura</a>
	<a href="wind.php">wiatr</a>
  </center>
<p>
  <div id="chart_div_temperature"></div>
  <br>
  <div id="pressure"></div>
  <br>
  <div id="chart_div_wind_averange"></div>
  <br>
  <div id="wind_goryczkowa"></div>
  <br>
  <div id="wind_piec_stawow"></div>
  <br>
  <div id="wind_morskie_oko"></div>
  <br>
  <div id="avalanche_level"></div>
</p>

<?php include('footer.html'); ?>
