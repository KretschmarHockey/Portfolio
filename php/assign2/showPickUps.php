<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        td,
        th {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            text-align: left;
        }
    </style>
</head>

<body>
    <?php
    // Name: Josh Kretschmar
    // Student ID: 16939790

    require_once('conf/settings.php');

    // Connecting to database
    $conn = @mysqli_connect(
        $sql_host,
        $sql_user,
        $sql_pass,
        $sql_db
    );

    if (!$conn) { // Database fails to connect
        die("Connection failed: " . mysqli_error($conn));
    }

    $query = "SELECT id, reference, name, phone, pick_suburb, dest_suburb, pick_date_time FROM $sql_tble"
    . " WHERE status = 'unassigned'" // Selecting unassigned bookings
    . " AND pick_date_time >= NOW()"
    . " AND pick_date_time < DATE_ADD(NOW(), INTERVAL 2 HOUR)"; // Selecting bookings with pickup within 2 hours
    $result = mysqli_query($conn, $query);

    // Creating table to show the selected bookings
    echo "<table>"
        . "<tr>"
        . "<th>Reference No.</th>"
        . "<th>Customer Name</th>"
        . "<th>Contact Phone</th>"
        . "<th>Pick-Up Suburb</th>"
        . "<th>Destination Suburb</th>"
        . "<th>Pick-Up Date</th>"
        . "<th>Pick-Up Time</th>";

    while ($row = mysqli_fetch_array($result)) { // Looping through array of all selected bookings.
        echo "<tr>";
        echo "<td>" . $row['reference'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['pick_suburb'] . "</td>";
        echo "<td>" . $row['dest_suburb'] . "</td>";
        echo "<td>" . date_format(new DateTime($row['pick_date_time']), 'd-m-Y') . "</td>";
        echo "<td>" . date_format(new DateTime($row['pick_date_time']), 'g:i A') . "</td>";
        echo "</tr>";
    }

    echo "</table>";


    mysqli_close($conn);
    ?>
</body>

</html>