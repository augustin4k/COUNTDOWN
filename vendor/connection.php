<?php

  $connect =mysqli_connect("localhost", "root", "", "countdown_db");

  if(!$connect) {
    die("Eroare la conectarea cu baza de date!");
  }
 ?>
