<?php
   session_start();

   if(isset($_SESSION["user"])){
     header("Location: cabinet/cabinet.php");
   }
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>Countdown</title>
      <link rel="icon" href="img/logo.png">
      <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <link href="css/sign.css" rel="stylesheet" />
      <link href="css/style_request.css" rel="stylesheet" />
      <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   </head>
   <body>
      <div class="form_logo">
         <header class="user__header">
            <div class="logo">
               <a href="index.php">
               <img src="img/logo.png" alt="app-logo" width="80px"/>
               </a>
            </div>
         </header>
         <?php
            if(isset($_GET['token']) && isset($_GET['action'] )&& $_GET['action']==="request") {
                echo '
               <form class="form" action="vendor/auth.php?token='.$_GET['token'].'" method="post">
                  <h1 style="font-size: 20px; text-align:center; color: #666870">Confirma parola noua:</h1>
                  <div class="icon_la_logare">
                     <img src="img\sign\padlock.png" alt="email-logo" height="18px"/>
                     <input name="password" type="password" placeholder="Password"></input>
                  </div>
                  <div class="icon_la_logare">
                     <img src="img\sign\padlock.png" alt="email-logo" height="18px"/>
                     <input type="password" name="password_repeat" placeholder="Repeat password"></input>
                  </div>
                  <button type="submit" name = "request_password"><b>Confirm</b></button>
                  ';
                 }
                 else {
                   $mail = '';
                   if(isset($_SESSION['message_mail'])) {
                     $mail = $_SESSION['message_mail'];
                     unset($_SESSION['message_mail']);
                   }
                   echo '
                  <form class="form" action="vendor/mail.php" method="post">
                     <div class="icon_la_logare">
                        <img src="img\sign\email(1).png" alt="email-logo" height="18px"/>
                        <input type="email" name = "email_request" placeholder="Email" value = "'.$mail.'"></input>
                     </div>
                     <button type = "submit" name = "reset_password"><b>Reset</b></button>
                     <div class="under_button">
                        <a href="sign-in.php">
                           <p>Back to sign in</p>
                        </a>
                        <p class="p">|</p>
                        <a href="sign-up.php">
                           <p>Go to sign up</p>
                        </a>
                     </div>';
               }
               if(isset($_SESSION["message_succes"])){
                 echo '<p class="msg" style = "border-color: green;font-size: 12px;">'.$_SESSION["message_succes"].'</p>';
                 unset($_SESSION["message_succes"]);
               }
               if(isset($_SESSION["message_not_seriously"])){
                 echo '<p class="msg" style = "border-color: orange;font-size: 12px;">'.$_SESSION["message_not_seriously"].'</p>';
                 unset($_SESSION["message_succes"]);
               }
               if(isset($_SESSION["message_failed"])){
                 echo '<p class="msg" style = "border-color: red;font-size: 12px;">'.$_SESSION["message_failed"].'</p>';
                 unset($_SESSION["message_failed"]);
               }
               echo '
                  </form>
                  ';
                ?>
      </div>
   </body>
</html>
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
