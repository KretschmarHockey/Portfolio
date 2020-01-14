// Name: Joshua Kretschmar
// Student ID: 16939790

function showPickUp() { // Makes request to server to show pick ups
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("bookings").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "showPickUps.php?", true);
    xmlhttp.send();
}

function assign() { // Makes request to server to change the reference pick to status from unassigned to assigned
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("bookings").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "assign.php?reference=" + document.getElementById("reference").value, true);
    xmlhttp.send();
}