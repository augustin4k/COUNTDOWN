<?php
  session_start();
  if(isset($_SESSION['user'])) {

    $disabled = "disabled = 'disabled' style = 'color: black;'";
    $mail_value = $_SESSION['user']['email'];
    $last_name_value = $_SESSION['user']['nume']." ";
    $first_name_value = $_SESSION['user']['prenume'];
  }
  else {
    $disabled = "";
    $mail_value = "";
    $last_name_value = "";
    $first_name_value = "";
  }
 ?>
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>Countdown</title>
      <link rel="icon" href="img/logo.png">
      <link href="css/style_contact.css" rel="stylesheet" />
      <link href="css/sign.css" rel="stylesheet" />
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
         <form class="form" action="http://localhost/COUNTDOWN/vendor/mail.php" method="post">
           <?php
           if(isset($_SESSION["message_succes"])){
              echo '<p class="msg" style = "border-color: green;font-size: 12px;">'.$_SESSION["message_succes"].'</p>';
              unset($_SESSION["message_succes"]);
            }
           if(isset($_SESSION["message_failed"])){
              echo '<p class="msg" style = "border-color: green;font-size: 12px;">'.$_SESSION["message_failed"].'</p>';
              unset($_SESSION["message_succes"]);
            }
            ?>
            <h2>Contacteaza-ne</h2>
            <p type="Name:">
              <input name = "full_name" type="hidden" placeholder="Write your name here.." value="<?php echo "$last_name_value"."$first_name_value" ?>"></input>
               <input <?php echo $disabled ?> name = "full_name" type="text" placeholder="Write your name here.." value="<?php echo "$last_name_value"."$first_name_value" ?>"></input>
            </p>
            <p type="Subject:">
               <input name = "subject" type = "text" placeholder="Write your subject name here.."></input>
            </p>
            <p type="Email:">
              <input name="email" type="hidden" placeholder="Let us know how to contact you back.." value = <?php echo "$mail_value" ?>></input>
               <input <?php echo $disabled ?> name = "email" type="email" placeholder="Let us know how to contact you back.." value = <?php echo "$mail_value" ?>></input>
            </p>
            <p type="Phone (with your region code):">
               <input name = "telefon" type="text" placeholder="Write your telephone number.."></input>
            </p>
            <p type="Message:">
               <input name = "message" type="text" placeholder="What would you like to tell us.."></input>
            </p>
            <button type="submit" name="send_mail">Send Message</button>
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
