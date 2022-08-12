<?php
session_start();
include '../vendor/connection.php';

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

$timestamp = date('Y-m-d H:i:s');
$datetime = explode(" ", $timestamp);
$date_curent = $datetime[0];
$current_hour = $datetime[1];
?>

<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>Countdown</title>
      <link rel="icon" href="../img/logo.png">
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
      <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <link href="../css/includes/preloader.css" rel="stylesheet" />
      <link href="../css/cabinet-css/cabinet.css" rel="stylesheet" />
      <script src="../js/SubWindow.js"></script>
   </head>

   <body>
      <div id="TopNav" class="TopNavClass" action="cabinet.php" method="post">
         <header>
            <div class="logo_bar"  onclick="myFunction('sub_windows_user')">
              <?php
                echo "<img src="."'".$_SESSION['user']['avatar']."'"." alt='user' width='40px' height = '40px' style = 'border-radius: 50%;'/>";
               ?>
               <p><?php echo $_SESSION['user']["nume"]." ".$_SESSION['user']["prenume"]; ?></p>
            </div>
            <span></span>
            <div class="search_not_bar">
               <img onclick="myFunction('gsearch')" class="search" src="../img/cabinet/magnifying-glass.png" alt="search" width="20px"/>
            </div>
         </header>

         <!-- subferestre -->
         <?php
          $link_get = "../contact.php?email=".$_SESSION['user']['email'];
          ?>
         <div class="sub_windows_userClass" id="sub_windows_user">
            <div class="" onclick="window.open('settings.php','_top')">
               <p>Settings</p>
            </div>
            <div class="" onclick="window.open('../contact.php','_top')">
               <p>Contact</p>
            </div>
            <div class="" onclick="window.open('../vendor/logout.php','_top')">
               <p>Sign out</p>
            </div>
         </div>

         <!-- subferestre -->
         <div class="result_search">
           <input type="search" class = "gsearchClass" id="gsearch" placeholder="Search" name="gsearch">
           <div id="result" class = 'resultClass'>
           </div>
         </div>
        <style media="screen">
          .search {
            margin: 0;
            padding: 0;
          }
        </style>
         <?php
           $grupari = array('Inbox', 'Today', 'Next_7_Days', 'Add_Event', 'Completed', 'Trash');
          for ($i=0; $i < count($grupari); $i++) {
            if($i !== 3 && $i !== 0)
              echo "<button type = 'button' name = "."'".$grupari[$i]."' "."class='icon_for_group_info' id=" . $grupari[$i] . "  onclick=".'"'."ColorCategory("."'" . $grupari[$i] . "'". ")".'"'. "><img
              src='../img/cabinet/grupari_img/". $grupari[$i] . ".png' alt=" . $grupari[$i] . " width='20px'/> <p>" . str_replace('_', ' ', $grupari[$i]) . "<p/></button>";
            if($i === 0)
              echo "<button type = 'button' name = "."'".$grupari[$i]."' "."class='icon_for_group_info color' id=" . $grupari[$i] . "  onclick=".'"'."ColorCategory("."'" . $grupari[$i] . "'". ")".'"'. "><img
              src='../img/cabinet/grupari_img/". $grupari[$i] . ".png' alt=" . $grupari[$i] . " width='20px'/> <p>" . str_replace('_', ' ', $grupari[$i]) . "<p/></button>";
            elseif($i === 3) {
              echo "<button type = 'button' name = '$grupari[$i]' class='icon_for_group_info Add_Event' id=" . $grupari[$i] . "  onclick=".'"'."ColorCategory("."'" . $grupari[$i] . "'". "); myFunction('fereastra_detalii')".'"'. "><img
              src='../img/cabinet/grupari_img/". $grupari[$i] . ".png' alt=" . $grupari[$i] . " width='20px'/> <p>" .str_replace('_', ' ', $grupari[$i]) . "</p></button>";
            }
          }
        ?>

      </div>

      <section class="middle"  id = "addCategorie">
      </section>

      <section class="right" id="right">
         <img src="../img/cabinet/select.png" alt="select" width="150px"/>
         <h1>Da click pe un task pentru detalii</h1>
      </section>

      <aside class="fereastra_detaliiClass" id="fereastra_detalii">
      </aside>

      <div id="preloader_malc">
         <img src="../img/logo.png" alt="" width="120px">
         <h1>Countdown</h1>
         <div>
            Please wait, loading ...
         </div>
      </div>

      <script type="text/javascript">
         window.onload = function() {

           setTimeout(function() {

               document.getElementById("preloader_malc").style.display = "none";

         }, 200);
         };

      </script>
   </body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    data_curenta = '<?php echo $date_curent?>';
    ora = '<?php echo $current_hour?>';
    var criteriu  = "data_event>='"+data_curenta+"'+and+completat=0+and";
    $("#addCategorie").load('includes/middle_categorie.php?title=Inbox&criteriu='+criteriu);

    $('#Inbox').on('click', function() {
      data_curenta = '<?php echo $date_curent?>';
      criteriu  = "data_event>='"+data_curenta+"'+and+completat=0+and";
      $("#addCategorie").load('includes/middle_categorie.php?title=Inbox&criteriu='+criteriu);
    });

    $('#Today').on('click', function() {
      data_curenta = '<?php echo $date_curent?>';
      criteriu  = "data_event='"+ data_curenta + "'+and+completat=0+and";
      $("#addCategorie").load('includes/middle_categorie.php?title=Today&criteriu='+criteriu);
    });

    $('#Next_7_Days').on('click', function() {
      data_curenta = '<?php echo $date_curent?>';
      data_7_zile = '<?php echo date('Y-m-d', strtotime($date_curent. ' + 7 days'))?>';
      criteriu  = "data_event>='"+ data_curenta + "'+and+data_event<='"+data_7_zile+"'+and+completat=0+and";
      $("#addCategorie").load('includes/middle_categorie.php?title=Next_7_Days&criteriu='+criteriu);
    });

    $('#Completed').on('click', function() {
      criteriu  = "completat=1+and";
      $("#addCategorie").load('includes/middle_categorie.php?title=Completed&criteriu='+criteriu);
    });

    $('#Add_Event').on('click', function() {
      $(".event_name").parent().removeClass('focus');
      <?php
      if(!isset($_POST['order']))
              $order = ";";
      else $order = $_POST['order'];
      ?>
      $("#fereastra_detalii").load('includes/fereastra_dreapta.php?title=add&order='+"<?php echo $order?>"+'&Add=add');
    });

    $('#Trash').on('click', function() {
      criteriu  = "";
      $("#addCategorie").load('includes/middle_categorie.php?title=Trash&criteriu='+criteriu);
    });
    $('.icon_for_group_info').on('click', function() {
      if($(this).attr("id") === "Trash")
        $(".right").css("opacity", "0.5");
      else {
        $(".right").css("opacity", "1");
      }
    });

    $('.search').on('click', function() {
      var search_input = $("#gsearch").val();
      if(search_input.length != 0 & $('#gsearch').hasClass("activat")) {
        search_input = search_input.replace(" ", "+");
        $("#result").load('includes/search.php?nume_event='+search_input);
        $('#result').addClass("activat");
      }
    });

    $(document).on('keyup',function(evt) {
      if (evt.keyCode == 27) {
        $(".event_name").parent().removeClass('focus');
        $(".activat").removeClass("activat");
        $("#Add_Event").removeClass("color");
      }
    });

    $("input[type = 'search']").keyup(function() {
      var search_input = $("#gsearch").val();
      search_input = search_input.replace(" ", "+");
      $("#result").load('includes/search.php?nume_event='+search_input);
      $('#result').addClass("activat");
    });

    setInterval(function(){
      $.ajax({
          method: "post",
          url: '../vendor/24_7.php',
          data: {send_remind: "aminteste", update_date: "schimba"},
          success: function(data)
          {
            // alert(data);
          }
      });
    }, 10000);
  });
</script>
