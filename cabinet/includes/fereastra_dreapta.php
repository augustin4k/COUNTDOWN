<head>
  <link href="../css/cabinet-css/includes/fereastra_dreapta.css" rel="stylesheet" />
</head>

<?php
  session_start();
  include "../../vendor/connection.php";

  if(!isset($_SESSION['user']))
    header("Location: ../sign-in.php");

  $timestamp = date('Y-m-d H:i:s');
  $datetime = explode(" ", $timestamp);
  $date_curent = $datetime[0];
  $current_hour = $datetime[1];

  if(isset($_GET['id_event'])){

    $id_event=$_GET['id_event'];
    $id_event = str_replace("event-","", $id_event);
  }

  if(!isset($_GET['Add']))
  {
    $actiune = "modifica";
    $result = mysqli_query($connect, "SELECT * FROM `evenimente`
                          join `user` on `user`.id_user = `evenimente`.id_user
                          where id_event = ".$id_event." and `user`.id_user = ".$_SESSION['user']['id']
                        );
    $RESULT = mysqli_fetch_assoc($result);
  }
  else {
    $id_event = "null";
    $actiune = "add";
    $RESULT['data_event'] = $date_curent;
    $RESULT['ora'] = "00:00:00";
    $RESULT['titlu'] = "";
    $RESULT['descriere'] = "";
    $RESULT['tip_repetare'] = "none";
    $RESULT['cantitate_repetare'] = 0;
    $RESULT['culoare'] = "rgba(189, 189, 189, 0.5)";
    $RESULT['id_user'] = $_SESSION['user']['id'];
    $RESULT['completat'] = 0;
    $RESULT['seen'] = 0;
  }

  $completat = "";
  if($RESULT['completat'] === '1')
    $completat = $completat."checked = 'checked'";
 ?>

   <header>
     <img id="left_arrow" style="cursor: pointer;" src="../img/cabinet/left-arrow.png" alt="sageata" width="20px">
     <label class="container">
            <input type="checkbox" <?php echo $completat;?>>
            <span class="checkmark"  style="left: 0;"></span>
      </label>
      <p style="color: rgba(189, 189, 189, 1); font-size: 40px; font-weight: 300; margin-left: 2.5px; margin-right: 15px;" class = "bara">|</p>

      <?php
      $days = ((strtotime($timestamp) - strtotime($RESULT['data_event'].' '.$RESULT['ora']))/60/60/24);
      $hours = $days*24;
      if($days>-1 && $days<1)
        $days = 0;
      $days = ceil($days);
      if($days == 0 && $hours < 0) {
        echo "<p style = 'color:#6180df;' class = 'data'>Azi; ".date('d F Y', strtotime($RESULT['data_event']))."; <br>Ora: ".$RESULT['ora']."</p>";
      }
      else if($days == 0 && $hours >= 0) {
        echo "<p style = 'color:red;' class = 'data'>Azi; ".date('d F Y', strtotime($RESULT['data_event']))."; <br>Ora: ".$RESULT['ora']."</p>";
      }
      else if($hours > 0) {
        echo "<p style = 'color:red;' class = 'data'>".abs($days)." zile in urma; ".date('d F Y', strtotime($RESULT['data_event']))."; <br>Ora: ".$RESULT['ora']."</p>";
      }
      else if($hours < 0) {
        echo "<p style = 'color:#6180df;' class = 'data'>Peste ".abs($days)." zile; ".date('d F Y', strtotime($RESULT['data_event']))."; <br>Ora: ".$RESULT['ora']."</p>";
      }
      ?>
  </header>

<!-- for calendar div -->
  <form class="calendarClass" id = "calendar" action="" method="post">
    <label style="margin-top: 0;" for="date"><p>Introdu data:</p></label>
    <input type="date" name="data_event" value="<?php echo $RESULT['data_event'] ?>">
    <div class="set_calendar">
      <label for="time">
        <p>Time</p>
        <img src="..\img\cabinet\clock.png" width="15px" alt="clock"/>
      </label>
      <input type="time" name="time" value="<?php echo $RESULT['ora'] ?>">

      <label for="repeat">
        <p>Repeat</p>
        <img src="../img/cabinet/repeat.png" width="15px" alt=""/>
      </label>
      <div class="repeat">
        <select onchange="document.getElementById('select_tip_repeat').value=this.value" id = "select_tip_repeat" name = "tip_repeat" class="button_icon">
          <option id = "none" class = "option" value="none">O singura data</option>
          <option id = "zilnic" class = "option" value="Zilnic">Zilnic</option>
          <option id = "saptamanal" class = "option" value="Saptamanal">Saptamanal</option>
          <option id = "lunar" class = "option" value="Lunar">Lunar</option>
          <option id = "anual" class = "option" value="Anual">Anual</option>
        </select>
        <input type="text" name="cantitate_repeat" value="<?php echo $RESULT['cantitate_repetare'] ?>">
      </div>
    </div>
    <div class="buton_calendar">
      <button class="clear" type="button"><b>Clear</b></button>
      <button class="ok" type="button"><b>OK</b></button>
    </div>
  </form>
<!--  -->

   <section>
      <input type="text" name = "titlu_event" id='titlu_event' value = '<?php echo $RESULT['titlu'] ?>' placeholder="Introdu titlul..."/>
      <textarea name="descriere_event" class="descriere_event" id="descriere_event" placeholder="Adauga o descriere..."><?php echo $RESULT['descriere'];?></textarea>
   </section>

   <div class="card">
    <p>Alege o culoare pentru task-ul tau:</p>
    <ul>
        <li class="color-item" id="rgba(239, 83, 80, 1)" style="background-color: rgba(239, 83, 80, 1);"></li>
        <li class="color-item" id="rgba(255, 51, 153, 1)" style="background-color: rgba(255, 51, 153, 1);"></li>
        <li class="color-item" id="rgba(102, 187, 106, 1)" style="background-color: rgba(102, 187, 106, 1);"></li>
        <li class="color-item" id="rgba(102, 255, 51, 1)" style="background-color: rgba(102, 255, 51, 1);"></li>
        <li class="color-item" id="rgba(255, 202, 40, 1)" style="background-color: rgba(255, 202, 40, 1);"></li>
        <li class="color-item" id="rgba(255, 255, 51, 1)" style="background-color: rgba(255, 255, 51, 1);"></li>
        <li class="color-item" id="rgba(97, 127, 222, 1)" style="background-color: rgba(97, 127, 222, 1);"></li>
        <li class="color-item" id="rgba(66, 165, 245, 1)" style="background-color: rgba(66, 165, 245, 1);"></li>
        <li class="color-item" id="rgba(189, 189, 189, 1)" style="background-color: rgba(189, 189, 189, 1);"></li>
    </ul>
  </div>


  <p id="demo" style="background: <?php echo $RESULT['culoare']?>;"></p>

  <script>
  var countDownDate = new Date("<?php echo $RESULT['data_event'].' '.$RESULT['ora']?>").getTime();
  var x = setInterval(function() {
    var now = new Date().getTime();
    var distance = countDownDate - now;
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    if (distance < 0) {
      days=0-days;
      hours=0-hours;
      minutes = 0-minutes;
      seconds = 0-seconds;
      days = days-1;
      hours = hours-1;
      document.getElementById("demo").innerHTML = "-" + days + "d " + hours + "h "
      + minutes + "m " + seconds + "s ";
    }
  }, 10);
</script>

   <div class="button_cancel_save">
     <button class="cancel" type="button"><b>Cancel</b></button>
     <button class="save" type="button"><b>Save</b></button>
   </div>

</aside>
<script type="text/javascript">
$(document).ready(function() {

  var culoare = '<?php echo $RESULT["culoare"];?>';
  culoare=culoare.replace(" 0.5)", " 1)");
  $('select option[value="<?php echo $RESULT["tip_repetare"];?>"]').attr("selected",true);
  $("[id = "+"'"+culoare+"'"+']').addClass("select_color");
  $('#left_arrow').on('click', function() {
    $('#fereastra_detalii').removeClass("activat");
  });

  $('select').on('change', function() {
      $("input[name = 'cantitate_repeat']").css("border-color", "#617fde");
      $("input[name = 'cantitate_repeat']").val(0);
  });

  $('input[name="data_event"]').on('click', function() {
    $(this).css("border-color", "#617fde");
  });
  $('input[name = "time"]').on('click', function() {
    $(this).css("border-color", "#617fde");
  });
  $('input[name="cantitate_repeat"]').on('click', function() {
    $(this).css("border-color", "#617fde");
  });

  culoare=culoare.replace(" 1)", " 0.5)");

  var click=0;
  var flag_for_save_data=0;
  if($("#Add_Event").hasClass("color"))
    flag_for_save_data = 1;

  $('.ok').on('click', function() {

    data = $('input[name = "data_event"]').val();
    ora = $('input[name = time]').val();
    tip_repeat = $("select[name = tip_repeat]").val();
    cantitate_repeat = $('input[name = cantitate_repeat]').val();

    if($.isNumeric(cantitate_repeat) === true && ora.length != 0 && data.length != 0)
    {
      flag_for_save_data=1;
      $("p.data").load("includes/titlu.php?ora="+ora+"&data="+data);
      $('#calendar').removeClass("activat");
      $("input[name='cantitate_repeat']").css("border-color", "#617fde");
      $("input[name='date']").css("border-color", "#617fde");
      $("input[name='time']").css("border-color", "#617fde");
      if($("#calendar").hasClass("activat") === false)
        click = 0;
    }
    if($.isNumeric(cantitate_repeat) === false)
      $("input[name='cantitate_repeat']").css("border-color", "red");
    if(data.length === 0)
      $("input[name='data_event']").css("border-color", "red");
    if(ora.length === 0)
      $("input[name='time']").css("border-color", "red");
  });

  $('.clear').on('click', function() {
    $("#calendar input").css("border-color", "#617fde");
    $("select option").prop("selected", false);
    $("select option[value='<?php echo $RESULT["tip_repetare"];?>']").prop("selected", true);
    $('input[name = data_event]').val("<?php echo $RESULT['data_event'];?>");
    $('input[name = time]').val("<?php echo $RESULT['ora'];?>");
    $('input[name = cantitate_repeat]').val("<?php echo $RESULT['cantitate_repetare'];?>");
    if($("option:selected").val() === "none") {
      $('input[name = "cantitate_repeat"]').prop('disabled', "disabled");
    }
  });

  $('#select_tip_repeat').on('change', function() {
    if($("option:selected").val() != "none" || $("option").val() !== "none") {
      $('input[name = "cantitate_repeat"]').prop('disabled', false);
    }
    else {
      $('input[name = "cantitate_repeat"]').val(0);
      $('input[name = "cantitate_repeat"]').prop('disabled', true);
    }
  });

  $('.data').on('click', function() {
    click++;
    if(click % 2 == 0)
    {
      $('#calendar').removeClass("activat");
      $("#calendar input").css("border-color", "#617fde");
      $("select option").prop("selected", false);
      $("select option[value='<?php echo $RESULT["tip_repetare"];?>']").prop("selected", true);
      $('input[name = cantitate_repeat]').val("<?php echo $RESULT['cantitate_repetare'];?>");
      data = "<?php echo $RESULT['data_event'];?>";
      ora = "<?php echo $RESULT['ora'];?>";
      $('input[name = data_event]').val(data);
      $('input[name = time]').val(ora);
      $("p.data").load("includes/titlu.php?ora="+ora+"&data="+data);
    }
    else {
      flag_for_save_data = 0;
      if($("option:selected").val() === "none") {

        $('input[name = "cantitate_repeat"]').attr('disabled', "disabled");
      }

      $('#calendar').addClass("activat");
    }
  });

  $('.color-item').on('click', function() {
    culoare=$(this).attr("id");
    culoare=culoare.replace(" 1)", " 0.5)");
    $(".color-item").removeClass("select_color");
    $(this).addClass("select_color");
    $("#demo").css("background", culoare);
  });

  $('.cancel').on('click', function() {
    $('#fereastra_detalii').removeClass("activat");
    $('#calendar').removeClass("activat");
    $('#Add_Event').removeClass("color");
  });

  $('.save').on('click', function() {
    $('#Add_Event').removeClass("color");
    $('#calendar').removeClass("activat");
    $('#fereastra_detalii').removeClass("activat");

    if(flag_for_save_data === 1) {
      data = $('input[name = data_event]').val();
      ora = $('input[name = time]').val();
      tip_repeat = $("select[name = tip_repeat]").val();
      cantitate_repeat = $('input[name = cantitate_repeat]').val();
    }

    else {
      data = "<?php echo $RESULT['data_event'] ?>"
      ora = "<?php echo $RESULT['ora'] ?>"
      tip_repeat = "<?php echo $RESULT['tip_repetare'] ?>"
      cantitate_repeat = "<?php echo $RESULT['cantitate_repetare'] ?>"
    }
    completat = 0;
    if($('#fereastra_detalii input[type = "checkbox"]').is(":checked") === true)
      completat = 1;

    var titlu_event = $('input[name = "titlu_event"]').val();
    var descriere_event = $('textarea[name = "descriere_event"]').val();
    var actiune = '<?php echo $actiune?>';
    console.log(tip_repeat);
    $.ajax({
      type: "POST",
      url: "includes/update_event.php",
      data: {modifica: actiune, completat1: completat, data_event: data, time: ora, tip_repeat: tip_repeat, cantitate_repeat: cantitate_repeat, titlu_event: titlu_event, descriere_event: descriere_event, culoare: culoare, id_event: '<?php echo $id_event;?>'},
      success: function(response) {
        <?php
        $_GET["order"] = str_replace(" ", "+", $_GET["order"]);
        ?>
        $(".icon_for_group_info").removeClass("color");
        $("#Inbox").addClass("color");
        data_curenta = '<?php echo $date_curent?>';
        criteriu  = "data_event>='"+data_curenta+"'+and+completat=0+and";
        $("#addCategorie").load('includes/middle_categorie.php?order='+"<?php echo $_GET['order'];?>"+'&title=Inbox&criteriu='+criteriu);
        var search_input = $("#gsearch").val();
        if(search_input.length != 0 & $('#gsearch').hasClass("activat")) {
          search_input = search_input.replace(" ", "+");
          $("#result").load('includes/search.php?nume_event='+search_input);
          $('#result').addClass("activat");
        }
      }
    });
  });
});
</script>
