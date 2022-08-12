<?php
  $timestamp = date('Y-m-d H:i:s');
  $datetime = explode(" ", $timestamp);
  $date_curent = $datetime[0];
  $current_hour = $datetime[1];

  $days = ((strtotime($date_curent) - strtotime($_GET['data'].' '.$_GET['ora']))/60/60/24);
  $hours = $days*24;
  if($days>-1 && $days<1)
    $days = 0;
  $days = ceil($days);

  if($days == 0 && $hours < 0) {
    echo "Azi; ".date('d F Y', strtotime($_GET['data']))."; <br>Ora: ".$_GET['ora'];
  }
  else if($days == 0 && $hours >= 0) {
    echo "Azi; ".date('d F Y', strtotime($_GET['data']))."; <br>Ora: ".$_GET['ora'];
  }
  else if($hours > 0) {
    echo abs($days)." zile in urma; ".date('d F Y', strtotime($_GET['data'])).";<br>Ora: ".$_GET['ora'];
  }
  else if($hours < 0 ) {
    echo "Peste ".abs($days)." zile; ".date('d F Y', strtotime($_GET['data']))."; <br>Ora: ".$_GET['ora'];
  }

 ?>
