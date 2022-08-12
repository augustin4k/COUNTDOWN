<?php
  session_start();
  include 'connection.php';
  // Request password
  if(isset($_POST['request_password']))
  {
    $password = $_POST["password"];
    $password_confirm = $_POST["password_repeat"];

    if(strlen($password)<5)
    {
      $_SESSION['message_failed'] = "Parola prea mica! (< 5 caractere)";
      header("Location: ../request.php?token=".$_GET['token']."&action=request");
    }
    elseif($password !== $password_confirm)
    {
      $_SESSION['message_failed'] = "Parolele nu coincid!";
      header("Location: ../request.php?token=".$_GET['token']."&action=request");
    }
    else
    {
      $_GET['token'] = $connect -> real_escape_string($_GET['token']);
      $result = mysqli_query($connect, "SELECT * FROM `user`
                                        where token = '".$_GET['token']."';"
      );

      $row = mysqli_fetch_assoc($result);

      $password = password_hash($password,  PASSWORD_DEFAULT);
      $token = openssl_random_pseudo_bytes(16);
      $token = bin2hex($token);

      $sql ="UPDATE `user`
        set parola = '".$password."', token = '".$token."',
        status = 1
        where id_user = '".$row['id_user']."'
        ;";

      if ($connect->query($sql) === TRUE) {
        echo "Record updated successfully";
      } else {
        echo "Error updating record: " . $connect->error;
      }

      $_SESSION["message_succes"] = "Parola actualizata!";
      header("Location: ../sign-in.php");

    }
  }
  // Login
  else {

    if(empty($_POST['email']) || empty($_POST['password'])) {
      $_SESSION["message_failed"] = "Campuri goale!";
      header("Location: ../sign-in.php");
    }
    else {

      $email = $_POST['email'];
      $email = htmlspecialchars($email);
      $password = $_POST['password'];

      $email = $connect -> real_escape_string($email);
      $check_user = mysqli_query($connect, "SELECT * FROM `user` WHERE email = '$email'");

      $user = mysqli_fetch_assoc($check_user);
      $bool = password_verify($password, $user["parola"]);

      if(mysqli_num_rows($check_user) > 0 && $user["status"] === "1" && $bool) {

        $_SESSION['user'] = [
          "id" => $user['id_user'],
          "nume" => $user['nume'],
          "avatar" => $user['avatar'],
          "prenume" => $user['prenume'],
          "email" => $user['email'],
          "id_event" => $user['id_event'],
          "token" => $user['token']
        ];

        $_SESSION['auth'] = "Autentificat!";
        header("Location: ../cabinet/cabinet.php");
      }
      elseif(mysqli_num_rows($check_user) === 0) {
        $_SESSION["message_failed"] = "Utilizator cu asa login nu exista!";
        header("Location: ../sign-in.php");
      }
      elseif($bool === False) {
        $_SESSION["message_failed"] = "Parola incorecta!";
        header("Location: ../sign-in.php");
      }

      elseif($user["status"] === "0") {
        $_SESSION["message_not_seriously"] = "Utilizator neactiv! Te rog verifica email-ul!";
        header("Location: ../sign-in.php");
      }
    }
  }
  mysqli_close($connect);
 ?>
