<?php
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
  $json_wind_goryczkowa = json_encode($table);

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
  $json_wind_piec_stawow = json_encode($table);

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
  $json_wind_morskie_oko = json_encode($table);
?>
