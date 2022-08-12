<?php
session_start();

if(!isset($_SESSION['user']))
  header("Location: ../sign-in.php");


else if(isset($_GET['nume_event'])) {

    $timestamp = date('Y-m-d H:i:s');
    $datetime = explode(" ", $timestamp);
    $date_curent = $datetime[0];
    $_GET['nume_event'] = str_replace("+", " ", $_GET['nume_event']);

    include "../../vendor/connection.php";

    $_GET['nume_event'] = $connect -> real_escape_string($_GET['nume_event']);
    $sql = "SELECT * FROM evenimente where (titlu  like '%".$_GET['nume_event']."%' or descriere like '%".$_GET['nume_event']."%') and LENGTH('".$_GET['nume_event']."') != 0 and id_user = '".$_SESSION['user']['id']."';";

    $result = $connect->query($sql);
    if(mysqli_num_rows($result) != 0) {
      echo "<div class='cautare'>";
      while($row = $result->fetch_assoc()) {
        $days = ((strtotime($timestamp) - strtotime($row['data_event'].' '.$row['ora']))/60/60/24);
        $hours = $days*24;
        if($days>-1 && $days<1)
          $days = 0;
        $days = ceil($days);
        echo "
        <div style = 'background: ".$row['culoare']."' class = 'resultat_cautare'>
            <p onclick = ".'"'."myFunction('fereastra_detalii')".'"'." style = 'cursor: pointer;' class = 'event_cautat' id = 'event-".$row['id_event']."'>".$row['titlu']."</p>";
            if($days == 0) {
              if($hours < 0)
                echo "<p style = 'color:#6180df;' class = 'data_event'>Azi</p>";
              else {
                echo "<p style = 'color:red;' class = 'data_event'>Azi</p>";
              }
            }
            else if($hours > 0) {
              echo "<p style = 'color:red;' class = 'data_event'>".abs($days)." zile in urma</p>";
            }
            else if($hours < 0) {
              echo "<p style = 'color:#6180df;' class = 'data_event'>Peste ".abs($days)." zile</p>";
            }
        echo "</div>";
       }
        echo "</div>";
      }
      else {
        echo '<div class="not_found cautare">
                <p>Nu au fost gasite task-uri</p>
              </div>';
      }
   }
   else if(isset($_SESSION['user']))
    header("Location: ../cabinet.php");
?>

<script type="text/javascript">
$(document).ready(function() {

  $('.event_cautat').on('click', function() {
    console.log($('#fereastra_detalii').attr('class'));
    var id_eveniment = $(this).attr('id');
    console.log(id_eveniment);
    <?php $order = ";" ?>
    $("#fereastra_detalii").load('includes/fereastra_dreapta.php?order='+"<?php echo $order;?>"+'&id_event='+id_eveniment);
    $('#result').addClass("activat");
    $('#gsearch').addClass("activat");
  });

  $('body').on('click', function() {
    if($("#TopNav").hasClass("activat")&& $("#icon_").hasClass("activat")===false)
      $("#icon_").addClass("activat");
  });
});
</script>


<style media="screen">

  .result_search {
    display: flex;
    flex-direction: column;
  }

  #result {
    display: none;
  }

  #result.activat {
    display: block;
  }

  .cautare p{
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
    width: 107.5px;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .data_event {
    text-align: right;
  }

  .resultat_cautare {
    display: flex;
    flex-direction: column;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    overflow: hidden;
    margin: 0;
    padding: 0 10px;
  }

  .cautare {
    overflow: hidden;
    overflow-y: scroll;
    scrollbar-width: none;
    margin: 0;
    padding: 0;
    max-height: calc(100vh - 95px);
    width: 235px;
    border-radius: 5px;
    position: absolute;
    top: 85px;
    left: 12.5px;
    z-index: 99;
    background: white;
    box-shadow: 0 2px 11px 0 rgba(0,0,0,.16);
  }

  .not_found p {
    width: 100%;
    padding: 0 10px;
  }
</style>
