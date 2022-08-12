<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Countdown</title>
    <link rel="icon" href="../img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="../css/cabinet-css/settings.css" rel="stylesheet" />
  </head>
  <body>
<?php
  session_start();
  include "../vendor/connection.php";

  if(!isset($_SESSION['user']))
    header("Location: ../sign-in.php");
  else {
    $result = mysqli_query($connect, "SELECT * FROM `user`
      where id_user = '".$_SESSION['user']['id']."';"
    );
    $row = mysqli_fetch_assoc($result);
    if($row['email'] !== $_SESSION['user']['email'])
      header("Location: ../vendor/logout.php");
  }

  $flag = 0;
  if(isset($_POST["salvare"])) {
    if(isset($_FILES["avatar"]) && strlen($_FILES['avatar']['name'])!==0) {
      $extensions = array(
                   "jpeg",
                   "jpg",
                   "png"
               );
      $tmp = explode('.', $_FILES['avatar']['name']);
      $file_ext = end($tmp);
      if (in_array($file_ext, $extensions) === false)
      {
         $_SESSION["message1"] = "Extensiile nu sunt permise. Se permit doar incarcarea fisierelor JPEG, JPG si PNG.";
      }
      else {

          $avatar = "../img/users_avatar/".time().$_FILES["avatar"]["name"];
          if($_SESSION['user']['avatar'] !== "../img/cabinet/user.png" )
            unlink($_SESSION['user']['avatar']);

          mysqli_query($connect, "UPDATE `user`
                        SET avatar = '$avatar'
                        WHERE id_user = ".$_SESSION['user']['id']);
          move_uploaded_file($_FILES['avatar']["tmp_name"], $avatar);
          $_SESSION['user']["avatar"] = $avatar;

          $flag = 1;
      }
    }
    if(!empty($_POST["email"]) && $_POST['email'] !== $_SESSION['user']['email']) {

      $email = htmlspecialchars($_POST['email']);
      $email = $connect -> real_escape_string($email);

      $query = "SELECT * FROM `user` where email = "."'".$email."'";
      $email_repeat = mysqli_query($connect, $query) or die("Eroare la conectarea cu baza");

      if(mysqli_num_rows($email_repeat) > 0)
      {
          $_SESSION['message2'] = "Utilizator cu asa email deja exista!";
      }
      else {

        $from='countdowncontactuab@gmail.com';
        $headersfrom='';
        $headersfrom .= 'MIME-Version: 1.0' . "\r\n";
        $headersfrom .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headersfrom .= 'From: '.$from.' '. "\r\n";

        $message = "<p>Hey! Salut <b>".$_SESSION['user']['prenume']."</b>!<br>Se pare ca recent ai avut o tentativa de a-ti schimba email-ul. Da click <a href='http://localhost/COUNTDOWN/vendor/mail.php?token=".$_SESSION['user']['token']."&email=".$email."'>AICI</a> pentru a finaliza acest lucru.</p>";
        $result = mail($_POST['email'], 'Schimb email COUNTDOWN', $message, $headersfrom);
        if(!$result) {
             echo "Error";
        } else {
            $_SESSION['message5'] = "Te rog confirma email-ul pentru a-l putea inregistra!";
        }
      }
    }
    if(!empty($_POST["first_name"]) && !empty($_POST["last_name"]))
    {
      $first_name = htmlspecialchars($_POST["first_name"]);
      $last_name = htmlspecialchars($_POST["last_name"]);

      if((strlen($first_name.$last_name)<5||strlen($first_name.$last_name)>25))
        $_SESSION['message3'] = "Lungime nume si prenume necorespunzatoare! (impreuna < de 5 caractere sau > de 25 caractere)";
      else {
        if($first_name !== $_SESSION['user']['prenume'] || $last_name !== $_SESSION['user']['nume']) {

          if(!empty($_POST["first_name"])) {

            $first_name = htmlspecialchars($_POST["first_name"]);
            $first_name = $connect -> real_escape_string($first_name);

            $sql = "UPDATE `user`
                    SET prenume = '$first_name'
                    WHERE id_user = ".$_SESSION['user']['id'];

            $connect->query($sql);
            $flag = 1;
            $_SESSION['user']['prenume'] = $first_name;
          }
          if(!empty($_POST["last_name"])) {

            $last_name = htmlspecialchars($_POST["last_name"]);
            $last_name = $connect -> real_escape_string($last_name);

            $sql = "UPDATE `user`
                    SET nume = '$last_name'
                    WHERE id_user = ".$_SESSION['user']['id'];

            $connect->query($sql);
            $_SESSION['user']['nume'] = $last_name;
            $flag = 1;
          }
        }
      }
    }
    else {
      $_SESSION['message4'] = "Nume sau prenume gol!";
    }
    if(!empty($_POST["password"])) {
      if(empty($_POST["re_password"])) {
        $_SESSION['message6'] = "Parola nu a fost salvata! Confirma parola!";
      }
      else {
        if($_POST["password"] === $_POST['re_password'] && $_POST['password']>=5) {
          $password = $_POST["password"];
          $password = password_hash($password, PASSWORD_DEFAULT);
          mysqli_query($connect, "UPDATE `user`
                                  SET parola = '$password'
                                  WHERE id_user = ".$_SESSION['user']['id']);
                                  $flag = 1;
                              }
        else if(($_POST['password']!==$_POST['re_password'])){
          $_SESSION["message6"] = "Parolele nu coincid!";
        }
        else if(strlen($_POST['password'])<5){
          $_SESSION["message6"] = "Parola mica! (< 5 caractere)";
        }
      }
    }

  }
  mysqli_close($connect);

  if($flag === 1) {
    $_SESSION["message"] = "Date salvate!";
  }

 ?>
    <header class="user__header">
       <div class="logo">
          <a href="cabinet.php">
           <img src="../img/logo.png" alt="app-logo" width="80px"/>
          </a>
       </div>
    </header>

    <form class="settings_form" action="settings.php" method="post" enctype="multipart/form-data"/>
      <?php
        if(isset($_SESSION["message"])) {
          echo '<p class="msg" style = "border-color: green;font-size: 12px;">'.$_SESSION["message"].'</p>';
        }
        if(isset($_SESSION["message1"])) {
          echo '<p class="msg" style = "border-color: red;font-size: 12px;">'.$_SESSION["message1"].'</p>';
        }
        if(isset($_SESSION["message2"])) {
          echo '<p class="msg" style = "border-color: red;font-size: 12px;">'.$_SESSION["message2"].'</p>';
        }
        if(isset($_SESSION["message3"])) {
          echo '<p class="msg" style = "border-color: red;font-size: 12px;">'.$_SESSION["message3"].'</p>';
        }
        if(isset($_SESSION["message4"])) {
          echo '<p class="msg" style = "border-color: red;font-size: 12px;">'.$_SESSION["message4"].'</p>';
        }
        if(isset($_SESSION["message5"])) {
          echo '<p class="msg" style = "border-color: orange;font-size: 12px;">'.$_SESSION["message5"].'</p>';
        }
        if(isset($_SESSION["message6"])) {
          echo '<p class="msg" style = "border-color: red;font-size: 12px;">'.$_SESSION["message6"].'</p>';
        }
        unset($_SESSION["message"]);
        unset($_SESSION["message1"]);
        unset($_SESSION["message2"]);
        unset($_SESSION["message3"]);
        unset($_SESSION["message4"]);
        unset($_SESSION["message5"]);
        unset($_SESSION["message6"]);
        unset($_POST);
       ?>
      <h1>Setari</h1>
      <div class="categorie_set fisier_set">
        <h2>Avatar</h2>
        <input type="file" name="avatar" />
      </div>
      <div class="categorie_set">
        <h2>Email</h2>
        <input type="email" name="email" value = <?php echo "'".$_SESSION['user']['email']."'";?> placeholder="Introdu noul email"/><br>
        <h2>Prenume & Nume</h2>
        <div class="categorie_password">
          <input type="text" name="first_name" value = <?php echo "'".$_SESSION['user']['prenume']."'"?> placeholder="Introdu noul prenume"/><br>
          <input type="text" name="last_name" value = <?php echo "'".$_SESSION['user']['nume']."'"?> placeholder = "Introdu noul nume"/><br>
        </div>
      </div>
      <div class="categorie_set categorie_password">
        <h2>Parola</h2>
        <input type="password" name="password" placeholder="Introdu parola noua"/><br>
        <input type="password" name="re_password" placeholder="Repeta parola noua"/><br>
      </div>
      <div class="button_settings">
        <button type="button"  class="back" onclick="window.open('cabinet.php','_top')"><b>Back</b></button>
        <button type="submit" class="save" name = "salvare"><b>Save</b></button>
      </div>
    </form>
  </body>
</html>

<script type="text/javascript">
if ( window.history.replaceState ) {

  window.history.replaceState( null, null, window.location.href );
}
</script>
<script type="text/javascript">
$(document).ready(function() {
  setInterval(function(){
    $.ajax({
      method: "post",
      url: 'http://localhost/COUNTDOWN/vendor/24_7.php',
      data: {send_remind: "aminteste", update_date: "schimba"},
      success: function(data)
      {
        // alert(data);
      }
    });
  }, 50000);
});
</script>
