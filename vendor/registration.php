<?php

  session_start();

  if(isset($_POST['registration'])) {

    include 'connection.php';
    $first_name = $last_name = $email = "";

    $first_name = htmlspecialchars($first_name.$_POST["first_name"]);
    $last_name = htmlspecialchars($last_name.$_POST["last_name"]);
    $email = htmlspecialchars($email.$_POST["email"]);

    $av_path = "../img/cabinet/user.png";
    $password = $_POST["password"];
    $password_confirm = $_POST["password_repeat"];
    $status = 0;
    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);

    $email = $connect -> real_escape_string($email);
    $query = "SELECT * FROM `user` where email = "."'".$email."'";
    $email_repeat = mysqli_query($connect, $query) or die("Eroare la conectarea cu baza");

    if(strlen($first_name) === 0  || strlen($last_name) === 0 || strlen($email) === 0 || empty($password) || empty($password_confirm))
    {
      $_SESSION['message_failed'] = "Unele campuri sunt goale!";
      header("Location: ../sign-up.php");
    }
    elseif(mysqli_num_rows($email_repeat) > 0)
    {
      $_SESSION['message_failed'] = "Utilizator cu asa email deja exista!";
      header("Location: ../sign-up.php");
    }
    elseif(strlen($password)<5)
    {
      $_SESSION['message_failed'] = "Parola prea mica!";
      header("Location: ../sign-up.php");
    }
    elseif($password !== $password_confirm)
    {
      $_SESSION['message_failed'] = "Parolele nu coincid!";
      header("Location: ../sign-up.php");
    }

    elseif(strlen($first_name.$last_name)<5||strlen($first_name.$last_name)>25)
    {
      $_SESSION['message_failed'] = "Lungime nume si prenume necorespunzatoare!";
      header("Location: ../sign-up.php");
    }
    else {

      $password = password_hash($password,  PASSWORD_DEFAULT);

      $first_name = $connect -> real_escape_string($first_name);
      $last_name = $connect -> real_escape_string($last_name);
      $email = $connect -> real_escape_string($email);

      mysqli_query($connect, "INSERT INTO `user` (`id_user`, `nume`, `prenume`, `avatar`, `email`, `parola`, `status`, `token`) VALUES (NULL, '$last_name', '$first_name', '$av_path', '$email', '$password', '$status', '$token')");
      $_SESSION['message_succes'] = "Inregistrarea a avut loc cu succes, nu uita sa confirmi email-ul!";

      $from='countdowncontactuab@gmail.com';
      $headersfrom='';
      $headersfrom .= 'MIME-Version: 1.0' . "\r\n";
      $headersfrom .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headersfrom .= 'From: '.$from.' '. "\r\n";
      $message = "<p>Hey! Salut <b>".$first_name."</b>!<br>Se pare ca recent te-ai inregistrat pe Countdown. Da click <a href='http://localhost/COUNTDOWN/vendor/mail.php?token=".$token."&action=reg'>AICI</a> pentru ati valida email-ul.</p>";
      $result = mail($email, 'Confirma email-ul pe COUNTDOWN', $message, $headersfrom);
      if(!$result) {
           echo "Error";
      } else {
          echo "Success";
      }

    mysqli_close($connect);
    header("Location: ../sign-in.php");
  }
}
else if(isset($_SESSION['user']))
  header("Location: ../cabinet/cabinet.php");
else if(!isset($_SESSION['user']))
  header("Location: ../sign-up.php");


 ?>
