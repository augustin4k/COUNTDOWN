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
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;700&display=swap" rel="stylesheet">
      <link href="css/sign.css" rel="stylesheet" />
      <link href="css/style_sign-in.css" rel="stylesheet" />
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

         <form action="vendor/registration.php" class="form" method="post">
            <h2>First time here?</h2>
            <p class = "under_title"><b>Sign up for Countdown</b></p>
            <div class="icon_la_logare">
               <img src="img\sign\id-card.png" alt="email-logo" height="18px"/>
               <input name="first_name" type="text" placeholder="Your first name"></input>
            </div>
            <div class="icon_la_logare">
               <img src="img\sign\id-card.png" alt="email-logo" height="18px"/>
               <input name="last_name" type="text" placeholder="Your last name"></input>
            </div>
            <div class="icon_la_logare">
               <img src="img\sign\email(1).png" alt="email-logo" height="18px"/>
               <input name="email" type="email" placeholder="Email"></input>
            </div>
            <div class="icon_la_logare">
               <img src="img\sign\padlock.png" alt="email-logo" height="18px"/>
               <input name="password" type="password" placeholder="Password"></input>
            </div>
            <div class="icon_la_logare">
               <img src="img\sign\padlock.png" alt="email-logo" height="18px"/>
               <input type="password" name="password_repeat" placeholder="Repeat password"></input>
            </div>
            <button type="submit" name = "registration"><b>Start</b></button>
            <p>Ai deja account? - <a href="sign-in.php">Intra</a></p>
            <?php
            if(isset($_SESSION["message_failed"])){
              echo '<p class="msg" style = "border-color: red;">'.$_SESSION["message_failed"].'</p>';
              unset($_SESSION["message_failed"]);
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
