<?php
  session_start();
  include "../../vendor/connection.php";
  if(!isset($_SESSION['user']))
    header("Location: ../sign-in.php");

  $timestamp = date('Y-m-d h:i:s');
  $datetime = explode(" ", $timestamp);
  $date_curent = $datetime[0];

  function redare_categorie($result) {
    while($RESULT = mysqli_fetch_assoc($result)) {

      $timestamp = date('Y-m-d H:i:s');
      $datetime = explode(" ", $timestamp);
      $date_curent = $datetime[0];
      $current_hour = $datetime[1];

      $days = ((strtotime($timestamp) - strtotime($RESULT['data_event'].' '.$RESULT['ora']))/60/60/24);
      $hours = $days*24;
      if($days>-1 && $days<1)
        $days = 0;
      $days = ceil($days);
      $completat = "";
      if($RESULT['completat'] === '1')
        $completat = $completat."checked = 'checked'";

      if($days>0)
        $overdue = " overdue";
      else {
        $overdue = "";
      }
      echo '<div class="check_info'.$overdue.'" style = "background: '.$RESULT['culoare'].';">
              <label class="container">
                <input type="checkbox" '.$completat.'>
                <span id="event-'.$RESULT['id_event'].'" class="checkmark"></span>
              </label>
              <div onclick = "myFunction('."'".'fereastra_detalii'."'".')" id="event-'.$RESULT['id_event'].'" class="event_name" >
                <p>'.$RESULT['titlu']."</p>
              </div>
              <div class='count_delete'>";
      if($days == 0) {
        if ($hours <= 0)
          echo "<p class = 'deadline' style = 'color:#6180df;'>Azi</p>";
        elseif($hours > 0) {
          echo "<p class = 'deadline' style = 'color:red;'>Azi</p>";
        }
      }
      elseif($hours>0) {
        echo "<p class = 'deadline' style = 'color:red;'>".abs($days)." zile in urma</p>";
      }
      elseif($hours < 0) {
        echo "<p style = 'color:#6180df;' class = 'deadline'>Peste ".abs($days)." zile</p>";
      }
      echo "<img src='../img/cabinet/remove.png' alt='remove' width='15px' class  = 'delete_event' id = '".$RESULT['id_event']."'/>
            </div>
          </div>";
    }
    return;
  }

  $_GET['title'] = str_replace("_", " ", $_GET['title']);
 ?>

<header>
   <div class="header_left">
      <h1 class = 'inbox_cat'><?php echo $_GET['title'];?></h1>
      <a href="javascript:void(0);" class="icon" id = "icon_" onclick="myFunction('TopNav')">
         <i class="fa fa-bars"></i>
      </a>
   </div>
   <img class="sort_img" onclick="myFunction('sub_windows_sort')" src="../img/cabinet/sort-down.png" alt="sortare" width="20px"/>
   <div class="sub_windows_sortClass" id="sub_windows_sort">
      <div class="sort" id = "sort_time">
         <img width="20px" src="../img/cabinet/sort_by_time0.png" alt="sort_by_time">
         <p>By Time</p>
      </div>
      <div class="sort" id = "sort_title">
         <img width="20px" src="../img/cabinet/sort_by_alpha0.png" alt="sort_by_alpha">
         <p>By Title</p>
      </div>
   </div>
</header>

<div class="categorie inbox_cat">

<?php
$criteriu_sort = $_GET['criteriu'];
$criteriu_sort = str_replace("+", " ", $criteriu_sort);

if(!isset($_GET['order']))
  $order = ';';
else
{
  $order = $_GET["order"];
  $order = str_replace("+", " ", $order);
}

$result = mysqli_query($connect, "SELECT * FROM `evenimente`
                      where ".$criteriu_sort." id_user = ".$_SESSION['user']['id'].
                      $order
                    );
if($_GET['title'] === 'Trash') {
  echo "
  <style media='screen'>
  .check_info {
    opacity: 0.6;
  }
  </style>
  ";
  $result = mysqli_query($connect, "SELECT * FROM `backup_evenimente`
    where ".$criteriu_sort." id_user = ".$_SESSION['user']['id'].
    $order
  );
}

if($_GET['title'] === 'Inbox') {
  echo "
  <style media='screen'>
  .overdue {
    opacity: 0.6;
  }
  </style>
  ";
  $overdue = mysqli_query($connect, "SELECT * FROM `evenimente`
                            where data_event<'$date_curent' and id_user = ".$_SESSION['user']['id']."
                            and completat = 0".$order
                          );
}

if($_GET['title'] !== 'Inbox')
  if(mysqli_num_rows($result) == 0)
  {

    echo '<div class = "middle_empty">
            <img src="../img/cabinet/empty-box.png" alt="empty_categorie" width="120px"/>
            <h1>Nu sunt task-uri...</h1>
          </div>';
  }

  else {
    redare_categorie($result);
  }

elseif($_GET['title'] === 'Inbox'){

  if(mysqli_num_rows($result) == 0 && mysqli_num_rows($overdue) == 0)
  {

    echo '<div class = "middle_empty">
    <img src="../img/cabinet/empty-box.png" alt="empty_categorie" width="120px"/>
    <h1>Nu sunt task-uri...</h1>
    </div>';
  }
  else {

    redare_categorie($result);

    if(mysqli_num_rows($overdue) != 0) {

      echo '<h2>Overdue</h2>';

      redare_categorie($overdue);
    }
  }
}
?>

<script type="text/javascript">
$(document).ready(function() {
  if($("#TopNav").hasClass("activat")&& $("#icon_").hasClass("activat")===false)
    $("#icon_").addClass("activat");

  $('.checkmark').on('click', function() {
    $("#fereastra_detalii").removeClass("activat");
    var id_event = $(this).attr("id");
    id_event = id_event.replace("event-", "");

    if($('#Trash').hasClass("color")===false) {

      <?php if($_GET['title'] == "Completed")
              $completed=0;
            else {
              $completed=1;
            }
      ?>
      var completed = <?php echo $completed;?>;
      $.ajax({
        type: "POST",
        url: "includes/update_event.php",
        data: {completat: completed, id_event: id_event, modifica: "modifica"},
        success: function(response) {
          // alert(response);
            <?php
              $_GET['title'] = str_replace(" ", "_", $_GET['title']);
              $_GET['criteriu'] = str_replace(" ", "+", $_GET['criteriu']);
              $order = str_replace(" ", "+", $order);
            ?>
            $("#addCategorie").load('includes/middle_categorie.php?order='+"<?php echo $order;?>"+'&title='+"<?php echo $_GET['title']?>"+'&criteriu='+"<?php echo $_GET['criteriu']?>");
          }
        });
      }
      else {
        $.ajax({
          type: "POST",
          url: "includes/update_event.php",
          data: {id_event: id_event, modifica: "restaurare"},
          success: function(response) {
            // alert(response);
            <?php
            $_GET['title'] = str_replace(" ", "_", $_GET['title']);
            $_GET['criteriu'] = str_replace(" ", "+", $_GET['criteriu']);
            $order = str_replace(" ", "+", $order);
            ?>
            $("#addCategorie").load('includes/middle_categorie.php?order='+"<?php echo $order;?>"+'&title='+"<?php echo $_GET['title']?>"+'&criteriu='+"<?php echo $_GET['criteriu']?>");
          }
        });
      }
    });

  $('.delete_event').on('click', function() {
    var id_event = $(this).attr("id");
    id_event=id_event.replace("event-", "")

    if($('#Trash').hasClass("color") === false) {
      $.ajax({
        type: "POST",
        url: "includes/update_event.php",
        data: {id_event: id_event, modifica: "sterge_backup"},
        success: function() {
          // alert(response);
          <?php
            $_GET['title'] = str_replace(" ", "_", $_GET['title']);
            $_GET['criteriu'] = str_replace(" ", "+", $_GET['criteriu']);
            $order = str_replace(" ", "+", $order);
          ?>
          $("#addCategorie").load('includes/middle_categorie.php?order='+"<?php echo $order;?>"+'&title='+"<?php echo $_GET['title']?>"+'&criteriu='+"<?php echo $_GET['criteriu']?>");
        }
      });
    }
    else {
      $.ajax({
        type: "POST",
        url: "includes/update_event.php",
        data: {id_event: id_event, modifica: "stergere_complet"},
        success: function() {
          // alert(response);
          <?php
          $_GET['title'] = str_replace(" ", "_", $_GET['title']);
          $_GET['criteriu'] = str_replace(" ", "+", $_GET['criteriu']);
          $order = str_replace(" ", "+", $order);
          ?>
          $("#addCategorie").load('includes/middle_categorie.php?order='+"<?php echo $order;?>"+'&title='+"<?php echo $_GET['title']?>"+'&criteriu='+"<?php echo $_GET['criteriu']?>");
        }
      });
    }
  });

  $('body').click(function(){
    if($("#fereastra_detalii").hasClass("activat")===false)
      $('.event_name').parent().removeClass('focus');
  });
  $('.event_name').on('click', function() {
    if($("#Add_Event").hasClass("color") === false) {
      $('.event_name').parent().removeClass('focus');
      if($("#Trash").hasClass("color") === false){
        $(this).parent().addClass('focus');
        click = 0;
        var id_eveniment = $(this).attr('id');
        $("#fereastra_detalii").load('includes/fereastra_dreapta.php?order='+"<?php echo $order;?>"+'&id_event='+id_eveniment);
      }
      else
        $("#fereastra_detalii").removeClass("activat");
    }
  });

  $('.sort').on('click', function() {
    var sortare = $(this).attr('id');
    if(sortare.includes("sort_title")) {
      var order = "+order+by+titlu+ASC;";
    }
    else if(sortare == "sort_time") {
      var order = "+order+by+data_event+ASC,+ora+ASC;";
    }
    <?php
      $_GET['title'] = str_replace(" ", "_", $_GET['title']);
      $_GET['criteriu'] = str_replace(" ", "+", $_GET['criteriu']);
    ?>
    $("#addCategorie").load('includes/middle_categorie.php?title='+"<?php echo $_GET['title']?>"+'&criteriu='+"<?php echo $_GET['criteriu']?>"+'&order='+order);
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
});
</script>
