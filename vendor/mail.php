<?php
include "connection.php";
session_start();

if(isset($_GET['token']) && isset($_GET['email'])) {

  session_destroy();
  session_start();

  $token = openssl_random_pseudo_bytes(16);
  $token = bin2hex($token);

  $_GET['token'] = $connect -> real_escape_string($_GET['token']);
  $result = mysqli_query($connect, "SELECT * FROM `user`
                                    where token = '".$_GET['token']."';"
  );

  if(mysqli_num_rows($result)!== 0) {

    $row = mysqli_fetch_assoc($result);

    $token = openssl_random_pseudo_bytes(16);
    $token = htmlspecialchars(bin2hex($token));

    $_GET['email'] = $connect -> real_escape_string($_GET['email']);
    $sql ="UPDATE `user`
      set email = '".$_GET['email']."', token = '".$token."'
      where id_user = '".$row['id_user']."'
      ;";

      if ($connect->query($sql) === TRUE) {
        echo "Record updated successfully";
        $_SESSION['message_succes'] = "Email setat cu succes!";
        header("Location: ../sign-in.php");
      } else {
        echo "Error updating record: " . $connect->error;
    }
  }
  else {
    $_SESSION['message_not_seriously'] = "Token neexistent!";
    header("Location: ../sign-in.php");
  }

}

else if(isset($_GET['token']) && isset($_GET['action'] )&& $_GET['action']==="request") {

  session_destroy();
  session_start();

  $_GET['token'] = $connect -> real_escape_string($_GET['token']);
  $result = mysqli_query($connect, "SELECT * FROM `user`
                      where token = '".$_GET['token']."'".";"
  );

  if(mysqli_num_rows($result) === 0) {

    $_SESSION['message_not_seriously'] = 'Token neexistent!';
    header("Location: ../request.php");
  }
  else {
    header("Location: ../request.php?token=".$_GET['token']."&action=request");
  }
}

else if(isset($_POST['email_request'])) {

  $_GET['email_request'] = $connect -> real_escape_string($_GET['email_request']);
  $result = mysqli_query($connect, "SELECT * FROM `user`
                      where email = '".$_POST['email_request']."'".";"
  );
  $connect->close();

  if(mysqli_num_rows($result) !== 0)
  {

    $row = mysqli_fetch_assoc($result);

    $from='countdowncontactuab@gmail.com';
    $headersfrom='';
    $headersfrom .= 'MIME-Version: 1.0' . "\r\n";
    $headersfrom .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headersfrom .= 'From: '.$from.' '. "\r\n";

    $message = "<p>Hey! Salut <b>".$row['prenume']."</b>!<br>Se pare ca recent ai avut o tentativa de ati recupera parola. Da click <a href='http://localhost/COUNTDOWN/vendor/mail.php?token=".$row['token']."&action=request'>AICI</a> pentru a finaliza acest lucru.</p>";
    $result = mail($row['email'], 'Resetare parola COUNTDOWN', $message, $headersfrom);
    if(!$result) {
         echo "Error";
    } else {
        echo "Success";
    }

    $_SESSION['message_succes'] = 'Verifica emailul pentru restabilire parola!';
    $_SESSION['message_mail'] = $row['email'];
    header("Location: ../request.php");
  }
  else {
    $_SESSION['message_failed'] = 'Utilizator cu asa email nu exista!';
    $_SESSION['message_mail'] = $_POST['email_request'];
    header("Location: ../request.php");
  }
}

else if(isset($_GET['token']) && isset($_GET['action'])&&$_GET['action']==="reg")
{
  session_destroy();
  session_start();
  $_GET['token'] = $connect -> real_escape_string($_GET['token']);
  $result = mysqli_query($connect, "SELECT * FROM `user`
                      where token = '".$_GET['token']."'".";"
  );

  if(mysqli_num_rows($result) !== 0)
  {

    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);

    $token = htmlspecialchars($token);
    $token = $connect -> real_escape_string($token);

    $row = mysqli_fetch_assoc($result);
    $sql ="UPDATE `user`
            set status = 1, token = '".$token."'
            where id_user = '".$row['id_user']."';";

    if ($connect->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $connect->error;
    }
    $connect->close();

    $_SESSION['message_succes'] = 'Utilizator inregistrat cu succes!';
    header("Location: ../sign-in.php");
  }
  else {
    $_SESSION['message_not_seriously'] = 'Token neexistent!';
    header("Location: ../sign-in.php");
  }
}

else if(isset($_POST['send_mail']))
{
  $from="countdowncontactuab@gmail.com";
  $headersfrom='';
  $headersfrom .= 'MIME-Version: 1.0' . "\r\n";
  $headersfrom .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headersfrom .= 'From: '.$from.' '. "\r\n";

  $message = "<p><b>Hey! Ma numesc ".$_POST['full_name'].". <br>Contactele mele: {<br>Telefon: ".$_POST['telefon']."<br>Email: ".$_POST['email']."<br>} <br><br>Mesajul subiectului este:</b><br>".$_POST['message']."</p>";
  $subject="Mesaj de la clienti! ".$_POST['subject'];
  $result = mail("countdowncontactuab@gmail.com", $subject, $message, $headersfrom);
  if(!$result) {
       echo "Error";
       $_SESSION['message_failed'] = 'Email netrimis!';
  } else {
      $_SESSION['message_succes'] = 'Email trimis cu succes!';
      echo "Success";
  }

  header("Location: ../contact.php");
}

else if(isset($_SESSION['user'])) {
  header("Location: ../cabinet/cabinet.php");
}
else if(!isset($_SESSION['user'])) {
  header("Location: ../index.php");
}
?>
