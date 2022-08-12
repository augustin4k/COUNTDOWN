<?php
  session_start();

  if(isset($_SESSION['user'])) {
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
      <link href="css/style_sign-in.css" rel="stylesheet" />
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
         <form class="form" action="vendor/auth.php" method="post">
            <div class="icon_la_logare">
               <img src="img\sign\profile-user.png" alt="email-logo" height="18px"/>
               <input name="email" type="email" placeholder="Email"></input>
            </div>
            <div class="icon_la_logare">
               <img src="img\sign\padlock.png" alt="password-logo" height="18px"/>
               <input name="password" type="password" placeholder="Password"></input>
            </div>
            <button type="submit">
              <b>Sign in</b>
            </button>
            <p><a href='request.php'>Forgot password?</a></p>
            <p>Nu ai account? - <a href='sign-up.php'>Inregistreaza-te</a></p>
             <?php
             if(isset($_SESSION["message_succes"])){
                echo '<p class="msg" style = "border-color: green;font-size: 12px;">'.$_SESSION["message_succes"].'</p>';
                unset($_SESSION["message_succes"]);
              }
              elseif(isset($_SESSION['message_failed'])) {
                echo '<p class="msg" style = "border-color: red;font-size: 12px">'.$_SESSION["message_failed"].'</p>';
                unset($_SESSION["message_failed"]);
              }
              elseif(isset($_SESSION['message_not_seriously'])) {
                echo '<p class="msg" style = "border-color:  orange;font-size: 12px">'.$_SESSION["message_not_seriously"].'</p>';
                unset($_SESSION["message_not_seriously"]);
              }
             ?>
         </form>
      </div>
   </body>
</html>
<script type="text/javascript">
$(document).ready(function() {
  setInterval(function(){
    $.ajax({
      method: "post",
      url: 'vendor/24_7.php',
      data: {send_remind: "aminteste", update_date: "schimba"},
      success: function(data)
      {
        // alert(data);
      }
    });
  }, 50000);
});
</script>
