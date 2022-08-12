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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;700&display=swap" rel="stylesheet">
      <link href="css/footer_header.css" rel="stylesheet" />
      <link href="css/meniu.css" rel="stylesheet" />
      <link href="css/style_desprenoi.css" rel="stylesheet" />
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
                  <a id = "despre_noi_tab" href="despre_noi.php">Despre noi</a>
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
         <div class="display_prim_art">
            <article class="art-first-dn">
               <h2>Facem ceea </h2>
               <h2 class = "titlu_sus">ce ne place, </h2>
               <h2 class="titlu_sus">spre mai bine</h2>
               <p class="p_n_responsive">Traim in domnia timpului si de aceea <br>ne-am pus drept scop sa-l dotam pe fiecare cu <br>posibilitatea de a putea ramane organizat si creativ.</p>
               <div class="p_ajutator">
                  <p>Traim in domnia timpului si de aceea ne-am pus drept scop sa-l dotam pe fiecare cu posibilitatea de a putea ramane organizat si creativ.</p>
               </div>
            </article>
            <aside>
               <img src="img/despre_noi_1.png" alt="despre_noi_1" width="100%" />
            </aside>
         </div>
         <article class="art-sec-dn">
            <h2>O echipa, un scop</h2>
            <p>
               Cineva codeaza, cineva scrie; cineva stapaneste timpul, cineva se lupta cu el. Pe toti ne uneste credinta profunda in arta managementului timpului, pasiunea de a construe un produs simplu si scopul de a ajuta pe toata
               lumea sa creasca productivitatea si sa se bucure de viata.
            </p>
            <p>
               Pretuim mult experienta utilizatorilor nostri si permanent suntem in cautarea unor functii inovative, pentru a face aplicatia si mai stabila si performanta. Utilizatorii e inima noastra si o sursa a energiei pentru
               cresterea aplicatiei noastre.
            </p>
            <img src="img/despre_noi_2.png" alt="despre_noi_2" width="86.1%" />
         </article>
      </section>
      <footer>
         <p>© 2021 Countdown</p>
      </footer>
   </body>
</html>
