<?php
  session_start();
  include "../../vendor/connection.php";

  if(isset($_POST['modifica']) && ($_POST['modifica'])==="modifica") {

    if(isset($_POST['completat'])) {
      if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
      }

      $_POST['completat'] = $connect -> real_escape_string($_POST['completat']);
      $sql ="UPDATE `evenimente`
            set completat = ".$_POST['completat'].", seen = ".$_POST['completat']."
            where id_event = ".$_POST['id_event']." and id_user = ".$_SESSION['user']['id'].";";

      if ($connect->query($sql) === TRUE) {
        echo "Record updated successfully";
      } else {
        echo "Error updating record: " . $connect->error;
      }

      $connect->close();

    }
    else {
      if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
      }

      if(strlen($_POST['titlu_event']) === 0)
      {

        $result = mysqli_query($connect, "SELECT * FROM `evenimente`
                              where id_user = ".$_SESSION['user']['id']
                            );
        $count = mysqli_num_rows ( $result );
        $_POST['titlu_event'] = "Event ".$count;
      }

      $_POST['titlu_event'] = htmlspecialchars($_POST['titlu_event']);
      $_POST['descriere_event'] = htmlspecialchars($_POST['descriere_event']);
      $_POST['completat1'] = htmlspecialchars($_POST['completat1']);
      $_POST['cantitate_repeat'] = htmlspecialchars($_POST['cantitate_repeat']);
      $_POST['culoare'] = htmlspecialchars($_POST['culoare']);
      $_POST['titlu_event'] = $connect -> real_escape_string($_POST['titlu_event']);
      $_POST['descriere_event'] = $connect -> real_escape_string($_POST['descriere_event']);
      $_POST['completat1'] = $connect -> real_escape_string($_POST['completat1']);
      $_POST['cantitate_repeat'] = $connect -> real_escape_string($_POST['cantitate_repeat']);
      $_POST['culoare'] = $connect -> real_escape_string($_POST['culoare']);

      $sql ="UPDATE `evenimente`
        set titlu = "."'".$_POST['titlu_event']."'".", descriere = "."'".$_POST['descriere_event']."'".", data_event = "."'".$_POST['data_event']."'".",
        ora = "."'".$_POST['time']."'".", tip_repetare = "."'".$_POST['tip_repeat']."'".", culoare = "."'".$_POST['culoare']."'".", cantitate_repetare = ".$_POST['cantitate_repeat'].", completat = '".$_POST['completat1']."'
        , seen = 0 where id_event = ".$_POST['id_event']." and id_user = ".$_SESSION['user']['id'].";";

      if ($connect->query($sql) === TRUE) {
        echo "gasit";
        echo "Record updated successfully";
      } else {
        echo "Error updating record: " . $connect->error;
      }

      $connect->close();
    }
  }
  else if(isset($_POST['modifica']) && $_POST['modifica']=== "add") {

    if(strlen($_POST['titlu_event']) === 0)
    {

      $result = mysqli_query($connect, "SELECT * FROM `evenimente`
                            where id_user = ".$_SESSION['user']['id']
                          );
      $count = mysqli_num_rows ( $result )+1;
      $_POST['titlu_event'] = "Event ".$count;
    }

    $_POST['titlu_event'] = htmlspecialchars($_POST['titlu_event']);
    $_POST['descriere_event'] = htmlspecialchars($_POST['descriere_event']);
    $_POST['completat'] = htmlspecialchars($_POST['completat']);
    $_POST['cantitate_repeat'] = htmlspecialchars($_POST['cantitate_repeat']);
    $_POST['titlu_event'] = $connect -> real_escape_string($_POST['titlu_event']);
    $_POST['descriere_event'] = $connect -> real_escape_string($_POST['descriere_event']);
    $_POST['completat'] = $connect -> real_escape_string($_POST['completat']);
    $_POST['cantitate_repeat'] = $connect -> real_escape_string($_POST['cantitate_repeat']);

    $sql ="INSERT INTO `evenimente` (`id_event`, `titlu`, `descriere`, `data_event`, `ora`,
            `tip_repetare`, `cantitate_repetare`, `culoare`, `id_user`, `completat`, `seen`)
            VALUES (NULL, '".$_POST['titlu_event']."', '".$_POST['descriere_event']."', '".$_POST['data_event']."', '".$_POST['time']."', '".$_POST['tip_repeat']."', '".$_POST['cantitate_repeat']."'
              , '".$_POST['culoare']."', '".$_SESSION['user']['id']."', '".$_POST['completat']."' , '0')";

    if ($connect->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $connect->error;
    }

    $connect->close();
  }

  else if(isset($_POST['modifica']) && $_POST['modifica'] === "sterge_backup") {

    $sql ="DELETE FROM evenimente where id_event = ".$_POST['id_event']." and id_user = ".$_SESSION['user']['id'].";";
    if ($connect->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $connect->error;
    }

    $connect->close();
  }

  else if (isset($_POST['modifica']) && $_POST['modifica'] === "restaurare" ) {

    $result = mysqli_query($connect, "SELECT * FROM `backup_evenimente`
                          where id_event = ".$_POST['id_event']." and id_user = ".$_SESSION['user']['id']
                        );

    $row = mysqli_fetch_assoc($result);

    $row['titlu_event'] = htmlspecialchars($row['titlu_event']);
    $row['descriere_event'] = htmlspecialchars($row['descriere_event']);
    $row['titlu_event'] = $connect -> real_escape_string($row['titlu_event']);
    $row['descriere_event'] = $connect -> real_escape_string($row['descriere_event']);

    $sql ="INSERT INTO `evenimente` (`id_event`, `titlu`, `descriere`, `data_event`, `ora`,
            `tip_repetare`, `cantitate_repetare`, `culoare`, `id_user`, `completat`, `seen`)
            VALUES (NULL, '".$row['titlu']."', '".$row['descriere']."', '".$row['data_event']."', '".$row['ora']."',
              '".$row['tip_repetare']."', '".$row['cantitate_repetare']."'
              , '".$row['culoare']."', '".$_SESSION['user']['id']."', '0', '0')";

    mysqli_query($connect, "delete FROM `backup_evenimente`
      where id_event = ".$_POST['id_event']." and id_user = ".$_SESSION['user']['id']
    );

    if ($connect->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $connect->error;
    }
    $connect->close();

  }

  else if (isset($_POST['modifica']) && $_POST['modifica'] === "stergere_complet" ) {

    mysqli_query($connect, "delete FROM `backup_evenimente`
                          where id_event = ".$_POST['id_event']." and id_user = ".$_SESSION['user']['id']
                        );

    if ($connect->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $connect->error;
    }
    $connect->close();
  }
 ?>
