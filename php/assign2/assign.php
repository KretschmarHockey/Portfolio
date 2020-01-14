<!DOCTYPE html>
<html>

<head>
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

    $reference = $_GET["reference"]; // Receiving reference from get request

    $query = "SELECT * FROM $sql_tble"
        . " WHERE reference=$reference"; // Selecting the reference booking from database
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) { // Testing if reference can be found
        $query = "UPDATE $sql_tble" // Reference found
            . " SET status = 'assigned'"
            . " WHERE reference = $reference"; // Changing reference status to assigned
        mysqli_query($conn, $query);
        if (!$result) { // SQL command contains error
            echo "<p>Something is wrong with ", $query, "</p>";
        } else { // Succesful add to database
            echo "<p>The booking request $reference has been properly assigned</p>";
        }
    } else { // Reference can't be found
        echo "<p>Sorry that reference number does not exist.";
    }

    mysqli_close($conn);
    ?>
</body>

</html>