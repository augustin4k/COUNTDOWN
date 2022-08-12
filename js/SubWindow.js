var myid = ["gsearch", "sub_windows_user", "sub_windows_sort", "TopNav", "fereastra_detalii", "result"];

function myFunction(a) {
    var Meniu = document.getElementById(a);
    a += "Class";
    var hamburger = document.getElementById("icon_");
    var nav_open = document.getElementById('TopNav');
    var footer_open = document.getElementById('fereastra_detalii');
    if (a !== "sub_windows_userClass" && a != "gsearchClass")
        hamburger.className = hamburger.className.replace(" activat", "");
    for (var i = 0; i < myid.length; i++) {
        var temp = document.getElementById(myid[i]);
        if (temp.className !== Meniu.className && temp.className.includes(" activat")) {
            if (temp.className === "TopNavClass activat" && a === "sub_windows_userClass" || temp.className === "TopNavClass activat" || temp.className === "TopNavClass activat" && a === "gsearchClass") {
                continue;
            }
            if (temp.className === "fereastra_detaliiClass activat" && a === "calendarClass") {
                continue;
            }
            temp.className = temp.className.replace(/ activat/, '');
        }
    }
    if (Meniu.className === a) {
        if (a === "TopNavClass") {
            hamburger.className += " activat";
        }
        Meniu.className += " activat";
    } else {
        if(Meniu.className !== "fereastra_detaliiClass activat")
          Meniu.className = a;
        if (a !== "sub_windows_userClass" && a != "gsearchClass")
            hamburger.className = hamburger.className.replace(" activat", "")
    }

    if(document.getElementById('fereastra_detalii').className.includes(" activat") ===  false && document.getElementById('Add_Event').className.includes(" color") === true)
      document.getElementById('Add_Event').className = document.getElementById('Add_Event').className.replace(" color", "");
};

flag_color = 0;

function ColorCategory(a) {

    var Meniu = document.getElementById(a);
    var hamburger = document.getElementById("icon_");

    var myid1 = ["Today", "Next_7_Days", "Inbox", "Add_Event", "Completed", "Trash"];
    for (var i = 0; i < myid.length; i++) {
        var temp1 = document.getElementById(myid[i])
        if (temp1.className.includes(" activat") && a !== "Add_Event"){
          temp1.className = temp1.className.replace(" activat", "");
          if(temp1.className.includes("TopNav"))
            hamburger.className = hamburger.className.replace(" activat", "");
        }
      }

    for (var i = 0; i < myid1.length; i++) {
        var temp = document.getElementById(myid1[i]);
        if (temp.className !== Meniu.className && temp.className.includes(" color") && a.includes("Add_Event") === false) {
            flag_color = 0;
            temp.className = temp.className.replace(/ color/, '');
        }

        if (a.includes("Add_Event") === true && Meniu.className.includes(" color") === false)
            flag_color = 0;
    }

    if (flag_color === 0) {
        flag_color = 1;
        if(Meniu.className.includes(" color") === false)
          Meniu.className += " color";
    }
    else
      if(a === "add" && Meniu.className.includes(" color")){
        Meniu.className = Meniu.className.replace(" color", "");
      }

    if (a !== "Add_Event" && document.getElementById("Add_Event").className.includes(" color") === false)
        document.getElementById('fereastra_detalii').className = document.getElementById('fereastra_detalii').className.replace(" activat", "");

}
