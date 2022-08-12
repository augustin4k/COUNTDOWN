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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;700&display=swap" rel="stylesheet">
      <link rel="icon" href="img/logo.png" />
      <link href="css/meniu.css" rel="stylesheet" />
      <link href="css/style_index.css" rel="stylesheet" />
      <link href="css/footer_header.css" rel="stylesheet" />
      <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script type="text/javascript">
         function myFunction() {
           var x = document.getElementById("myLinks");
           if (x.style.display === "block") {
             x.style.display = "none";
           } else {
             x.style.display = "block";
           }
         }
      </script>
   </head>
   <body>
      <header>
         <nav class="topnav">
            <a class="logo display" href="index.php">
               <img src="img/logo.png" alt="app-logo" />
               <h1>Countdown</h1>
            </a>
            <ul id="myLinks" class="display">
               <li class="sign">
                  <a href="sign-up.php" >
                  <b>Sign up</b>
                  </a>
               </li>
               <li>
                  <a href="sign-in.php">Sign in</a>
               </li>
               <li>
                  <a href="despre_noi.php">Despre noi</a>
               </li>
               <li>
                  <a href="contact.php">Contact</a>
               </li>
            </ul>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
         </nav>
      </header>
      <section>
         <div class ="content">
            <div class = "partea_stanga">
               <article class="prim-art-home">
                  <h1>Stai organizat</h1>
                  <h1>Stai creativ</h1>
                  <a href="sign-up.php">
                  <button class="first_button" type="button" name="Incepem">Începe</button>
                  </a>
               </article>
               <div class="img_responsive">
                  <aside>
                     <img src="img/img-homepage.png" alt="img-homepage" width="100%" />
                  </aside>
               </div>
               <article class="doi-art-home">
                  <h2>Organizează orice în viața ta</h2>
                  <p>Indiferent dacă există o sarcină legată de muncă sau un obiectiv personal,
                     <b class="p_logo">Countdown</b> este aici pentru a vă ajuta să vă gestionați toate activitățile.
                  </p>
               </article>
            </div>
            <aside class="img_n_responsive">
               <img src="img/img-homepage.png" alt="img-homepage" width="100%" />
            </aside>
         </div>
      </section>
      <footer>
         <p>© 2021 Countdown</p>
      </footer>
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
