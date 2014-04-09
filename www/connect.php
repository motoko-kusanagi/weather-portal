<?php
  mysql_connect("localhost", "ruby", "github") or die("Error connecting to server");
  mysql_select_db("topr") or die("Error connecting to server");

  $date_last = date('Y-m-d', strtotime('-2 week'));
  $date_now = date('Y-m-d', strtotime('+1 day'));
?>
