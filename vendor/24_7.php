<?php

  session_start();

  if(!isset($_POST['send_remind']) && !isset($_POST['update_date']))
    if(!isset($_SESSION['user']))
      header('Location: ../index.php');
    else {
      header('Location: ../cabinet/cabinet.php');
    }

  if(isset($_POST['send_remind'])) {

    include "connection.php";
    $timestamp = date('Y-m-d H:i:s');
    $datetime = explode(" ", $timestamp);
    $date_curent = $datetime[0];
    $current_hour = $datetime[1];

    $sql = "SELECT * FROM evenimente join user on user.id_user = evenimente.id_user where seen != 1 and data_event>='".$date_curent."' and ora >='".$current_hour."';";

    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result) > 0) {
    {
      while($row = mysqli_fetch_assoc($result))
      {

          $minutes = ((strtotime($row['data_event'].' '.$row['ora'])-strtotime($timestamp))/60);
          // echo $minutes;
          if($minutes <= 5 && $row['seen'] !== 1)
          {
            $sql1 ="UPDATE `evenimente`
                  set seen = 1
                  where id_event = ".$row['id_event'].";";
            $connect->query($sql1);

            $from='countdowncontactuab@gmail.com';
            $headersfrom='';
            $headersfrom .= 'MIME-Version: 1.0' . "\r\n";
            $headersfrom .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headersfrom .= 'From: '.$from.' '. "\r\n";
            $message = "<p>Hey! Salut <b>".$row['prenume']."</b>!<br>Ai un task de realizat peste cca 5 minute cu urmatoarele datalii:<br><b>Titlul:</b> ".$row['titlu']."<br><b>Descriere:</b><br>".$row['descriere']."<br><b>Ora: </b>".$row['ora']."</p>";
            $result = mail($row['email'], 'Task in asteptare!', $message, $headersfrom);
            if(!$result) {
                 echo "Error";
            } else {
                echo "Success";
            }
          }
        }
      }
    }
    $connect->close();
  }
  if (isset($_POST['update_date']))
  {
    include "connection.php";

    $sql = "SELECT * FROM evenimente;";

    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result) !== 0)
    {
      while($row = mysqli_fetch_assoc($result))
      {

        if(((strtotime($timestamp) - strtotime($row['data_event'].' '.$row['ora']))) > 0)
        {
          if($row['tip_repetare'] === "Zilnic") {

            $date = new DateTime($row['data_event']);
            $date->modify('+'.$row["cantitate_repetare"].' days');
            $data_noua = $date->format('Y-m-d');

            $sql1 ="UPDATE `evenimente`
                  set data_event = '".$data_noua."'
                  where id_event = ".$row['id_event'].";";
            $connect->query($sql1);
          }
          if($row['tip_repetare'] === "Saptamanal") {

            $date = new DateTime($row['data_event']);
            $date->modify('+'.$row["cantitate_repetare"].' weeks');
            $data_noua = $date->format('Y-m-d');

            $sql1 ="UPDATE `evenimente`
            set data_event = '".$data_noua."'
            where id_event = ".$row['id_event'].";";
            $connect->query($sql1);
          }
          if($row['tip_repetare'] === "Lunar") {

            $date = new DateTime($row['data_event']);
            $date->modify('+'.$row["cantitate_repetare"].' months');
            $data_noua = $date->format('Y-m-d');

            $sql1 ="UPDATE `evenimente`
            set data_event = '".$data_noua."'
            where id_event = ".$row['id_event'].";";
            $connect->query($sql1);
          }
          if($row['tip_repetare'] === "Anual") {

            $date = new DateTime($row['data_event']);
            $date->modify('+'.$row["cantitate_repetare"].' years');
            $data_noua = $date->format('Y-m-d');
            $sql1 ="UPDATE `evenimente`
            set data_event = '".$data_noua."'
            where id_event = ".$row['id_event'].";";
            $connect->query($sql1);
          }
        }
      }
    }
    $connect->close();
  }
 ?>
