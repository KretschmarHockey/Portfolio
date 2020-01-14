// Name: Joshua Kretschmar
// Student ID: 16939790

function makeBooking() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("response").innerHTML = this.responseText;
        }
    };

    if (validateForm()) { // If Validated Form send object to book.php
        xmlhttp.open("GET", "book.php?name=" + document.getElementById("name").value + "&phone=" + document.getElementById("phone").value + "&unit=" + document.getElementById("unit").value + "&street_number=" + document.getElementById("street_number").value + "&street_name=" + document.getElementById("street_name").value + "&pick_suburb=" + document.getElementById("pick_suburb").value + "&dest_suburb=" + document.getElementById("dest_suburb").value + "&date_time=" + document.getElementById("date_time").value, false);
    }
    xmlhttp.send(null);

    clearForm();
}

// Validates each input from the form
function validateForm() {
    if (document.getElementById("name").value == "") {
        alert("Name must be filled out");
        return false;
    }

    if (document.getElementById("phone").value == "") {
        alert("Phone Number must be filled out");
        return false;
    }

    if (document.getElementById("street_number").value == "") {
        alert("Street Number must be filled out");
        return false;
    }

    if (document.getElementById("pick_suburb").value == "") {
        alert("Suburb must be filled out");
        return false;
    }

    if (document.getElementById("dest_suburb").value == "") {
        alert("Destination Suburb must be filled out");
        return false;
    }

    if (document.getElementById("date_time").value == "") {
        alert("Pick Up Date must be filled out");
        return false;
    }

    // Checks if input date is after the current date
    if (new Date() > new Date(document.getElementById("date_time").value)) {
        alert("Pick up time must be after current time");
        return false;
    }

    return true;
}

function clearForm() {
    document.getElementById("name").value = '';
    document.getElementById("phone").value = '';
    document.getElementById("unit").value = '';
    document.getElementById("street_number").value = '';
    document.getElementById("street_name").value = '';
    document.getElementById("pick_suburb").value = '';
    document.getElementById("dest_suburb").value = '';
    document.getElementById("date_time").value = '';

}